<?php
namespace App\Controllers;
require_once __DIR__ . '/../Core/Controller.php';
use App\Core\Controller;

class CheckoutController extends Controller {

    public function index() {
        $nombreCurso = isset($_GET['curso']) ? trim($_GET['curso']) : '';

        require_once __DIR__ . '/../Models/Curso.php';
        $cursoModel = new \App\Models\Curso();
        $cursoDB = $cursoModel->getCursoByNombre($nombreCurso);

        // Detecta el pais del visitante por IP para sugerir moneda y medios de pago
        // por defecto (?moneda= en la URL sigue pudiendo forzarlo manualmente).
        require_once __DIR__ . '/../Helpers/GeoHelper.php';
        $paisDetectado = \App\Helpers\GeoHelper::detectarPais();
        $reglasPais = \App\Helpers\GeoHelper::reglasParaPais($paisDetectado);

        $this->view('checkout/index', [
            'cursoDB' => $cursoDB,
            'paisDetectado' => $paisDetectado,
            'monedaSugerida' => $reglasPais['moneda'],
            'metodosDisponibles' => $reglasPais['metodos'],
        ], false);
    }

    public function voucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            
            if (isset($_FILES['voucher']) && $_FILES['voucher']['error'] === UPLOAD_ERR_OK) {
                $curso = isset($_POST['curso']) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['curso']) : 'curso_desconocido';
                $uploadDir = __DIR__ . '/../../assets/img/vouchers/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExt = strtolower(pathinfo($_FILES['voucher']['name'], PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
                
                if (!in_array($fileExt, $allowedExts)) {
                    echo json_encode(['success' => false, 'error' => 'Formato no permitido (solo JPG, PNG, PDF)']);
                    return;
                }

