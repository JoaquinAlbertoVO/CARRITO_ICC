<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Catalogo;

/**
 * Tienda de cursos grabados y packs: /tienda, /tienda/pack/<slug>, /tienda/curso/<slug>.
 *
 * El precio SIEMPRE sale de la BD (admin > Packs y cursos grabados), nunca del navegador:
 * - PayPal: se verifica la orden con PayPal (servidor a servidor) y que el monto cubra el precio en
 *   dolares; recien ahi se da el acceso (cuenta + cursos + certificados reservados).
 * - Yape / Plin / transferencia: queda "pendiente" con su comprobante y un asesor la aprueba en el admin.
 * Un producto sin publicar o sin precio no se puede comprar; el admin lo puede previsualizar.
 */
class TiendaController extends Controller {

    const WHATSAPP = '51941208020';

    private function esAdmin() {
        return !empty($_SESSION['es_admin']);
    }

    private function noEncontrado() {
        http_response_code(404);
        $this->view('tienda/no_encontrado', [], false);
    }

    private function reglasPago() {
        require_once __DIR__ . '/../Helpers/GeoHelper.php';
        $pais = \App\Helpers\GeoHelper::detectarPais();
        $reglas = \App\Helpers\GeoHelper::reglasParaPais($pais);
        $moneda = strtoupper((string) ($_GET['moneda'] ?? $reglas['moneda']));
        if (!in_array($moneda, ['PEN', 'USD'], true)) {
            $moneda = $reglas['moneda'];
        }
        // Hotmart no aplica a la tienda (no hay productos de Hotmart por pack): PayPal siempre, y
        // Yape/Plin solo donde el checkout de siempre lo ofrece (Peru)
        $metodos = in_array('manual', $reglas['metodos'], true) ? ['manual', 'paypal'] : ['paypal'];
        return ['pais' => $pais, 'moneda' => $moneda, 'metodos' => $metodos];
    }

    public function index() {
        $cat = new Catalogo();
        $packs = array_values(array_filter($cat->packs(true), function ($p) { return Catalogo::vendible($p); }));
        $cursos = array_values(array_filter($cat->cursosAsincronos(true), function ($c) { return Catalogo::vendible($c); }));
        $vistaPrevia = false;
        if (!$packs && !$cursos && $this->esAdmin()) {
            // El admin ve todo lo importado aunque no este publicado, para revisar como queda
            $packs = $cat->packs(false);
            $cursos = $cat->cursosAsincronos(false);
            $vistaPrevia = true;
        }
        $this->view('tienda/index', [
            'packs' => $packs, 'cursos' => $cursos, 'pago' => $this->reglasPago(), 'vistaPrevia' => $vistaPrevia,
        ], 'layouts/tienda');
    }

    public function pack($slug = '') {
        $cat = new Catalogo();
        $p = $cat->packPorSlug($slug);
        if (!$p || (!Catalogo::vendible($p) && !$this->esAdmin())) {
            $this->noEncontrado();
            return;
        }
        $this->checkout('pack', $p['id_pack'], [
            'nombre' => $p['nombre'], 'etiqueta' => $p['tipo'] === 'ruta' ? 'Ruta de aprendizaje' : ($p['tipo'] === 'integral' ? 'Pack completo' : 'Pack'),
            'descripcion' => $p['descripcion'], 'publico' => $p['publico'], 'incluye' => $p['incluye'],
            'precio' => (float) $p['precio'], 'precio_usd' => (float) $p['precio_usd'],
            'suma_pen' => Catalogo::sumaSueltos($p, 'precio'), 'suma_usd' => Catalogo::sumaSueltos($p, 'precio_usd'),
            'horas' => Catalogo::horasPack($p), 'cursos' => $p['cursos'], 'vendible' => Catalogo::vendible($p),
            'clases' => array_sum(array_map(function ($c) { return (int) $c['total_clases']; }, $p['cursos'])),
        ]);
    }

    public function curso($slug = '') {
        $cat = new Catalogo();
        $c = $cat->cursoPorSlug($slug);
        if (!$c || (!Catalogo::vendible($c) && !$this->esAdmin())) {
            $this->noEncontrado();
            return;
        }
        $clases = (new \App\Models\Curso())->getVideosByCurso($c['id_curso']);
        $this->checkout('curso', $c['id_curso'], [
            'nombre' => $c['nombre_curso'], 'etiqueta' => 'Curso grabado', 'descripcion' => $c['resumen'], 'publico' => '', 'incluye' => '',
            'precio' => (float) $c['precio'], 'precio_usd' => (float) $c['precio_usd'], 'suma_pen' => null, 'suma_usd' => null,
            'horas' => (int) $c['horas_academicas'], 'cursos' => [], 'vendible' => Catalogo::vendible($c),
            'clases' => (int) $c['total_clases'], 'temario' => array_map(function ($v) { return $v['titulo']; }, $clases),
            'materiales' => (int) $c['total_materiales'],
        ]);
    }

