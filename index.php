<?php
// Iniciar la sesión global para la aplicación
session_start();
header('Content-Type: text/html; charset=utf-8');

// Configuración de errores para PRODUCCIÓN
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Definir constante base que detecte subcarpetas (ej. /CARRITO/)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$script = $script === '/' ? '' : $script;
define('BASE_URL', $protocol . "://" . $host . $script . "/");

// Carga automática simple de clases
spl_autoload_register(function ($class) {
    // Convertir App\Core\Router a app/Core/Router.php
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Incluir helpers globales
require_once __DIR__ . '/app/Helpers/Security.php';

// Inicializar el Router
$router = new \App\Core\Router();
