<?php
require_once __DIR__ . '/app/Core/Database.php';

try {
    $db = (new \App\Core\Database())->connect();
    
    // Buscar el ID del curso
    $stmt = $db->prepare("SELECT id_curso FROM cursos WHERE nombre_curso LIKE '%Mantenimiento de Subestaciones%' LIMIT 1");
    $stmt->execute();
    $curso = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$curso) {
        die("<h2 style='color:red;'>Error: No se encontró el curso 'Mantenimiento de Subestaciones Electricas'.</h2>");
    }
    
    $id_curso = $curso['id_curso'];
    
    // Borrar videos anteriores de este curso para no duplicar
    $stmtDelete = $db->prepare("DELETE FROM curso_videos WHERE id_curso = ?");
    $stmtDelete->execute([$id_curso]);
    
    // Lista de módulos a insertar (Duración máximo de 8 a 10 caracteres)
    $modulos = [
        [
            'modulo' => 'MÓDULO 1 CLASE VIRTUAL EN VIVO GRABADA',
            'titulo' => 'Clase Virtual 1',
            'url_video' => 'https://www.youtube.com/watch?v=nDVQPwAPmvo&list=PLIJfqFdcwwF4&index=8',
            'duracion' => '01:30:00',
            'orden' => 1
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASINCRONA',
            'titulo' => 'Playlist Asíncrona 1',
            'url_video' => 'https://www.youtube.com/playlist?list=PLIJfqFdcwwF4',
            'duracion' => 'Playlist',
            'orden' => 2
        ],
        [
            'modulo' => 'MÓDULO 3 CLASE VIRTUAL EN VIVO GRABADA',
            'titulo' => 'Clase Virtual 2 (Próximamente)',
            'url_video' => 'https://www.youtube.com/watch?v=nDVQPwAPmvo', 
            'duracion' => '00:00:00',
            'orden' => 3
        ],
        [
            'modulo' => 'MÓDULO 4 CLASE GRABADA ASINCRONA',
            'titulo' => 'Playlist Asíncrona 2',
            'url_video' => 'https://www.youtube.com/playlist?list=PLan4iXtjW3Gs',
            'duracion' => 'Playlist',
            'orden' => 4
        ]
    ];
    
    $stmtInsert = $db->prepare("INSERT INTO curso_videos (id_curso, modulo, titulo, duracion, url_video, estado, orden) VALUES (?, ?, ?, ?, ?, 1, ?)");
    
    echo "<div style='font-family: Arial; padding: 20px;'>";
    echo "<h2>Actualización de Módulos - Mantenimiento de Subestaciones</h2><ul>";
    
    foreach ($modulos as $mod) {
        $stmtInsert->execute([
            $id_curso, 
            $mod['modulo'], 
            $mod['titulo'], 
            $mod['duracion'], 
            $mod['url_video'], 
            $mod['orden']
        ]);
        echo "<li style='color: green;'>✅ Módulo agregado: <b>{$mod['modulo']}</b></li>";
    }
    
    echo "</ul><p><b>¡Proceso completado!</b> Los módulos se han actualizado correctamente.</p>";
    echo "<p>Por seguridad, borraremos este archivo ahora mismo...</p>";
    echo "<a href='/Aula/aula_ingenieria/aula/curso.php?id={$id_curso}'>Ir al curso</a></div>";
    
    // Auto-eliminar
    if (file_exists(__FILE__)) {
        unlink(__FILE__);
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
