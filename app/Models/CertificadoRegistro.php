<?php
namespace App\Models;

/**
 * Registro de certificados emitidos: es lo que consulta la pagina publica /verificar.
 *
 * El QR de un certificado apunta a /verificar/<codigo>. Antes apuntaba al PDF del propio certificado,
 * lo que no demostraba nada. Los certificados emitidos en lote (script masivo) nunca quedaron en la
 * base de datos, asi que aqui se registran (alta automatica al generarlos desde el panel, desde el script
 * de lotes, o importando el _resumen.csv del lote desde admin > Registro de certificados).
 */
class CertificadoRegistro {
    const RUC = '20602400159';
    const RAZON_SOCIAL = 'INSTITUTO DE CAPACITACION CONTINUA S.R.L.';

    /**
     * Marcas que emiten certificados. 'ICC' usa la identidad de arriba; 'ST' (ST Energy) toma su razon social y RUC del
     * .env del servidor (ST_RAZON_SOCIAL, ST_RUC): no se escriben aqui para no inventarlos. El host decide la marca por
     * defecto (verifica.stenergyedu.com = ST); un certificado siempre se muestra con la marca con que se registro.
     */
    public static function marca($clave) {
        if (strtoupper((string) $clave) === 'ST') {
            require_once __DIR__ . '/../Helpers/Mailer.php';
            return [
                'clave' => 'ST',
                'nombre' => 'ST Energy',
                'razon_social' => trim((string) \App\Helpers\Mailer::env('ST_RAZON_SOCIAL')),
                'ruc' => trim((string) \App\Helpers\Mailer::env('ST_RUC')),
                'email' => 'informes@stenergyedu.com',
                'telefono' => '+51 986 884 219',
                'imagen' => false, // el diseno del certificado de ST Energy no es el de ICC: no se dibuja
            ];
        }
        return [
            'clave' => 'ICC', 'nombre' => 'ICC – Instituto de Capacitación Continua', 'razon_social' => self::RAZON_SOCIAL,
            'ruc' => self::RUC, 'email' => 'informes@icc.com.pe', 'telefono' => '+51 941 208 020', 'imagen' => true,
        ];
    }

    /** Marca por defecto segun el dominio por el que se entra. */
    public static function marcaDeHost($host) {
        return stripos((string) $host, 'stenergyedu.com') !== false ? 'ST' : 'ICC';
    }

    public static function normalizarMarca($m) {
        return strtoupper(trim((string) $m)) === 'ST' ? 'ST' : 'ICC';
    }

    private $db;

