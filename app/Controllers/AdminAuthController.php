<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AdminAuthController extends Controller {
    public function login() {
        // Si ya está logueado, redirigir al dashboard
        if (isset($_SESSION['active']) && $_SESSION['active'] === true) {
            header('Location: ' . BASE_URL . 'admin/dashboard');
            exit;
        }

        $alert = '';

        // Lockout Check
        if (isset($_SESSION['lockout_time'])) {
            if (time() < $_SESSION['lockout_time']) {
                $alert = '
                <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Aviso - </strong> Demasiados intentos fallidos. Por seguridad, intente de nuevo en 15 minutos.
                </div>';
                $this->view('admin/login', ['alert' => $alert], false);
                return;
            } else {
                // Lockout expired, reset
                unset($_SESSION['lockout_time']);
                $_SESSION['login_attempts'] = 0;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['rol']) || empty($_POST['usuario']) || empty($_POST['clave'])) {
                $alert = '
                <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Aviso - </strong> Ingrese su usuario, clave y rol al que pertenece.
                </div>';
            } else {
                $userModel = new User();
                $data = $userModel->authenticate($_POST['usuario'], $_POST['clave'], $_POST['rol']);

                if ($data) {
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $data['id_pla'];
                    $_SESSION['nombre'] = $data['name'];
                    $_SESSION['lastname'] = $data['last_name'];
                    $_SESSION['user'] = $data['user'];
                    $_SESSION['rol']  = $data['rol'];
                    $_SESSION['login_attempts'] = 0; // reset on success

                    header('Location: ' . BASE_URL . 'admin/dashboard');
                    exit;
                } else {
                    if (!isset($_SESSION['login_attempts'])) {
                        $_SESSION['login_attempts'] = 0;
                    }
                    $_SESSION['login_attempts']++;

                    if ($_SESSION['login_attempts'] >= 5) {
                        $_SESSION['lockout_time'] = time() + (15 * 60); // 15 minutos
                        $alert = '
                        <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                            <strong>Aviso - </strong> Demasiados intentos fallidos. Por seguridad, intente de nuevo en 15 minutos.
                        </div>';
                    } else {
                        $restantes = 5 - $_SESSION['login_attempts'];
                        $alert = '
                        <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Aviso - </strong> El usuario, clave o rol son incorrectos! (Intentos restantes: ' . $restantes . ')
                        </div>';
                    }
                }
            }
        }

        // Cargar la vista de login (pasando la variable alert y sin usar layout)
        $this->view('admin/login', ['alert' => $alert], false);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'admin/login');
        exit;
    }
}
