<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        // Datos para SEO y layout
        $data = [
            'title' => 'Inicio - Instituto de Capacitación Continua',
            'meta_description' => 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería Eléctrica.',
        ];

        // Llama a la vista app/Views/home/index.php
        $this->view('home/index', $data);
    }
}
