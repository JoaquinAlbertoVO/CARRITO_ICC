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