    private function checkout($tipo, $id, array $item) {
        $item['tipo'] = $tipo;
        $item['id'] = (int) $id;
        $pago = $this->reglasPago();
        $this->view('tienda/checkout', [
            'item' => $item, 'pago' => $pago, 'whatsapp' => self::WHATSAPP,
            'js' => [
                'base' => BASE_URL, 'tipo' => $tipo, 'id' => (int) $id, 'nombre' => $item['nombre'],
                'precioPen' => $item['precio'], 'precioUsd' => $item['precio_usd'], 'moneda' => $pago['moneda'],
                'metodos' => $pago['metodos'], 'vendible' => $item['vendible'],
            ],
        ], 'layouts/tienda');
    }

    /** Lee y limpia los datos del alumno que manda el checkout. */
    private function datosAlumno(array $in) {
        $limpio = function ($k, $max) use ($in) {
            return substr(trim(strip_tags((string) ($in[$k] ?? ''))), 0, $max);
        };
        $correo = trim((string) ($in['correo'] ?? ''));
        return [
            'nombre' => trim(preg_replace('/\s+/u', ' ', $limpio('nombre', 100) . ' ' . $limpio('apellido', 100))),
            'documento' => preg_replace('/[^A-Za-z0-9-]/', '', $limpio('dni', 20)),
            'celular' => $limpio('celular', 30),
            'correo' => filter_var($correo, FILTER_VALIDATE_EMAIL) ? strtolower($correo) : '',
        ];
    }

    private function json($datos, $codigo = 200) {
        http_response_code($codigo);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }

