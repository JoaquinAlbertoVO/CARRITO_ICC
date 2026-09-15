<?php
namespace App\Libraries;

/**
 * Cliente para llamar a la API del sistema de StEnergyedu (proyecto "react-cours"),
 * especificamente el endpoint enroll-wp que crea/matricula al alumno en el
 * WordPress de stenergyedu.com.
 *
 * Requiere en el .env del servidor:
 *   STENERGY_API_URL=https://stenergyedu.com/sistema/api/index.php
 *   STENERGY_API_SECRET=...  (el mismo que usa el frontend de react-cours)
 */
class StEnergyClient {
    private $apiUrl;
    private $secret;

    public function __construct() {
        $this->loadEnv();
        $this->apiUrl = rtrim($_ENV['STENERGY_API_URL'] ?? 'https://stenergyedu.com/sistema/api/index.php', '/');
        $this->secret = $_ENV['STENERGY_API_SECRET'] ?? '';
    }

    private function loadEnv() {
        if (!empty($_ENV['STENERGY_API_URL'])) {
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

    /**
     * Llama a ?action=enroll-wp para crear/matricular al alumno en un curso de WordPress.
     * @return array{code:int, data:array|null, raw:string}
     */
    public function enrollCourse($courseId, $email, $name, $dni) {
        if (empty($this->secret)) {
            throw new \Exception('Falta STENERGY_API_SECRET en el .env del servidor');
        }

        $payload = [
            'clientEmail' => $email,
            'clientName'  => $name,
            'courseId'    => $courseId,
            'clientDni'   => $dni,
        ];

        $ch = curl_init($this->apiUrl . '?action=enroll-wp');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: ' . $this->secret,
            ],
        ]);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new \Exception('Error de red llamando a enroll-wp: ' . $err);
        }

        return [
            'code' => $code,
            'data' => json_decode($response, true),
            'raw'  => $response,
        ];
    }
}
