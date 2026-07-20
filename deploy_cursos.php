<?php
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Curso.php';

$cursoModel = new \App\Models\Curso();

$cursos_data = [
    'Analizador de Redes' => 'Portada_ANA.png',
    'Banco de Condensadores' => 'Portada_BDC.png',
    'Canalizacion de Tuberias Conduit' => 'Portada_CTC.png',
    'Especializacion en Electricidad Industrial' => 'Portada_EEI.png',
    'Empalmes Termocontraibles en MT' => 'Portada_EMPTER.png',
    'Mantenimiento de Subestaciones Electricas' => 'Portada_MSE.png',
    'Terminaciones Termocontraibles en MT' => 'Portada_TERTER.png',
    'Variadores de Frecuencia' => 'Portada_VDF.png'
];

echo "<div style='font-family: Arial; padding: 20px;'>";
echo "<h2>Actualización de Base de Datos - Cursos ICC</h2>";
echo "<ul>";

foreach ($cursos_data as $nombre => $foto) {
    try {
        $db = (new \App\Core\Database())->connect();
        $stmt = $db->prepare("SELECT id_curso FROM cursos WHERE nombre_curso = ?");
        $stmt->execute([$nombre]);
        
        if (!$stmt->fetch()) {
            $cursoModel->registrarCurso([
                'nombre_curso' => $nombre,
                'categoria' => 'Ingeniería',
                'fecha_emision' => date('Y-m-d'),
                'horas_academicas' => 20,
                'foto' => $foto,
                'precio' => 89.90,
                'docente' => 'Ricardo Cardenas',
                'docente_foto' => 'profesor.jpg',
                'lecciones' => 10,
                'descripcion' => 'Aprende todo sobre ' . strtolower($nombre) . ' con nuestro curso especializado en ICC.',
                'requisitos' => 'Conocimientos básicos de electricidad.'
            ]);
            echo "<li style='color: green;'>✅ Curso creado exitosamente: <b>$nombre</b></li>";
        } else {
            echo "<li style='color: gray;'>⏭️ El curso ya existía: <b>$nombre</b></li>";
        }
    } catch (Exception $e) {
        echo "<li style='color: red;'>❌ Error al crear $nombre: " . $e->getMessage() . "</li>";
    }
}
echo "</ul>";
echo "<p><b>¡Proceso completado!</b> Ya puedes eliminar este archivo por seguridad.</p>";
echo "<a href='" . BASE_URL . "'>Volver al inicio</a>";
echo "</div>";
