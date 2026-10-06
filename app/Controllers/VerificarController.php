<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CertificadoRegistro;

/**
 * Pagina publica de verificacion de certificados (/verificar y /verificar/<codigo>).
 * El QR de cada certificado nuevo apunta aqui; los certificados anteriores se verifican
 * escribiendo el codigo impreso en el certificado ("Codigo: CERT-...").
 */
class VerificarController extends Controller {
    public function index($codigo = null) {
        $ingresado = $codigo !== null ? $codigo : ($_GET['c'] ?? '');
        $ingresado = trim((string) $ingresado);

        $estado = 'formulario'; // formulario | valido | anulado | no_encontrado | invalido
        $cert = null;

        if ($ingresado !== '') {
            // Una consulta con codigo no debe indexarse ni quedar en cache
            header('X-Robots-Tag: noindex, nofollow');
            header('Cache-Control: no-store');

            if (CertificadoRegistro::normalizar($ingresado) === '') {
                $estado = 'invalido';
            } else {
                try {
                    $cert = (new CertificadoRegistro())->buscar($ingresado);
                    $estado = $cert ? ($cert['estado'] === 'vigente' ? 'valido' : 'anulado') : 'no_encontrado';
                } catch (\Throwable $e) {
                    error_log('Verificar certificado: ' . $e->getMessage());
                    $estado = 'error';
                }
            }
        }

        $this->view('verificar/index', [
            'title' => 'Verificar certificado - ICC',
            'meta_description' => 'Verifica la autenticidad de un certificado emitido por el Instituto de Capacitación Continua (ICC).',
            'estado' => $estado,
            'cert' => $cert,
            'ingresado' => $ingresado,
            'ruc' => CertificadoRegistro::RUC,
            'razon_social' => CertificadoRegistro::RAZON_SOCIAL,
            'dni_enmascarado' => $cert ? CertificadoRegistro::enmascararDni($cert['dni']) : '',
        ]);
    }

    /**
     * GET /verificar/imagen/<codigo>: imagen JPEG del certificado (sin DNI) para mostrarla junto a los datos.
     * Solo para certificados vigentes; se dibuja a partir del registro y se guarda en assets/certificados_img/.
     */
    public function imagen($codigo = null) {
        header('X-Robots-Tag: noindex, nofollow');
        try {
            $cert = $codigo ? (new CertificadoRegistro())->buscar($codigo) : null;
        } catch (\Throwable $e) {
            $cert = null;
        }
        if (!$cert || $cert['estado'] !== 'vigente') {
            http_response_code(404);
            exit;
        }

        header('Content-Type: image/jpeg');
        header('Cache-Control: public, max-age=3600');

        $ruta = CertificadoRegistro::rutaCache($cert['codigo']);
        if (is_file($ruta)) {
            readfile($ruta);
            exit;
        }

        $img = CertificadoRegistro::renderizarImagen($cert, BASE_URL . 'verificar/' . $cert['codigo']);
        $dir = dirname($ruta);
        if (is_dir($dir) || @mkdir($dir, 0775, true)) {
            @imagejpeg($img, $ruta, 85); // si no se puede guardar, igual se sirve abajo
        }
        imagejpeg($img, null, 85);
        imagedestroy($img);
        exit;
    }

    /**
     * POST /verificar/registrar: lo usa el script de lotes (scripts/generar_certificados_lote.php) para dar de alta
     * en el registro los certificados que acaba de generar. Protegido por CERT_REGISTRO_TOKEN del .env del servidor;
     * sin esa variable el endpoint esta apagado.
     */
    public function registrar() {
        header('Content-Type: application/json');
        header('Cache-Control: no-store');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['ok' => false, 'error' => 'metodo']);
            return;
        }

        require_once __DIR__ . '/../Helpers/Mailer.php';
        $token = trim((string) \App\Helpers\Mailer::env('CERT_REGISTRO_TOKEN'));
        if ($token === '') {
            http_response_code(503);
            echo json_encode(['ok' => false, 'error' => 'apagado: falta CERT_REGISTRO_TOKEN en el .env del servidor']);
            return;
        }

        $in = json_decode(file_get_contents('php://input'), true);
        if (!is_array($in) || !hash_equals($token, (string) ($in['token'] ?? ''))) {
            usleep(400000); // frena los intentos de adivinar el token
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'token']);
            return;
        }

        $lista = $in['certificados'] ?? null;
        if (!is_array($lista) || count($lista) === 0 || count($lista) > 500) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'lista: entre 1 y 500 certificados']);
            return;
        }

        $registro = new CertificadoRegistro();
        $ok = 0;
        $omitidas = 0;
        foreach ($lista as $c) {
            (is_array($c) && $registro->registrar($c)) ? $ok++ : $omitidas++;
        }
        echo json_encode(['ok' => true, 'registrados' => $ok, 'omitidos' => $omitidas]);
    }
}
