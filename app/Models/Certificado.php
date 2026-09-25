<?php
namespace App\Models;

/**
 * Certificado de participacion ICC (diseno A).
 *
 * Fuente del diseno (HTML + firmas sueltas, fuera del repo a proposito): carpeta ICC_certificado_fuente del
 * escritorio; lienzo de 1123x794 px (A4 apaisado). Ver LEEME.md de esa carpeta para regenerar las imagenes.
 * El fondo estatico (marco, panel, firmas, sellos, banderas) es assets/images/certificado-fondo.png a
 * 2246x1588 px (2x); aqui solo se escribe lo variable: horas, nombre, DNI, curso, fechas y emision.
 * Todas las coordenadas estan en px del lienzo de diseno y se multiplican por ESCALA.
 * El QR se coloca despues sobre el PDF (ver QR_MM); su tarjeta blanca ya viene dibujada en el fondo.
 */
class Certificado {

    const ESCALA = 2;
    const FONDO = 'assets/images/certificado-fondo.png';

    /** Posicion del QR en el PDF, en mm sobre A4 apaisado (297x210): [x, y, lado]. */
    const QR_MM = [28.83, 90.71, 34.91];

    // Colores de la paleta ICC
    private $c = [
        'azul_marino' => [23, 26, 49],
        'gris'        => [91, 96, 112],
        'tinta'       => [51, 55, 74],
        'dorado'      => [243, 221, 139],
        'emision'     => [190, 191, 197],
    ];

    private function fuente($nombre) {
        return __DIR__ . '/../../assets/fonts/certificado/' . $nombre . '.ttf';
    }

    private function color($img, $clave) {
        return imagecolorallocate($img, $this->c[$clave][0], $this->c[$clave][1], $this->c[$clave][2]);
    }

    /**
     * Convierte px a la unidad de tamano de GD. Segun la version de GD, imagettftext interpreta el
     * tamano como puntos a 96 dpi (1 px = 0.75) o a 72 dpi (1 px = 1); se mide una "H" de Montserrat
     * (altura de mayuscula = 0.70 em) para saber cual es y no depender del servidor.
     */
    private function pt($px) {
        static $k = null;
        if ($k === null) {
            $b = imagettfbbox(100, 0, $this->fuente('Montserrat-Regular'), 'H');
            $k = (($b[1] - $b[7]) / 70) > 1.15 ? 0.75 : 1.0;
        }
        return $px * $k;
    }

    private function ancho($size, $font, $txt) {
        $b = imagettfbbox($this->pt($size), 0, $font, $txt);
        return $b[2] - $b[0];
    }

    /** Avance horizontal de un caracter (sin kerning); sirve tambien para el espacio. */
    private function avance($size, $font, $ch) {
        static $cache = [];
        $k = $font . '|' . $size . '|' . $ch;
        if (!isset($cache[$k])) {
            $cache[$k] = $this->ancho($size, $font, 'l' . $ch . 'l') - $this->ancho($size, $font, 'll');
        }
        return $cache[$k];
    }

    /** Avance horizontal de un texto completo (incluye kerning y apoyos laterales; no solo la tinta). */
    private function avance_texto($size, $font, $txt) {
        return $this->ancho($size, $font, 'l' . $txt . 'l') - $this->ancho($size, $font, 'll');
    }

    private function caracteres($txt) {
        return preg_split('//u', $txt, -1, PREG_SPLIT_NO_EMPTY);
    }

    /** Ancho de un texto con espaciado entre letras (igual que letter-spacing en CSS). */
    private function ancho_track($size, $font, $txt, $track) {
        $w = 0;
        foreach ($this->caracteres($txt) as $ch) {
            $w += $this->avance($size, $font, $ch) + $track;
        }
        return $w;
    }

    private function dibujar_track($img, $size, $x, $y, $color, $font, $txt, $track) {
        foreach ($this->caracteres($txt) as $ch) {
            imagettftext($img, $this->pt($size), 0, (int)round($x), (int)round($y), $color, $font, $ch);
            $x += $this->avance($size, $font, $ch) + $track;
        }
    }

