<?php
namespace App\Models;

use App\Core\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function authenticate($user, $pass, $rol) {
        $sql = "SELECT * FROM plataforma WHERE user = :user AND rol = :rol";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user' => $user,
            ':rol' => $rol
        ]);

        $admin = $stmt->fetch();
        if ($admin) {
            // Validar la contraseña (si es hash bcrypt, si no, fallback por seguridad antes de migrar)
            if (password_verify($pass, $admin['pass']) || $pass === $admin['pass']) {
                // Autenticación correcta
                return $admin;
            }
        }
        return false;
    }
}
