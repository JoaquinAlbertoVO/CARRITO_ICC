<?php
namespace App\Controllers;

use App\Core\Controller;

class AulaAuthController extends Controller {
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si ya está logueado y activo, redirigir al dashboard del aula
        if (!empty($_SESSION['active']) && !empty($_SESSION['idUser'])) {
            header('location: ' . BASE_URL . 'aula');
            exit;
        }

        $alert = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['usuario']) || empty($_POST['clave'])) {
                $alert = '<div class="mo-toast mo-toast-error">
                            <span>⚠️</span> Ingrese su usuario y contraseña.
                          </div>';
            } else {
                $db = new \App\Core\Database();
                try {
                    $pdo = $db->connect();
                    $user = trim($_POST['usuario']);
                    $pass = trim($_POST['clave']);

                    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE usuario = :user AND password = :pass");
                    $stmt->execute([':user' => $user, ':pass' => $pass]);
                    
                    $data = $stmt->fetch(\PDO::FETCH_ASSOC);
                    
                    if ($data) {
                        $_SESSION['active'] = true;
                        $_SESSION['idUser'] = $data['iduser'];
                        $_SESSION['id_pla'] = $data['id_pla'];
                        $_SESSION['nombre'] = $data['nombre'];
                        $_SESSION['user'] = $data['usuario'];

                        header('location: ' . BASE_URL . 'aula');
                        exit;
                    } else {
                        $alert = '<div class="mo-toast mo-toast-error">
                                    <span>❌</span> Usuario o contraseña incorrectos.
                                  </div>';
                    }
                } catch (\PDOException $e) {
                    $alert = '<div class="mo-toast mo-toast-error">
                                <span>❌</span> Error de conexión a la base de datos.
                              </div>';
                }
            }
        }

        // Cargar vista de login del aula (sin layout general)
        $this->view('aula/login', ['alert' => $alert], false);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('location: ' . BASE_URL . 'aula/login');
        exit;
    }
}