    /** Texto centrado en $cx con espaciado entre letras. */
    private function centrado_track($img, $size, $cx, $y, $color, $font, $txt, $track) {
        $w = $this->ancho_track($size, $font, $txt, $track);
        $this->dibujar_track($img, $size, $cx - $w / 2, $y, $color, $font, $txt, $track);
    }

    /** Reparte $txt en como maximo $max_lineas lineas equilibradas que quepan en $ancho_max. Devuelve null si no caben. */
    private function partir_lineas($txt, $size, $font, $track, $ancho_max, $max_lineas) {
        $palabras = preg_split('/\s+/u', trim($txt), -1, PREG_SPLIT_NO_EMPTY);
        if ($this->ancho_track($size, $font, $txt, $track) <= $ancho_max) {
            return [trim($txt)];
        }
        if ($max_lineas < 2 || count($palabras) < 2) {
            return null;
        }
        $mejor = null;
        $mejor_ancho = PHP_INT_MAX;
        for ($i = 1; $i < count($palabras); $i++) {
            $l1 = implode(' ', array_slice($palabras, 0, $i));
            $l2 = implode(' ', array_slice($palabras, $i));
            $w = max($this->ancho_track($size, $font, $l1, $track), $this->ancho_track($size, $font, $l2, $track));
            if ($w < $mejor_ancho) {
                $mejor_ancho = $w;
                $mejor = [$l1, $l2];
            }
        }
        return $mejor_ancho <= $ancho_max ? $mejor : null;
    }

    /**
     * Convierte tramos [texto, negrita] en palabras (una palabra = lista de tramos pegados,
     * asi la coma que sigue a un tramo en negrita no se separa de el).
     */
    private function a_palabras($tramos) {
        $palabras = [];
        $actual = [];
        foreach ($tramos as $t) {
            $partes = preg_split('/(\s+)/u', $t[0], -1, PREG_SPLIT_DELIM_CAPTURE);
            foreach ($partes as $p) {
                if ($p === '') {
                    continue;
                }
                if (preg_match('/^\s+$/u', $p)) {
                    if ($actual) {
                        $palabras[] = $actual;
                        $actual = [];
                    }
                } else {
                    $actual[] = [$p, $t[1]];
                }
            }
        }
        if ($actual) {
            $palabras[] = $actual;
        }
        return $palabras;
    }

    private function ancho_palabra($palabra, $size, $normal, $negrita) {
        $w = 0;
        foreach ($palabra as $seg) {
            $w += $this->avance_texto($size, $seg[1] ? $negrita : $normal, $seg[0]);
        }
        return $w;
    }

    /** Texto con tramos en negrita, ajustado a $ancho_max y centrado en $cx. Devuelve la cantidad de lineas. */
    private function parrafo_centrado($img, $tramos, $size, $cx, $y0, $paso, $ancho_max, $normal, $negrita, $col_normal, $col_negrita) {
        $palabras = $this->a_palabras($tramos);
        $espacio = $this->avance($size, $normal, ' ');

        $lineas = [];
        $linea = [];
        $w_linea = 0;
        foreach ($palabras as $p) {
            $wp = $this->ancho_palabra($p, $size, $normal, $negrita);
            if ($linea && $w_linea + $espacio + $wp > $ancho_max) {
                $lineas[] = [$linea, $w_linea];
                $linea = [];
                $w_linea = 0;
            }
            $w_linea += ($linea ? $espacio : 0) + $wp;
            $linea[] = $p;
        }
        if ($linea) {
            $lineas[] = [$linea, $w_linea];
        }

        foreach ($lineas as $i => $l) {
            $x = $cx - $l[1] / 2;
            $y = (int)round($y0 + $i * $paso);
            foreach ($l[0] as $j => $p) {
                if ($j > 0) {
                    $x += $espacio;
                }
                foreach ($p as $seg) {
                    $font = $seg[1] ? $negrita : $normal;
                    imagettftext($img, $this->pt($size), 0, (int)round($x), $y, $seg[1] ? $col_negrita : $col_normal, $font, $seg[0]);
                    $x += $this->avance_texto($size, $font, $seg[0]);
                }
            }
        }
        return count($lineas);
    }

