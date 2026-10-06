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
}
