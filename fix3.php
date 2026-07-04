<?php
$files = glob(__DIR__ . '/app/Views/cursos/detalles/*.php');
foreach ($files as $file) {
    if (basename($file) === 'banco_condensadores.php') continue; // this one is correct
    $content = file_get_contents($file);
    // Remove the Electricidad_Industrial image from details banners
    $content = preg_replace('/<img src="<\?= BASE_URL \?>assets\/images\/Electricidad_Industrial\.jpeg".*?>/', '<h4 style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 20px;">[ ESPACIO PARA IMAGEN ]<br><span style="font-size:14px; font-weight:normal; color:#fff;">(Banner del Curso)</span></h4>', $content);
    file_put_contents($file, $content);
}

// Now for index.php and ingenieria.php
$files2 = [__DIR__ . '/app/Views/cursos/index.php', __DIR__ . '/app/Views/cursos/ingenieria.php'];
foreach ($files2 as $file) {
    $content = file_get_contents($file);
    $content = preg_replace('/<img src="<\?= BASE_URL \?>assets\/images\/Electricidad_Industrial\.jpeg".*?>/', '<h4 style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 14px;">[ ESPACIO PARA IMAGEN ]<br><span style="font-size:11px; font-weight:normal; color:#fff;">(Curso)</span></h4>', $content);
    file_put_contents($file, $content);
}
