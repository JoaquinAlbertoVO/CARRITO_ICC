<?php
// generar_certificado.php
session_start();
include '../conexion.php';

// Validar que se reciba el id del usuario y del curso
if(!isset($_GET['id_usuario']) || !isset($_GET['id_curso'])) {
    die("Faltan parámetros.");
}

$id_usuario = intval($_GET['id_usuario']);
$id_curso = intval($_GET['id_curso']);

// 1. Obtener datos del alumno
$query_alumno = mysqli_query($conection, "SELECT nombre, dni FROM usuario WHERE iduser = $id_usuario");
if(mysqli_num_rows($query_alumno) == 0) die("Alumno no encontrado.");
$alumno = mysqli_fetch_assoc($query_alumno);

// 2. Obtener datos del curso
$query_curso = mysqli_query($conection, "SELECT nombre_curso, horas_academicas, fecha_emision FROM cursos WHERE id_curso = $id_curso");
if(mysqli_num_rows($query_curso) == 0) die("Curso no encontrado.");
$curso = mysqli_fetch_assoc($query_curso);

// 3. Preparar la imagen base (Asumimos que subiste 'certificado_base.jpg' a la carpeta assets/images/)
$ruta_plantilla = '../../assets/images/certificado_base.jpg'; 
if(!file_exists($ruta_plantilla)) {
    die("Falta la imagen de plantilla: $ruta_plantilla");
}

// Cargar la imagen en memoria
$imagen = imagecreatefromjpeg($ruta_plantilla);

// Configurar colores
$color_negro = imagecolorallocate($imagen, 0, 0, 0);
$color_gris = imagecolorallocate($imagen, 100, 100, 100);
$color_azul = imagecolorallocate($imagen, 20, 50, 120);

// Configurar la ruta de la fuente (TTF) - Usaremos una fuente genérica de Windows o debes subir un archivo .ttf
// Si estás en cPanel, es OBLIGATORIO tener un archivo .ttf en la carpeta. Usaremos uno básico por ahora.
$ruta_fuente = __DIR__ . '/arial.ttf'; 
if(!file_exists($ruta_fuente)) {
    die("Por favor, sube un archivo de fuente llamado 'arial.ttf' en la misma carpeta que este script para que funcione el texto.");
}

// 4. Dibujar el texto sobre la imagen
// imagettftext(imagen, tamaño, ángulo, x, y, color, fuente, texto)

// Nombre del Alumno (Centrado y grande)
$texto_nombre = mb_strtoupper($alumno['nombre'], 'UTF-8');
imagettftext($imagen, 40, 0, 400, 500, $color_negro, $ruta_fuente, $texto_nombre);

// DNI
$texto_dni = "Con DNI: " . $alumno['dni'];
imagettftext($imagen, 20, 0, 400, 550, $color_gris, $ruta_fuente, $texto_dni);

// Nombre del Curso
$texto_curso = mb_strtoupper($curso['nombre_curso'], 'UTF-8');
imagettftext($imagen, 30, 0, 400, 650, $color_azul, $ruta_fuente, $texto_curso);

// Horas y Fecha
$texto_horas = $curso['horas_academicas'] . " Horas Lectivas - Fecha: " . $curso['fecha_emision'];
imagettftext($imagen, 18, 0, 400, 700, $color_gris, $ruta_fuente, $texto_horas);


// 5. Descargar la imagen automáticamente
$nombre_archivo = "Certificado_" . $alumno['dni'] . "_" . $curso['nombre_curso'] . ".jpg";
$nombre_archivo = str_replace(' ', '_', $nombre_archivo);

header('Content-Description: File Transfer');
header('Content-Type: image/jpeg');
header('Content-Disposition: attachment; filename="'.$nombre_archivo.'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Imprimir la imagen procesada
imagejpeg($imagen, null, 100);

// Liberar memoria
imagedestroy($imagen);
?>
