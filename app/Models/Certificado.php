<?php
namespace App\Models;

class Certificado {
    
    public function generarImagenCertificado($alumno, $dni, $curso, $horas, $fecha_emision, $categoria) {
        $font_path = __DIR__ . '/../Views/admin/cursos/arial.ttf';
        
        $imagen_path = __DIR__ . '/../../assets/images/CERTIFICADO DE 2_ICC_page-0001.jpg'; 
        
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
        $bbox = imagettfbbox(45, 0, $font_path, mb_strtoupper($alumno, 'UTF-8'));
        $x_nombre = (int)(1130 - ($bbox[2] / 2)); // Centrado sobre la linea
        imagettftext($imagen, 45, 0, $x_nombre, 465, $color_nombre, $font_path, mb_strtoupper($alumno, 'UTF-8'));

        // 2. DNI (Solo el numero, colocado mas a la derecha del texto N° DNI de la plantilla)
        imagettftext($imagen, 20, 0, 1250, 540, $color_dni, $font_path, $dni);

        // 3. Párrafo central
        $parrafo1 = "Certificado por haber culminado las $horas horas lectivas del";
        $parrafo2 = "CURSO DE \"" . mb_strtoupper($curso, 'UTF-8') . "\"";
        $parrafo3 = "organizado por el \"INSTITUTO DE CAPACITACIÓN CONTINUA.\"";
        
        $b_p1 = imagettfbbox(22, 0, $font_path, $parrafo1);
        $b_p2 = imagettfbbox(24, 0, $font_path, $parrafo2);
        $b_p3 = imagettfbbox(22, 0, $font_path, $parrafo3);

        imagettftext($imagen, 22, 0, (int)(1130 - ($b_p1[2]/2)), 690, $color_texto, $font_path, $parrafo1);
        imagettftext($imagen, 24, 0, (int)(1130 - ($b_p2[2]/2)), 740, $color_texto, $font_path, $parrafo2);
        imagettftext($imagen, 22, 0, (int)(1130 - ($b_p3[2]/2)), 790, $color_texto, $font_path, $parrafo3);

        // 4. Fechas (quemadas por ahora como ejemplo, deberían venir de bd)
        $texto_fecha = "Realizado del 20 de Julio al 25 de Julio del 2026.";
        $b_fecha = imagettfbbox(20, 0, $font_path, $texto_fecha);
        imagettftext($imagen, 20, 0, (int)(1130 - ($b_fecha[2]/2)), 890, $color_texto, $font_path, $texto_fecha);

        // 5. Fecha Emisión (Esquina inferior izquierda, texto blanco)
        $blanco = imagecolorallocate($imagen, 255, 255, 255);
        imagettftext($imagen, 16, 0, 80, 1150, $blanco, $font_path, "Emitido: " . $fecha_emision);

        // 6. Horas lectivas barra izquierda (número grande, texto pequeño al lado)
        $horas_text = $horas;
        $bbox_h = imagettfbbox(50, 0, $font_path, $horas_text);
        $w_h = $bbox_h[2] - $bbox_h[0];
        
        $acad_text = " horas académicas";
        $bbox_a = imagettfbbox(24, 0, $font_path, $acad_text);
        $w_a = $bbox_a[2] - $bbox_a[0];
        
        $total_w = $w_h + $w_a;
        // Aumentamos el centro a 240 para que se mueva a la derecha y no se corte el primer dígito
        $start_x = (int)(240 - ($total_w / 2)); 
        
        imagettftext($imagen, 50, 0, $start_x, 410, $blanco, $font_path, $horas_text);
        imagettftext($imagen, 24, 0, $start_x + $w_h, 410, $blanco, $font_path, $acad_text);

        return $imagen;
    }
}
