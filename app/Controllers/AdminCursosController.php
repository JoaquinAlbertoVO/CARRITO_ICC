<?php
namespace App\Controllers;

use App\Core\Controller;

class AdminCursosController extends Controller {

    public function __construct() {
        // Proteger el panel completo
        if (empty($_SESSION['active'])) {
            header('Location: ' . BASE_URL . 'admin/login');
            exit;
        }
    }

    public function dashboard() {
        // Datos para el dashboard (simulados temporalmente)
        $data = [
            'total_mes_ingenieria' => 0,
            'total_general_ingenieria' => 0,
            'total_mes_derecho' => 0,
            'total_general_derecho' => 0,
        ];

        // Llama a la vista del dashboard principal usando el layout de admin
        $this->view('admin/dashboard/index', $data, 'admin/layouts/main');
    }
}
