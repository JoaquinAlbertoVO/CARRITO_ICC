<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'icccom_icc';
$password = 'pWhOD~@e{DZ5ie%x';
$db = 'icccom_icc';

try {
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $password, $options);
    
    // Test basic queries
    echo "✅ Conexión exitosa a la base de datos: $db\n\n";
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tablas encontradas (" . count($tables) . "):\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
    if (in_array('usuarios', $tables)) {
        $users = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        echo "\nTotal de usuarios: $users\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error de conexión:\n" . $e->getMessage() . "\n\n";
    echo "NOTA: Este error es normal si el script se ejecuta en tu PC (localhost)\n";
    echo "porque tu PC no es el servidor de cPanel.";
}
