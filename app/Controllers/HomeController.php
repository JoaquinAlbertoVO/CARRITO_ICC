<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $cursoModel = new \App\Models\Curso();
        $cursos_db = $cursoModel->getCursos(1);

        $ingenieria_courses = [];
        foreach ($cursos_db as $c) {
            $cat = strtolower($c['categoria'] ?? '');
            if ($cat == 'ingeniería' || $cat == 'ingenieria' || $cat == '') {
                $slug = strtolower(str_replace(' ', '_', $c['nombre_curso']));
                $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                $slug = str_replace('_', '-', $slug); // use hyphens for pretty URLs

                $ingenieria_courses[] = [
                    "id" => $c['id_curso'],
                    "title" => $c['nombre_curso'],
                    "image" => "assets/images/cursos/" . ($c['foto'] ?: 'default.png'),
                    "price" => $c['precio'],
                    "hours" => $c['horas_academicas'] . " hrs",
                    "link" => $slug
                ];
            }
        }

        $data = [
            'title' => 'Inicio - Instituto de Capacitación Continua',
            'meta_description' => 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería Eléctrica.',
            'ingenieria_courses' => $ingenieria_courses
        ];

        // Llama a la vista app/Views/home/index.php
        $this->view('home/index', $data);
    }
}

