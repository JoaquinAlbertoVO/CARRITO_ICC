<?php
session_start();
include '../conexion.php';

if (empty($_SESSION['active']) || empty($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$iduser = $_SESSION['idUser'];
$id_curso = isset($_POST['id_curso']) ? (int)$_POST['id_curso'] : 0;

if($id_curso > 0) {
    // Actualizar el estado de certificado a 1 (Solicitado)
    $query = "UPDATE usuario_cursos SET estado_certificado = 1 WHERE id_usuario = $iduser AND id_curso = $id_curso";
    if (mysqli_query($conection, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en DB']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
?>
