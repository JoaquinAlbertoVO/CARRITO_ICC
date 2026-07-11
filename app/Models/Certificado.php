<?php
namespace App\Models;

class Certificado {
    
    public function generarImagenCertificado($alumno, $dni, $curso, $horas, $fecha_emision, $categoria) {
        $font_path = __DIR__ . '/../Views/admin/cursos/arial.ttf';
        
        $imagen_path = __DIR__ . '/../../assets/images/CERTIFICADO DE XD_ICC_page-0001.jpg'; 
        
        if(file_exists($imagen_path)) {
            $imagen = imagecreatefromjpeg($imagen_path);
        } else {
            $imagen = imagecreatetruecolor(1200, 800);
            $blanco = imagecolorallocate($imagen, 255, 255, 255);
            imagefill($imagen, 0, 0, $blanco);
        }
        
        $color_nombre = imagecolorallocate($imagen, 110, 110, 110); 
        $color_dni = imagecolorallocate($imagen, 130, 130, 130);
        $color_texto = imagecolorallocate($imagen, 120, 120, 120);
        $color_curso = imagecolorallocate($imagen, 150, 150, 150); // Ajustar colores si es necesario
        
        // Coordenadas estimadas, requieren ajuste
        
        // 1. Nombres del alumno
        // imagettftext($imagen, tamaño, angulo, x, y, color, fuente, texto)
        $bbox = imagettfbbox(45, 0, $font_path, mb_strtoupper($alumno, 'UTF-8'));
        $x_nombre = 1000 - ($bbox[2] / 2); // Centrado aprox lado derecho
        imagettftext($imagen, 45, 0, $x_nombre, 600, $color_nombre, $font_path, mb_strtoupper($alumno, 'UTF-8'));

        // 2. DNI
        $dni_text = "N° DNI " . $dni;
        $bbox2 = imagettfbbox(20, 0, $font_path, $dni_text);
        $x_dni = 1000 - ($bbox2[2] / 2);
        imagettftext($imagen, 20, 0, $x_dni, 680, $color_dni, $font_path, $dni_text);

        // 3. Párrafo central
        $parrafo1 = "Certificado por haber culminado las $horas horas lectivas del";
        $parrafo2 = "CURSO DE \"" . mb_strtoupper($curso, 'UTF-8') . "\"";
        $parrafo3 = "organizado por el \"INSTITUTO DE CAPACITACIÓN CONTINUA.\"";
        
        imagettftext($imagen, 18, 0, 600, 780, $color_texto, $font_path, $parrafo1);
        imagettftext($imagen, 18, 0, 600, 830, $color_texto, $font_path, $parrafo2);
        imagettftext($imagen, 18, 0, 600, 880, $color_texto, $font_path, $parrafo3);

        // 4. Fechas (quemadas por ahora como ejemplo, deberían venir de bd)
        imagettftext($imagen, 18, 0, 600, 950, $color_texto, $font_path, "Realizado del 20 de Julio al 25 de Julio del 2026.");

        // 5. Fecha Emisión
        imagettftext($imagen, 18, 0, 100, 1100, $color_texto, $font_path, $fecha_emision);

        // 6. Horas lectivas barra izquierda
        $bbox3 = imagettfbbox(24, 0, $font_path, "$horas horas lectivas");
        imagettftext($imagen, 24, 0, 200, 480, imagecolorallocate($imagen, 255, 255, 255), $font_path, "$horas horas lectivas");

        return $imagen;
    }
}
