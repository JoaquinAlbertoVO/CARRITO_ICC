<?php
session_start();
include '../conexion.php';

if (empty($_SESSION['active']) || empty($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$iduser = $_SESSION['idUser'];
$id_video = isset($_POST['id_video']) ? (int)$_POST['id_video'] : 0;
$id_curso = isset($_POST['id_curso']) ? (int)$_POST['id_curso'] : 0;

if($id_video > 0 && $id_curso > 0) {
    $query = "INSERT IGNORE INTO progreso_videos (id_usuario, id_curso, id_video) VALUES ($iduser, $id_curso, $id_video)";
    if (mysqli_query($conection, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en DB']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
?>
