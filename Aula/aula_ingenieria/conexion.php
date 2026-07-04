<?php
mysqli_report(MYSQLI_REPORT_OFF);

$host     = 'localhost';
$user     = 'icccom_icc';
$password = 'bpFsCGU@d0sx@zO';
$db       = 'icccom_icc';

// Leer .env local si existe para desarrollo
$env_path = __DIR__ . '/../../.env';
if (file_exists($env_path)) {
    $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

$host     = $_ENV['DB_HOST'] ?? $host;
$user     = $_ENV['DB_USER'] ?? $user;
$password = $_ENV['DB_PASS'] ?? $password;
$db       = $_ENV['DB_NAME'] ?? $db;

$conection = @mysqli_connect($host, $user, $password, $db);

if (!$conection) {
	echo "Error de Conexion: " . mysqli_connect_error();
}
?>