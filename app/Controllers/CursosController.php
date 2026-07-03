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
            $data = [
                'title' => 'Detalle del Curso - ICC',
                'meta_description' => 'Información detallada del curso.',
            ];
            $this->view($view_path, $data);
        } else {
            die("Error 404: Curso no encontrado");
        }
    }
}
