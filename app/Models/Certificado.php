<?php
namespace App\Models;

class Certificado {
    
    public function generarImagenCertificado($alumno, $curso, $fecha, $categoria) {
        $font_path = __DIR__ . '/../Views/admin/cursos/arial.ttf';
        
        // Asumiendo que el template base está en assets/images/
        $imagen_path = __DIR__ . '/../../assets/images/CERTIFICADO DE PRUEBA_ICC.jpg'; 
        
        // Si el archivo no es jpg o no existe, intentaremos crear uno en blanco
        if(file_exists($imagen_path)) {
            $imagen = imagecreatefromjpeg($imagen_path);
        } else {
            $imagen = imagecreatetruecolor(1200, 800);
            $blanco = imagecolorallocate($imagen, 255, 255, 255);
            imagefill($imagen, 0, 0, $blanco);
        }
        
        $color_texto = imagecolorallocate($imagen, 0, 0, 0); 
        $color_fecha = imagecolorallocate($imagen, 100, 100, 100);

        // Nombres del alumno
        imagettftext($imagen, 30, 0, 400, 350, $color_texto, $font_path, strtoupper($alumno));

        // Nombre del curso
        imagettftext($imagen, 24, 0, 400, 450, $color_texto, $font_path, "Curso: " . strtoupper($curso));

        // Categoría y Fecha
        imagettftext($imagen, 18, 0, 400, 520, $color_fecha, $font_path, "Especialidad: " . ucfirst($categoria));
        imagettftext($imagen, 18, 0, 400, 560, $color_fecha, $font_path, "Fecha de Emisión: " . $fecha);

        return $imagen;
    }
}
