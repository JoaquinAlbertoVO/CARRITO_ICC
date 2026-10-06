<?php
namespace App\Models;

/**
 * Registro de certificados emitidos: es lo que consulta la pagina publica /verificar.
 *
 * El QR de un certificado apunta a /verificar/<codigo>. Antes apuntaba al PDF del propio certificado,
 * lo que no demostraba nada. Los certificados emitidos en lote (script masivo) nunca quedaron en la
 * base de datos, asi que aqui se registran (alta automatica al generarlos desde el panel, o importando
 * el _resumen.csv del lote desde admin > Registro de certificados).
 */
class CertificadoRegistro {
    const RUC = '20602400159';
    const RAZON_SOCIAL = 'INSTITUTO DE CAPACITACION CONTINUA S.R.L.';

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
            `archivo_pdf` VARCHAR(255) DEFAULT NULL,
            `estado` VARCHAR(12) NOT NULL DEFAULT 'vigente',
            `creado` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `idx_codigo` (`codigo`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
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
        $st = $this->db->prepare("INSERT INTO certificados_emitidos (codigo, nombre, dni, curso, horas, periodo, fecha_emision, archivo_pdf)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), dni = VALUES(dni), curso = VALUES(curso), horas = VALUES(horas),
                periodo = VALUES(periodo), fecha_emision = VALUES(fecha_emision), archivo_pdf = VALUES(archivo_pdf)");
        return $st->execute([
            $codigo, $nombre, substr(trim((string) ($d['dni'] ?? '')), 0, 20), $curso,
            substr(trim((string) ($d['horas'] ?? '')), 0, 20), substr(trim((string) ($d['periodo'] ?? '')), 0, 160),
            substr(trim((string) ($d['fecha_emision'] ?? '')), 0, 60), substr(trim((string) ($d['archivo_pdf'] ?? '')), 0, 255),
        ]);
    }

    /**
     * Importa el _resumen.csv que deja el script masivo (columnas Nombre, DNI, Codigo, Archivo, URL_QR).
     * El curso, las horas, el periodo y la fecha de emision son del lote completo.
     * @return array{ok:int, omitidas:int}
     */
    public function importarCsv($ruta, $curso, $horas, $periodo, $emision) {
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
                'archivo_pdf' => $get('archivo'),
            ]);
            $guardada ? $ok++ : $omitidas++;
        }
        fclose($h);
        return ['ok' => $ok, 'omitidas' => $omitidas];
    }

    /** Resumen por curso para el panel: [curso, total]. */
    public function resumen() {
        return $this->db->query("SELECT curso, COUNT(*) AS total FROM certificados_emitidos GROUP BY curso ORDER BY curso")->fetchAll(\PDO::FETCH_ASSOC);
    }
}
