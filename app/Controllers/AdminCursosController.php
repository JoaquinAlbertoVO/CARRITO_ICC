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

    public function ingenieria() {
        $estudianteModel = new \App\Models\Estudiante();
        
        $por_pagina = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;
        $desde = ($pagina - 1) * $por_pagina;

        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

        $total_registro = $estudianteModel->getTotalEstudiantes('usuario', $busqueda);
        $total_paginas = ceil($total_registro / $por_pagina);
        
        $estudiantes = $estudianteModel->getEstudiantes('usuario', $desde, $por_pagina, $busqueda);

        $data = [
            'estudiantes' => $estudiantes,
            'pagina' => $pagina,
            'total_paginas' => $total_paginas,
            'busqueda' => $busqueda,
            'titulo' => 'Ingeniería Eléctrica',
            'ruta_lista' => 'admin/ingenieria',
            'ruta_editar' => 'admin/ingenieria_editar',
            'ruta_eliminar' => 'admin/ingenieria_delete'
        ];
        $this->view('admin/ingenieria/lista', $data, 'admin/layouts/main');
    }

    public function derecho() {
        $estudianteModel = new \App\Models\Estudiante();
        
        $por_pagina = 10;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;
        $desde = ($pagina - 1) * $por_pagina;

        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

        $total_registro = $estudianteModel->getTotalEstudiantes('usuario_d', $busqueda);
        $total_paginas = ceil($total_registro / $por_pagina);
        
        $estudiantes = $estudianteModel->getEstudiantes('usuario_d', $desde, $por_pagina, $busqueda);

        $data = [
            'estudiantes' => $estudiantes,
            'pagina' => $pagina,
            'total_paginas' => $total_paginas,
            'busqueda' => $busqueda,
            'titulo' => 'Derecho y Gestión Pública',
            'ruta_lista' => 'admin/derecho',
            'ruta_editar' => 'admin/derecho_editar',
            'ruta_eliminar' => 'admin/derecho_delete'
        ];
        $this->view('admin/derecho/lista', $data, 'admin/layouts/main');
    }
}
