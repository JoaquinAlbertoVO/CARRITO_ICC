<?php
$file = 'app/Views/home/index.php';
$content = file_get_contents($file);

// Fix the corrupted </h2> tags
$content = str_replace('</span>', '</h2>', $content); // Revert all first
$content = str_replace('<span class="main-slider-two__tagline" style="display:inline-block; margin-bottom:10px;">Cursos online</h2>', '<span class="main-slider-two__tagline" style="display:inline-block; margin-bottom:10px;">Cursos online</span>', $content);

// Fix h4 tags skipping h3
$content = str_replace('<h4 ', '<h3 ', $content);
$content = str_replace('</h4>', '</h3>', $content);

// Brute force fix encoding again since it reverted to ?
$content = preg_replace('/INGENIER..A/i', 'INGENIERÍA', $content);
$content = preg_replace('/Capac.tate/i', 'Capacítate', $content);
$content = preg_replace('/Especial.zate/i', 'Especialízate', $content);
$content = preg_replace('/El.ctrica/i', 'Eléctrica', $content);
$content = preg_replace('/m.si.n/i', 'misión', $content);
$content = preg_replace('/.Qu. est.n/i', '¿Qué están', $content);
$content = preg_replace('/Regulaci.n/i', 'Regulación', $content);
$content = preg_replace('/El.ctrico/i', 'Eléctrico', $content);
$content = preg_replace('/Especializaci.n/i', 'Especialización', $content);

file_put_contents($file, $content);
echo "Fixes applied to index.php";
