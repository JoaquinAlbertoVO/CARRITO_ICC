<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class VideoModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    /** Obtener todos los videos de un curso ordenados */
    public function getVideosByCurso($id_curso) {
        $sql = "SELECT * FROM curso_videos WHERE id_curso = :id_curso AND estado = 1 ORDER BY orden ASC, id_video ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Obtener un video por su ID */
    public function getVideoById($id_video) {
        $sql = "SELECT * FROM curso_videos WHERE id_video = :id_video";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_video', $id_video, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Crear un nuevo video */
    public function crearVideo($data) {
        $sql = "INSERT INTO curso_videos (id_curso, titulo, url_video, descripcion, orden)
                VALUES (:id_curso, :titulo, :url_video, :descripcion, :orden)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_curso',    $data['id_curso'],    PDO::PARAM_INT);
        $stmt->bindParam(':titulo',      $data['titulo'],      PDO::PARAM_STR);
        $stmt->bindParam(':url_video',   $data['url_video'],   PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':orden',       $data['orden'],       PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** Actualizar un video existente */
    public function actualizarVideo($id_video, $data) {
        $sql = "UPDATE curso_videos SET titulo = :titulo, url_video = :url_video,
                descripcion = :descripcion, orden = :orden
                WHERE id_video = :id_video";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo',      $data['titulo'],      PDO::PARAM_STR);
        $stmt->bindParam(':url_video',   $data['url_video'],   PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':orden',       $data['orden'],       PDO::PARAM_INT);
        $stmt->bindParam(':id_video',    $id_video,            PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** Eliminar un video */
    public function eliminarVideo($id_video) {
        $sql = "DELETE FROM curso_videos WHERE id_video = :id_video";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_video', $id_video, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** Contar cuántos videos tiene un curso (para sugerir el siguiente orden) */
    public function countVideosByCurso($id_curso) {
        $sql = "SELECT COUNT(*) FROM curso_videos WHERE id_curso = :id_curso AND estado = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    /** Obtener nombre del curso por ID */
    public function getNombreCurso($id_curso) {
        $sql = "SELECT nombre_curso FROM cursos WHERE id_curso = :id_curso";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['nombre_curso'] : 'Curso';
    }
}
