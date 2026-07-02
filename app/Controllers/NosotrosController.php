<?php
namespace App\Controllers;

use App\Core\Controller;

class NosotrosController extends Controller {
    public function index() {
        // Datos para SEO y layout
        $data = [
            'title' => 'Nosotros - Instituto de Capacitación Continua',
            'meta_description' => 'Conoce más sobre nuestra misión de capacitar ingenieros en Perú.',
        ];

        // Llama a la vista app/Views/nosotros/index.php
        $this->view('nosotros/index', $data);
    }
}
