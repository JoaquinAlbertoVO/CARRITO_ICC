<?php
namespace App\Controllers;

use App\Core\Controller;

class ContactoController extends Controller {
    public function index() {
        $data = [
            'title' => 'Contacto - Instituto de Capacitación Continua',
            'meta_description' => 'Ponte en contacto con nosotros para más información sobre nuestros cursos de ingeniería.',
        ];

        $this->view('contacto/index', $data);
    }
}
