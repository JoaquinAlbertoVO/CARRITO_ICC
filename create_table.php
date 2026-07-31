<?php
require 'app/Core/Database.php';

use App\Core\Database;

$db = new Database();
$pdo = $db->connect();

$sql = "
CREATE TABLE IF NOT EXISTS libro_reclamaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_reclamo VARCHAR(50) NOT NULL,
    nombres VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    tipo_documento VARCHAR(20) NOT NULL,
    numero_documento VARCHAR(50) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tipo_bien VARCHAR(50) NOT NULL,
    monto_reclamado DECIMAL(10,2) DEFAULT NULL,
    descripcion_bien TEXT NOT NULL,
    tipo_reclamo VARCHAR(50) NOT NULL,
    detalle_reclamo TEXT NOT NULL,
    pedido TEXT NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    $pdo->exec($sql);
    echo "Tabla libro_reclamaciones creada correctamente.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
