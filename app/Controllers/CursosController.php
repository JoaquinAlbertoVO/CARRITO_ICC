<?php
namespace App\Controllers;

use App\Core\Controller;

class CursosController extends Controller {
    /** Slug de la URL del detalle (cursos/detalle/{slug}) a partir del nombre del curso. */
    public static function slug($nombre) {
        $s = mb_strtolower((string) $nombre, 'UTF-8');
        $s = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $s);
        $s = preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', $s));
        return str_replace('_', '-', $s);
    }

    /**
     * Precio de preventa (S/ y US$) y horas que muestran las listas de cursos (mismos valores que
     * antes estaban repetidos en cursos/index.php y en ingenieria()). La fecha sale de la BD
     * (fecha_prox), como en el inicio: las fechas fijas de esta tabla eran de agosto y ya vencieron.
     */
    public static function datosLista($c) {
        $n = mb_strtolower($c['nombre_curso'] ?? '', 'UTF-8');
        $fecha = !empty($c['fecha_prox']) ? $c['fecha_prox'] : 'PRÓXIMAMENTE';
        $regular = \App\Models\Catalogo::regularPen($c);
        $tabla = [
            'subestaciones' => [150.00, 45.00, '18/08', 25],
            'condensadores' => [150.00, 30.00, '01/09', 25],
            'analizador' => [150.00, 30.00, '17/08', 25],
            'canalizacion' => [100.00, 30.00, '04/08', 16],
            'terminaciones' => [150.00, 30.00, '26/08', 15],
            'empalmes' => [150.00, 30.00, '26/08', 15],
            'variadores' => [150.00, 35.00, '20/08', 30],
            'electricidad industrial' => [150.00, 30.00, '17/08', 40],
        ];
        foreach ($tabla as $clave => $v) {
            if (strpos($n, $clave) !== false) {
                // El precio en soles es el de la BD (admin); la tabla queda de respaldo
                $pen = (float) ($c['precio'] ?? 0) > 0 ? (float) $c['precio'] : $v[0];
                return ['pen' => $pen, 'regular' => $regular, 'usd' => $v[1], 'fecha' => $fecha, 'horas' => $v[3]];
            }
        }
        return ['pen' => (float) ($c['precio'] ?? 89.90), 'regular' => $regular, 'usd' => 30.00, 'fecha' => $fecha, 'horas' => (int) ($c['horas_academicas'] ?? 20)];
    }

    /** Tarjeta de curso para las vistas de lista (cursos/index e ingenieria). */
    private function tarjeta($c) {
        $d = self::datosLista($c);
        return [
            'id' => $c['id_curso'],
            'title' => $c['nombre_curso'],
            'image' => 'assets/images/cursos/' . ($c['foto'] ?: 'default.png'),
            'price' => number_format($d['pen'], 2),
            'price_usd' => number_format($d['usd'], 2),
            'price_regular' => $d['regular'] ? number_format($d['regular'], 2) : null,
            'date' => $d['fecha'],
            'hours' => $d['horas'] . ' hrs',
            'link' => self::slug($c['nombre_curso']),
            'docente' => $c['docente'] ?? '',
            'docente_foto' => $c['docente_foto'] ?? '',
        ];
    }

    /** Tarjeta de un curso grabado: lleva a su pagina de compra en la tienda. */
    private function tarjetaGrabado($c) {
        $foto = $c['foto'] ?? '';
        $regular = \App\Models\Catalogo::regularPen($c);
        $docente = trim((string) ($c['docente'] ?? ''));
        return [
            'id' => $c['id_curso'],
            'title' => $c['nombre_curso'],
            'image' => ($foto !== '' && $foto !== 'default.png') ? 'assets/images/cursos/' . $foto : '',
            'price' => number_format((float) $c['precio'], 2),
            'price_usd' => number_format((float) $c['precio_usd'], 2),
            'price_regular' => $regular ? number_format($regular, 2) : null,
            'date' => 'A tu ritmo',
            'date_icon' => 'fas fa-play-circle',
            'hours' => (int) $c['horas_academicas'] . ' hrs',
            'url' => BASE_URL . 'tienda/curso/' . $c['slug'],
            'badge' => 'Grabado',
            'docente' => ($docente === 'Docente') ? '' : $docente,
            'docente_foto' => $c['docente_foto'] ?? '',
        ];
    }

    public function index() {
        $cursoModel = new \App\Models\Curso();
        $cursos_db = $cursoModel->getCursos(1); // 1 = estado activo
        $cursos = array_filter($cursos_db, function($c) {
            return mb_stripos($c['nombre_curso'], 'canalizaci', 0, 'UTF-8') === false;
        });

        // Cursos grabados a la venta en la tienda (los mismos de "Cursos sueltos")
        $grabados = array_values(array_filter((new \App\Models\Catalogo())->cursosAsincronos(true), function ($c) {
            return \App\Models\Catalogo::vendible($c);
        }));

        $data = [
            'title' => 'Cursos - Instituto de Capacitación Continua',
            'meta_description' => 'Explora todos nuestros cursos disponibles: en vivo por Zoom y grabados para avanzar a tu ritmo.',
            'cursos' => array_map([$this, 'tarjeta'], array_values($cursos)),
            'grabados' => array_map([$this, 'tarjetaGrabado'], $grabados),
        ];
        $this->view('cursos/index', $data, 'layouts/sitio');
    }

    public function ingenieria() {
        $cursoModel = new \App\Models\Curso();
        $cursos_raw = $cursoModel->getCursos(1);
        $cursos_db = array_filter($cursos_raw, function($c) {
            return mb_stripos($c['nombre_curso'], 'canalizaci', 0, 'UTF-8') === false;
        });

        $ingenieria_courses = [];
        foreach ($cursos_db as $c) {
            $cat = mb_strtolower($c['categoria'] ?? '', 'UTF-8');
            if ($cat == 'ingeniería' || $cat == 'ingenieria' || $cat == '') {
                $ingenieria_courses[] = $this->tarjeta($c);
            }
        }

        $data = [
            'title' => 'Cursos de Ingeniería - ICC',
            'meta_description' => 'Cursos especializados en Ingeniería.',
            'ingenieria_courses' => $ingenieria_courses
        ];
        $this->view('cursos/ingenieria', $data, 'layouts/sitio');
    }

    public function detalle($slug = '') {
        if(empty($slug)) {
            // Si no hay slug, redirigir a cursos
            header('Location: ' . BASE_URL . 'cursos');
            exit;
        }

        $cursoModel = new \App\Models\Curso();
        $cursos = $cursoModel->getCursos(1);
        $curso_encontrado = null;

        foreach ($cursos as $c) {
            // El slug de entrada puede tener guiones o subguiones
            if (self::slug($c['nombre_curso']) === str_replace('_', '-', $slug)) {
                $curso_encontrado = $c;
                break;
            }
        }

        if (!$curso_encontrado) {
            die("Error 404: Curso no encontrado");
        }

        // Obtener videos para el temario
        require_once 'app/Models/VideoModel.php';
        $videoModel = new \App\Models\VideoModel();
        $videos_db = $videoModel->getVideosByCurso($curso_encontrado['id_curso']);
        
        // Agrupar por módulo
        $modulos = [];
        foreach ($videos_db as $v) {
            $modulos[$v['modulo']][] = $v;
        }

        
        // Otros 3 cursos para recomendar al final, excluyendo el actual (precio de la lista)
        $latest_courses = [];
        foreach ($cursos as $c) {
            if ($c['id_curso'] != $curso_encontrado['id_curso']) {
                $latest_courses[] = $this->tarjeta($c);
            }
            if (count($latest_courses) >= 3) break;
        }

        // Generar Schema Markup (JSON-LD) para Rich Snippets
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Course",
            "name" => $curso_encontrado['nombre_curso'],
            "description" => $curso_encontrado['descripcion'] ?? 'Curso en el Instituto de Capacitación Continua.',
            "provider" => [
                "@type" => "Organization",
                "name" => "Instituto de Capacitación Continua - ICC",
                "sameAs" => BASE_URL
            ],
            "offers" => [
                "@type" => "Offer",
                "price" => $curso_encontrado['precio'] ?? "89.90",
                "priceCurrency" => "PEN",
                "category" => "Paid"
            ]
            // Sin "aggregateRating": no hay reseñas reales que lo respalden
        ];

        $data = [
            'title' => $curso_encontrado['nombre_curso'] . ' - ICC',
            'meta_description' => $curso_encontrado['descripcion'] ?? 'Información detallada del curso en el Instituto de Capacitación Continua.',
            'og_image' => BASE_URL . 'assets/images/cursos/' . ($curso_encontrado['foto'] ?? 'default.png'),
            'og_url' => BASE_URL . 'cursos/detalle/' . $slug,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'curso' => $curso_encontrado,
            'modulos' => $modulos,
            'latest_courses' => $latest_courses
        ];

        $this->view('cursos/detalle_curso', $data, 'layouts/sitio');
    }
}

