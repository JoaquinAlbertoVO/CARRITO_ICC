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

    // -------------------------------------------------------------
    // CONEXIÓN A BASE DE DATOS (Estilo MySQLi, como en check_db.php)
    // Cambiar estas credenciales en el servidor de producción si es necesario
    // -------------------------------------------------------------
    
    /* 
    $conn = new mysqli('localhost', 'root', '', 'prueba1');
    if (!$conn->connect_error) {
        // Ejemplo de Query para registrar al alumno (ajusta el nombre de tu tabla)
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, curso_comprado) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $curso);
        $stmt->execute();
        $stmt->close();
    }
    */

    // Log en archivo de texto para verificar que funciona
    $log_msg = date("Y-m-d H:i:s") . " | VENTA EXITOSA: $nombre ($email) compro $curso \n";
    file_put_contents('hotmart_log.txt', $log_msg, FILE_APPEND);

    // IMPORTANTE: Devolver siempre 200 OK a Hotmart
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Alumno procesado en ICC"]);

} else {
    // Si no es compra aprobada, solo devolvemos 200 para que Hotmart termine la petición
    http_response_code(200);
    echo json_encode(["status" => "ignored", "event" => $datos['event'] ?? '']);
}
?>
