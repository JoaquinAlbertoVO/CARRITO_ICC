<?php
namespace App\Models;

use App\Core\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function authenticate($user, $pass, $rol) {
        $sql = "SELECT * FROM plataforma WHERE user = :user AND pass = :pass AND rol = :rol";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user' => $user,
            ':pass' => $pass,
            ':rol' => $rol
        ]);

        return $stmt->fetch();
    }
}
