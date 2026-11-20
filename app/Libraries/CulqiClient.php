<?php
namespace App\Libraries;

require_once __DIR__ . '/../Helpers/Mailer.php';

/**
 * Cliente minimo de Culqi (cobro con tarjeta en soles) del lado del servidor.
 * El navegador solo convierte la tarjeta en un token (Culqi Checkout Custom); el cargo
 * lo crea este servidor con la llave secreta, asi que el monto lo decide el servidor.
 *
 * Requiere en el .env del servidor (CulqiPanel > Desarrollo > API Keys):
 *   CULQI_PUBLIC_KEY=pk_test_... / pk_live_...
 *   CULQI_SECRET_KEY=sk_test_... / sk_live_...
 * Con llaves de integracion (pk_test_/sk_test_) no se hacen cobros reales.
 *
 * Docs: https://docs.culqi.com/es/documentacion/checkout/checkout-custom
 *       https://docs.culqi.com/es/documentacion/culqi-3ds/v1/uso-libreria
 *       https://apidocs.culqi.com/#tag/Cargos/operation/crear-cargo
 */
class CulqiClient {
    const API_CARGOS = 'https://api.culqi.com/v2/charges';

    private $secretKey;

    public function __construct() {
        $this->secretKey = \App\Helpers\Mailer::env('CULQI_SECRET_KEY');
    }

    /** Llave publica para el checkout del navegador ('' si Culqi no esta configurado). */
    public static function llavePublica() {
        return \App\Helpers\Mailer::env('CULQI_PUBLIC_KEY');
    }

    /**
     * Crea un cargo. Segun la API de Culqi:
     *   201 + objeto "charge"          -> cargo exitoso
     *   200 + action_code "REVIEW"     -> el banco pide autenticacion 3DS (reintentar con authentication_3DS)
     *   4xx/5xx + objeto "error"       -> cargo rechazado o error
     *
     * @return array ['estado' => 'exitoso'|'requiere_3ds'|'rechazado', 'http' => int, 'data' => array]
     */
    public function crearCargo(array $cuerpo) {
        if ($this->secretKey === '') {
            throw new \Exception('Falta CULQI_SECRET_KEY en el .env del servidor');
        }

        $ch = curl_init(self::API_CARGOS);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($cuerpo, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->secretKey,
            ],
        ]);
        $respuesta = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new \Exception('Error de red al conectar con Culqi: ' . $err);
        }
        $data = json_decode((string) $respuesta, true);
        if (!is_array($data)) {
            throw new \Exception('Respuesta no valida de Culqi (HTTP ' . $http . '): ' . substr((string) $respuesta, 0, 300));
        }

        // Se decide por el contenido, no solo por el codigo HTTP (la documentacion de Culqi no es
        // consistente sobre si 200 o 201 es el exito; el objeto devuelto si lo es).
        if (($data['object'] ?? '') === 'charge' && ($data['outcome']['type'] ?? '') === 'venta_exitosa') {
            return ['estado' => 'exitoso', 'http' => $http, 'data' => $data];
        }
        if (($data['action_code'] ?? '') === 'REVIEW') {
            return ['estado' => 'requiere_3ds', 'http' => $http, 'data' => $data];
        }
        return ['estado' => 'rechazado', 'http' => $http, 'data' => $data];
    }
}