    public function __construct() {
        $this->db = (new \App\Core\Database())->connect();
        $this->db->exec("CREATE TABLE IF NOT EXISTS `certificados_emitidos` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `codigo` VARCHAR(60) NOT NULL,
            `nombre` VARCHAR(200) NOT NULL,
            `dni` VARCHAR(20) DEFAULT NULL,
            `curso` VARCHAR(200) NOT NULL,
            `horas` VARCHAR(20) DEFAULT NULL,
            `periodo` VARCHAR(160) DEFAULT NULL,
            `fecha_emision` VARCHAR(60) DEFAULT NULL,
            `modalidad` VARCHAR(40) DEFAULT NULL,
            `marca` VARCHAR(10) NOT NULL DEFAULT 'ICC',
            `archivo_pdf` VARCHAR(255) DEFAULT NULL,
            `estado` VARCHAR(12) NOT NULL DEFAULT 'vigente',
            `creado` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `idx_codigo` (`codigo`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        // Tablas creadas antes de que existiera la columna modalidad (la imagen del certificado la necesita)
        if (!$this->db->query("SHOW COLUMNS FROM `certificados_emitidos` LIKE 'modalidad'")->fetch()) {
            $this->db->exec("ALTER TABLE `certificados_emitidos` ADD COLUMN `modalidad` VARCHAR(40) DEFAULT NULL AFTER `fecha_emision`");
        }
        if (!$this->db->query("SHOW COLUMNS FROM `certificados_emitidos` LIKE 'marca'")->fetch()) {
            $this->db->exec("ALTER TABLE `certificados_emitidos` ADD COLUMN `marca` VARCHAR(10) NOT NULL DEFAULT 'ICC' AFTER `modalidad`");
        }
    }

    /** Deja el codigo en su forma canonica (mayusculas, sin espacios) o '' si no tiene forma de codigo. */
    public static function normalizar($codigo) {
        $c = strtoupper(preg_replace('/\s+/', '', (string) $codigo));
        return preg_match('/^[A-Z0-9-]{6,60}$/', $c) ? $c : '';
    }

    /** Codigo nuevo, no adivinable (los del lote viejo llevan el DNI dentro). */
    public static function generarCodigo() {
        return 'CERT-' . strtoupper(bin2hex(random_bytes(5)));
    }

    /** 48185736 -> 48****36 (la pagina es publica: nunca se muestra el DNI completo). */
    public static function enmascararDni($dni) {
        $d = preg_replace('/\s+/', '', (string) $dni);
        $n = strlen($d);
        if ($n < 5) {
            return $n > 0 ? str_repeat('*', $n) : '';
        }
        return substr($d, 0, 2) . str_repeat('*', $n - 4) . substr($d, -2);
    }

    public function buscar($codigo) {
        $c = self::normalizar($codigo);
        if ($c === '') {
            return null;
        }
        $st = $this->db->prepare("SELECT * FROM certificados_emitidos WHERE codigo = ? LIMIT 1");
        $st->execute([$c]);
        return $st->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    /** Alta (o actualizacion si el codigo ya existia). Devuelve true si guardo. */
    public function registrar(array $d) {
        $codigo = self::normalizar($d['codigo'] ?? '');
        $nombre = trim((string) ($d['nombre'] ?? ''));
        $curso = trim((string) ($d['curso'] ?? ''));
        if ($codigo === '' || $nombre === '' || $curso === '') {
            return false;
        }
        $st = $this->db->prepare("INSERT INTO certificados_emitidos (codigo, nombre, dni, curso, horas, periodo, fecha_emision, modalidad, marca, archivo_pdf)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), dni = VALUES(dni), curso = VALUES(curso), horas = VALUES(horas),
                periodo = VALUES(periodo), fecha_emision = VALUES(fecha_emision), modalidad = VALUES(modalidad), marca = VALUES(marca), archivo_pdf = VALUES(archivo_pdf)");
        $ok = $st->execute([
            $codigo, $nombre, substr(trim((string) ($d['dni'] ?? '')), 0, 20), $curso,
            substr(trim((string) ($d['horas'] ?? '')), 0, 20), substr(trim((string) ($d['periodo'] ?? '')), 0, 160),
            substr(trim((string) ($d['fecha_emision'] ?? '')), 0, 60), substr(trim((string) ($d['modalidad'] ?? '')), 0, 40), self::normalizarMarca($d['marca'] ?? 'ICC'),
            substr(trim((string) ($d['archivo_pdf'] ?? '')), 0, 255),
        ]);
        if ($ok) {
            @unlink(self::rutaCache($codigo)); // si cambiaron los datos, la imagen guardada ya no vale
        }
        return $ok;
    }

    /**
     * Importa el _resumen.csv que deja el script de lotes (columnas Nombre, DNI, Codigo, Archivo, URL_QR).
     * El curso, las horas, el periodo, la fecha de emision y la modalidad son del lote completo.
     * @return array{ok:int, omitidas:int}
     */
    public function importarCsv($ruta, $curso, $horas, $periodo, $emision, $modalidad = '', $marca = 'ICC') {
        $ok = 0;
        $omitidas = 0;
        $h = fopen($ruta, 'r');
        if (!$h) {
            return ['ok' => 0, 'omitidas' => 0];
        }
        // El BOM (marca de codificacion) va pegado a la comilla del primer encabezado: si no se salta ANTES de
        // leer, fgetcsv no reconoce la comilla y la columna "Nombre" no se encuentra (se descartaban todas las filas).
        if (fread($h, 3) !== "\xEF\xBB\xBF") {
            rewind($h);
        }
        // Excel con configuracion regional en español guarda los CSV con ';' en vez de ','
        $pos = ftell($h);
        $primera = (string) fgets($h);
        fseek($h, $pos);
        $sep = substr_count($primera, ';') > substr_count($primera, ',') ? ';' : ',';

        $cab = null;
        while (($fila = fgetcsv($h, 0, $sep)) !== false) {
            if ($cab === null) {
                $cab = array_map(function ($c) { return strtolower(trim((string) $c, " \t\r\n\"'")); }, $fila);
                continue;
            }
            $get = function ($col) use ($cab, $fila) {
                $i = array_search($col, $cab, true);
                return $i === false ? '' : ($fila[$i] ?? '');
            };
            $guardada = $this->registrar([
                'codigo' => $get('codigo'), 'nombre' => $get('nombre'), 'dni' => $get('dni'),
                'curso' => $curso, 'horas' => $horas, 'periodo' => $periodo, 'fecha_emision' => $emision,
                'modalidad' => $modalidad, 'marca' => $marca, 'archivo_pdf' => $get('archivo'),
            ]);
            $guardada ? $ok++ : $omitidas++;
        }
        fclose($h);
        return ['ok' => $ok, 'omitidas' => $omitidas];
    }

    /** Resumen por curso para el panel: [curso, total]. */
    public function resumen() {
        return $this->db->query("SELECT marca, curso, COUNT(*) AS total FROM certificados_emitidos GROUP BY marca, curso ORDER BY marca, curso")->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Ultimos certificados, o los que coincidan con q (codigo, nombre, DNI o curso). Para el panel. */
    public function listar($q = '', $limite = 50) {
        $limite = max(1, min(200, (int) $limite));
        $q = trim((string) $q);
        if ($q === '') {
            $st = $this->db->query("SELECT id, codigo, nombre, dni, curso, fecha_emision, marca, estado FROM certificados_emitidos ORDER BY id DESC LIMIT $limite");
        } else {
            $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
            $st = $this->db->prepare("SELECT id, codigo, nombre, dni, curso, fecha_emision, marca, estado FROM certificados_emitidos
                WHERE codigo LIKE ? OR nombre LIKE ? OR dni LIKE ? OR curso LIKE ? ORDER BY id DESC LIMIT $limite");
            $st->execute([$like, $like, $like, $like]);
        }
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Anula o reactiva un certificado: la pagina publica pasa a decir "anulado" / "valido". */
    public function cambiarEstado($id, $estado) {
        if (!in_array($estado, ['vigente', 'anulado'], true)) {
            return false;
        }
        $st = $this->db->prepare("UPDATE certificados_emitidos SET estado = ? WHERE id = ?");
        return $st->execute([$estado, (int) $id]);
    }

    // ---- Imagen del certificado para la pagina publica ----

    public static function rutaCache($codigo) {
        return __DIR__ . '/../../assets/certificados_img/' . self::normalizar($codigo) . '.jpg';
    }

    /**
     * Dibuja el certificado a partir de los datos del registro (mismo diseno que el PDF: fondo, texto, codigo y QR).
     * NO lleva el DNI: la pagina es publica y ahi solo se muestra enmascarado.
     * @param array  $c      fila de certificados_emitidos
     * @param string $urlQr  direccion que lleva el QR
     * @return resource|\GdImage reducida a 1123 px de ancho
     */
    public static function renderizarImagen(array $c, $urlQr) {
        require_once __DIR__ . '/../Libraries/phpqrcode/qrlib.php';
        $modelo = new Certificado();
        $img = $modelo->generarImagenCertificado(
            $c['nombre'], '', $c['curso'], $c['horas'], $c['fecha_emision'], '',
            !empty($c['periodo']) ? $c['periodo'] : null, null, !empty($c['modalidad']) ? $c['modalidad'] : null
        );
        $modelo->dibujarCodigo($img, $c['codigo']);

        // El QR no forma parte del fondo (en el PDF se pega aparte): se coloca en la misma posicion
        $tmp = tempnam(sys_get_temp_dir(), 'qr');
        $viejo = error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        \QRcode::png($urlQr, $tmp, QR_ECLEVEL_M, 10, 0);
        error_reporting($viejo);
        $qr = @imagecreatefrompng($tmp);
        @unlink($tmp);
        if ($qr) {
            $pxMm = imagesx($img) / 297; // el lienzo es el A4 apaisado (297 mm de ancho)
            list($qx, $qy, $ql) = Certificado::QR_MM;
            imagecopyresampled($img, $qr, (int) round($qx * $pxMm), (int) round($qy * $pxMm), 0, 0,
                (int) round($ql * $pxMm), (int) round($ql * $pxMm), imagesx($qr), imagesy($qr));
            imagedestroy($qr);
        }

        $w = 1123;
        $h = (int) round(imagesy($img) * $w / imagesx($img));
        $chica = imagecreatetruecolor($w, $h);
        imagecopyresampled($chica, $img, 0, 0, 0, 0, $w, $h, imagesx($img), imagesy($img));
        imagedestroy($img);
        return $chica;
    }
}
