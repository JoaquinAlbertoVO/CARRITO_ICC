<?php
namespace App\Controllers;

use App\Core\Controller;

/**
 * Login del aula virtual. Usa sus propias claves de sesion (aula_*): antes compartia 'active' e
 * 'idUser' con el panel admin y un alumno logueado podia entrar a /admin.
 */
class AulaAuthController extends Controller {

    const MAX_INTENTOS = 8;
    const BLOQUEO_SEG = 600;

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['aula_uid'])) {
            header('Location: ' . BASE_URL . 'aula');
            exit;
        }

        $error = '';
        $usuario = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim((string) ($_POST['usuario'] ?? ''));
            $clave = (string) ($_POST['clave'] ?? '');
            $bloqueo = (int) ($_SESSION['aula_bloqueo'] ?? 0);

            if ($bloqueo > time()) {
                $error = 'Demasiados intentos. Espera unos minutos y vuelve a intentarlo.';
            } elseif ($usuario === '' || $clave === '') {
                $error = 'Ingresa tu usuario y tu contraseña.';
            } else {
                try {
                    $pdo = (new \App\Core\Database())->connect();
                    // El usuario suele ser el correo: se acepta tambien el correo aunque el usuario sea otro
                    $st = $pdo->prepare("SELECT * FROM usuario WHERE (usuario = ? OR correo = ?) AND (estatus IS NULL OR estatus = 1) ORDER BY iduser ASC");
                    $st->execute([$usuario, $usuario]);
                    $alumno = null;
                    foreach ($st->fetchAll(\PDO::FETCH_ASSOC) as $fila) {
                        $guardada = (string) $fila['password'];
                        // Las claves del aula se guardan en texto plano (asi las ven los asesores);
                        // si algun dia se guardan con hash, esto ya las acepta.
                        $ok = (strpos($guardada, '$2y$') === 0) ? password_verify($clave, $guardada) : hash_equals($guardada, trim($clave));
                        if ($ok) {
                            $alumno = $fila;
                            break;
                        }
                    }
                    if ($alumno) {
                        session_regenerate_id(true);
                        unset($_SESSION['aula_intentos'], $_SESSION['aula_bloqueo']);
                        $_SESSION['aula_uid'] = (int) $alumno['iduser'];
                        $_SESSION['aula_nombre'] = (string) $alumno['nombre'];
                        $_SESSION['aula_usuario'] = (string) $alumno['usuario'];
                        header('Location: ' . BASE_URL . 'aula');
                        exit;
                    }
                    $_SESSION['aula_intentos'] = (int) ($_SESSION['aula_intentos'] ?? 0) + 1;
                    if ($_SESSION['aula_intentos'] >= self::MAX_INTENTOS) {
                        $_SESSION['aula_bloqueo'] = time() + self::BLOQUEO_SEG;
                        $_SESSION['aula_intentos'] = 0;
                    }
                    $error = 'Usuario o contraseña incorrectos.';
                } catch (\PDOException $e) {
                    error_log('Aula login: ' . $e->getMessage());
                    $error = 'No pudimos conectar. Intenta de nuevo en un momento.';
                }
            }
        }
        $this->view('aula/login', ['error' => $error, 'usuario' => $usuario], false);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Solo cierra el aula (si en el mismo navegador hay una sesion del admin, sigue abierta)
        foreach (array_keys($_SESSION) as $k) {
            if (strpos($k, 'aula_') === 0) {
                unset($_SESSION[$k]);
            }
        }
        session_regenerate_id(true);
        header('Location: ' . BASE_URL . 'aula/login');
        exit;
    }
}
