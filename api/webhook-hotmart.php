<?php
header('Content-Type: application/json');

// 1. Obtener los headers
if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
$headers = getallheaders();

// 2. Extraer y validar el Token Hottok (hash_equals evita timing attacks al comparar secretos)
$token_recibido = $headers['X-Hotmart-Hottok'] ?? ($headers['x-hotmart-hottok'] ?? '');
$mi_token_secreto = "VSjWkJjjbrI7QCQL6iFCkE3kv65BgJ58b811b3-57bc-4d2e-97a6-c478922ff02f";

if (!hash_equals($mi_token_secreto, (string) $token_recibido)) {
    http_response_code(401);
    die(json_encode(["error" => "Acceso Denegado. Token inválido."]));
}

// 3. Obtener el cuerpo de la petición JSON
$payload = file_get_contents('php://input');
$datos = json_decode($payload, true);

if (!$datos) {
    http_response_code(400);
    die(json_encode(["error" => "JSON inválido."]));
}

$logFile = __DIR__ . '/hotmart_log.txt';
function hotmart_log($msg) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | $msg\n", FILE_APPEND);
}

$evento = $datos['event'] ?? '';
// substr defensivo: n_operacion es varchar(100) en la tabla usuario, nunca debe poder
// tumbar el insert por mas larga/rara que venga la transaccion desde Hotmart.
$transaccion = substr(trim($datos['data']['purchase']['transaction'] ?? ''), 0, 100);

// Eventos que dan acceso al curso
$eventosAprobados = ['PURCHASE_APPROVED', 'PURCHASE_COMPLETE'];
// Eventos que deben QUITAR el acceso otorgado antes (reembolso, contracargo, cancelacion...)
// Antes esto no existia: una venta reembolsada se quedaba con acceso al curso para siempre.
$eventosRevocacion = ['PURCHASE_CANCELED', 'PURCHASE_REFUNDED', 'PURCHASE_CHARGEBACK', 'PURCHASE_EXPIRED', 'PURCHASE_PROTEST'];

$respuesta = ['status' => 'ignored', 'event' => $evento];

