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

// 2. Extraer y validar el Token Hottok
$token_recibido = isset($headers['X-Hotmart-Hottok']) ? $headers['X-Hotmart-Hottok'] : (isset($headers['x-hotmart-hottok']) ? $headers['x-hotmart-hottok'] : '');
$mi_token_secreto = "VSjWkJjjbrI7QCQL6iFCkE3kv65BgJ58b811b3-57bc-4d2e-97a6-c478922ff02f";

if ($token_recibido !== $mi_token_secreto) {
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

// 4. Manejar solo los eventos de compra aprobada
if (isset($datos['event']) && $datos['event'] === 'PURCHASE_APPROVED') {
    
    $nombre = $datos['data']['buyer']['name'] ?? 'Desconocido';
    $email  = $datos['data']['buyer']['email'] ?? 'desconocido@correo.com';
    $curso  = $datos['data']['product']['name'] ?? 'Curso no identificado';
    $transaccion = $datos['data']['purchase']['transaction'] ?? '';
    $monto = $datos['data']['purchase']['price']['value'] ?? 0;

    // -------------------------------------------------------------
    // CONEXIÓN A BASE DE DATOS (Usando App\Core\Database nativo de ICC)
    // -------------------------------------------------------------
    require_once __DIR__ . '/../app/Core/Database.php';
    
    try {
        $db = new \App\Core\Database();
        $pdo = $db->connect();
        
        // A. Verificar si el usuario ya existe por su correo
        $stmt = $pdo->prepare("SELECT iduser FROM usuario WHERE correo = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            // Usuario nuevo: Le generamos una contraseña temporal
            $password = substr(md5(uniqid()), 0, 8); 
            
            // Insertar en la tabla usuario (id_pla=1 por defecto)
            $sql = "INSERT INTO usuario (id_pla, nombre, correo, usuario, password, n_operacion, m_pagado, banco, estatus) 
                    VALUES (1, ?, ?, ?, ?, ?, ?, 'HOTMART', 1)";
            $stmtInsert = $pdo->prepare($sql);
            $stmtInsert->execute([$nombre, $email, $email, $password, $transaccion, $monto]);
            
            $id_usuario = $pdo->lastInsertId();
        } else {
            // Usuario ya existía
            $id_usuario = $user['iduser'];
        }
        
        // B. Intentar asociarle el curso (Tabla usuario_cursos)
        // Buscamos el ID del curso por nombre (aproximado a los primeros 15 chars por si varía ligeramente)
        $stmtCurso = $pdo->prepare("SELECT id_curso FROM cursos WHERE nombre_curso LIKE ? LIMIT 1");
        $stmtCurso->execute(['%' . substr($curso, 0, 15) . '%']);
        $cursoData = $stmtCurso->fetch();
        
        if ($cursoData) {
            $id_curso = $cursoData['id_curso'];
            // Verificar si el usuario ya tiene este curso para no duplicar
            $stmtCheck = $pdo->prepare("SELECT id FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?");
            $stmtCheck->execute([$id_usuario, $id_curso]);
            
            if (!$stmtCheck->fetch()) {
                $stmtLink = $pdo->prepare("INSERT INTO usuario_cursos (id_usuario, id_curso) VALUES (?, ?)");
                $stmtLink->execute([$id_usuario, $id_curso]);
            }
        }

        // Registrar en el LOG que todo salió excelente
        $log_msg = date("Y-m-d H:i:s") . " | VENTA EXITOSA BD: $nombre ($email) compro $curso (Transaccion: $transaccion) \n";
        file_put_contents(__DIR__ . '/hotmart_log.txt', $log_msg, FILE_APPEND);

    } catch (Exception $e) {
        // Registrar error de BD si ocurre alguno
        $log_msg = date("Y-m-d H:i:s") . " | ERROR BD: " . $e->getMessage() . "\n";
        file_put_contents(__DIR__ . '/hotmart_log.txt', $log_msg, FILE_APPEND);
    }

    // IMPORTANTE: Devolver siempre 200 OK a Hotmart
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Alumno procesado en ICC BD"]);

} else {
    // Si no es compra aprobada, solo devolvemos 200 para que Hotmart termine la petición
    http_response_code(200);
    echo json_encode(["status" => "ignored", "event" => $datos['event'] ?? '']);
}
?>
