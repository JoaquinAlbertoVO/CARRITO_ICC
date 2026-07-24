<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $cursoModel = new \App\Models\Curso();
        $cursos_db = $cursoModel->getCursos(1);
        
        $ingenieria_courses = [];
        
        $remove_keywords = [
            'stenergy',
            'puesta a tierra',
            'p.l.c',
            'plc',
            'electricidad basica',
            'electricidad básica'
        ];

        foreach ($cursos_db as $c) {
            $nombre_lower = mb_strtolower($c['nombre_curso'], 'UTF-8');
            
            $should_remove = false;
            foreach ($remove_keywords as $rk) {
                if (mb_strpos($nombre_lower, $rk, 0, 'UTF-8') !== false) {
                    $should_remove = true;
                    break;
                }
            }
            if ($should_remove) continue;

            $cat = mb_strtolower($c['categoria'] ?? '', 'UTF-8');
            if ($cat === 'ingeniería' || $cat === 'ingenieria' || $cat === '') {
                $slug = strtolower(str_replace(' ', '_', $c['nombre_curso']));
                $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                $slug = str_replace('_', '-', $slug);


                $precioPreventa = 89.90;
                $nombreCursoSafe = strtolower($c['nombre_curso'] ?? '');
                
                if (strpos($nombreCursoSafe, 'subestaciones') !== false) {
                    $precioPreventa = 99.00;
                } elseif (strpos($nombreCursoSafe, 'condensadores') !== false) {
                    $precioPreventa = 99.00;
                } elseif (strpos($nombreCursoSafe, 'analizador') !== false) {
                    $precioPreventa = 99.00;
                } elseif (strpos($nombreCursoSafe, 'canalizacion') !== false) {
                    $precioPreventa = 100.00;
                } elseif (strpos($nombreCursoSafe, 'terminaciones') !== false) {
                    $precioPreventa = 99.00;
                } elseif (strpos($nombreCursoSafe, 'empalmes') !== false) {
                    $precioPreventa = 99.00;
                } elseif (strpos($nombreCursoSafe, 'variadores') !== false) {
                    $precioPreventa = 99.00;
                } else {
                    $precioPreventa = $c['precio'] ?? 89.90;
                }
                
                $ingenieria_courses[] = [
                    "id" => $c['id_curso'],
                    "title" => $c['nombre_curso'],
                    "image" => "assets/images/cursos/" . ($c['foto'] ?: 'default.png'),
                    "price" => number_format($precioPreventa, 2),
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

