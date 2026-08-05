<?php
namespace App\Controllers;

use App\Core\Controller;

class AulaController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['active']) || empty($_SESSION['idUser'])) {
            header('location: ' . BASE_URL . 'aula/login');
            exit;
        }
    }

    public function index() {
        $iduser = $_SESSION['idUser'];
        $cursoModel = new \App\Models\Curso();
        $resume_curso = $cursoModel->getUltimoCursoEstudiante($iduser);
        $cursos = $cursoModel->getCursosByEstudiante($iduser);
        $certificados = $cursoModel->getCertificadosUsuario($iduser);

        $data = [
            'title' => 'Mi Aula Virtual - ICC',
            'resume_curso' => $resume_curso,
            'cursos' => $cursos,
            'certificados' => $certificados
        ];
        $this->view('aula/index', $data, 'layouts/aula');
    }
    
    public function curso($id = 0) {
        $id = (int)$id;
        if ($id <= 0) {
            header('location: ' . BASE_URL . 'aula');
            exit;
        }
        
        $iduser = $_SESSION['idUser'];
        $cursoModel = new \App\Models\Curso();
        
        // Verificar si tiene acceso
        if (!$cursoModel->checkAccesoEstudiante($iduser, $id)) {
            $data = ['title' => 'Acceso Denegado', 'error' => 'No tienes acceso a este curso o no estás inscrito.'];
            $this->view('aula/error', $data, 'layouts/aula');
            return;
        }

        $curso = $cursoModel->getCursoById($id);
        if (!$curso) {
            $data = ['title' => 'Curso no encontrado', 'error' => 'El curso no existe.'];
            $this->view('aula/error', $data, 'layouts/aula');
            return;
        }

        $videos = $cursoModel->getVideosByCurso($id);
        $modulos = [];
        $primer_video = "https://www.youtube.com/embed/";
        
        if (!empty($videos)) {
            foreach ($videos as $vid) {
                $modulos[$vid['modulo']][] = $vid;
            }
            $primer_video = $videos[0]['url_video'];
            if (strpos($primer_video, 'playlist?list=') !== false) {
                $primer_video = str_replace('playlist?list=', 'embed/videoseries?list=', $primer_video);
            } else {
                if (strpos($primer_video, 'watch?v=') !== false) {
                    $primer_video = str_replace('watch?v=', 'embed/', $primer_video);
                } elseif (strpos($primer_video, 'youtu.be/') !== false) {
                    $primer_video = str_replace('youtu.be/', 'www.youtube.com/embed/', $primer_video);
                }
                if (strpos($primer_video, 'embed/') !== false && strpos($primer_video, '?') === false && strpos($primer_video, '&') !== false) {
                    $primer_video = preg_replace('/&/', '?', $primer_video, 1);
                }
            }
        }
        
        $videos_completados = $cursoModel->getProgresoVideos($iduser, $id);
        $total_videos = count($videos);
        $completados_count = count($videos_completados);
        $porcentaje_progreso = $total_videos > 0 ? round(($completados_count / $total_videos) * 100) : 0;
        
        $estado_certificado = $cursoModel->getEstadoCertificado($iduser, $id);
        
        $data = [
            'title' => 'Curso: ' . ($curso['nombre_curso'] ?? ''),
            'curso' => $curso,
            'videos' => $videos,
            'modulos' => $modulos,
            'primer_video' => $primer_video,
            'videos_completados' => $videos_completados,
            'porcentaje_progreso' => $porcentaje_progreso,
            'estado_certificado' => $estado_certificado
        ];
        
        $this->view('aula/curso', $data, 'layouts/aula');
    }

    public function marcar_progreso() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_video']) && isset($_POST['id_curso'])) {
            $id_video = (int)$_POST['id_video'];
            $id_curso = (int)$_POST['id_curso'];
            $iduser = $_SESSION['idUser'];
            
            $cursoModel = new \App\Models\Curso();
            $cursoModel->marcarVideoCompletado($iduser, $id_curso, $id_video);
            header("Location: " . BASE_URL . "aula/curso/" . $id_curso);
        } else {
            header("Location: " . BASE_URL . "aula");
        }
        exit;
    }
    
    public function solicitar_certificado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_curso'])) {
            $id_curso = (int)$_POST['id_curso'];
            $iduser = $_SESSION['idUser'];
            
            // In the future this should call a Model method to update the DB
            $db = (new \App\Core\Database())->connect();
            try {
                $sql = "UPDATE usuario_cursos SET estado_certificado = 1 WHERE id_usuario = ? AND id_curso = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$iduser, $id_curso]);
            } catch (\PDOException $e) {}
            
            header("Location: " . BASE_URL . "aula/curso/" . $id_curso);
        } else {
            header("Location: " . BASE_URL . "aula");
        }
        exit;
    }
}
