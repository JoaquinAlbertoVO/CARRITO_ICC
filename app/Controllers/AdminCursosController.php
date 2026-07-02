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
        $estudianteModel = new \App\Models\Estudiante();
        $statsIngenieria = $estudianteModel->getDashboardStatsIngenieria();
        $statsDerecho = $estudianteModel->getDashboardStatsDerecho();
        
        $data = [
            'total_mes_ingenieria' => $statsIngenieria['total_mes'],
            'total_general_ingenieria' => $statsIngenieria['total_general'],
            'estudiantes_ingenieria' => $statsIngenieria['estudiantes'],
            'total_mes_derecho' => $statsDerecho['total_mes'],
            'total_general_derecho' => $statsDerecho['total_general'],
            'estudiantes_derecho' => $statsDerecho['estudiantes'],
        ];

        // Llama a la vista del dashboard principal usando el layout de admin
        $this->view('admin/dashboard', $data, 'admin/layouts/main');
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
            'ruta_registro' => 'admin/ingenieria_registro',
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
            'ruta_registro' => 'admin/derecho_registro',
            'ruta_editar' => 'admin/derecho_editar',
            'ruta_eliminar' => 'admin/derecho_delete'
        ];
        $this->view('admin/derecho/lista', $data, 'admin/layouts/main');
    }
    public function ingenieria_registro() {
        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['pass'])) {
                $alert = '
                    <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Aviso - </strong> Todos los campos son obligatorios
                    </div>
                ';
            } else {
                $data = $_POST;
                $foto = $_FILES['foto'] ?? null;
                
                $estudianteModel = new \App\Models\Estudiante();
                $resultado = $estudianteModel->registrarEstudianteIngenieria($_SESSION['idUser'] ?? 1, $data, $foto);

                if ($resultado) {
                    $alert = '
                        <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Exitoso - </strong> Registro guardado satisfactoriamente
                        </div>
                    ';
                } else {
                    $alert = '
                        <div class="alert alert-dismissible bg-warning border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Advertencia - </strong> Error al guardar el registro
                        </div>
                    ';
                }
            }
        }

        $data = [
            'alert' => $alert
        ];
        $this->view('admin/ingenieria/registro', $data, 'admin/layouts/main');
    }
    public function ingenieria_editar() {
        $alert = '';
        $estudianteModel = new \App\Models\Estudiante();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['pass'])) {
                $alert = '
                    <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Aviso - </strong> Todos los campos son obligatorios
                    </div>
                ';
            } else {
                $data = $_POST;
                $foto = $_FILES['foto'] ?? null;
                
                $resultado = $estudianteModel->actualizarEstudianteIngenieria($data, $foto);

                if ($resultado) {
                    $alert = '
                        <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Exitoso - </strong> Registro actualizado satisfactoriamente
                        </div>
                    ';
                } else {
                    $alert = '
                        <div class="alert alert-dismissible bg-warning border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Advertencia - </strong> Error al actualizar el registro
                        </div>
                    ';
                }
            }
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'admin/ingenieria');
            exit;
        }

        $estudiante = $estudianteModel->getEstudianteIngenieriaById($id);
        if (!$estudiante) {
            header('Location: ' . BASE_URL . 'admin/ingenieria');
            exit;
        }

        $data = [
            'alert' => $alert,
            'data' => $estudiante
        ];
        $this->view('admin/ingenieria/editar', $data, 'admin/layouts/main');
    }

    public function derecho_editar() {
        $alert = '';
        $estudianteModel = new \App\Models\Estudiante();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['pass'])) {
                $alert = '
                    <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Aviso - </strong> Todos los campos son obligatorios
                    </div>
                ';
            } else {
                $data = $_POST;
                $foto = $_FILES['foto'] ?? null;
                
                $resultado = $estudianteModel->actualizarEstudianteDerecho($data, $foto);

                if ($resultado) {
                    $alert = '
                        <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Exitoso - </strong> Registro actualizado satisfactoriamente
                        </div>
                    ';
                } else {
                    $alert = '
                        <div class="alert alert-dismissible bg-warning border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Advertencia - </strong> Error al actualizar el registro
                        </div>
                    ';
                }
            }
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'admin/derecho');
            exit;
        }

        $estudiante = $estudianteModel->getEstudianteDerechoById($id);
        if (!$estudiante) {
            header('Location: ' . BASE_URL . 'admin/derecho');
            exit;
        }

        $data = [
            'alert' => $alert,
            'data' => $estudiante
        ];
        $this->view('admin/derecho/editar', $data, 'admin/layouts/main');
    }
    public function derecho_registro() {
        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['pass'])) {
                $alert = '
                    <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Aviso - </strong> Todos los campos son obligatorios
                    </div>
                ';
            } else {
                $data = $_POST;
                $foto = $_FILES['foto'] ?? null;
                
                $estudianteModel = new \App\Models\Estudiante();
                $resultado = $estudianteModel->registrarEstudianteDerecho($_SESSION['idUser'] ?? 1, $data, $foto);

                if ($resultado) {
                    $alert = '
                        <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Exitoso - </strong> Registro guardado satisfactoriamente
                        </div>
                    ';
                } else {
                    $alert = '
                        <div class="alert alert-dismissible bg-warning border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Advertencia - </strong> Error al guardar el registro
                        </div>
                    ';
                }
            }
        }

        $data = [
            'alert' => $alert
        ];
        $this->view('admin/derecho/registro', $data, 'admin/layouts/main');
    }
    public function ingenieria_delete() {
        if (isset($_GET['id'])) {
            $estudianteModel = new \App\Models\Estudiante();
            $estudianteModel->eliminarEstudianteIngenieria($_GET['id']);
        }
        header("Location: " . BASE_URL . "admin/ingenieria");
        exit();
    }

    public function derecho_delete() {
        if (isset($_GET['id'])) {
            $estudianteModel = new \App\Models\Estudiante();
            $estudianteModel->eliminarEstudianteDerecho($_GET['id']);
        }
        header("Location: " . BASE_URL . "admin/derecho");
        exit();
    }
}
