<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class VisitorLocation {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
        
        // Crear la tabla si no existe
        $sql = "CREATE TABLE IF NOT EXISTS visitor_locations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            pais VARCHAR(100) DEFAULT 'Perú',
            departamento VARCHAR(100) NOT NULL,
            provincia VARCHAR(100) NOT NULL,
            distrito VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        try {
            $this->db->exec($sql);
            // Intentar agregar la columna pais por si la tabla ya existía
            try {
                $this->db->exec("ALTER TABLE visitor_locations ADD COLUMN pais VARCHAR(100) DEFAULT 'Perú' AFTER ip_address");
            } catch (\PDOException $e) {
                // Si la columna ya existe, simplemente ignora el error
            }
        } catch (\PDOException $e) {
            error_log("Error creando tabla visitor_locations: " . $e->getMessage());
        }
    }

    public function saveLocation($ip, $pais, $departamento, $provincia, $distrito) {
        try {
            $sql = "INSERT INTO visitor_locations (ip_address, pais, departamento, provincia, distrito) VALUES (:ip, :pais, :dep, :prov, :dist)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':dep', $departamento);
            $stmt->bindParam(':prov', $provincia);
            $stmt->bindParam(':dist', $distrito);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error guardando ubicacion: " . $e->getMessage());
            return false;
        }
    }
}
