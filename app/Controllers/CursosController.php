<?php
namespace App\Controllers;

use App\Core\Controller;

class CursosController extends Controller {
    public function index() {
        $data = [
            'title' => 'Cursos - Instituto de CapacitaciÃ³n Continua',
            'meta_description' => 'Explora todos nuestros cursos disponibles.',
        ];
        $this->view('cursos/index', $data);
    }

    public function ingenieria() {
        $data = [
            'title' => 'Cursos de IngenierÃ­a - ICC',
            'meta_description' => 'Cursos especializados en IngenierÃ­a.',
        ];
        $this->view('cursos/ingenieria', $data);
    }

    public function detalle($slug = '') {
        if(empty($slug)) {
            // Si no hay slug, redirigir a cursos
            header('Location: ' . BASE_URL . 'cursos');
            exit;
        }

        $view_path = 'cursos/detalles/' . str_replace('-', '_', $slug);

        if(file_exists('app/Views/' . $view_path . '.php')) {
            // Diccionario de metadatos SEO por curso
            $seo_data = [
                'programacion-plc' => [
                    'title' => 'ProgramaciÃ³n bÃ¡sica de PLC - ICC',
                    'meta_description' => 'Aprende programaciÃ³n de PLC desde cero. Curso completo para automatizaciÃ³n industrial.',
                    'og_image' => BASE_URL . 'assets/images/Fondo_Plc.png'
                ],
                'puesta-tierra' => [
                    'title' => 'Sistema Puesta a Tierra - ICC',
                    'meta_description' => 'Aprende diseÃ±o, instalaciÃ³n y mediciÃ³n de Sistemas de Puesta a Tierra.',
                    'og_image' => BASE_URL . 'assets/images/Puesta_a_Tierra.jpeg'
                ],
                'banco-condensadores' => [
                    'title' => 'Banco de Condensadores - ICC',
                    'meta_description' => 'DiseÃ±o y montaje de Bancos de Condensadores Industriales.',
                    'og_image' => BASE_URL . 'assets/images/Banco_de_Condensadores.jpeg'
                ],
                'analisis-facturacion' => [
                    'title' => 'AnÃ¡lisis de Facturas y Tarifas E. - ICC',
                    'meta_description' => 'EvaluaciÃ³n de tarifas elÃ©ctricas y analizador de redes BT.',
                    'og_image' => BASE_URL . 'assets/images/Analizador_de_Redes_BT.jpeg'
                ]
            ];

            // Obtener los datos del diccionario o usar valores por defecto
            $curso_seo = isset($seo_data[$slug]) ? $seo_data[$slug] : [
                'title' => 'Detalle del Curso - ICC',
                'meta_description' => 'Información detallada del curso en el Instituto de Capacitación Continua.',
                'og_image' => BASE_URL . 'assets/images/resources/logo-icc.png'
            ];

            // Generar Schema Markup (JSON-LD) para Rich Snippets
            $schema = [
                "@context" => "https://schema.org",
                "@type" => "Course",
                "name" => $curso_seo['title'],
                "description" => $curso_seo['meta_description'],
                "provider" => [
                    "@type" => "Organization",
                    "name" => "Instituto de Capacitación Continua - ICC",
                    "sameAs" => BASE_URL
                ],
                "offers" => [
                    "@type" => "Offer",
                    "price" => "120.00",
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
                'title' => $curso_seo['title'],
                'meta_description' => $curso_seo['meta_description'],
                'og_image' => $curso_seo['og_image'],
                'og_url' => BASE_URL . 'cursos/detalle/' . $slug,
                'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ];

            $this->view($view_path, $data);
        } else {
            die("Error 404: Curso no encontrado");
        }
    }
}

