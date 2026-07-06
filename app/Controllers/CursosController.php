<?php
namespace App\Controllers;

use App\Core\Controller;

class CursosController extends Controller {
    public function index() {
        $data = [
            'title' => 'Cursos - Instituto de Capacitación Continua',
            'meta_description' => 'Explora todos nuestros cursos disponibles.',
        ];
        $this->view('cursos/index', $data);
    }

    public function ingenieria() {
        $data = [
            'title' => 'Cursos de Ingeniería - ICC',
            'meta_description' => 'Cursos especializados en Ingeniería.',
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
                    'title' => 'Programación básica de PLC - ICC',
                    'meta_description' => 'Aprende programación de PLC desde cero. Curso completo para automatización industrial.',
                    'og_image' => BASE_URL . 'assets/images/Fondo_Plc.png'
                ],
                'puesta-tierra' => [
                    'title' => 'Sistema Puesta a Tierra - ICC',
                    'meta_description' => 'Aprende diseño, instalación y medición de Sistemas de Puesta a Tierra.',
                    'og_image' => BASE_URL . 'assets/images/Puesta_a_Tierra.jpeg'
                ],
                'banco-condensadores' => [
                    'title' => 'Banco de Condensadores - ICC',
                    'meta_description' => 'Diseño y montaje de Bancos de Condensadores Industriales.',
                    'og_image' => BASE_URL . 'assets/images/Banco_de_Condensadores.jpeg'
                ],
                'analisis-facturacion' => [
                    'title' => 'Análisis de Facturas y Tarifas E. - ICC',
                    'meta_description' => 'Evaluación de tarifas eléctricas y analizador de redes BT.',
                    'og_image' => BASE_URL . 'assets/images/Analizador_de_Redes_BT.jpeg'
                ]
            ];

            // Obtener los datos del diccionario o usar valores por defecto
            $curso_seo = isset($seo_data[$slug]) ? $seo_data[$slug] : [
                'title' => 'Detalle del Curso - ICC',
                'meta_description' => 'Información detallada del curso en el Instituto de Capacitación Continua.',
                'og_image' => BASE_URL . 'assets/images/resources/logo-icc.png'
            ];

            $data = [
                'title' => $curso_seo['title'],
                'meta_description' => $curso_seo['meta_description'],
                'og_image' => $curso_seo['og_image'],
                'og_url' => BASE_URL . 'cursos/detalle/' . $slug
            ];

            $this->view($view_path, $data);
        } else {
            die("Error 404: Curso no encontrado");
        }
    }
}
