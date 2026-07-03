<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Curso {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getCursos($estado = 1) {
        try {
            $sql = "SELECT * FROM cursos WHERE estado = :estado ORDER BY id_curso DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error obteniendo cursos: " . $e->getMessage());
            return [];
        }
    }

    public function getCursoById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cursos WHERE id_curso = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function registrarCurso($data) {
        try {
            $sql = "INSERT INTO cursos(nombre_curso, categoria, fecha_emision, horas_academicas) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['nombre_curso'],
                $data['categoria'],
                $data['fecha_emision'],
                $data['horas_academicas']
            ]);
            return true;
        } catch (\PDOException $e) {
            error_log("Error registrando curso: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarCurso($data) {
        try {
            $sql = "UPDATE cursos SET nombre_curso = ?, categoria = ?, fecha_emision = ?, horas_academicas = ? WHERE id_curso = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['nombre_curso'],
                $data['categoria'],
                $data['fecha_emision'],
                $data['horas_academicas'],
                $data['id_curso']
            ]);
            return true;
        } catch (\PDOException $e) {
            error_log("Error actualizando curso: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarCurso($id) {
        try {
            $sql = "UPDATE cursos SET estado = 0 WHERE id_curso = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Error eliminando curso: " . $e->getMessage());
            return false;
        }
    }
}
