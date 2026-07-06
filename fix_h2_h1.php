<?php
$file = 'app/Views/home/index.php';
$content = file_get_contents($file);

// Fix heading order (h2 before h1) -> make it a span
$content = str_replace('<h2 class="main-slider-two__tagline">', '<span class="main-slider-two__tagline" style="display:inline-block; margin-bottom:10px;">', $content);
$content = str_replace('</h2><br>', '</span><br>', $content);
$content = str_replace('</h2>', '</span>', $content); // Catch any missing <br>

// Brute force fix the corrupted characters
$content = preg_replace('/Capac.tate/i', 'Capacítate', $content);
$content = preg_replace('/Especial.zate/i', 'Especialízate', $content);
$content = preg_replace('/Ingenier.a/i', 'Ingeniería', $content);
$content = preg_replace('/El.ctrica/i', 'Eléctrica', $content);
$content = preg_replace('/m.s/i', 'más', $content);

file_put_contents($file, $content);
echo "Fixes applied";
