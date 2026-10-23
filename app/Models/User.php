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
            $guardada = (string) $admin['pass'];
            // Si la columna guarda un hash, solo vale password_verify: comparar en texto plano dejaria
            // entrar a quien escriba el hash mismo (por ejemplo, sacado de un respaldo de la base)
            if (password_get_info($guardada)['algo'] !== null) {
                if (password_verify($pass, $guardada)) {
                    return $admin;
                }
                return false;
            }
            // Admin que aun tiene la clave en texto plano: se acepta una vez y se guarda como bcrypt
            if ($guardada !== '' && hash_equals($guardada, (string) $pass)) {
                $update = $this->db->prepare("UPDATE plataforma SET pass = ? WHERE id_pla = ?");
                $update->execute([password_hash($pass, PASSWORD_BCRYPT), $admin['id_pla']]);
                return $admin;
            }
        }
        return false;
    }
}