    /** 'Y-m-d' (o DATE de MySQL) -> DateTime, o null si esta vacio o no es una fecha real (p. ej. 0000-00-00). */
    private static function fecha_ymd($v) {
        $v = substr(trim((string)$v), 0, 10);
        $d = \DateTime::createFromFormat('!Y-m-d', $v);
        return ($d && $d->format('Y-m-d') === $v && (int)$d->format('Y') >= 2000) ? $d : null;
    }

    /**
     * Frase del periodo del curso para el certificado, o null si no hay fechas:
     * "Realizado del 20 de octubre al 20 de noviembre", "Realizado del 20 al 25 de octubre",
     * "Realizado el 20 de octubre" (un solo dia) o, si cruza de ano, con el ano en cada extremo.
     * El ano normal no se escribe: ya figura en "Emitido: ...".
     */
    public static function textoPeriodo($inicio, $fin = null) {
        $a = self::fecha_ymd($inicio);
        $b = self::fecha_ymd($fin);
        if (!$a && !$b) {
            return null;
        }
        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        $f = function ($d, $con_anio = false) use ($meses) {
            return (int)$d->format('j') . ' de ' . $meses[(int)$d->format('n') - 1] . ($con_anio ? ' del ' . $d->format('Y') : '');
        };
        if (!$a || !$b || $a == $b) {
            return 'Realizado el ' . $f($a ?: $b);
        }
        if ($b < $a) {
            list($a, $b) = [$b, $a];
        }
        if ($a->format('Y') !== $b->format('Y')) {
            return 'Realizado del ' . $f($a, true) . ' al ' . $f($b, true);
        }
        if ($a->format('n') === $b->format('n')) {
            return 'Realizado del ' . (int)$a->format('j') . ' al ' . $f($b);
        }
        return 'Realizado del ' . $f($a) . ' al ' . $f($b);
    }

    /** "Realizado del 1 de Setiembre al 19 de Setiembre del 2026." -> [prefijo normal, fechas en negrita]. */
    private function partir_fechas($texto) {
        $t = trim(preg_replace('/[\s\.]+$/u', '', trim($texto)));
        if (preg_match('/^realizado\s+(del|el|en)\s+(.+)$/iu', $t, $m)) {
            return ['realizado ' . mb_strtolower($m[1], 'UTF-8') . ' ', mb_strtolower($m[2], 'UTF-8')];
        }
        if (preg_match('/^realizado\s+(.+)$/iu', $t, $m)) {
            return ['realizado ', mb_strtolower($m[1], 'UTF-8')];
        }
        return ['realizado ', mb_strtolower($t, 'UTF-8')];
    }

