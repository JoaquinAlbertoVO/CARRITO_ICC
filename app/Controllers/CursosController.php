<?php
namespace App\Controllers;

use App\Core\Controller;

class CursosController extends Controller {
    public function index() {
        $cursoModel = new \App\Models\Curso();
        $cursos = $cursoModel->getCursos(1); // 1 = estado activo

        $data = [
            'title' => 'Cursos - Instituto de Capacitación Continua',
            'meta_description' => 'Explora todos nuestros cursos disponibles.',
            'cursos' => $cursos
        ];
        $this->view('cursos/index', $data);
    }

    public function ingenieria() {
        $cursoModel = new \App\Models\Curso();
        $cursos_db = $cursoModel->getCursos(1);

        $ingenieria_courses = [];
        foreach ($cursos_db as $c) {
            $cat = strtolower($c['categoria'] ?? '');
            if ($cat == 'ingeniería' || $cat == 'ingenieria' || $cat == '') {
                $slug = strtolower(str_replace(' ', '_', $c['nombre_curso']));
                $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                $slug = str_replace('_', '-', $slug); // use hyphens for pretty URLs


                $precioPreventa = 89.90;
                $fechaProx = 'PRÓXIMAMENTE';
                $horas = $c['horas_academicas'] . " hrs";
                
                $nombreCursoSafe = strtolower($c['nombre_curso'] ?? '');
                
                if (strpos($nombreCursoSafe, 'subestaciones') !== false) {
                    $precioPreventa = 99.00;
                    $fechaProx = '18/08';
                    $horas = '25 hrs';
                } elseif (strpos($nombreCursoSafe, 'condensadores') !== false) {
                    $precioPreventa = 99.00;
                    $fechaProx = '01/09';
                    $horas = '25 hrs';
                } elseif (strpos($nombreCursoSafe, 'analizador') !== false) {
                    $precioPreventa = 99.00;
                    $fechaProx = '17/08';
                    $horas = '25 hrs';
                } elseif (strpos($nombreCursoSafe, 'canalizacion') !== false) {
                    $precioPreventa = 100.00;
                    $fechaProx = '04/08';
                    $horas = '16 hrs';
                } elseif (strpos($nombreCursoSafe, 'terminaciones') !== false) {
                    $precioPreventa = 99.00;
                    $fechaProx = '26/08';
                    $horas = '15 hrs';
                } elseif (strpos($nombreCursoSafe, 'empalmes') !== false) {
                    $precioPreventa = 99.00;
                    $fechaProx = '26/08';
                    $horas = '15 hrs';
                } elseif (strpos($nombreCursoSafe, 'variadores') !== false) {
                    $precioPreventa = 99.00;
                    $fechaProx = '20/08';
                    $horas = '30 hrs';
                } else {
                    $precioPreventa = $c['precio'] ?? 89.90;
                }
                
                $ingenieria_courses[] = [
                    "id" => $c['id_curso'],
                    "title" => $c['nombre_curso'],
                    "image" => "assets/images/cursos/" . ($c['foto'] ?: 'default.png'),
                    "price" => number_format($precioPreventa, 2),
                    "date" => $fechaProx,
                    "hours" => $horas,
                    "link" => $slug,
                    "docente" => $c['docente'] ?? 'Docente',
                    "docente_foto" => $c['docente_foto'] ?: '50x50',
                    "lecciones" => $c['lecciones'] ?? 1
                ];
            }
        }

        $data = [
            'title' => 'Cursos de Ingeniería - ICC',
            'meta_description' => 'Cursos especializados en Ingeniería.',
            'ingenieria_courses' => $ingenieria_courses
        ];
        $this->view('cursos/ingenieria', $data);
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
            $c_slug = strtolower(str_replace(' ', '_', $c['nombre_curso']));
            $c_slug = preg_replace('/[^a-z0-9_]/', '', $c_slug);
            // El slug de entrada puede tener guiones en lugar de subguiones, así que normalizamos
            $normalized_slug = str_replace('-', '_', $slug);
            if ($c_slug == $normalized_slug || $c_slug == $slug) {
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
            ],
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => "4.9",
                "ratingCount" => "124"
            ]
        ];

        $data = [
            'title' => $curso_encontrado['nombre_curso'] . ' - ICC',
            'meta_description' => $curso_encontrado['descripcion'] ?? 'Información detallada del curso en el Instituto de Capacitación Continua.',
            'og_image' => BASE_URL . 'assets/images/cursos/' . ($curso_encontrado['foto'] ?? 'default.png'),
            'og_url' => BASE_URL . 'cursos/detalle/' . $slug,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'curso' => $curso_encontrado,
            'modulos' => $modulos
        ];

        $this->view('cursos/detalle_curso', $data);
    }
}

