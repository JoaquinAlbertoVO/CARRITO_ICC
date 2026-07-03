<?php
header('Content-Type: application/json');

// Permitir solicitudes CORS desde cualquier origen si es necesario (opcional)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST");

// Obtener datos enviados desde el frontend
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['token']) || !isset($data['amount']) || !isset($data['email'])) {
    echo json_encode([
        'success' => false,
        'error' => ['user_message' => 'Datos incompletos de transacción.']
    ]);
    exit;
}

$token = $data['token'];
$amount = intval($data['amount']); // Debe ser entero en céntimos (ej: S/ 150.00 -> 15000)
$email = $data['email'];

// =========================================================================
// CONFIGURACIÓN DE TU LLAVE PRIVADA DE CULQUI
// Reemplaza 'sk_test_xxxxxx' por tu llave secreta real (Prueba o Producción)
// =========================================================================
$private_key = 'sk_test_xxxxxxxxxxxxxxxx'; 

// Payload para Culqui API v2 / Charges
$payload = json_encode([
    'amount' => $amount,
    'currency_code' => 'PEN',
    'email' => $email,
    'source_id' => $token
]);

$ch = curl_init('https://api.culqui.com/v2/charges');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $private_key
]);

$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$responseData = json_decode($response, true);

if ($http_status === 200 || $http_status === 201) {
    echo json_encode([
        'success' => true,
        'data' => $responseData
    ]);
} else {
    // Si hay un error, Culqui responde con detalles específicos
    $errorMessage = 'Error desconocido al procesar el pago.';
    if (isset($responseData['user_message'])) {
        $errorMessage = $responseData['user_message'];
    } elseif (isset($responseData['merchant_message'])) {
        $errorMessage = $responseData['merchant_message'];
    }
    
    echo json_encode([
        'success' => false,
        'error' => [
            'user_message' => $errorMessage,
            'details' => $responseData
        ]
    ]);
}
?>
