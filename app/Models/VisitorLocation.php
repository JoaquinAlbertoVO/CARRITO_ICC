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
            departamento VARCHAR(100) NOT NULL,
            provincia VARCHAR(100) NOT NULL,
            distrito VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        try {
            $this->db->exec($sql);
        } catch (\PDOException $e) {
            error_log("Error creando tabla visitor_locations: " . $e->getMessage());
        }
    }

    public function saveLocation($ip, $departamento, $provincia, $distrito) {
        try {
            $sql = "INSERT INTO visitor_locations (ip_address, departamento, provincia, distrito) VALUES (:ip, :dep, :prov, :dist)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ip', $ip);
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
