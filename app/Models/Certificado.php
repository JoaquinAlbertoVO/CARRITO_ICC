<?php
namespace App\Models;

class Certificado {
    
    public function generarImagenCertificado($alumno, $dni, $curso, $horas, $fecha_emision, $categoria) {
        $font_path = __DIR__ . '/../Views/admin/cursos/arial.ttf';
        $font_bold = __DIR__ . '/../Views/admin/cursos/arialbd.ttf';
        $font_serif = __DIR__ . '/../Views/admin/cursos/georgia.ttf';
        
        $imagen_path = __DIR__ . '/../../assets/images/CERTIFICADO DE 2_ICC_page-0001.jpg'; 
        
        if(file_exists($imagen_path)) {
            $imagen = imagecreatefromjpeg($imagen_path);
        } else {
            $imagen = imagecreatetruecolor(1200, 800);
            $blanco = imagecolorallocate($imagen, 255, 255, 255);
            imagefill($imagen, 0, 0, $blanco);
        }
        
        // Azul oscuro elegante para el nombre
        $color_nombre = imagecolorallocate($imagen, 27, 41, 78); 
        $color_dni = imagecolorallocate($imagen, 130, 130, 130);
        $color_texto = imagecolorallocate($imagen, 120, 120, 120);
        $color_curso_bold = imagecolorallocate($imagen, 70, 70, 70); // Gris más oscuro y fuerte
        
        // Coordenadas estimadas, requieren ajuste
        
        $center_x = 1180; // Centro ajustado basado en la linea de la plantilla
        
        // 1. Nombres del alumno (Fuente Serif, con auto-ajuste de tamaño)
        $font_size_nombre = 46; // Empezamos con una fuente un poco más pequeña
        $max_width_nombre = 850; // Ancho máximo igual al largo de la línea gris para que no la rebase
        $alumno_upper = mb_strtoupper($alumno, 'UTF-8');
        
        do {
            $bbox = imagettfbbox($font_size_nombre, 0, $font_serif, $alumno_upper);
            $width_nombre = $bbox[2] - $bbox[0];
            if ($width_nombre > $max_width_nombre) {
                $font_size_nombre--;
            }
        } while ($width_nombre > $max_width_nombre && $font_size_nombre > 20);

        $x_nombre = (int)($center_x - ($width_nombre / 2));
        imagettftext($imagen, $font_size_nombre, 0, $x_nombre, 465, $color_nombre, $font_serif, $alumno_upper);

        // 2. DNI (Centrado debajo del nombre)
        $dni_text = "N° DNI " . $dni;
        $bbox2 = imagettfbbox(20, 0, $font_path, $dni_text);
        $x_dni = (int)($center_x - ($bbox2[2] / 2));
        imagettftext($imagen, 20, 0, $x_dni, 540, $color_dni, $font_path, $dni_text);

        // 3. Párrafo central
        $parrafo1 = "Certificado por haber culminado las $horas horas lectivas del";
        $parrafo2 = "CURSO DE \"" . mb_strtoupper($curso, 'UTF-8') . "\"";
        $parrafo3 = "organizado por el \"INSTITUTO DE CAPACITACIÓN CONTINUA.\"";
        
        $b_p1 = imagettfbbox(22, 0, $font_path, $parrafo1);
        $b_p2 = imagettfbbox(24, 0, $font_bold, $parrafo2);
        $b_p3 = imagettfbbox(22, 0, $font_path, $parrafo3);

        imagettftext($imagen, 22, 0, (int)($center_x - ($b_p1[2]/2)), 690, $color_texto, $font_path, $parrafo1);
        // Curso en negrita y un poco más oscuro
        imagettftext($imagen, 24, 0, (int)($center_x - ($b_p2[2]/2)), 740, $color_curso_bold, $font_bold, $parrafo2);
        imagettftext($imagen, 22, 0, (int)($center_x - ($b_p3[2]/2)), 790, $color_texto, $font_path, $parrafo3);

        // 4. Fechas (quemadas por ahora como ejemplo, deberían venir de bd)
        $texto_fecha = "Realizado del 20 de Julio al 25 de Julio del 2026.";
        $b_fecha = imagettfbbox(20, 0, $font_path, $texto_fecha);
        imagettftext($imagen, 20, 0, (int)($center_x - ($b_fecha[2]/2)), 890, $color_texto, $font_path, $texto_fecha);

        // 5. Fecha Emisión (Esquina inferior izquierda, texto blanco)
        $blanco = imagecolorallocate($imagen, 255, 255, 255);
        imagettftext($imagen, 16, 0, 80, 1150, $blanco, $font_path, "Emitido: " . $fecha_emision);

        // 6. Horas lectivas barra izquierda (número grande, texto pequeño al lado)
        $horas_text = $horas;
        $bbox_h = imagettfbbox(50, 0, $font_bold, $horas_text);
        $w_h = $bbox_h[2] - $bbox_h[0];
        
        $acad_text = " horas académicas";
        $bbox_a = imagettfbbox(24, 0, $font_path, $acad_text);
        $w_a = $bbox_a[2] - $bbox_a[0];
        
        $total_w = $w_h + $w_a;
        // Aumentamos el centro a 240 para que se mueva a la derecha y no se corte el primer dígito
        $start_x = (int)(240 - ($total_w / 2)); 
        
        imagettftext($imagen, 50, 0, $start_x, 410, $blanco, $font_bold, $horas_text);
        imagettftext($imagen, 24, 0, $start_x + $w_h, 410, $blanco, $font_path, $acad_text);

        return $imagen;
    }
}
