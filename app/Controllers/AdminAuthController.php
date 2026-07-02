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

                    header('Location: ' . BASE_URL . 'admin/dashboard');
                    exit;
                } else {
                    $alert = '
                    <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Aviso - </strong> El usuario, clave o rol son incorrectos!
                    </div>';
                }
            }
        }

        // Cargar la vista de login (pasando la variable alert)
        $this->view('admin/login', ['alert' => $alert]);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'admin/login');
        exit;
    }
}
