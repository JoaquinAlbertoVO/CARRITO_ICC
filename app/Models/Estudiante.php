<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use Exception;

class Estudiante {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    /**
     * Obtiene la lista de estudiantes para una especialidad
     * $tabla: 'usuario' para IngenierÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â­a, 'usuario_d' para Derecho
     */
    public function getEstudiantes($tabla, $desde, $por_pagina, $busqueda = '') {
        $where = "estatus = 1";
        
        if (!empty($busqueda)) {
            $where .= " AND (nombre LIKE :busqueda OR usuario LIKE :busqueda)";
        }

        $sql = "SELECT * FROM {$tabla} WHERE {$where} ORDER BY iduser DESC LIMIT :desde, :por_pagina";
        $stmt = $this->db->prepare($sql);

        if (!empty($busqueda)) {
            $busquedaStr = '%' . $busqueda . '%';
            $stmt->bindParam(':busqueda', $busquedaStr, PDO::PARAM_STR);
        }

        $stmt->bindParam(':desde', $desde, PDO::PARAM_INT);
        $stmt->bindParam(':por_pagina', $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Obtiene el total de registros para paginaciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n
     */
    public function getTotalEstudiantes($tabla, $busqueda = '') {
        $where = "estatus = 1";
        
        if (!empty($busqueda)) {
            $where .= " AND (nombre LIKE :busqueda OR usuario LIKE :busqueda)";
        }

        $sql = "SELECT COUNT(*) as total_registro FROM {$tabla} WHERE {$where}";
        $stmt = $this->db->prepare($sql);

        if (!empty($busqueda)) {
            $busquedaStr = '%' . $busqueda . '%';
            $stmt->bindParam(':busqueda', $busquedaStr, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result['total_registro'];
    }

    public function registrarEstudianteIngenieria($id_pla, $data, $foto) {
        $nombre = $data['nombre'];
        $correo = $data['correo'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $dni = $data['dni'] ?? '';
        $nopera = $data['nopera'] ?? '';
        $mpagado = $data['mpagado'] ?? '';
        $encargado = $data['encargado'] ?? '';
        $banco = $data['banco'] ?? '';
        $fecha = $data['fecha'] ?? '';
        $usuario = $data['usuario'];
        $pass = $data['pass'];
        
        $imgboucher = 'ejemplo.png';

        if ($foto && $foto['name'] != '') {
            $destino = 'public/assets/img/uploads/';
            if (!is_dir($destino)) {
                mkdir($destino, 0777, true);
            }
            $img_nombre = 'img_' . md5(date('d-m-Y H:i:s'));
            $imgboucher = $img_nombre . '.jpg';
            $src = $destino . $imgboucher;
            move_uploaded_file($foto['tmp_name'], $src);
        }

        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO usuario(id_pla, nombre, correo, telefono, dni, n_operacion, m_pagado, encargado, banco, fecha_deposito, usuario, password, boucher) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $id_pla, $nombre, $correo, $telefono, $dni, $nopera, $mpagado, $encargado, $banco, $fecha, $usuario, $pass, $imgboucher
            ]);

            $iduser = $this->db->lastInsertId();

            $sqlInscrito = "INSERT INTO inscrito(id_user, plc, e_basica, s_p_tierra, m_electrico, banco_c, a_facturas_t_e, g_seguridad_t, r_mercado_e, a_redes, riesgo_e, t_altura, e_motores_e, s_p_t_antiguo, costo_p, idtermo, id_residencial, id_medicion, m_t_electricos, redes_electricas, t_caliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInscrito = $this->db->prepare($sqlInscrito);
            $stmtInscrito->execute([
                $iduser, 
                $data['2'] ?? 1, $data['3'] ?? 1, $data['4'] ?? 1, $data['5'] ?? 1, $data['6'] ?? 1, 
                $data['7'] ?? 1, $data['8'] ?? 1, $data['9'] ?? 1, $data['10'] ?? 1, $data['11'] ?? 1, 
                $data['12'] ?? 1, $data['13'] ?? 1, $data['14'] ?? 1, $data['15'] ?? 1, $data['16'] ?? 1, 
                $data['17'] ?? 1, $data['18'] ?? 1, $data['19'] ?? 1, $data['20'] ?? 1, $data['21'] ?? 1
            ]);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Error registrando estudiante de ingenieria: " . $e->getMessage());
            return false;
        }
    }
    public function getEstudianteIngenieriaById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE iduser = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }



    public function actualizarEstudianteIngenieria($data, $foto) {
        $id = $data['id_usuario'];
        $nombre = $data['nombre'];
        $correo = $data['correo'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $dni = $data['dni'] ?? '';
        $nopera = $data['nopera'] ?? '';
        $mpagado = $data['mpagado'] ?? '';
        $banco = $data['banco'] ?? '';
        $fecha = $data['fecha'] ?? '';
        
        $imgboucher = $data['foto_actual'] ?? 'ejemplo.png';
        if ($foto && $foto['name'] != '') {
            $destino = 'public/assets/img/uploads/';
            if (!is_dir($destino)) {
                mkdir($destino, 0777, true);
            }
            $img_nombre = 'img_' . md5(date('d-m-Y H:i:s'));
            $imgboucher = $img_nombre . '.jpg';
            $src = $destino . $imgboucher;
            move_uploaded_file($foto['tmp_name'], $src);
        }

        try {
            $sql = "UPDATE usuario SET nombre = ?, correo = ?, telefono = ?, dni = ?, n_operacion = ?, m_pagado = ?, banco = ?, fecha_deposito = ?, boucher = ? WHERE iduser = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nombre, $correo, $telefono, $dni, $nopera, $mpagado, $banco, $fecha, $imgboucher, $id]);
            return true;
        } catch (\PDOException $e) {
            error_log("Error actualizando estudiante ingenieria: " . $e->getMessage());
            return false;
        }
    }


    public function eliminarEstudianteIngenieria($id) {
        try {
            $sql = "DELETE FROM usuario WHERE iduser = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Error eliminando estudiante de ingenieria: " . $e->getMessage());
            return false;
        }
    }


    public function getDashboardStatsIngenieria() {
        $mes_actual = date('n'); // Mes actual sin ceros a la izquierda, ej: 10
        try {
            $sql = "SELECT COUNT(*) as estudiantes, SUM(m_pagado) as total_general FROM usuario";
            $stmt = $this->db->query($sql);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            $sql_mes = "SELECT SUM(m_pagado) as total_mes FROM usuario WHERE MONTH(fecha_deposito) = ?";
            $stmt_mes = $this->db->prepare($sql_mes);
            $stmt_mes->execute([$mes_actual]);
            $row_mes = $stmt_mes->fetch(\PDO::FETCH_ASSOC);

            return [
                'estudiantes' => $row['estudiantes'] ?? 0,
                'total_general' => $row['total_general'] ?? 0,
                'total_mes' => $row_mes['total_mes'] ?? 0
            ];
        } catch (\PDOException $e) {
            error_log("Error obteniendo stats de ingenieria: " . $e->getMessage());
            return ['estudiantes' => 0, 'total_general' => 0, 'total_mes' => 0];
        }
    }


}
