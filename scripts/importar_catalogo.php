<?php
/**
 * Importa el catalogo de cursos grabados y packs (JSON generado desde el Excel) a la BD del .env.
 * Uso (solo CLI):  php scripts/importar_catalogo.php C:\Users\...\ICC_catalogo\catalogo_asincrono.json
 * En produccion se usa admin > Catalogo > Importar (sube el mismo JSON).
 * El JSON lleva los enlaces de las clases y materiales: vive FUERA del repo (el repo es publico).
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
if ($argc < 2 || !is_file($argv[1])) {
    fwrite(STDERR, "Uso: php scripts/importar_catalogo.php <catalogo.json>\n");
    exit(1);
}
spl_autoload_register(function ($class) {
    if (strncmp('App\\', $class, 4) === 0) {
        $f = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (is_file($f)) {
            require $f;
        }
    }
});
$data = json_decode(file_get_contents($argv[1]), true);
if (!is_array($data)) {
    fwrite(STDERR, "El archivo no es un JSON valido.\n");
    exit(1);
}
$res = (new \App\Models\Catalogo())->importar($data);
foreach ($res as $k => $v) {
    echo str_pad($k, 22) . $v . "\n";
}
