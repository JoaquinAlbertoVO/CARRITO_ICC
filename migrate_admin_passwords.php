<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'app/Core/Database.php';

$db = new \App\Core\Database();
try {
    $pdo = $db->connect();
    
    // IMPORTANTE: Aumentar el tamaño de la columna para que soporte el hash de 60 caracteres
    $pdo->exec("ALTER TABLE plataforma MODIFY COLUMN pass VARCHAR(255)");
    
    // Check if there's any admin that needs migration
    $stmt = $pdo->query("SELECT * FROM plataforma");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $migrados = 0;
    foreach ($admins as $admin) {
        $pass = $admin['pass'];
        // Si no empieza con $2y$ (BCRYPT), la encriptamos
        if (strpos($pass, '$2y$') !== 0) {
            $hashed = password_hash($pass, PASSWORD_BCRYPT);
            $update = $pdo->prepare("UPDATE plataforma SET pass = ? WHERE id_pla = ?");
            $update->execute([$hashed, $admin['id_pla']]);
            $migrados++;
        }
    }
    
    echo "<h1>Migración Completa</h1>";
    echo "<p>Se encriptaron $migrados contraseñas de administrador.</p>";
    echo "<p>Por seguridad, elimina este archivo (migrate_admin_passwords.php) de tu servidor.</p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
