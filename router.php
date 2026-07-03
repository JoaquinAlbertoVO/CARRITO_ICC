<?php
// router.php para el servidor local de PHP (php -S)
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Si el archivo físico existe (ej. assets, imagenes, css), sírvelo tal cual
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Si no existe, envía todo al Front Controller (emulando el .htaccess)
$_GET['url'] = ltrim($uri, '/');
require_once __DIR__ . '/index.php';
