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
    "Hipolito Coaguila Berrios" => "HipÃ³lito Coaguila Berrios",
    "Ricardo Cardenas" => "Ricardo CÃ¡rdenas",
    "Melissa Jimenez" => "Melissa JimÃ©nez",
    "NÃ‚Âº" => "NÂº",
    "Ingenieria Electrica" => "IngenierÃ­a ElÃ©ctrica",
    "PROGRAMACION BASICA P.L.C" => "PROGRAMACIÃ“N BÃSICA P.L.C",
    "ANALISIS DE FACTURAS Y EVALUACION DE TARIFAS ELECTRICAS" => "ANÃLISIS DE FACTURAS Y EVALUACIÃ“N DE TARIFAS ELÃ‰CTRICAS",
    "Regulacion del Mercado de Energia" => "RegulaciÃ³n del Mercado de EnergÃ­a"
];

replaceInFiles(__DIR__ . '/app/Controllers', $replacements);
echo "Done!\n";

