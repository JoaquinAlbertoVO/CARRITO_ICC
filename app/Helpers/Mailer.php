<?php
namespace App\Helpers;

/**
 * Envio de correos transaccionales usando mail() nativo de PHP - el mismo mecanismo
 * que ya usan HomeController (formulario de contacto) y LegalController (reclamos),
 * asi que ya sabemos que el servidor lo tiene configurado y funcionando.
 *
 * No depende de ninguna cuenta/API externa (a diferencia de WhatsApp vía CallMeBot,
 * que tiene limites de uso y no es apto para volumen de negocio real).
 */
class Mailer {

    /**
     * Correo de bienvenida con las credenciales del Aula Virtual, para un alumno
     * que se acaba de crear (vía Hotmart, PayPal, o cualquier otro medio de pago
     * que cree la cuenta automaticamente).
     */
    public static function enviarBienvenida($email, $nombre, $usuario, $password, $curso) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $loginUrl = 'https://icc.com.pe/aula/login';
        $subject  = 'Bienvenido a ICC - Tus accesos al Aula Virtual';

        $body = '
        <div style="font-family: Arial, Helvetica, sans-serif; max-width: 520px; margin: 0 auto; color:#0f172a;">
            <h2 style="color:#3730a3; margin-bottom: 4px;">¡Bienvenido(a) a ICC, ' . htmlspecialchars($nombre) . '!</h2>
            <p style="color:#334155;">Tu pago fue confirmado y ya tienes acceso al curso <strong>' . htmlspecialchars($curso) . '</strong> en nuestra Aula Virtual.</p>

            <div style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:8px; padding:16px; margin:20px 0;">
                <p style="margin:4px 0;"><strong>Usuario:</strong> ' . htmlspecialchars($usuario) . '</p>
                <p style="margin:4px 0;"><strong>Contraseña:</strong> ' . htmlspecialchars($password) . '</p>
            </div>

            <p>
                <a href="' . $loginUrl . '" style="background:#3730a3; color:#ffffff; padding:12px 24px; border-radius:24px; text-decoration:none; font-weight:bold; display:inline-block;">
                    Ingresar al Aula Virtual
                </a>
            </p>

            <p style="font-size:0.85rem; color:#64748b; margin-top:24px;">
                Por seguridad, te recomendamos cambiar tu contraseña una vez que ingreses.<br>
                ¿Algún problema para entrar? Escríbenos a <a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a> o al WhatsApp +51 941 208 020.
            </p>
        </div>';

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: ICC <informes@icc.com.pe>\r\n";

