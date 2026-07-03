<?php
namespace App\Core;
use PDO;
use PDOException;
class Database {
    // Valores por defecto (credenciales de PRODUCCIÓN en cPanel)
    private $host = 'localhost';
    private $user = 'icccom_icc';
    private $password = 'pWhOD~@e{DZ5ie%x';
    private $db = 'icccom_icc';
    private $pdo;

    public function __construct() {
        // Lógica súper sencilla para leer archivo .env local sin dependencias (Composer)
        if (file_exists(__DIR__ . '/../../.env')) {
            $lines = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                list($name, $value) = explode('=', $line, 2);
                $_ENV[trim($name)] = trim($value);
            }
        }

        // Si existen variables de entorno (ya sea del .env local o del servidor), sobrescribimos
        $this->host     = $_ENV['DB_HOST']     ?? $this->host;
        $this->user     = $_ENV['DB_USER']     ?? $this->user;
        $this->password = $_ENV['DB_PASS']     ?? $this->password;
        $this->db       = $_ENV['DB_NAME']     ?? $this->db;
    }

    public function connect() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $this->pdo = new PDO($dsn, $this->user, $this->password, $options);
            } catch (PDOException $e) {
                die("Error de Conexión a la Base de Datos: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
?>