    /**
     * @param string      $alumno          Nombre completo.
     * @param string      $dni             Documento; si esta vacio (o todo ceros) no se imprime.
     * @param string      $curso           Nombre del curso.
     * @param string|int  $horas           Horas lectivas.
     * @param string      $fecha_emision   Ej.: "20 de Setiembre del 2026".
     * @param string      $categoria       (sin uso en este diseno; se mantiene por compatibilidad).
     * @param string|null $texto_realizado Ej.: "Realizado del 1 de Setiembre al 19 de Setiembre del 2026" (ver textoPeriodo());
     *                                     null o vacio = el certificado no lleva frase de fechas.
     * @param string|null $descripcion     Frase opcional al final ("orientado a ..."), sin punto final.
     * @return resource|\GdImage Imagen 2246x1588 lista para imagejpeg().
     */
    public function generarImagenCertificado($alumno, $dni, $curso, $horas, $fecha_emision, $categoria, $texto_realizado = null, $descripcion = null) {
        $E = self::ESCALA;

        $ruta_fondo = __DIR__ . '/../../' . self::FONDO;
        if (file_exists($ruta_fondo)) {
            $img = imagecreatefrompng($ruta_fondo);
        } else {
            $img = imagecreatetruecolor(1123 * $E, 794 * $E);
            imagefill($img, 0, 0, imagecolorallocate($img, 255, 255, 255));
        }
        imagealphablending($img, true);

        $f_reg  = $this->fuente('Montserrat-Regular');
        $f_semi = $this->fuente('Montserrat-SemiBold');
        $f_bold = $this->fuente('Montserrat-Bold');
        $f_xbold = $this->fuente('Montserrat-ExtraBold');
        $f_nombre = $this->fuente('CormorantGaramond-Bold');

        $navy   = $this->color($img, 'azul_marino');
        $gris   = $this->color($img, 'gris');
        $tinta  = $this->color($img, 'tinta');
        $dorado = $this->color($img, 'dorado');
        $emision_c = $this->color($img, 'emision');

        $horas = trim((string)$horas);
        $txt_horas = $horas . ($horas === '1' ? ' hora lectiva' : ' horas lectivas');

        // --- Panel: horas lectivas (dorado, en mayusculas y con espaciado) y fecha de emision
        $this->dibujar_track($img, 13 * $E, 96 * $E, 180.6 * $E, $dorado, $f_semi, mb_strtoupper($txt_horas, 'UTF-8'), 3 * $E);
        imagettftext($img, $this->pt(10.5 * $E), 0, 96 * $E, (int)round(512.2 * $E), $emision_c, $f_reg, 'Emitido: ' . $fecha_emision);

        // --- Nombre (serif, mayusculas; se reduce hasta caber en 560 px de lienzo)
        $cx = 776.5;
        $nombre = mb_strtoupper(trim($alumno), 'UTF-8');
        $ancho_n = 560 * $E;
        $tam = 49;
        while ($tam > 28 && $this->ancho_track($tam * $E, $f_nombre, $nombre, 1.5 * $E) > $ancho_n) {
            $tam--;
        }
        if ($this->ancho_track($tam * $E, $f_nombre, $nombre, 1.5 * $E) <= $ancho_n) {
            // Una linea; la linea base sigue al tamano para que quede centrada en su franja
            $this->centrado_track($img, $tam * $E, $cx * $E, (219 + 0.3185 * $tam) * $E, $navy, $f_nombre, $nombre, 1.5 * $E);
        } else {
            // Nombre muy largo: dos lineas equilibradas, con el mayor tamano al que quepan (tope 33 para no tocar "Otorgado a")
            $lineas_n = null;
            for ($tam = 33; $tam >= 20 && $lineas_n === null; $tam--) {
                $lineas_n = $this->partir_lineas($nombre, $tam * $E, $f_nombre, 1.5 * $E, $ancho_n, 2);
            }
            $tam++;
            if ($lineas_n === null) {
                $lineas_n = [$nombre];
            }
            $base_n = 249 - (count($lineas_n) - 1) * $tam * 1.05;
            foreach ($lineas_n as $i => $l) {
                $this->centrado_track($img, $tam * $E, $cx * $E, ($base_n + $i * $tam * 1.05) * $E, $navy, $f_nombre, $l, 1.5 * $E);
            }
        }

        // --- DNI (solo si existe)
        $dni = trim((string)$dni);
        if ($dni !== '' && !preg_match('/^0+$/', $dni)) {
            $this->centrado_track($img, 15 * $E, $cx * $E, 292.5 * $E, $gris, $f_semi, 'N° DNI ' . $dni, 2.6 * $E);
        }

        // --- Parrafo central
        $cxp = 776;
        $ancho_p = 556 * $E;
        $intro = 'Por su participación en el curso de';
        $wi = $this->avance_texto(14.5 * $E, $f_reg, $intro);
        imagettftext($img, $this->pt(14.5 * $E), 0, (int)round($cxp * $E - $wi / 2), (int)round(347.7 * $E), $tinta, $f_reg, $intro);

        // Curso: 25 px; si no cabe en una linea se parte en dos y, de ser necesario, se reduce
        $curso_up = mb_strtoupper(trim($curso), 'UTF-8');
        $tam_c = 25;
        $lineas_curso = null;
        while ($tam_c >= 15) {
            $lineas_curso = $this->partir_lineas($curso_up, $tam_c * $E, $f_xbold, 0.6 * $E, $ancho_p, 2);
            if ($lineas_curso !== null) {
                break;
            }
            $tam_c--;
        }
        if ($lineas_curso === null) {
            $lineas_curso = [$curso_up];
        }
        foreach ($lineas_curso as $i => $l) {
            $this->centrado_track($img, $tam_c * $E, $cxp * $E, (385.3 + $i * 28.75) * $E, $navy, $f_xbold, $l, 0.6 * $E);
        }
        $extra = (count($lineas_curso) - 1) * 28.75;

        // Cuerpo: organizador, fechas y horas resaltados
        // Sin fechas (null o vacio) no se escribe la frase "realizado del ...": mejor omitirla que imprimir una fecha equivocada.
        $organiza = 'organizado por el Instituto de Capacitación Continua';
        if ($texto_realizado !== null && trim((string)$texto_realizado) !== '') {
            $fechas = $this->partir_fechas($texto_realizado);
            $tramos = [
                [$organiza . ', ' . $fechas[0], false],
                [$fechas[1], true],
                [', con una duración de ', false],
                [$txt_horas, true],
            ];
        } else {
            $tramos = [
                [$organiza . ', con una duración de ', false],
                [$txt_horas, true],
            ];
        }
        $desc = trim((string)$descripcion);
        $tramos[] = [$desc !== '' ? ', ' . rtrim($desc, ". \t") . '.' : '.', false];

        $this->parrafo_centrado($img, $tramos, 14.5 * $E, $cxp * $E, (416.4 + $extra) * $E, 24.94 * $E, $ancho_p, $f_reg, $f_bold, $tinta, $navy);

        return $img;
    }

