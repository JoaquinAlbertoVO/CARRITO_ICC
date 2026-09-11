<?php
// Script temporal para actualizar programacion y temas del curso Subestaciones
// ELIMINAR DESPUÉS DE USAR
require_once __DIR__ . '/app/Core/Database.php';

header('Content-Type: text/html; charset=utf-8');

$db = (new \App\Core\Database())->connect();

// 1. Obtener el curso
$stmt = $db->prepare("SELECT id_curso, nombre_curso, programacion, temas FROM cursos WHERE nombre_curso LIKE ? AND estado = 1 LIMIT 1");
$stmt->execute(['%Subestaciones%']);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$curso) {
    die("Curso no encontrado");
}

$id = $curso['id_curso'];

// === MOSTRAR CONTENIDO ACTUAL ===
if (!isset($_GET['ejecutar'])) {
    echo "<h2>Curso: {$curso['nombre_curso']} (ID: $id)</h2>";
    echo "<h3>PROGRAMACIÓN ACTUAL:</h3><pre>" . htmlspecialchars($curso['programacion']) . "</pre>";
    echo "<h3>TEMAS ACTUALES:</h3><pre>" . htmlspecialchars($curso['temas']) . "</pre>";
    echo "<br><a href='?ejecutar=1' style='background:red;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>EJECUTAR CAMBIOS</a>";
    exit;
}

// === EJECUTAR CAMBIOS ===

// Cambio 1: Quitar la línea del 03/10 de la programación
$programacion = $curso['programacion'];
// Eliminar la línea que contiene 03/10
$programacion = preg_replace('/<li[^>]*>.*?03\/10.*?<\/li>/s', '', $programacion);

// Cambio 2: Renombrar "Equipos y herramientas" por "Herramientas que vamos a usar en el curso"
$temas = $curso['temas'];
$temas = str_replace('Equipos y herramientas', 'Herramientas que vamos a usar en el curso', $temas);

// Guardar cambios
$update = $db->prepare("UPDATE cursos SET programacion = ?, temas = ? WHERE id_curso = ?");
$result = $update->execute([$programacion, $temas, $id]);

if ($result) {
    echo "<h2 style='color:green'>✅ Cambios aplicados correctamente</h2>";
    echo "<h3>PROGRAMACIÓN NUEVA:</h3><pre>" . htmlspecialchars($programacion) . "</pre>";
    echo "<h3>TEMAS NUEVOS:</h3><pre>" . htmlspecialchars($temas) . "</pre>";
    echo "<p><strong>IMPORTANTE: Elimina este archivo del servidor después de usar.</strong></p>";
} else {
    echo "<h2 style='color:red'>❌ Error al actualizar</h2>";
}
