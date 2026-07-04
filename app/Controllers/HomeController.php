<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        // Datos para SEO y layout
        $data = [
            'title' => 'Inicio - Instituto de Capacitación Continua',
            'meta_description' => 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería Eléctrica.',
            'ingenieria_courses' => [
                ["id" => 1, "title" => "Programación básica de PLC", "image" => "assets/images/Electricidad_Industrial.jpeg", "price" => "120.00", "hours" => "40 hrs", "link" => "programacion-plc"],
                ["id" => 2, "title" => "Sistema puesta a tierra", "image" => "assets/images/Electricidad_Industrial.jpeg", "price" => "99.90", "hours" => "120 hrs", "link" => "puesta-tierra"],
                ["id" => 3, "title" => "Banco de condensadores", "image" => "assets/images/Banco_de_Condensadores.jpeg", "price" => "99.90", "hours" => "120 hrs", "link" => "banco-condensadores"],
                ["id" => 4, "title" => "Análisis de facturas y Evaluación de Tarifas E.", "image" => "assets/images/Analizador_de_Redes_BT.jpeg", "price" => "99.90", "hours" => "120 hrs", "link" => "analisis-facturacion"]
            ]
        ];

        // Llama a la vista app/Views/home/index.php
        $this->view('home/index', $data);
    }
}