    /** Codigo de certificado (opcional), en el panel justo debajo de "Emitido: ...". */
    public function dibujarCodigo($img, $codigo) {
        $E = self::ESCALA;
        $font = $this->fuente('Montserrat-Regular');
        $color = $this->color($img, 'emision');
        $txt = 'Código: ' . $codigo;
        $x = 96 * $E;
        $y = 527.2 * $E;
        // El panel se corta en diagonal: el ancho util es ~186 px en esta linea y ~165 px una linea mas abajo.
        $max1 = 186 * $E;
        $max2 = 165 * $E;

        // 1) Una linea, reduciendo hasta 9 px si hace falta
        $tam = 10.5;
        $w = $this->avance_texto($tam * $E, $font, $txt);
        if ($w > $max1) {
            $tam = max(9, $tam * $max1 / $w);
        }
        if ($this->avance_texto($tam * $E, $font, $txt) <= $max1) {
            imagettftext($img, $this->pt($tam * $E), 0, $x, (int)round($y), $color, $font, $txt);
            return;
        }

        // 2) Codigo muy largo (nombre en vez de DNI): se parte en dos lineas en un guion
        $tam = 9.5;
        $partes = explode('-', $codigo);
        $l1 = 'Código: ' . array_shift($partes);
        while ($partes && $this->avance_texto($tam * $E, $font, $l1 . '-' . $partes[0] . '-') <= $max1) {
            $l1 .= '-' . array_shift($partes);
        }
        $l2 = implode('-', $partes);
        if ($l2 !== '') {
            $l1 .= '-';
        }
        imagettftext($img, $this->pt($tam * $E), 0, $x, (int)round($y), $color, $font, $l1);
        if ($l2 !== '') {
            $tam2 = $tam;
            $w2 = $this->avance_texto($tam2 * $E, $font, $l2);
            if ($w2 > $max2) {
                $tam2 = max(8, $tam2 * $max2 / $w2);
            }
            imagettftext($img, $this->pt($tam2 * $E), 0, $x, (int)round($y + 12.5 * $E), $color, $font, $l2);
        }
    }
}
