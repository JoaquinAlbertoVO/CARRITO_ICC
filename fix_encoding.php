<?php
$dir = new RecursiveDirectoryIterator('app/Views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    urldecode('%C3%83%C2%A1') => 'á',
    urldecode('%C3%83%C2%A9') => 'é',
    urldecode('%C3%83%C2%AD') => 'í',
    urldecode('%C3%83%C2%B3') => 'ó',
    urldecode('%C3%83%C2%BA') => 'ú',
    urldecode('%C3%83%C2%B1') => 'ñ',
    urldecode('%C3%83%C2%81') => 'Á',
    urldecode('%C3%83%C2%89') => 'É',
    urldecode('%C3%83%C2%8D') => 'Í',
    urldecode('%C3%83%C2%93') => 'Ó',
    urldecode('%C3%83%C2%9A') => 'Ú',
    urldecode('%C3%83%C2%91') => 'Ñ',
    urldecode('%C3%A2%E2%82%AC%E2%80%9C') => '-', // En-dash
    urldecode('%C3%82%C2%A9') => '©',
    urldecode('%C3%82%C2%A1') => '¡',
    urldecode('%C3%82%C2%BF') => '¿'
];

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $new_content = strtr($content, $replacements);
    if ($content !== $new_content) {
        file_put_contents($path, $new_content);
        echo "Fixed: $path\n";
    }
}
