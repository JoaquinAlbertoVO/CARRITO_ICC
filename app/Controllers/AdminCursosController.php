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
        $data = [
            'total_mes_ingenieria' => $statsIngenieria['total_mes'],
            'total_general_ingenieria' => $statsIngenieria['total_general'],
            'estudiantes_ingenieria' => $statsIngenieria['estudiantes'],
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


    public function ingenieria_delete() {
        if (isset($_GET['id'])) {
            $estudianteModel = new \App\Models\Estudiante();
            $estudianteModel->eliminarEstudianteIngenieria($_GET['id']);
        }
        header("Location: " . BASE_URL . "admin/ingenieria");
        exit();
    }
    
    public function cursos() {
        $cursoModel = new \App\Models\Curso();
        $cursos = $cursoModel->getCursos();
        $data = ['cursos' => $cursos];
        $this->view('admin/cursos/lista', $data, 'admin/layouts/main');
    }

    public function cursos_registro() {
        $alert = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nombre_curso']) || empty($_POST['categoria']) || empty($_POST['fecha_emision'])) {
                $alert = '<div class="alert alert-danger">Todos los campos son obligatorios</div>';
            } else {
                $cursoModel = new \App\Models\Curso();
                if ($cursoModel->registrarCurso($_POST)) {
                    $alert = '<div class="alert alert-success">Curso registrado correctamente</div>';
                } else {
                    $alert = '<div class="alert alert-warning">Error al registrar el curso</div>';
                }
            }
        }
        $data = ['alert' => $alert];
        $this->view('admin/cursos/registro', $data, 'admin/layouts/main');
    }

    public function cursos_editar() {
        $alert = '';
        $cursoModel = new \App\Models\Curso();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($cursoModel->actualizarCurso($_POST)) {
                $alert = '<div class="alert alert-success">Curso actualizado correctamente</div>';
            } else {
                $alert = '<div class="alert alert-warning">Error al actualizar</div>';
            }
        }
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . 'admin/cursos');
            exit;
        }

        $curso = $cursoModel->getCursoById($id);
        $data = ['alert' => $alert, 'data' => $curso];
        $this->view('admin/cursos/editar', $data, 'admin/layouts/main');
    }

    public function cursos_delete() {
        if (isset($_GET['id'])) {
            $cursoModel = new \App\Models\Curso();
            $cursoModel->eliminarCurso($_GET['id']);
        }
        header("Location: " . BASE_URL . "admin/cursos");
        exit();
    }

    public function certificados() {
        // En un futuro aquí listaríamos certificados generados.
        // Por ahora redirige a estudiantes para generar desde allí
        header("Location: " . BASE_URL . "admin/ingenieria");
        exit();
    }

    public function generar_certificado() {
        // API Endpoint para generar imagen
        if (!isset($_GET['alumno']) || !isset($_GET['curso']) || !isset($_GET['fecha']) || !isset($_GET['categoria'])) {
            die("Faltan parámetros");
        }

        $alumno = $_GET['alumno'];
        $curso = $_GET['curso'];
        $fecha = $_GET['fecha'];
        $categoria = $_GET['categoria'];

        $certificadoModel = new \App\Models\Certificado();
        $imagen = $certificadoModel->generarImagenCertificado($alumno, $curso, $fecha, $categoria);

        header("Content-Type: image/jpeg");
        header("Content-Disposition: inline; filename=certificado.jpg");
        imagejpeg($imagen, null, 100);
        imagedestroy($imagen);
        exit;
    }
}
