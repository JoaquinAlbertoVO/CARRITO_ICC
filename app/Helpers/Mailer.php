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
}