                $fileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.' . $fileExt;
                $destination = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['voucher']['tmp_name'], $destination)) {
                    
                    // Guardar datos del estudiante en un JSON
                    $dni = isset($_POST['dni']) ? strip_tags($_POST['dni']) : '';
                    $nombre = isset($_POST['nombre']) ? strip_tags($_POST['nombre']) : '';
                    $apellido = isset($_POST['apellido']) ? strip_tags($_POST['apellido']) : '';
                    $celular = isset($_POST['celular']) ? strip_tags($_POST['celular']) : '';
                    
                    $studentData = [
                        'dni' => $dni,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'celular' => $celular,
                        'curso' => $curso,
                        'fecha' => date('Y-m-d H:i:s')
                    ];
                    
                    $jsonFileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.json';
                    file_put_contents($uploadDir . $jsonFileName, json_encode($studentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                    // --- ALERTA POR WHATSAPP (CALLMEBOT) ---
                    // IMPORTANTE: Reemplaza estos datos con tu numero y tu API key de CallMeBot
                    $whatsapp_phone = ""; // Ej: +51999999999 (con el simbolo + y el codigo de pais)
                    $whatsapp_apikey = ""; // Ej: 123456
                    
                    if (!empty($whatsapp_phone) && !empty($whatsapp_apikey)) {
                        $mensaje_wa = "💰 *¡NUEVO PAGO REGISTRADO!* 💰\n\n";
                        $mensaje_wa .= "👤 *Alumno:* " . $nombre . " " . $apellido . "\n";
                        $mensaje_wa .= "🪪 *DNI:* " . $dni . "\n";
                        $mensaje_wa .= "📱 *Celular:* " . $celular . "\n";
                        $mensaje_wa .= "🎓 *Curso:* " . str_replace('_', ' ', $curso) . "\n\n";
                        $mensaje_wa .= "Revisa tu panel de administración para ver el voucher subido.";
                        
                        $url_wa = "https://api.callmebot.com/whatsapp.php?phone=" . urlencode($whatsapp_phone) . "&text=" . urlencode($mensaje_wa) . "&apikey=" . urlencode($whatsapp_apikey);
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url_wa);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout corto para no retrasar al usuario
                        curl_exec($ch);
                        curl_close($ch);
                    }
                    // ----------------------------------------

                    echo json_encode(['success' => true, 'file' => $fileName]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error al mover el archivo']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'No se subio el archivo o hubo un error en la subida']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
        }
    }

    /**
     * El navegador llega aqui despues de que el boton de PayPal reporta "capture" exitoso.
     * NO nos fiamos de eso: volvemos a preguntarle a PayPal (servidor a servidor) el estado
     * real de esa orden, y solo si PayPal confirma COMPLETED guardamos la venta y matriculamos
     * al alumno. Asi una orden nunca queda sin registro, y nadie puede "forzar" el exito desde
     * la consola del navegador sin haber pagado de verdad.
     */
    public function paypal_confirm() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        // n_operacion y dni son varchar(100)/varchar(20) en la tabla usuario: recortamos
        // aqui para que un ID de orden o un documento fuera de rango nunca tumbe el insert
        // completo (esto es justo lo que le paso al webhook de Hotmart con su dato de prueba).
        $orderId  = isset($input['orderID']) ? substr(trim($input['orderID']), 0, 100) : '';
        $curso    = isset($input['curso']) ? trim($input['curso']) : 'Curso no identificado';
        $dni      = isset($input['dni']) ? substr(strip_tags(trim($input['dni'])), 0, 20) : '';
        $nombre   = isset($input['nombre']) ? strip_tags(trim($input['nombre'])) : '';
        $apellido = isset($input['apellido']) ? strip_tags(trim($input['apellido'])) : '';
        $celular  = isset($input['celular']) ? strip_tags(trim($input['celular'])) : '';

        if (empty($orderId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Falta el orderID de PayPal']);
            return;
        }

        require_once __DIR__ . '/../Libraries/PayPalClient.php';
        require_once __DIR__ . '/../Core/Database.php';

        $logFile = __DIR__ . '/../../api/paypal_log.txt';

        try {
            $paypal = new \App\Libraries\PayPalClient();
            $order = $paypal->verifyOrder($orderId);
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR VERIFICACION: " . $e->getMessage() . " (Orden $orderId)\n", FILE_APPEND);
            http_response_code(502);
            echo json_encode(['success' => false, 'error' => 'No se pudo verificar el pago con PayPal. Intenta de nuevo o escribenos por el chat con tu numero de orden: ' . $orderId]);
            return;
        }

        // Fuente de verdad: el estado que PayPal reporta de su propia orden, nunca lo que diga el navegador
        if (empty($order['status']) || $order['status'] !== 'COMPLETED') {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | RECHAZADO (estado " . ($order['status'] ?? 'desconocido') . "): Orden $orderId\n", FILE_APPEND);
            http_response_code(402);
            echo json_encode(['success' => false, 'error' => 'PayPal no confirma este pago como completado.']);
            return;
        }

        $purchaseUnit  = $order['purchase_units'][0] ?? [];
        $monto         = $purchaseUnit['amount']['value'] ?? 0;
        $monedaPagada  = $purchaseUnit['amount']['currency_code'] ?? 'USD';
        $payer         = $order['payer'] ?? [];
        $emailPaypal   = $payer['email_address'] ?? '';
        $nombrePaypal  = trim(($payer['name']['given_name'] ?? '') . ' ' . ($payer['name']['surname'] ?? ''));

        // Preferimos los datos que el alumno escribio (para el certificado); si faltan, usamos los de PayPal
        $nombreFinal = $nombre !== '' ? trim($nombre . ' ' . $apellido) : ($nombrePaypal ?: 'Alumno PayPal');
        $emailFinal  = $emailPaypal ?: (preg_replace('/[^a-z0-9]/', '', strtolower($nombreFinal)) . '_' . substr($orderId, -6) . '@paypal.icc.com.pe');

        try {
            $db = new \App\Core\Database();
            $pdo = $db->connect();

            // Evitar duplicar la venta si el navegador reintenta este fetch (ej. el usuario recarga)
            $stmtDup = $pdo->prepare("SELECT iduser FROM usuario WHERE n_operacion = ? AND banco = 'PAYPAL' LIMIT 1");
            $stmtDup->execute([$orderId]);
            $existente = $stmtDup->fetch();

            if ($existente) {
                $id_usuario = $existente['iduser'];
            } else {
                $stmtUser = $pdo->prepare("SELECT iduser FROM usuario WHERE correo = ? LIMIT 1");
                $stmtUser->execute([$emailFinal]);
                $user = $stmtUser->fetch();

                if ($user) {
                    $id_usuario = $user['iduser'];
                } else {
                    $password = substr(md5(uniqid()), 0, 8);
                    $sql = "INSERT INTO usuario (id_pla, nombre, correo, usuario, password, dni, telefono, n_operacion, m_pagado, banco, fecha_deposito, estatus)
                            VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, 'PAYPAL', NOW(), 1)";
                    $stmtInsert = $pdo->prepare($sql);
                    $stmtInsert->execute([$nombreFinal, $emailFinal, $emailFinal, $password, $dni, $celular, $orderId, $monto]);
                    $id_usuario = $pdo->lastInsertId();
                }
            }

            // Matricular en el curso (mismo criterio que ya usa el webhook de Hotmart)
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

            file_put_contents($logFile, date('Y-m-d H:i:s') . " | VENTA PAYPAL OK: $nombreFinal ($emailFinal) - Orden $orderId - $monto $monedaPagada - Curso: $curso\n", FILE_APPEND);

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR BD: " . $e->getMessage() . " (Orden $orderId, ya pagada en PayPal)\n", FILE_APPEND);
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Tu pago en PayPal fue exitoso pero hubo un error al registrarlo. Escribenos por el chat con tu numero de orden: ' . $orderId]);
        }
    }
}
