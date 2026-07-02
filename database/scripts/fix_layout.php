<?php
$head = file_get_contents('administrador/administrador/includes/head.php');
$header = file_get_contents('administrador/administrador/includes/header.php');
$barra = file_get_contents('administrador/administrador/includes/barra_lateral.php');
$script = file_get_contents('administrador/administrador/includes/script.php');

$replace_what = '<?php echo isset($base_path) ? $base_path : \'\' ; ?>';
$replace_what2 = '<?php echo isset($base_path) ? $base_path : \'\'; ?>';
$replace_what3 = '<?php echo isset($base_path) ? $base_path : \\\'\\\'; ?>';
$replace_what4 = "<?php echo isset(\$base_path) ? \$base_path : \\'\\' ; ?>";

$replace_with = '<?= BASE_URL ?>administrador/administrador/';

$head = str_replace([$replace_what, $replace_what2, $replace_what3, $replace_what4], $replace_with, $head);
$header = str_replace([$replace_what, $replace_what2, $replace_what3, $replace_what4], $replace_with, $header);
$script = str_replace([$replace_what, $replace_what2, $replace_what3, $replace_what4], $replace_with, $script);

// Extra regex just in case
$head = preg_replace('/<\?php\s*echo\s*isset\(\$base_path\)\s*\?\s*\$base_path\s*:\s*.*?\?>/', $replace_with, $head);
$header = preg_replace('/<\?php\s*echo\s*isset\(\$base_path\)\s*\?\s*\$base_path\s*:\s*.*?\?>/', $replace_with, $header);
$script = preg_replace('/<\?php\s*echo\s*isset\(\$base_path\)\s*\?\s*\$base_path\s*:\s*.*?\?>/', $replace_with, $script);

// Remove the DB query in barra_lateral completely
$barra = preg_replace('/<\?php\s*include\s*\'\.\.\/conexion\.php\';.*?mysqli_num_rows\(\$sql\);\s*\?>/s', '', $barra);
$barra = preg_replace('/<\?php\s*if\s*\(\$result\s*>\s*0\)\s*\{.*?<\?php\s*\}\s*\}\s*\?>/s', '', $barra);
$barra = str_replace('<?php echo $_SESSION[\'nombre\']; ?>', '<?= $_SESSION[\'nombre\'] ?? \'Admin\' ?>', $barra);

$layout = $head . "\n" . $header . "\n" . "<!-- VISTA DINAMICA DEL DASHBOARD -->\n<div class=\"mdk-drawer-layout__content page\">\n    <?= \$content ?>\n</div>\n<!-- FIN VISTA DINAMICA -->\n" . $barra . "\n" . $script;

file_put_contents('app/Views/admin/layouts/main.php', $layout);
