<?php
$viewsDir = __DIR__ . '/app/Views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$phpFiles = [];
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $phpFiles[] = $file->getPathname();
    }
}

// Mapeo de fragmentos de título a nombre de imagen
$imageMapping = [
    'Analizadores' => 'Analizador_de_Redes_BT.jpeg',
    'Banco' => 'Banco_de_Condensadores.jpeg',
    'Electricidad' => 'Electricidad_Industrial.jpeg',
    'Tuberia' => 'Canalizacion_Tuberia_Conduit.jpeg',
    'Subestaciones' => 'Mantenimiento_de_Subestaciones_Electricas.jpeg',
    'Termocontraible' => 'Terminaciones_Termocontraible_MT.jpeg',
    'Variadores' => 'Variadores_de_frecuencia.jpeg',
    // Fallback genérico para los cursos que no tienen flyer subido:
    'PLC' => 'Electricidad_Industrial.jpeg',
    'Puesta a Tierra' => 'Electricidad_Industrial.jpeg',
    'Tarifas' => 'Electricidad_Industrial.jpeg',
    'Seguridad' => 'Electricidad_Industrial.jpeg',
    'Mercado' => 'Electricidad_Industrial.jpeg',
    'Motores' => 'Electricidad_Industrial.jpeg'
];

foreach ($phpFiles as $file) {
    $content = file_get_contents($file);
    if (strpos($content, '[ ESPACIO PARA IMAGEN ]') === false) {
        continue;
    }
    
    // Para home/index.php, que itera un array dinámico:
    if (strpos($file, 'home\index.php') !== false || strpos($file, 'home/index.php') !== false) {
        $content = preg_replace('/<div class="tarjeta-dark-img-overlay">\s*<h4[^>]*>\[ ESPACIO PARA IMAGEN \].*?<\/h4>\s*<\/div>/is', '', $content);
        file_put_contents($file, $content);
        echo "Updated home/index.php\n";
        continue;
    }
    
    // Para los demas archivos, donde cada curso tiene su propio bloque HTML
    // Buscamos bloques que contengan [ ESPACIO PARA IMAGEN ] y el título del curso más abajo.
    // Usaremos un regex complejo o un procesamiento por bloques.
    $blocks = preg_split('/(<div class="courses-one__single">|<div class="course-details__header[^"]*">)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    if (count($blocks) > 1) {
        $newContent = $blocks[0];
        for ($i = 1; $i < count($blocks); $i += 2) {
            $divider = $blocks[$i];
            $blockContent = $blocks[$i+1];
            
            if (strpos($blockContent, '[ ESPACIO PARA IMAGEN ]') !== false) {
                // Determinar el título
                $matchedImg = 'logoicc.jfif'; // Default
                foreach ($imageMapping as $keyword => $imgFile) {
                    if (strpos($blockContent, $keyword) !== false) {
                        $matchedImg = $imgFile;
                        break;
                    }
                }
                
                // Reemplazar el div overlay con el ESPACIO PARA IMAGEN por una img (si es course-details)
                if (strpos($divider, 'course-details') !== false) {
                    $blockContent = preg_replace('/<div style="[^"]*border:[^"]*">\s*<h4[^>]*>\[ ESPACIO PARA IMAGEN \].*?<\/h4>\s*<\/div>/is', '<img src="<?= BASE_URL ?>assets/images/' . $matchedImg . '" alt="Banner" style="width:100%; border-radius:10px;">', $blockContent);
                } else {
                    // Para cursos/index.php
                    // Primero, eliminar el div .tarjeta-dark-img-overlay
                    $blockContent = preg_replace('/<div class="tarjeta-dark-img-overlay">\s*<h4[^>]*>\[ ESPACIO PARA IMAGEN \].*?<\/h4>\s*<\/div>/is', '', $blockContent);
                    // Insertar o reemplazar la img en courses-one__single-img
                    $blockContent = preg_replace('/(<div class="courses-one__single-img">)\s*(.*?)\s*(<div class="overlay-text">)/is', '$1 <img src="<?= BASE_URL ?>assets/images/' . $matchedImg . '" alt=""/> $3', $blockContent);
                }
            }
            $newContent .= $divider . $blockContent;
        }
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}
