<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'app/Core/Database.php';
$db = new \App\Core\Database();
try {
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
    $pdo->exec($sql);
    echo "<h1>Tabla libro_reclamaciones creada correctamente en la base de datos de produccion.</h1>";
    echo "<p>Por seguridad, por favor elimina este archivo (install.php) de tu servidor una vez termines.</p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
