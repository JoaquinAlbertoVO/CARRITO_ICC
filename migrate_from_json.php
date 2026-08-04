<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'app/Core/Database.php';

$db = new \App\Core\Database();
try {
    $pdo = $db->connect();
    
    // Load JSON data
    $jsonString = file_get_contents(__DIR__ . '/courses_data.json');
    if ($jsonString === false) {
        die("Error: No se pudo leer courses_data.json");
    }
    
    $coursesData = json_decode($jsonString, true);
    if ($coursesData === null) {
        die("Error: courses_data.json no es un JSON válido: " . json_last_error_msg());
    }

    $actualizados = 0;
    
    foreach ($coursesData as $kw => $data) {
        if (empty($data['resumen']) && empty($data['temas'])) {
            continue;
        }
        
        $resumen = $data['resumen'];
        $temas = $data['temas'];
        $beneficios = $data['beneficios'];
        $programacion = $data['programacion'];
        
        $update = $pdo->prepare("UPDATE cursos SET resumen = ?, temas = ?, beneficios = ?, programacion = ? WHERE LOWER(nombre_curso) LIKE ?");
        $update->execute([$resumen, $temas, $beneficios, $programacion, "%$kw%"]);
        
        $actualizados += $update->rowCount();
    }
    
    echo "<h1>Migración de HTML desde JSON Completa</h1>";
    echo "<p>Se actualizaron los textos descriptivos de los cursos en la BD.</p>";
    echo "<p>Cursos actualizados: $actualizados</p>";
    echo "<p><strong>¡Ahora el diseño debería verse perfecto!</strong></p>";

} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error general: " . $e->getMessage();
}
