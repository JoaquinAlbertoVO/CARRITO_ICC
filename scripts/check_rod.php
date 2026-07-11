<?php
$host = 'localhost';
$db = 'icccom_icc'; // Based on setup_db.sql
$user = 'root'; // Assuming default XAMPP
$pass = ''; // Assuming default XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "--- Usuarios ---\n";
    $stmt = $pdo->query("SELECT iduser, nombre, usuario FROM usuario");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    echo "\n--- Usuarios Cursos ---\n";
    $stmt = $pdo->query("SELECT * FROM usuario_cursos");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
