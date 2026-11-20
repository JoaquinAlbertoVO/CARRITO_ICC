<?php
namespace App\Controllers;

use App\Models\Catalogo;

/**
 * Admin > Packs y cursos grabados. Se usa dentro de AdminCursosController (el router manda todo
 * /admin/<metodo> a ese controlador, que ya exige sesion de admin).
 *
 * Todas las acciones que escriben piden POST y un token propio (evita que una pagina ajena haga
 * que el admin apruebe una venta sin saberlo).
 */
trait AdminCatalogo {

    private function cat_token() {
        if (empty($_SESSION['csrf_catalogo'])) {
            $_SESSION['csrf_catalogo'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['csrf_catalogo'];
    }

    /** Corta si no es un POST con el token correcto. */
    private function cat_post_valido($volver) {
        $ok = $_SERVER['REQUEST_METHOD'] === 'POST'
            && !empty($_SESSION['csrf_catalogo'])
            && hash_equals($_SESSION['csrf_catalogo'], (string) ($_POST['_token'] ?? ''));
        if (!$ok) {
            $this->cat_volver($volver, 'danger', 'La sesión del formulario venció. Vuelve a intentarlo.');
        }
    }

    private function cat_volver($ruta, $tipo, $texto) {
        $_SESSION['cat_msg'] = ['tipo' => $tipo, 'texto' => $texto];
        header('Location: ' . BASE_URL . $ruta);
        exit;
    }

    private function cat_msg() {
        $m = $_SESSION['cat_msg'] ?? null;
        unset($_SESSION['cat_msg']);
        return $m;
    }

    /** Lista de packs y cursos grabados con lo que les falta para venderse. */
    public function catalogo() {
        $cat = new Catalogo();
        $this->view('admin/catalogo/index', [
            'msg' => $this->cat_msg(), 'token' => $this->cat_token(),
            'cursos' => $cat->cursosAsincronos(false), 'packs' => $cat->packs(false),
            'pendientes' => count($cat->ventas('pendiente', 500)),
        ], 'admin/layouts/main');
    }

    /** POST: sube el JSON generado desde el Excel. */
    public function catalogo_importar() {
        $this->cat_post_valido('admin/catalogo');
        if (empty($_FILES['archivo']['tmp_name']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            $this->cat_volver('admin/catalogo', 'danger', 'Elige el archivo .json del catálogo.');
        }
        if ($_FILES['archivo']['size'] > 5 * 1024 * 1024) {
            $this->cat_volver('admin/catalogo', 'danger', 'El archivo es demasiado grande (máx. 5 MB).');
        }
        $data = json_decode(file_get_contents($_FILES['archivo']['tmp_name']), true);
        if (!is_array($data)) {
            $this->cat_volver('admin/catalogo', 'danger', 'El archivo no es un JSON válido.');
        }
        try {
            $r = (new Catalogo())->importar($data);
        } catch (\Throwable $e) {
            error_log('Catalogo importar: ' . $e->getMessage());
            $this->cat_volver('admin/catalogo', 'danger', 'No se pudo importar: ' . $e->getMessage());
        }
        $this->cat_volver('admin/catalogo', 'success', sprintf(
            'Importado: %d cursos nuevos, %d actualizados, %d clases, %d materiales, %d packs. Precios, horas y publicación no se tocaron.',
            $r['cursos_nuevos'], $r['cursos_actualizados'], $r['clases'], $r['materiales'], $r['packs']
        ));
    }

    /** GET: formulario del curso grabado. POST: guarda. */
    public function catalogo_curso($id = 0) {
        $cat = new Catalogo();
        $curso = $cat->curso((int) $id);
        if (!$curso || $curso['modalidad'] !== Catalogo::MODALIDAD_ASINCRONO) {
            $this->cat_volver('admin/catalogo', 'danger', 'Curso no encontrado.');
        }
        $ruta = 'admin/catalogo_curso/' . (int) $id;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cat_post_valido($ruta);
            $d = [
                'nombre' => trim((string) ($_POST['nombre'] ?? '')),
                'sigla' => substr(preg_replace('/[^A-Z0-9]/', '', strtoupper((string) ($_POST['sigla'] ?? ''))), 0, 10),
                'precio' => Catalogo::precioONull($_POST['precio'] ?? ''),
                'precio_usd' => Catalogo::precioONull($_POST['precio_usd'] ?? ''),
                'horas' => max(0, (int) ($_POST['horas'] ?? 0)),
                'resumen' => trim((string) ($_POST['resumen'] ?? '')),
                'publicado' => !empty($_POST['publicado']),
            ];
            if ($d['nombre'] === '') {
                $this->cat_volver($ruta, 'danger', 'El nombre es obligatorio (sale en el certificado).');
            }
            if ($d['publicado'] && (!$d['precio'] || !$d['precio_usd'] || $d['horas'] <= 0)) {
                $d['publicado'] = false;
                $cat->guardarCurso($id, $d);
                $this->cat_volver($ruta, 'warning', 'Guardado, pero NO publicado: para venderlo necesita precio en soles, en dólares y horas académicas.');
            }
            $cat->guardarCurso($id, $d);
            $this->cat_volver($ruta, 'success', 'Curso guardado' . ($d['publicado'] ? ' y publicado en la tienda.' : '.'));
        }

        $this->view('admin/catalogo/curso', [
            'msg' => $this->cat_msg(), 'token' => $this->cat_token(), 'curso' => $curso,
            'materiales' => $cat->materiales($id, false),
            'clases' => (new \App\Models\Curso())->getVideosByCurso($id),
        ], 'admin/layouts/main');
    }

    /** POST: alta, edicion o borrado de un material del curso. */
    public function catalogo_material() {
        $idCurso = (int) ($_POST['id_curso'] ?? 0);
        $ruta = 'admin/catalogo_curso/' . $idCurso;
        $this->cat_post_valido($ruta);
        $cat = new Catalogo();
        if (!empty($_POST['eliminar'])) {
            $cat->eliminarMaterial((int) $_POST['eliminar']);
            $this->cat_volver($ruta, 'success', 'Material eliminado.');
        }
        $url = trim((string) ($_POST['url'] ?? ''));
        $titulo = trim((string) ($_POST['titulo'] ?? ''));
        if ($titulo === '' || !preg_match('#^https://#i', $url)) {
            $this->cat_volver($ruta, 'danger', 'El material necesita título y un enlace que empiece con https:// (Drive, PDF, etc.).');
        }
        $cat->guardarMaterial([
            'id_material' => (int) ($_POST['id_material'] ?? 0), 'id_curso' => $idCurso,
            'titulo' => substr($titulo, 0, 255), 'tipo' => substr(preg_replace('/[^a-z]/', '', strtolower((string) ($_POST['tipo'] ?? 'pdf'))), 0, 20) ?: 'pdf',
            'url' => substr($url, 0, 500), 'orden' => (int) ($_POST['orden'] ?? 0), 'estado' => !isset($_POST['estado']) || !empty($_POST['estado']),
        ]);
        $this->cat_volver($ruta, 'success', 'Material guardado.');
    }

    /** GET: formulario del pack. POST: guarda. */
    public function catalogo_pack($id = 0) {
        $cat = new Catalogo();
        $pack = $cat->pack((int) $id);
        if (!$pack) {
            $this->cat_volver('admin/catalogo', 'danger', 'Pack no encontrado.');
        }
        $ruta = 'admin/catalogo_pack/' . (int) $id;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cat_post_valido($ruta);
            $d = [
                'nombre' => trim((string) ($_POST['nombre'] ?? '')),
                'descripcion' => trim((string) ($_POST['descripcion'] ?? '')),
                'publico' => substr(trim((string) ($_POST['publico'] ?? '')), 0, 255),
                'precio' => Catalogo::precioONull($_POST['precio'] ?? ''),
                'precio_usd' => Catalogo::precioONull($_POST['precio_usd'] ?? ''),
                'orden' => (int) ($_POST['orden'] ?? 0),
                'publicado' => !empty($_POST['publicado']),
                'cursos' => array_map('intval', (array) ($_POST['cursos'] ?? [])),
            ];
            if ($d['nombre'] === '' || !$d['cursos']) {
                $this->cat_volver($ruta, 'danger', 'El pack necesita nombre y al menos un curso.');
            }
            $cat->guardarPack($id, $d);
            if ($d['publicado']) {
                $p = $cat->pack($id);
                $faltan = [];
                if (!$d['precio'] || !$d['precio_usd']) {
                    $faltan[] = 'precio en soles y en dólares';
                }
                foreach ($p['cursos'] as $c) {
                    if ((int) $c['horas_academicas'] <= 0) {
                        $faltan[] = 'horas de "' . $c['nombre_curso'] . '"';
                    }
                }
                if ($faltan) {
                    $d['publicado'] = false;
                    $cat->guardarPack($id, $d);
                    $this->cat_volver($ruta, 'warning', 'Guardado, pero NO publicado. Falta: ' . implode(', ', $faltan) . '.');
                }
            }
            $this->cat_volver($ruta, 'success', 'Pack guardado' . ($d['publicado'] ? ' y publicado en la tienda.' : '.'));
        }

        $this->view('admin/catalogo/pack', [
            'msg' => $this->cat_msg(), 'token' => $this->cat_token(), 'pack' => $pack,
            'todos' => $cat->cursosAsincronos(false),
        ], 'admin/layouts/main');
    }

    /** Ventas del catalogo: los vouchers quedan pendientes hasta que alguien los apruebe aqui. */
    public function catalogo_ventas() {
        $cat = new Catalogo();
        $this->view('admin/catalogo/ventas', [
            'msg' => $this->cat_msg(), 'token' => $this->cat_token(),
            'pendientes' => $cat->ventas('pendiente', 200), 'recientes' => $cat->ventas(null, 100),
        ], 'admin/layouts/main');
    }

    /** POST: aprobar (da acceso) o rechazar una venta pendiente. */
    public function catalogo_venta() {
        $this->cat_post_valido('admin/catalogo_ventas');
        $cat = new Catalogo();
        $venta = $cat->venta((int) ($_POST['id_venta'] ?? 0));
        if (!$venta || $venta['estado'] !== 'pendiente') {
            $this->cat_volver('admin/catalogo_ventas', 'warning', 'Esa venta ya no está pendiente.');
        }
        if (($_POST['accion'] ?? '') === 'rechazar') {
            $cat->cerrarVenta($venta['id_venta'], 'rechazado');
            $this->cat_volver('admin/catalogo_ventas', 'success', 'Venta marcada como rechazada. No se dio acceso.');
        }
        try {
            require_once __DIR__ . '/../Helpers/VentaCatalogo.php';
            $r = \App\Helpers\VentaCatalogo::concretar($cat, $venta);
        } catch (\Throwable $e) {
            error_log('Catalogo aprobar venta ' . $venta['id_venta'] . ': ' . $e->getMessage());
            $this->cat_volver('admin/catalogo_ventas', 'danger', 'No se pudo dar el acceso: ' . $e->getMessage());
        }
        $this->cat_volver('admin/catalogo_ventas', 'success', 'Acceso dado a ' . $venta['nombre'] . ' (' . count($r['cursos']) . ' cursos). '
            . ($r['cuenta_nueva'] ? 'Se creó su cuenta y se le enviaron sus accesos por correo.' : 'Ya tenía cuenta: se le avisó por correo.'));
    }

    /** Comprobante de un voucher (vive fuera de la web). */
    public function catalogo_comprobante($id = 0) {
        $venta = (new Catalogo())->venta((int) $id);
        $archivo = $venta ? basename((string) $venta['comprobante']) : '';
        $ruta = __DIR__ . '/../../storage/comprobantes/' . $archivo;
        if ($archivo === '' || !is_file($ruta)) {
            http_response_code(404);
            echo 'Comprobante no encontrado.';
            return;
        }
        $mimes = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'pdf' => 'application/pdf', 'webp' => 'image/webp'];
        $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
        header('Content-Disposition: inline; filename="' . $archivo . '"');
        header('X-Content-Type-Options: nosniff');
        readfile($ruta);
        exit;
    }
}
