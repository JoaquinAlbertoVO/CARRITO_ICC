<?php
namespace App\Controllers;

use App\Core\Controller;

class LegalController extends Controller {
    public function privacidad() {
        $data = [
            'title' => 'Política de Privacidad - ICC',
            'meta_description' => 'Política de Privacidad del Instituto de Capacitación Continua.'
        ];
        $this->view('legal/privacidad', $data);
    }

    public function terminos() {
        $data = [
            'title' => 'Términos de Servicio - ICC',
            'meta_description' => 'Términos y Condiciones de Servicio del Instituto de Capacitación Continua.'
        ];
        $this->view('legal/terminos', $data);
    }
}