if (empty($transaccion)) {
    hotmart_log("IGNORADO (sin numero de transaccion) - Evento: $evento");
} else {
    require_once __DIR__ . '/../app/Core/Database.php';

    try {
        $db = new \App\Core\Database();
        $pdo = $db->connect();

        // Auto-migracion: 1 fila por transaccion de Hotmart. Es lo que permite, si mas
        // adelante llega un reembolso/contracargo de esa misma transaccion, saber
        // exactamente a que usuario y a que curso hay que quitarle el acceso.
        $pdo->exec("CREATE TABLE IF NOT EXISTS `ventas_hotmart` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `n_operacion` VARCHAR(100) NOT NULL,
            `id_usuario` INT DEFAULT NULL,
            `id_curso` INT DEFAULT NULL,
            `evento` VARCHAR(30) NOT NULL DEFAULT 'APROBADA',
            `monto` DECIMAL(10,2) DEFAULT 0,
            `moneda` VARCHAR(10) DEFAULT 'USD',
            `fecha_evento` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `idx_n_operacion` (`n_operacion`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        if (in_array($evento, $eventosAprobados, true)) {
            $nombre  = $datos['data']['buyer']['name'] ?? 'Desconocido';
            $email   = $datos['data']['buyer']['email'] ?? '';
            // dni es varchar(20): recortamos por si acaso, para que un documento de
            // prueba/extranjero fuera de rango no tumbe el insert completo del alumno.
            $dni     = substr(trim($datos['data']['buyer']['document'] ?? ''), 0, 20);
            $celular = $datos['data']['buyer']['checkout_phone'] ?? ($datos['data']['buyer']['phone'] ?? '');
            $curso   = $datos['data']['product']['name'] ?? 'Curso no identificado';
            $monto   = $datos['data']['purchase']['price']['value'] ?? 0;
            $moneda  = $datos['data']['purchase']['price']['currency_value'] ?? 'USD';
            $fechaAprobada = isset($datos['data']['purchase']['approved_date'])
                ? date('Y-m-d H:i:s', intval($datos['data']['purchase']['approved_date'] / 1000))
                : date('Y-m-d H:i:s');

            if (empty($email)) {
                hotmart_log("IGNORADO (sin email del comprador) - Transaccion $transaccion");
                $respuesta = ['status' => 'ignored', 'reason' => 'sin email del comprador'];
            } else {
                // A. Usuario: buscar por correo, o crear uno nuevo con clave temporal
                $stmt = $pdo->prepare("SELECT iduser FROM usuario WHERE correo = ? LIMIT 1");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user) {
                    $id_usuario = $user['iduser'];
                } else {
                    $password = substr(md5(uniqid()), 0, 8);
                    $sql = "INSERT INTO usuario (id_pla, nombre, correo, usuario, password, dni, telefono, n_operacion, m_pagado, banco, fecha_deposito, estatus)
                            VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, 'HOTMART', ?, 1)";
                    $stmtInsert = $pdo->prepare($sql);
                    $stmtInsert->execute([$nombre, $email, $email, $password, $dni, $celular, $transaccion, $monto, $fechaAprobada]);
                    $id_usuario = $pdo->lastInsertId();
                }

                // B. Curso: buscarlo por nombre aproximado y matricular si no lo tiene ya
                $id_curso = null;
                $stmtCurso = $pdo->prepare("SELECT id_curso FROM cursos WHERE nombre_curso LIKE ? LIMIT 1");
                $stmtCurso->execute(['%' . substr($curso, 0, 15) . '%']);
                $cursoData = $stmtCurso->fetch();

                if ($cursoData) {
                    $id_curso = $cursoData['id_curso'];
                    $stmtCheck = $pdo->prepare("SELECT id FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?");
                    $stmtCheck->execute([$id_usuario, $id_curso]);
                    if (!$stmtCheck->fetch()) {
                        $stmtLink = $pdo->prepare("INSERT INTO usuario_cursos (id_usuario, id_curso) VALUES (?, ?)");
                        $stmtLink->execute([$id_usuario, $id_curso]);
                    }
                }

                // C. Dejar registro de la transaccion (para poder revertir el acceso si luego llega un reembolso)
                $stmtVenta = $pdo->prepare("INSERT INTO ventas_hotmart (n_operacion, id_usuario, id_curso, evento, monto, moneda, fecha_evento)
                                             VALUES (?, ?, ?, 'APROBADA', ?, ?, ?)
                                             ON DUPLICATE KEY UPDATE id_usuario = VALUES(id_usuario), id_curso = VALUES(id_curso), evento = 'APROBADA', monto = VALUES(monto), moneda = VALUES(moneda), fecha_evento = VALUES(fecha_evento)");
                $stmtVenta->execute([$transaccion, $id_usuario, $id_curso, $monto, $moneda, $fechaAprobada]);

                $avisoCurso = $id_curso ? '' : ' [ADVERTENCIA: no se encontro el curso "' . $curso . '" en la BD, matricular a mano]';
                hotmart_log("VENTA APROBADA: $nombre ($email) compro '$curso' - Transaccion $transaccion - $monto $moneda$avisoCurso");
                $respuesta = ['status' => 'success', 'message' => 'Alumno procesado en ICC BD'];
            }

        } elseif (in_array($evento, $eventosRevocacion, true)) {
            // Buscamos la venta original de esta transaccion para saber a quien y que curso revocar
            $stmtVenta = $pdo->prepare("SELECT id_usuario, id_curso FROM ventas_hotmart WHERE n_operacion = ? LIMIT 1");
            $stmtVenta->execute([$transaccion]);
            $venta = $stmtVenta->fetch();

            if ($venta && $venta['id_usuario'] && $venta['id_curso']) {
                $stmtRevoke = $pdo->prepare("DELETE FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?");
                $stmtRevoke->execute([$venta['id_usuario'], $venta['id_curso']]);

                $stmtUpdate = $pdo->prepare("UPDATE ventas_hotmart SET evento = ?, fecha_evento = NOW() WHERE n_operacion = ?");
                $stmtUpdate->execute([$evento, $transaccion]);

                hotmart_log("ACCESO REVOCADO ($evento): usuario_id={$venta['id_usuario']} curso_id={$venta['id_curso']} - Transaccion $transaccion");
                $respuesta = ['status' => 'processed', 'event' => $evento];
            } else {
                hotmart_log("$evento recibido pero no se encontro la venta original de la transaccion $transaccion (revisar manualmente)");
                $respuesta = ['status' => 'ignored', 'reason' => 'venta original no encontrada', 'event' => $evento];
            }

        } else {
            hotmart_log("Evento ignorado: $evento - Transaccion $transaccion");
            $respuesta = ['status' => 'ignored', 'event' => $evento];
        }

    } catch (\Exception $e) {
        hotmart_log("ERROR BD ($evento): " . $e->getMessage() . " - Transaccion $transaccion");
        $respuesta = ['status' => 'error', 'message' => 'Error interno, revisar hotmart_log.txt'];
    }
}

// IMPORTANTE: Devolver siempre 200 OK a Hotmart (evita que reintente en loop o desactive
// el webhook); cualquier problema real queda registrado en hotmart_log.txt para revisar a mano.
http_response_code(200);
echo json_encode($respuesta);
