<?php
require 'app/Core/Database.php';
$db = (new \App\Core\Database())->connect();
$stmt = $db->prepare("SELECT id_curso, nombre_curso FROM cursos WHERE nombre_curso LIKE '%Mantenimiento de Subestaciones%'");
$stmt->execute();
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $db->query("SHOW COLUMNS FROM curso_videos");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
