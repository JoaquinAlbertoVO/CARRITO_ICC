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
        // PRESENTACIÓN
        [
            'modulo' => 'PRESENTACIÓN DEL CURSO',
            'titulo' => 'Introducción al Curso',
            'url_video' => 'https://www.youtube.com/watch?v=nDVQPwAPmvo',
            'duracion' => '05:00',
            'orden' => 0
        ],
        // MÓDULO 1
        [
            'modulo' => 'MÓDULO 1 CLASE VIRTUAL EN VIVO GRABADA',
            'titulo' => 'Clase Virtual 1 (Próximamente)',
            'url_video' => 'https://www.youtube.com/watch?v=nDVQPwAPmvo', // Fallback temporal
            'duracion' => '00:00:00',
            'orden' => 1
        ],
        // MÓDULO 2 DESGLOSADO
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Introducción',
            'url_video' => 'https://youtu.be/i3DGfbp5_9A',
            'duracion' => '00:42',
            'orden' => 2
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 1: Equipos de protección personal, trajes ignífugos',
            'url_video' => 'https://youtu.be/qOc05IAAjD8',
            'duracion' => '12:00', // Aproximado por icono superpuesto
            'orden' => 3
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 2: Equipos de maniobra',
            'url_video' => 'https://youtu.be/tzDiviqeFxU',
            'duracion' => '19:29',
            'orden' => 4
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 3: 5 reglas de oro',
            'url_video' => 'https://youtu.be/FTyQ-k-tPfQ',
            'duracion' => '09:49',
            'orden' => 5
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 4: Apertura y cierre con seccionador tripolar',
            'url_video' => 'https://youtu.be/su1NSM_3fgk',
            'duracion' => '15:05',
            'orden' => 6
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 5: Apertura y cierre de seccionador CUT OUT',
            'url_video' => 'https://youtu.be/Qp21PFFNzrg',
            'duracion' => '13:42',
            'orden' => 7
        ],
        [
            'modulo' => 'MÓDULO 2 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 6: Secuencia de actividades en un mantenimiento',
            'url_video' => 'https://youtu.be/Nt2wwXNUbrM',
            'duracion' => '15:51',
            'orden' => 8
        ],
        // FIN MÓDULO 2
        [
            'modulo' => 'MÓDULO 3 CLASE VIRTUAL EN VIVO GRABADA',
            'titulo' => 'Clase Virtual 2 (Próximamente)',
            'url_video' => 'https://www.youtube.com/watch?v=nDVQPwAPmvo', 
            'duracion' => '00:00:00',
            'orden' => 9
        ],
        // MÓDULO 4 DESGLOSADO
        [
            'modulo' => 'MÓDULO 4 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 1: Protocolo de pruebas',
            'url_video' => 'https://youtu.be/jB_rjV9NUGQ',
            'duracion' => '20:40',
            'orden' => 10
        ],
        [
            'modulo' => 'MÓDULO 4 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 2: Informe técnico',
            'url_video' => 'https://youtu.be/P-CdZqBp00Q',
            'duracion' => '26:55',
            'orden' => 11
        ],
        [
            'modulo' => 'MÓDULO 4 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 3: Protocolo de pruebas',
            'url_video' => 'https://youtu.be/OSiofcpJuyQ',
            'duracion' => '16:53',
            'orden' => 12
        ],
        [
            'modulo' => 'MÓDULO 4 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 4: Certificación de operatividad',
            'url_video' => 'https://youtu.be/Gn12NWBVt0Y',
            'duracion' => '20:05',
            'orden' => 13
        ],
        [
            'modulo' => 'MÓDULO 4 CLASE GRABADA ASÍNCRONA',
            'titulo' => 'Tema 5: Elaboración de cotización o presupuestos',
            'url_video' => 'https://youtu.be/B-X3u3b6LbU',
            'duracion' => '10:05',
            'orden' => 14
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