        // @ para que un fallo de correo (poco comun, pero posible) nunca tumbe el flujo
        // de matricula que lo llama - el alumno ya quedo creado en la BD de todas formas.
        return @mail($email, $subject, $body, $headers);
    }

    /** Correo del equipo de asesores: recibe un aviso por cada matricula / pago nuevo. */
    const CORREO_ASESORES = 'informes@stenergyedu.com';

    /**
     * Aviso interno para los asesores con todos los datos del alumno, para que lleven su
     * propio control sin entrar al panel admin. Sirve para PayPal, Hotmart y vouchers de
     * Yape/Plin (en ese caso el pago aun esta por verificar y se adjunta la captura).
     *
     * $d: metodo, estado, nombre, documento, correo, celular, curso, monto, moneda, referencia.
     * $adjunto (opcional): ['ruta' => ..., 'nombre' => ..., 'mime' => ...] (max 5 MB).
     */
    public static function notificarMatricula(array $d, $adjunto = null) {
        $v = function ($k) use ($d) {
            $x = isset($d[$k]) ? trim((string) $d[$k]) : '';
            return $x;
        };
        $h = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };

        $porVerificar = $v('estado') === 'POR VERIFICAR';
        $documento = $v('documento') !== '' ? $v('documento') : 'No indicó (alumno del extranjero)';
        $monto = $v('monto') !== '' ? $v('monto') . ' ' . $v('moneda') : '—';

        $filas = [
            'Estado'           => $v('estado'),
            'Medio de pago'    => $v('metodo'),
            'Alumno'           => $v('nombre'),
            'Documento'        => $documento,
            'Correo'           => $v('correo') !== '' ? $v('correo') : '—',
            'Celular/WhatsApp' => $v('celular'),
            'Curso'            => $v('curso'),
            'Monto'            => $monto,
            'Referencia/orden' => $v('referencia') !== '' ? $v('referencia') : '—',
            'Fecha'            => date('d/m/Y H:i') . ' (hora Perú)',
        ];

        $tabla = '';
        foreach ($filas as $etiqueta => $valor) {
            $tabla .= '<tr><td style="padding:8px 12px;background:#f1f5f9;font-weight:bold;border:1px solid #e2e8f0;white-space:nowrap;">'
                . $h($etiqueta) . '</td><td style="padding:8px 12px;border:1px solid #e2e8f0;">' . $h($valor) . '</td></tr>';
        }

        $titulo = $porVerificar ? 'Pago por verificar (Yape/Plin)' : 'Nueva matrícula confirmada';
        $nota = $porVerificar
            ? 'El alumno subió su comprobante (adjunto). Verifica el pago antes de dar acceso.'
            : 'El pago ya fue confirmado y el alumno quedó registrado en el aula virtual.';

        $html = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:560px;margin:0 auto;color:#0f172a;">'
            . '<h2 style="color:#3730a3;margin-bottom:4px;">' . $h($titulo) . '</h2>'
            . '<p style="color:#334155;">' . $h($nota) . '</p>'
            . '<table style="border-collapse:collapse;width:100%;font-size:14px;">' . $tabla . '</table>'
            . '</div>';

        // Sin saltos de linea en el asunto (evita inyeccion de cabeceras con nombres raros)
        $asunto = '[ICC] ' . ($porVerificar ? 'Pago por verificar' : 'Nueva matrícula') . ' - '
            . preg_replace('/[\r\n]+/', ' ', $v('nombre')) . ' - ' . preg_replace('/[\r\n]+/', ' ', $v('curso'));
        $asuntoCodificado = '=?UTF-8?B?' . base64_encode($asunto) . '?=';

        $cabeceras = "MIME-Version: 1.0\r\nFrom: ICC <informes@icc.com.pe>\r\n";

        $adjuntoOk = is_array($adjunto) && !empty($adjunto['ruta']) && is_file($adjunto['ruta']) && filesize($adjunto['ruta']) <= 5 * 1024 * 1024;
        if ($adjuntoOk) {
            $limite = 'icc_' . md5(uniqid('', true));
            $cabeceras .= "Content-Type: multipart/mixed; boundary=\"$limite\"\r\n";
            $nombreAdj = preg_replace('/[^A-Za-z0-9._-]/', '_', $adjunto['nombre'] ?? basename($adjunto['ruta']));
            $mensaje = "--$limite\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
                . chunk_split(base64_encode($html))
                . "--$limite\r\nContent-Type: " . ($adjunto['mime'] ?? 'application/octet-stream') . "; name=\"$nombreAdj\"\r\n"
                . "Content-Transfer-Encoding: base64\r\nContent-Disposition: attachment; filename=\"$nombreAdj\"\r\n\r\n"
                . chunk_split(base64_encode(file_get_contents($adjunto['ruta'])))
                . "--$limite--";
        } else {
            $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
            $mensaje = $html;
        }

        // @ : un fallo de correo nunca debe tumbar la matricula/pago que lo llama
        $ok = @mail(self::CORREO_ASESORES, $asuntoCodificado, $mensaje, $cabeceras);

        // Registro sin datos personales, solo para saber si el aviso salio o fallo
        @file_put_contents(__DIR__ . '/../../api/notificaciones_log.txt',
            date('Y-m-d H:i:s') . ' | ' . ($ok ? 'AVISO ENVIADO' : 'FALLO AVISO') . ' | ' . $v('metodo') . ' | ref ' . $v('referencia') . "\n", FILE_APPEND);

        return $ok;
    }
}
