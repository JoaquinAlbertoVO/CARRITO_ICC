<?php
namespace App\Helpers;

use App\Models\Catalogo;

/**
 * Concreta una venta del catalogo (curso grabado o pack) ya pagada: crea o reutiliza la cuenta del
 * aula, matricula en los cursos, reserva un certificado por curso y avisa al alumno y a los asesores.
 * Lo usan el pago con PayPal (TiendaController) y la aprobacion de vouchers en el admin.
 */
class VentaCatalogo {

    /**
     * @param array $venta fila de catalogo_ventas
     * @return array ['id_usuario' => int, 'cuenta_nueva' => bool, 'cursos' => string[]]
     */
    public static function concretar(Catalogo $cat, array $venta) {
        require_once __DIR__ . '/Mailer.php';

        list($idUsuario, $password) = $cat->alumnoPorCorreo(
            $venta['correo'], $venta['nombre'], (string) $venta['documento'], (string) $venta['celular'],
            ['referencia' => $venta['referencia'], 'monto' => $venta['monto'], 'banco' => strtoupper($venta['metodo'])]
        );
        $idsCurso = $cat->cursosDeProducto($venta['tipo'], $venta['id_item']);
        $origen = $venta['tipo'] === 'pack' ? 'pack:' . self::codigoPack($cat, $venta['id_item']) : 'curso';
        $cat->matricular($idUsuario, $idsCurso, $origen);
        $cat->cerrarVenta($venta['id_venta'], 'pagado', $idUsuario);

        $nombresCursos = [];
        foreach ($idsCurso as $id) {
            $c = $cat->curso($id);
            if ($c) {
                $nombresCursos[] = $c['nombre_curso'];
            }
        }

        self::correoAcceso($venta['correo'], $venta['nombre'], $venta['item_nombre'], $nombresCursos, $venta['correo'], $password);

        Mailer::notificarMatricula([
            'metodo' => $venta['metodo'] === 'paypal' ? 'PayPal / Tarjeta' : 'Yape / Plin / Transferencia (aprobado en el admin)',
            'estado' => 'PAGADO', 'nombre' => $venta['nombre'], 'documento' => $venta['documento'], 'correo' => $venta['correo'],
            'celular' => $venta['celular'], 'curso' => $venta['item_nombre'] . ($venta['tipo'] === 'pack' ? ' (' . count($idsCurso) . ' cursos)' : ''),
            'monto' => $venta['monto'], 'moneda' => $venta['moneda'], 'referencia' => $venta['referencia'],
            'nota' => 'Pago confirmado. El alumno ya tiene acceso en el aula virtual y sus certificados listos para descargar.',
        ]);

        return ['id_usuario' => $idUsuario, 'cuenta_nueva' => $password !== null, 'cursos' => $nombresCursos];
    }

    private static function codigoPack(Catalogo $cat, $idPack) {
        $p = $cat->pack($idPack);
        return $p ? $p['codigo'] : (string) $idPack;
    }

    /** Correo al alumno: accesos (si la cuenta es nueva) y lista de cursos con certificado. */
    public static function correoAcceso($email, $nombre, $producto, array $cursos, $usuario, $password = null) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
        $login = 'https://icc.com.pe/aula/login';
        $lista = '';
        foreach ($cursos as $c) {
            $lista .= '<li style="margin:4px 0;">' . $h($c) . '</li>';
        }
        $credenciales = $password !== null
            ? '<div style="background:#f5f7fb;border:1px dashed #c9d3ea;border-radius:8px;padding:16px;margin:20px 0;">'
              . '<p style="margin:4px 0;"><strong>Usuario:</strong> ' . $h($usuario) . '</p>'
              . '<p style="margin:4px 0;"><strong>Contraseña:</strong> ' . $h($password) . '</p></div>'
            : '<p style="color:#4b5573;">Entra con tu mismo usuario de siempre (<strong>' . $h($usuario) . '</strong>). Si no recuerdas tu contraseña, escríbenos.</p>';

        $body = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:540px;margin:0 auto;color:#0a1640;">'
            . '<div style="background:#061660;padding:18px 20px;border-radius:12px 12px 0 0;"><span style="color:#cddd32;font-weight:bold;font-size:18px;">ICC · Aula Virtual</span></div>'
            . '<div style="border:1px solid #e8eefb;border-top:0;border-radius:0 0 12px 12px;padding:20px;">'
            . '<h2 style="color:#0050f4;margin:0 0 8px;">¡Listo, ' . $h($nombre) . '!</h2>'
            . '<p>Tu pago de <strong>' . $h($producto) . '</strong> fue confirmado. Ya tienes acceso a:</p>'
            . '<ul style="padding-left:20px;">' . $lista . '</ul>'
            . '<p>Las clases están grabadas: avanzas a tu ritmo. <strong>Tu certificado de cada curso ya está disponible para descargar</strong> desde el aula.</p>'
            . $credenciales
            . '<p><a href="' . $login . '" style="background:#0050f4;color:#fff;padding:12px 24px;border-radius:10px;text-decoration:none;font-weight:bold;display:inline-block;">Entrar al Aula Virtual</a></p>'
            . '<p style="font-size:13px;color:#4b5573;margin-top:24px;">¿Problemas para entrar? Escríbenos a informes@icc.com.pe o al WhatsApp +51 941 208 020.</p>'
            . '</div></div>';

        $headers = "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\nFrom: ICC <informes@icc.com.pe>\r\n";
        // @: un fallo de correo nunca debe tumbar la matricula (el alumno ya quedo creado)
        return @mail($email, '=?UTF-8?B?' . base64_encode('Tu acceso a ' . $producto . ' - ICC') . '?=', $body, $headers);
    }
}
