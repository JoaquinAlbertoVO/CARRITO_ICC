<?php
namespace App\Helpers;

/**
 * Deteccion de pais por IP, para decidir que medios de pago mostrar por defecto
 * en el checkout segun de donde venga el visitante (vision de mercado internacional).
 *
 * Usa la API gratuita de ip-api.com (sin API key, sin costo). Si falla, esta lenta,
 * o la IP no se puede geolocalizar (ej. localhost en desarrollo), se usa Peru por
 * defecto: el checkout NUNCA debe romperse ni demorarse por esto.
 *
 * El usuario siempre puede seguir forzando el pais/moneda a mano con ?moneda=PEN|USD
 * en la URL (para links promocionales) - la deteccion solo decide el valor por defecto.
 */
class GeoHelper {

    const PAIS_POR_DEFECTO = 'PE';

    // Reglas por pais: moneda sugerida y que pestañas de pago mostrar.
    // Hoy solo hay 2 rieles: "manual" (Yape/Plin, solo tiene sentido en Peru) y "paypal"
    // (funciona en cualquier pais). Cuando se sume una pasarela nueva para otro pais
    // (ej. Mercado Pago para Mexico/Colombia/Argentina), solo hay que agregar su fila aqui.
    const REGLAS_POR_PAIS = [
        'PE' => ['moneda' => 'PEN', 'metodos' => ['manual', 'paypal']],
    ];

    // Cualquier pais que no esté explícitamente en REGLAS_POR_PAIS cae aquí
    const REGLA_INTERNACIONAL = ['moneda' => 'USD', 'metodos' => ['paypal']];

    public static function detectarPais() {
        // Cache en sesion: si el visitante recarga el checkout varias veces, no volvemos
        // a llamar a la API externa en cada carga (ahorra tiempo y no gasta el limite gratuito).
        if (!empty($_SESSION['pais_detectado'])) {
            return $_SESSION['pais_detectado'];
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '';

        // IPs locales/privadas (desarrollo, pruebas desde el propio servidor) no se
        // pueden geolocalizar: usamos el pais por defecto sin llamar a ninguna API.
        if (empty($ip) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return self::PAIS_POR_DEFECTO;
        }

        $codigoPais = null;

        try {
            $ch = curl_init('http://ip-api.com/json/' . urlencode($ip) . '?fields=status,countryCode');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 2,        // No debe retrasar el checkout si la API esta lenta
                CURLOPT_CONNECTTIMEOUT => 2,
            ]);
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if (!$err && $response) {
                $data = json_decode($response, true);
                if (!empty($data['status']) && $data['status'] === 'success' && !empty($data['countryCode'])) {
                    $codigoPais = strtoupper($data['countryCode']);
                }
            }
        } catch (\Exception $e) {
            // Silencioso a proposito: si la deteccion falla, seguimos con el pais por defecto
        }

        $codigoPais = $codigoPais ?: self::PAIS_POR_DEFECTO;
        $_SESSION['pais_detectado'] = $codigoPais;
        return $codigoPais;
    }

    /**
     * @return array{moneda: string, metodos: string[]}
     */
    public static function reglasParaPais($countryCode) {
        return self::REGLAS_POR_PAIS[$countryCode] ?? self::REGLA_INTERNACIONAL;
    }
}
