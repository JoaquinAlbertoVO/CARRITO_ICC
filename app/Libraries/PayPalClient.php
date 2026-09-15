<?php
namespace App\Libraries;

/**
 * Cliente minimo para verificar ordenes de PayPal contra los servidores de PayPal
 * (server-to-server), en vez de confiar en lo que el navegador dice que paso.
 *
 * Requiere en el .env del servidor:
 *   PAYPAL_CLIENT_ID=...
 *   PAYPAL_SECRET=...
 *   PAYPAL_MODE=live   (o "sandbox" para pruebas)
 */
class PayPalClient {
    private $clientId;
    private $secret;
    private $baseUrl;

    public function __construct() {
        $this->loadEnv();
        $this->clientId = $_ENV['PAYPAL_CLIENT_ID'] ?? '';
        $this->secret    = $_ENV['PAYPAL_SECRET'] ?? '';
        $mode = strtolower($_ENV['PAYPAL_MODE'] ?? 'live');
        $this->baseUrl = ($mode === 'sandbox')
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';
    }

    // Lector de .env identico al de App\Core\Database, por si aun no se cargo en esta petición
    private function loadEnv() {
        if (!empty($_ENV['PAYPAL_CLIENT_ID'])) {
            return;
        }
        $envFile = __DIR__ . '/../../.env';
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            if (preg_match('/^([a-zA-Z0-9_]+)\s*=\s*(.*)$/', $line, $m)) {
                $value = trim($m[2]);
                if (preg_match('/^([\'"])(.*)\1$/', $value, $qm)) {
                    $value = $qm[2];
                }
                $_ENV[$m[1]] = $value;
            }
        }
    }

    private function getAccessToken() {
        if (empty($this->clientId) || empty($this->secret)) {
            throw new \Exception('Faltan PAYPAL_CLIENT_ID / PAYPAL_SECRET en el .env del servidor');
        }

        $ch = curl_init($this->baseUrl . '/v1/oauth2/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERPWD => $this->clientId . ':' . $this->secret,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new \Exception('Error de red al conectar con PayPal: ' . $err);
        }
        $data = json_decode($response, true);
        if ($code !== 200 || empty($data['access_token'])) {
            throw new \Exception('PayPal rechazo la autenticacion (revisa PAYPAL_CLIENT_ID/SECRET/MODE en el .env): ' . $response);
        }
        return $data['access_token'];
    }

    /**
     * Pide a PayPal el estado real de una orden. Esta es la unica fuente de verdad:
     * nunca hay que confiar en que el navegador diga "paymentSuccess = true".
     *
     * @return array Respuesta completa de PayPal (incluye status, purchase_units, payer, etc.)
     */
    public function verifyOrder($orderId) {
        $token = $this->getAccessToken();

        $ch = curl_init($this->baseUrl . '/v2/checkout/orders/' . urlencode($orderId));
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
        ]);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new \Exception('Error de red al consultar la orden en PayPal: ' . $err);
        }
        $data = json_decode($response, true);
        if ($code !== 200 || empty($data)) {
            throw new \Exception('PayPal no pudo devolver la orden ' . $orderId . ' (HTTP ' . $code . '): ' . $response);
        }
        return $data;
    }
}