    /** POST JSON {orderID, tipo, id, nombre, apellido, dni, celular, correo} despues del capture de PayPal. */
    public function paypal() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'error' => 'Método no permitido'], 405);
        }
        $in = json_decode(file_get_contents('php://input'), true) ?: [];
        $orderId = substr(preg_replace('/[^A-Za-z0-9-]/', '', (string) ($in['orderID'] ?? '')), 0, 100);
        $alumno = $this->datosAlumno($in);
        $log = __DIR__ . '/../../api/paypal_log.txt';
        if ($orderId === '') {
            $this->json(['success' => false, 'error' => 'Falta el número de orden de PayPal.'], 400);
        }

        $cat = new Catalogo();
        $prod = $cat->producto((string) ($in['tipo'] ?? ''), (int) ($in['id'] ?? 0));
        if (!$prod) {
            file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA producto no vendible ({$in['tipo']}/{$in['id']}) Orden $orderId\n", FILE_APPEND);
            $this->json(['success' => false, 'error' => 'Este producto no está a la venta. Escríbenos con tu número de orden: ' . $orderId], 409);
        }

        // Reintento del navegador: la orden ya se registro
        $previa = $cat->ventaPorReferencia('paypal', $orderId);
        if ($previa && $previa['estado'] === 'pagado') {
            $this->json(['success' => true, 'repetido' => true]);
        }

        require_once __DIR__ . '/../Libraries/PayPalClient.php';
        try {
            $order = (new \App\Libraries\PayPalClient())->verifyOrder($orderId);
        } catch (\Throwable $e) {
            file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA ERROR VERIFICACION: " . $e->getMessage() . " (Orden $orderId)\n", FILE_APPEND);
            $this->json(['success' => false, 'error' => 'No pudimos confirmar el pago con PayPal. Escríbenos con tu número de orden: ' . $orderId], 502);
        }
        if (($order['status'] ?? '') !== 'COMPLETED') {
            file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA RECHAZADO estado " . ($order['status'] ?? '?') . " Orden $orderId\n", FILE_APPEND);
            $this->json(['success' => false, 'error' => 'PayPal no confirma este pago como completado.'], 402);
        }
        $unidad = $order['purchase_units'][0] ?? [];
        $monto = (float) ($unidad['payments']['captures'][0]['amount']['value'] ?? ($unidad['amount']['value'] ?? 0));
        $moneda = (string) ($unidad['payments']['captures'][0]['amount']['currency_code'] ?? ($unidad['amount']['currency_code'] ?? ''));
        // El precio es el de la BD: se tolera solo un centavo por redondeo
        if ($moneda !== 'USD' || $monto + 0.01 < $prod['precio_usd']) {
            file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA MONTO NO CUBRE ($monto $moneda < {$prod['precio_usd']} USD) {$prod['nombre']} Orden $orderId - NO matriculado\n", FILE_APPEND);
            $this->json(['success' => false, 'error' => 'El monto pagado no coincide con el precio. Escríbenos con tu número de orden: ' . $orderId], 402);
        }

        $payer = $order['payer'] ?? [];
        if ($alumno['correo'] === '') {
            $alumno['correo'] = filter_var($payer['email_address'] ?? '', FILTER_VALIDATE_EMAIL) ? strtolower($payer['email_address']) : '';
        }
        if ($alumno['nombre'] === '') {
            $alumno['nombre'] = trim(($payer['name']['given_name'] ?? '') . ' ' . ($payer['name']['surname'] ?? '')) ?: 'Alumno';
        }
        if ($alumno['correo'] === '') {
            file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA SIN CORREO Orden $orderId pagada - matricular a mano\n", FILE_APPEND);
            $this->json(['success' => false, 'error' => 'Tu pago se recibió, pero falta tu correo para crear tu acceso. Escríbenos con tu número de orden: ' . $orderId], 422);
        }

        try {
            $idVenta = $previa ? (int) $previa['id_venta'] : $cat->registrarVenta([
                'metodo' => 'paypal', 'referencia' => $orderId, 'tipo' => $prod['tipo'], 'id_item' => $prod['id'], 'item_nombre' => $prod['nombre'],
                'monto' => $monto, 'moneda' => 'USD', 'estado' => 'pendiente',
            ] + $alumno);
            require_once __DIR__ . '/../Helpers/VentaCatalogo.php';
            $r = \App\Helpers\VentaCatalogo::concretar($cat, $cat->venta($idVenta));
        } catch (\Throwable $e) {
            file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA ERROR BD: " . $e->getMessage() . " (Orden $orderId, YA PAGADA)\n", FILE_APPEND);
            $this->json(['success' => false, 'error' => 'Tu pago fue exitoso pero hubo un error al darte el acceso. Escríbenos con tu número de orden: ' . $orderId], 500);
        }
        file_put_contents($log, date('Y-m-d H:i:s') . " | TIENDA VENTA OK {$prod['nombre']} - {$alumno['correo']} - $monto USD - Orden $orderId\n", FILE_APPEND);
        $this->json(['success' => true, 'correo' => $alumno['correo'], 'cuenta_nueva' => $r['cuenta_nueva']]);
    }

    /** POST multipart: comprobante de Yape / Plin / transferencia. Queda pendiente de aprobacion. */
    public function voucher() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'error' => 'Método no permitido'], 405);
        }
        $cat = new Catalogo();
        $prod = $cat->producto((string) ($_POST['tipo'] ?? ''), (int) ($_POST['id'] ?? 0));
        if (!$prod) {
            $this->json(['success' => false, 'error' => 'Este producto no está a la venta.'], 409);
        }
        $alumno = $this->datosAlumno($_POST);
        if ($alumno['nombre'] === '' || $alumno['correo'] === '' || $alumno['celular'] === '') {
            $this->json(['success' => false, 'error' => 'Completa tu nombre, celular y un correo válido.'], 422);
        }
        $f = $_FILES['voucher'] ?? null;
        if (!$f || $f['error'] !== UPLOAD_ERR_OK) {
            $this->json(['success' => false, 'error' => 'Adjunta la captura de tu pago.'], 422);
        }
        if ($f['size'] > 8 * 1024 * 1024) {
            $this->json(['success' => false, 'error' => 'La imagen pesa demasiado (máx. 8 MB).'], 422);
        }
        // Tipo real del archivo (no la extension que manda el navegador)
        $mime = function_exists('mime_content_type') ? mime_content_type($f['tmp_name']) : '';
        $exts = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'application/pdf' => 'pdf'];
        if (!isset($exts[$mime])) {
            $this->json(['success' => false, 'error' => 'Formato no permitido: sube una imagen JPG, PNG o un PDF.'], 422);
        }
        $dir = __DIR__ . '/../../storage/comprobantes/';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $referencia = 'V' . date('YmdHis') . '-' . bin2hex(random_bytes(3));
        $archivo = $referencia . '.' . $exts[$mime];
        if (!move_uploaded_file($f['tmp_name'], $dir . $archivo)) {
            $this->json(['success' => false, 'error' => 'No se pudo guardar el comprobante. Intenta de nuevo.'], 500);
        }
        $metodo = in_array($_POST['metodo'] ?? '', ['yape', 'plin', 'transferencia'], true) ? $_POST['metodo'] : 'yape';
        $cat->registrarVenta([
            'metodo' => $metodo, 'referencia' => $referencia, 'tipo' => $prod['tipo'], 'id_item' => $prod['id'], 'item_nombre' => $prod['nombre'],
            'monto' => $prod['precio'], 'moneda' => 'PEN', 'estado' => 'pendiente', 'comprobante' => $archivo,
        ] + $alumno);

        require_once __DIR__ . '/../Helpers/Mailer.php';
        \App\Helpers\Mailer::notificarMatricula([
            'metodo' => ucfirst($metodo) . ' (voucher)', 'estado' => 'POR VERIFICAR', 'curso' => $prod['nombre'],
            'monto' => number_format($prod['precio'], 2, '.', ''), 'moneda' => 'PEN', 'referencia' => $referencia,
            'nota' => 'Comprobante adjunto. Si el pago llegó, apruébalo en admin > Ventas de packs para darle el acceso.',
        ] + $alumno, ['ruta' => $dir . $archivo, 'nombre' => $archivo, 'mime' => $mime]);

        $this->json(['success' => true]);
    }
}
