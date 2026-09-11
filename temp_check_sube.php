<?php
// Script temporal para ver el contenido actual del curso
require_once __DIR__ . '/app/Core/Database.php';

$db = (new \App\Core\Database())->connect();
$stmt = $db->prepare("SELECT id_curso, nombre_curso, programacion, temas FROM cursos WHERE nombre_curso LIKE ? AND estado = 1 LIMIT 1");
$stmt->execute(['%Subestaciones%']);
$curso = $stmt->fetch(\PDO::FETCH_ASSOC);

header('Content-Type: text/plain; charset=utf-8');
if ($curso) {
    echo "=== CURSO ID: {$curso['id_curso']} ===\n";
    echo "=== NOMBRE: {$curso['nombre_curso']} ===\n\n";
    echo "=== PROGRAMACION ===\n";
    echo $curso['programacion'] . "\n\n";
    echo "=== TEMAS ===\n";
    echo $curso['temas'] . "\n";
} else {
    echo "Curso no encontrado";
}
