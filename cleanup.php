<?php
echo "<h1>Limpieza de Basura (Ransomware) Iniciada</h1>";
$dir = __DIR__;
$deletedFiles = 0;
$deletedDirs = 0;
$bytesSaved = 0;

// Iterar recursivamente sobre todo el directorio
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $filename = $file->getFilename();
        $ext = strtolower($file->getExtension());
        
        // BORRAR SOLO: archivos .sorry y notas del hacker README.md
        if ($ext === 'sorry' || $filename === 'README.md') {
            $size = $file->getSize();
            if (unlink($file->getRealPath())) {
                $deletedFiles++;
                $bytesSaved += $size;
            }
        }
    } elseif ($file->isDir()) {
        // Borrar carpetas vacías
        $path = $file->getRealPath();
        $items = array_diff(scandir($path), array('.', '..'));
        if (count($items) === 0) {
            if (rmdir($path)) {
                $deletedDirs++;
            }
        }
    }
}

// Hacemos una segunda y tercera pasada rápida solo para las carpetas,
// por si al borrar una carpeta anidada, la carpeta padre quedó vacía.
for ($i = 0; $i < 3; $i++) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $file) {
        if ($file->isDir()) {
            $path = $file->getRealPath();
            if (is_dir($path)) {
                $items = array_diff(scandir($path), array('.', '..'));
                if (count($items) === 0) {
                    if (rmdir($path)) {
                        $deletedDirs++;
                    }
                }
            }
        }
    }
}

echo "<p><strong>Archivos basura eliminados:</strong> $deletedFiles</p>";
echo "<p><strong>Carpetas vacías eliminadas:</strong> $deletedDirs</p>";
echo "<p><strong>Espacio liberado:</strong> " . round($bytesSaved / 1024 / 1024, 2) . " MB</p>";
echo "<p style='color: green;'>¡Limpieza completada con éxito!</p>";
?>
