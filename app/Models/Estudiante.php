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
     * $tabla: 'usuario' para Ingeniería, 'usuario_d' para Derecho
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
     * Obtiene el total de registros para paginación
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
}
