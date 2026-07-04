<?php
$files = ['app/Views/cursos/index.php', 'app/Views/cursos/ingenieria.php'];
foreach ($files as $f) {
    $c = file_get_contents($f);
    $c = preg_replace('/<img src="<\?= BASE_URL \?>assets\/images\/Electricidad_Industrial\.jpeg"[^>]*>/', '<h4 style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 14px;">[ ESPACIO PARA IMAGEN ]<br><span style="font-size:11px; font-weight:normal; color:#fff;">(Curso)</span></h4>', $c);
    file_put_contents($f, $c);
}
