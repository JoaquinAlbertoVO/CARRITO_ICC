<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $user = 'root'; // Usuario local por defecto en XAMPP
    private $password = ''; // Sin contraseña por defecto en XAMPP
    private $db = 'prueba1'; // Base de datos local
    private $pdo;

    public function __construct() {
        // En caso de que estemos en producción, podemos cambiar estas credenciales dinámicamente
        // Leyéndolas de un archivo .env, pero por ahora las mantenemos en código para facilitar la migración.
    }

    public function connect() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en errores
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve arrays asociativos por defecto
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa sentencias preparadas nativas
                ];
                $this->pdo = new PDO($dsn, $this->user, $this->password, $options);
            } catch (PDOException $e) {
                die("Error de Conexión a la Base de Datos: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
