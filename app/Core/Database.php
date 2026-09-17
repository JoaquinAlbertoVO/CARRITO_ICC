<?php
namespace App\Core;
use PDO;
use PDOException;
class Database {
    // Sin valores por defecto reales: las credenciales SIEMPRE deben venir del .env
    // del servidor (nunca hardcodeadas aqui - este repo es publico en GitHub).
    private $host = 'localhost';
    private $user = '';
    private $password = '';
    private $db = '';
    private $pdo;

    public function __construct() {
        // Lector de .env robusto nativo (Fase 2)
        if (file_exists(__DIR__ . '/../../.env')) {
            $lines = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || strpos($line, '#') === 0) continue;
                
                // Parse: KEY=VALUE (soporta comillas)
                if (preg_match('/^([a-zA-Z0-9_]+)\s*=\s*(.*)$/', $line, $matches)) {
                    $name = $matches[1];
                    $value = trim($matches[2]);
                    
                    // Remover comillas envolventes si las hay
                    if (preg_match('/^([\'"])(.*)\1$/', $value, $quoteMatches)) {
                        $value = $quoteMatches[2];
                    }
                    
                    $_ENV[$name] = $value;
                }
            }
        }

        // Si existen variables de entorno (ya sea del .env local o del servidor), sobrescribimos
        $this->host     = $_ENV['DB_HOST']     ?? $this->host;
        $this->user     = $_ENV['DB_USER']     ?? $this->user;
        $this->password = $_ENV['DB_PASS']     ?? $this->password;
        $this->db       = $_ENV['DB_NAME']     ?? $this->db;

        if (empty($this->user) || empty($this->db)) {
            die('Error de configuración: faltan DB_USER/DB_NAME en el .env del servidor.');
        }
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