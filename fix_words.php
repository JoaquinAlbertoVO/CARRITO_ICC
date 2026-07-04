<?php
function replaceInFiles($directory, $replacements) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $originalContent = $content;
            
            foreach ($replacements as $search => $replace) {
                $content = str_replace($search, $replace, $content);
            }
            
            if ($content !== $originalContent) {
                file_put_contents($file->getPathname(), $content);
                echo "Updated: " . $file->getPathname() . "\n";
            }
        }
    }
}

$replacements = [
    "Hipolito Coaguila Berrios" => "Hipólito Coaguila Berrios",
    "Ricardo Cardenas" => "Ricardo Cárdenas",
    "Melissa Jimenez" => "Melissa Jiménez",
    "NÂº" => "Nº",
    "Ingenieria Electrica" => "Ingeniería Eléctrica",
    "PROGRAMACION BASICA P.L.C" => "PROGRAMACIÓN BÁSICA P.L.C",
    "ANALISIS DE FACTURAS Y EVALUACION DE TARIFAS ELECTRICAS" => "ANÁLISIS DE FACTURAS Y EVALUACIÓN DE TARIFAS ELÉCTRICAS",
    "Regulacion del Mercado de Energia" => "Regulación del Mercado de Energía"
];

replaceInFiles(__DIR__ . '/app/Views', $replacements);
echo "Done!\n";
