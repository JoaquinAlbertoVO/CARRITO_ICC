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

        $cursoModel = new \App\Models\Curso();
        $cursos = $cursoModel->getCursos();

        $data = [
            'alert' => $alert,
            'cursos' => $cursos
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
    
    public function ventas() {
        $dir = __DIR__ . '/../../assets/img/vouchers/';
        $vouchers = [];
        
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                // Ignore . and .. and any non-files
                if ($file === '.' || $file === '..' || !is_file($dir . $file)) {
                    continue;
                }
                
                // Filename format: voucher_YYYYMMDD_HHMMSS_CursoName.ext
                $dateFormatted = 'Desconocida';
                $courseName = 'Desconocido';
                
                if (preg_match('/^voucher_(\d{8})_(\d{6})_(.+)\.([a-zA-Z0-9]+)$/', $file, $matches)) {
                    $dateStr = $matches[1] . ' ' . $matches[2];
                    $datetime = \DateTime::createFromFormat('Ymd His', $dateStr);
                    if ($datetime) {
                        $dateFormatted = $datetime->format('d/m/Y h:i A');
                    }
                    $courseName = str_replace('_', ' ', $matches[3]);
                }
                
                $vouchers[] = [
                    'filename' => $file,
                    'url' => BASE_URL . 'assets/img/vouchers/' . $file,
                    'date' => $dateFormatted,
                    'course' => $courseName,
                    'timestamp' => filectime($dir . $file)
                ];
            }
            
            // Sort by timestamp descending (newest first)
            usort($vouchers, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
        }
        
        $data = [
            'vouchers' => $vouchers,
            'titulo' => 'Ventas y Comprobantes'
        ];
        
        $this->view('admin/ventas/lista', $data, 'admin/layouts/main');
    }

    public function ventas_delete() {
        if (isset($_GET['file'])) {
            $file = basename($_GET['file']); // basename to prevent directory traversal
            $path = __DIR__ . '/../../assets/img/vouchers/' . $file;
            
            if (file_exists($path) && is_file($path)) {
                unlink($path);
            }
        }
        header("Location: " . BASE_URL . "admin/ventas");
        exit();
    }

    public function boleta_rapida() {
        $data = [
            'titulo' => 'Generar Boleta Rápida'
        ];
        $this->view('admin/ventas/boleta_rapida', $data, 'admin/layouts/main');
    }

    // ============================================================
    // GESTIÓN DE VIDEOS POR CURSO
    // ============================================================

    public function videos() {
        $id_curso = isset($_GET['curso']) ? (int)$_GET['curso'] : 0;
        if (!$id_curso) {
            header('Location: ' . BASE_URL . 'admin/cursos');
            exit();
        }
        $alert = '';
        if (isset($_GET['eliminado'])) {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Video eliminado correctamente.
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                      </div>';
        }
        if (isset($_GET['guardado'])) {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Video guardado correctamente.
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                      </div>';
        }
        $videoModel = new \App\Models\VideoModel();
        $data = [
            'id_curso'     => $id_curso,
            'nombre_curso' => $videoModel->getNombreCurso($id_curso),
            'videos'       => $videoModel->getVideosByCurso($id_curso),
            'alert'        => $alert,
        ];
        $this->view('admin/videos/lista', $data, 'admin/layouts/main');
    }

    public function videos_registro() {
        $id_curso = isset($_GET['curso']) ? (int)$_GET['curso'] : 0;
        if (!$id_curso) {
            header('Location: ' . BASE_URL . 'admin/cursos');
            exit();
        }
        $videoModel = new \App\Models\VideoModel();
        $alert = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modulo      = trim($_POST['modulo'] ?? 'Módulo 1');
            $titulo      = trim($_POST['titulo'] ?? '');
            $url_video   = trim($_POST['url_video'] ?? '');
            $duracion    = trim($_POST['duracion'] ?? '0:00');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $orden       = (int)($_POST['orden'] ?? 1);
            $id_curso_post = (int)($_POST['id_curso'] ?? $id_curso);

            if (empty($titulo) || empty($url_video)) {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            El título y la URL del video son obligatorios.
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                          </div>';
            } else {
                $videoModel->crearVideo([
                    'id_curso'    => $id_curso_post,
                    'modulo'      => $modulo,
                    'titulo'      => $titulo,
                    'url_video'   => $url_video,
                    'duracion'    => $duracion,
                    'descripcion' => $descripcion,
                    'orden'       => $orden ?: 1,
                ]);
                header('Location: ' . BASE_URL . 'admin/videos?curso=' . $id_curso_post . '&guardado=1');
                exit();
            }
        }

        $siguiente_orden = $videoModel->countVideosByCurso($id_curso) + 1;
        $data = [
            'id_curso'       => $id_curso,
            'nombre_curso'   => $videoModel->getNombreCurso($id_curso),
            'siguiente_orden' => $siguiente_orden,
            'alert'          => $alert,
        ];
        $this->view('admin/videos/registro', $data, 'admin/layouts/main');
    }

    public function videos_editar() {
        $id_video = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$id_video) {
            header('Location: ' . BASE_URL . 'admin/cursos');
            exit();
        }
        $videoModel = new \App\Models\VideoModel();
        $video = $videoModel->getVideoById($id_video);
        if (!$video) {
            header('Location: ' . BASE_URL . 'admin/cursos');
            exit();
        }
        $alert = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modulo      = trim($_POST['modulo'] ?? 'Módulo 1');
            $titulo      = trim($_POST['titulo'] ?? '');
            $url_video   = trim($_POST['url_video'] ?? '');
            $duracion    = trim($_POST['duracion'] ?? '0:00');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $orden       = (int)($_POST['orden'] ?? 1);
            $id_curso    = (int)($_POST['id_curso'] ?? $video['id_curso']);

            if (empty($titulo) || empty($url_video)) {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            El título y la URL son obligatorios.
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                          </div>';
            } else {
                $videoModel->actualizarVideo($id_video, [
                    'modulo'      => $modulo,
                    'titulo'      => $titulo,
                    'url_video'   => $url_video,
                    'duracion'    => $duracion,
                    'descripcion' => $descripcion,
                    'orden'       => $orden ?: 1,
                ]);
                header('Location: ' . BASE_URL . 'admin/videos?curso=' . $id_curso . '&guardado=1');
                exit();
            }
        }

        $data = [
            'id_curso'    => $video['id_curso'],
            'nombre_curso' => $videoModel->getNombreCurso($video['id_curso']),
            'video'       => $video,
            'alert'       => $alert,
        ];
        $this->view('admin/videos/editar', $data, 'admin/layouts/main');
    }

    public function videos_eliminar() {
        $id_video = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $id_curso = isset($_GET['curso']) ? (int)$_GET['curso'] : 0;
        if ($id_video) {
            $videoModel = new \App\Models\VideoModel();
            $videoModel->eliminarVideo($id_video);
        }
        header('Location: ' . BASE_URL . 'admin/videos?curso=' . $id_curso . '&eliminado=1');
        exit();
    }
}

