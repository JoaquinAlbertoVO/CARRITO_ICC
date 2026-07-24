<?php
$conn = new mysqli('localhost', 'root', '', 'prueba1');
$conn->set_charset("utf8mb4");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$queries = [
    "UPDATE cursos SET nombre_curso = 'Diseño de Subestaciones Eléctricas', categoria = 'Especialización', docente = 'Ing. Carlos Méndez' WHERE id_curso = 1",
    "UPDATE cursos SET categoria = 'Técnico', docente = 'Ing. Luis Fernández' WHERE id_curso = 2",
    "UPDATE cursos SET nombre_curso = 'Sistemas de Energías Renovables', docente = 'Dra. Ana Gómez' WHERE id_curso = 3"
];

foreach($queries as $q) {
    if (!$conn->query($q)) {
        echo "Error: " . $conn->error . "\n";
    }
}
echo "Cursos actualizados con tildes correctamente.\n";
