<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Curso {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
        
        // Quick migration (ignorar error si ya existen las columnas)
        try {
            $this->db->exec("ALTER TABLE cursos 
              ADD COLUMN precio DECIMAL(10,2) DEFAULT '89.90',
              ADD COLUMN precio_usd DECIMAL(10,2) DEFAULT '30.00',
              ADD COLUMN fecha_prox VARCHAR(50) DEFAULT 'PRÓXIMAMENTE',
              ADD COLUMN docente VARCHAR(150) DEFAULT 'Docente',
              ADD COLUMN docente_foto VARCHAR(255) DEFAULT '50x50',
              ADD COLUMN lecciones INT(11) DEFAULT 1;");
        } catch (\PDOException $e) {}
        try {
            $this->db->exec("ALTER TABLE cursos ADD COLUMN requisitos TEXT;");
        } catch (\PDOException $e) {}
        try {
            $this->db->exec("ALTER TABLE cursos 
              ADD COLUMN resumen TEXT,
              ADD COLUMN temas TEXT,
              ADD COLUMN beneficios TEXT,
              ADD COLUMN programacion TEXT;");
        } catch (\PDOException $e) {}
    }

    public function getCursos($estado = 1) {
        try {
            $sql = "SELECT c.*, (SELECT COUNT(DISTINCT modulo) FROM curso_videos v WHERE v.id_curso = c.id_curso AND v.estado = 1) AS lecciones_reales FROM cursos c WHERE c.estado = :estado ORDER BY c.id_curso DESC";
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
            $sql = "INSERT INTO cursos(nombre_curso, categoria, fecha_emision, horas_academicas, foto, precio, docente, docente_foto, lecciones, descripcion, requisitos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['nombre_curso'],
                $data['categoria'],
                $data['fecha_emision'],
                $data['horas_academicas'],
                $data['foto'] ?? 'default.png',
                $data['precio'] ?? 89.90,
                $data['docente'] ?? 'Docente ICC',
                $data['docente_foto'] ?? '50x50',
                $data['lecciones'] ?? 1,
                $data['descripcion'] ?? '',
                $data['requisitos'] ?? ''
            ]);
            return true;
        } catch (\PDOException $e) {
            error_log("Error registrando curso: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarCurso($data) {
        try {
            // Construir SQL dinámicamente porque las fotos pueden o no enviarse
            $sql = "UPDATE cursos SET nombre_curso = ?, categoria = ?, fecha_emision = ?, horas_academicas = ?, precio = ?, precio_usd = ?, fecha_prox = ?, docente = ?, lecciones = ?, descripcion = ?, requisitos = ?, resumen = ?, temas = ?, beneficios = ?, programacion = ?";
            $params = [
                $data['nombre_curso'],
                $data['categoria'],
                $data['fecha_emision'],
                $data['horas_academicas'],
                $data['precio'],
                $data['precio_usd'] ?? 30.00,
                $data['fecha_prox'] ?? 'PRÓXIMAMENTE',
                $data['docente'],
                $data['lecciones'],
                $data['descripcion'] ?? '',
                $data['requisitos'] ?? '',
                $data['resumen'] ?? '',
                $data['temas'] ?? '',
                $data['beneficios'] ?? '',
                $data['programacion'] ?? ''
            ];

            if (!empty($data['foto'])) {
                $sql .= ", foto = ?";
                $params[] = $data['foto'];
            }
            if (!empty($data['docente_foto'])) {
                $sql .= ", docente_foto = ?";
                $params[] = $data['docente_foto'];
            }

            $sql .= " WHERE id_curso = ?";
            $params[] = $data['id_curso'];

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
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
            $stmt->execute([$id]);
            return ['status' => true, 'msg' => 'Curso eliminado correctamente'];
        } catch (\PDOException $e) {
            return ['status' => false, 'msg' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }

    public function getCursoByNombre($nombre) {
        try {
            // Buscamos coincidencia parcial por si la URL trae un nombre ligeramente distinto
            $sql = "SELECT * FROM cursos WHERE nombre_curso LIKE ? AND estado = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['%' . $nombre . '%']);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getUltimoCursoEstudiante($iduser) {
        try {
            $sql = "SELECT c.id_curso, c.nombre_curso FROM usuario_cursos uc INNER JOIN cursos c ON uc.id_curso = c.id_curso WHERE uc.id_usuario = ? AND c.estado = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$iduser]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getCursosByEstudiante($iduser) {
        try {
            $sql = "SELECT c.id_curso, c.nombre_curso, c.foto, c.horas_academicas, c.lecciones, c.categoria 
                    FROM usuario_cursos uc 
                    INNER JOIN cursos c ON uc.id_curso = c.id_curso 
                    WHERE uc.id_usuario = ? AND c.estado = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$iduser]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function checkAccesoEstudiante($iduser, $id_curso) {
        try {
            $sql = "SELECT id_curso FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$iduser, $id_curso]);
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getVideosByCurso($id_curso) {
        try {
            $sql = "SELECT * FROM curso_videos WHERE id_curso = ? AND estado = 1 ORDER BY orden ASC, modulo ASC, id_video ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_curso]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getProgresoVideos($iduser, $id_curso) {
        try {
            $sql = "SELECT id_video FROM progreso_videos WHERE id_usuario = ? AND id_curso = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$iduser, $id_curso]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN); // Devuelve array de IDs de video
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getEstadoCertificado($iduser, $id_curso) {
        try {
            $sql = "SELECT estado_certificado FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$iduser, $id_curso]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res ? $res['estado_certificado'] : 0;
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function marcarVideoCompletado($iduser, $id_curso, $id_video) {
        try {
            // Verificar si ya existe
            $sql_check = "SELECT id FROM progreso_videos WHERE id_usuario = ? AND id_curso = ? AND id_video = ?";
            $stmt_check = $this->db->prepare($sql_check);
            $stmt_check->execute([$iduser, $id_curso, $id_video]);
            
            if ($stmt_check->rowCount() == 0) {
                $sql = "INSERT INTO progreso_videos (id_usuario, id_curso, id_video, fecha_completado) VALUES (?, ?, ?, NOW())";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$iduser, $id_curso, $id_video]);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}

