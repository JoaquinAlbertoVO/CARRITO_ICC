<?php
$file = 'app/Views/home/index.php';
$content = file_get_contents($file);

// Accesibilidad
$content = str_replace('<h2 class="main-slider__title">', '<h1 class="main-slider__title" style="font-size:inherit; font-weight:inherit;">', $content);
$content = str_replace('</h2><br><br><br><br>', '</h1><br><br><br><br>', $content);

// Ortografia
$content = preg_replace('/Capac.tate/u', 'Capacítate', $content);
$content = preg_replace('/Especial.zate/u', 'Especialízate', $content);
$content = preg_replace('/Ingenier.a/u', 'Ingeniería', $content);
$content = preg_replace('/El.ctrica/u', 'Eléctrica', $content);
$content = preg_replace('/m.s/u', 'más', $content);

file_put_contents($file, $content);
echo "Fixes applied to home/index.php";
