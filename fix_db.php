<?php
require_once __DIR__ . '/app/Core/Database.php';

try {
    $db = (new \App\Core\Database())->connect();
    
    $cursos_oficiales = [
        'Analizador de Redes',
        'Banco de Condensadores',
        'Canalizacion de Tuberias Conduit',
        'Especializacion en Electricidad Industrial',
        'Empalmes Termocontraibles en MT',
        'Mantenimiento de Subestaciones Electricas',
        'Terminaciones Termocontraibles en MT',
        'Variadores de Frecuencia'
    ];
    
    $placeholders = implode(',', array_fill(0, count($cursos_oficiales), '?'));
    
    // 1. Eliminar los cursos que NO estén en la lista oficial
    $stmtDelete = $db->prepare("DELETE FROM cursos WHERE nombre_curso NOT IN ($placeholders)");
    $stmtDelete->execute($cursos_oficiales);
    echo "<h1>Actualización de Base de Datos</h1>";
    echo "<p>Cursos antiguos eliminados: " . $stmtDelete->rowCount() . "</p>";
    
    // 2. Actualizar el docente y la foto
    $random_foto = 'profesor.jpg';
    $stmtUpdate = $db->prepare("UPDATE cursos SET docente = 'Ricardo Cardenas', docente_foto = ?");
    $stmtUpdate->execute([$random_foto]);
    echo "<p>Cursos actualizados con Ricardo Cardenas: " . $stmtUpdate->rowCount() . "</p>";
    
    echo "<p style='color: green;'><b>¡Base de datos actualizada correctamente en el servidor en vivo!</b></p>";
    echo "<p>Por seguridad, borraremos este archivo ahora mismo...</p>";
    
    // Auto-eliminar el script después de ejecutarse por seguridad
    unlink(__FILE__);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
