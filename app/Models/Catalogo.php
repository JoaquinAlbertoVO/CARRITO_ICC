<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Catalogo de cursos grabados (asincronos) y packs.
 *
 * - Un curso asincrono es una fila de `cursos` con modalidad = 'asincrono'. Los cursos en vivo
 *   (modalidad = 'en_vivo', los de siempre) no cambian.
 * - Un pack (o ruta) agrupa cursos: comprarlo matricula en todos sus cursos.
 * - El certificado es UNO POR CURSO. Al matricular se reserva su codigo; el PDF se dibuja la
 *   primera vez que el alumno lo descarga (despues de confirmar su nombre y documento) y recien
 *   ahi queda dado de alta en /verificar.
 * - Nada se vende hasta que el admin pone precios (soles y dolares), horas y lo publica.
 *
 * Las tablas se crean solas (mismo criterio que el resto de modelos de este proyecto).
 */
class Catalogo {
    const VERSION_ESQUEMA = 1;
    const MODALIDAD_ASINCRONO = 'asincrono';

    /** Carpeta (fuera de la web, ver .htaccess) donde quedan los PDF que descargan los alumnos */
    const DIR_CERTIFICADOS = __DIR__ . '/../../storage/certificados_aula/';

    private $db;
    private static $esquemaListo = false;

    public function __construct() {
        $this->db = (new Database())->connect();
        if (!self::$esquemaListo) {
            $this->asegurarEsquema();
            self::$esquemaListo = true;
        }
    }

    public function db() {
        return $this->db;
    }

    // ------------------------------------------------------------------
    // Esquema
    // ------------------------------------------------------------------

    private function columnaExiste($tabla, $columna) {
        // SHOW COLUMNS no acepta parametros preparados
        return (bool) $this->db->query("SHOW COLUMNS FROM `$tabla` LIKE " . $this->db->quote($columna))->fetch();
    }

    private function agregarColumna($tabla, $columna, $definicion) {
        if (!$this->columnaExiste($tabla, $columna)) {
            $this->db->exec("ALTER TABLE `$tabla` ADD COLUMN `$columna` $definicion");
        }
    }

    private function asegurarEsquema() {
        $this->db->exec("CREATE TABLE IF NOT EXISTS `catalogo_meta` (
            `clave` VARCHAR(40) NOT NULL PRIMARY KEY, `valor` VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $st = $this->db->query("SELECT valor FROM catalogo_meta WHERE clave = 'esquema'");
        $v = $st ? (int) $st->fetchColumn() : 0;
        if ($v >= self::VERSION_ESQUEMA) {
            return;
        }

        // Columnas nuevas en tablas que ya existian
        $this->agregarColumna('cursos', 'modalidad', "VARCHAR(12) NOT NULL DEFAULT 'en_vivo'");
        $this->agregarColumna('cursos', 'slug', "VARCHAR(90) NULL DEFAULT NULL");
        $this->agregarColumna('cursos', 'sigla', "VARCHAR(10) NULL DEFAULT NULL");
        $this->agregarColumna('cursos', 'clave_origen', "VARCHAR(60) NULL DEFAULT NULL");
        $this->agregarColumna('cursos', 'publicado', "TINYINT(1) NOT NULL DEFAULT 0");
        $this->agregarColumna('cursos', 'precio_usd', "DECIMAL(10,2) NULL DEFAULT NULL");
        $this->agregarColumna('usuario_cursos', 'origen', "VARCHAR(60) NULL DEFAULT NULL");
        $this->agregarColumna('usuario_cursos', 'fecha_matricula', "DATETIME NULL DEFAULT NULL");
        $this->agregarColumna('usuario', 'datos_cert_ok', "TINYINT(1) NOT NULL DEFAULT 0");

        $this->db->exec("CREATE TABLE IF NOT EXISTS `packs` (
            `id_pack` INT NOT NULL AUTO_INCREMENT,
            `codigo` VARCHAR(10) NOT NULL,
            `slug` VARCHAR(90) NOT NULL,
            `nombre` VARCHAR(200) NOT NULL,
            `tipo` VARCHAR(12) NOT NULL DEFAULT 'pack',
            `descripcion` TEXT NULL,
            `publico` VARCHAR(255) NULL,
            `incluye` VARCHAR(200) NULL,
            `precio` DECIMAL(10,2) NULL DEFAULT NULL,
            `precio_usd` DECIMAL(10,2) NULL DEFAULT NULL,
            `orden` INT NOT NULL DEFAULT 0,
            `publicado` TINYINT(1) NOT NULL DEFAULT 0,
            `creado` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id_pack`),
            UNIQUE KEY `idx_pack_codigo` (`codigo`),
            UNIQUE KEY `idx_pack_slug` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $this->db->exec("CREATE TABLE IF NOT EXISTS `pack_cursos` (
            `id_pack` INT NOT NULL,
            `id_curso` INT NOT NULL,
            `orden` INT NOT NULL DEFAULT 0,
            PRIMARY KEY (`id_pack`, `id_curso`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $this->db->exec("CREATE TABLE IF NOT EXISTS `curso_materiales` (
            `id_material` INT NOT NULL AUTO_INCREMENT,
            `id_curso` INT NOT NULL,
            `titulo` VARCHAR(255) NOT NULL,
            `tipo` VARCHAR(20) NOT NULL DEFAULT 'pdf',
            `url` VARCHAR(500) NOT NULL,
            `tamano_mb` DECIMAL(8,1) NULL DEFAULT NULL,
            `nota_interna` VARCHAR(255) NULL DEFAULT NULL,
            `orden` INT NOT NULL DEFAULT 0,
            `estado` TINYINT(1) NOT NULL DEFAULT 1,
            `creado` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id_material`),
            KEY `idx_mat_curso` (`id_curso`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $this->db->exec("CREATE TABLE IF NOT EXISTS `aula_certificados` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `id_usuario` INT NOT NULL,
            `id_curso` INT NOT NULL,
            `codigo` VARCHAR(60) NOT NULL,
            `archivo` VARCHAR(255) NULL DEFAULT NULL,
            `emitido` DATETIME NULL DEFAULT NULL,
            `creado` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `idx_cert_usuario_curso` (`id_usuario`, `id_curso`),
            UNIQUE KEY `idx_cert_codigo` (`codigo`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $this->db->exec("CREATE TABLE IF NOT EXISTS `catalogo_ventas` (
            `id_venta` INT NOT NULL AUTO_INCREMENT,
            `metodo` VARCHAR(20) NOT NULL,
            `referencia` VARCHAR(120) NOT NULL,
            `tipo` VARCHAR(10) NOT NULL,
            `id_item` INT NOT NULL,
            `item_nombre` VARCHAR(200) NOT NULL,
            `monto` DECIMAL(10,2) NULL DEFAULT NULL,
            `moneda` VARCHAR(3) NULL DEFAULT NULL,
            `estado` VARCHAR(12) NOT NULL DEFAULT 'pendiente',
            `id_usuario` INT NULL DEFAULT NULL,
            `nombre` VARCHAR(200) NULL,
            `documento` VARCHAR(20) NULL,
            `correo` VARCHAR(150) NULL,
            `celular` VARCHAR(30) NULL,
            `comprobante` VARCHAR(255) NULL,
            `creado` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `resuelto` DATETIME NULL DEFAULT NULL,
            PRIMARY KEY (`id_venta`),
            UNIQUE KEY `idx_venta_ref` (`metodo`, `referencia`),
            KEY `idx_venta_estado` (`estado`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $this->db->exec("REPLACE INTO catalogo_meta (clave, valor) VALUES ('esquema', '" . self::VERSION_ESQUEMA . "')");
    }

    // ------------------------------------------------------------------
    // Utilidades
    // ------------------------------------------------------------------

    public static function slug($txt) {
        $t = strtr((string) $txt, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n', 'ü' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u', 'Ñ' => 'n', 'Ü' => 'u',
        ]);
        $t = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $t), '-'));
        return substr($t, 0, 90);
    }

    /** Precio > 0 o null (el formulario manda '' cuando el campo esta vacio). */
    public static function precioONull($v) {
        $v = str_replace(',', '.', trim((string) $v));
        return (is_numeric($v) && (float) $v > 0) ? round((float) $v, 2) : null;
    }

    /** Un producto se puede vender solo si esta publicado y tiene los dos precios. */
    public static function vendible(array $item) {
        return !empty($item['publicado']) && (float) ($item['precio'] ?? 0) > 0 && (float) ($item['precio_usd'] ?? 0) > 0;
    }

    // ------------------------------------------------------------------
    // Lectura del catalogo
    // ------------------------------------------------------------------

    public function cursosAsincronos($soloPublicados = false) {
        $sql = "SELECT c.*,
                  (SELECT COUNT(*) FROM curso_videos v WHERE v.id_curso = c.id_curso AND v.estado = 1) AS total_clases,
                  (SELECT COUNT(*) FROM curso_materiales m WHERE m.id_curso = c.id_curso AND m.estado = 1) AS total_materiales
                FROM cursos c
                WHERE c.modalidad = 'asincrono' AND c.estado = 1" . ($soloPublicados ? " AND c.publicado = 1" : "") . "
                ORDER BY c.id_curso ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function curso($id) {
        $st = $this->db->prepare("SELECT * FROM cursos WHERE id_curso = ?");
        $st->execute([(int) $id]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function cursoPorSlug($slug) {
        $st = $this->db->prepare("SELECT c.*,
                  (SELECT COUNT(*) FROM curso_videos v WHERE v.id_curso = c.id_curso AND v.estado = 1) AS total_clases,
                  (SELECT COUNT(*) FROM curso_materiales m WHERE m.id_curso = c.id_curso AND m.estado = 1) AS total_materiales
                FROM cursos c WHERE c.slug = ? AND c.modalidad = 'asincrono' AND c.estado = 1 LIMIT 1");
        $st->execute([(string) $slug]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function packs($soloPublicados = false) {
        $packs = $this->db->query("SELECT * FROM packs" . ($soloPublicados ? " WHERE publicado = 1" : "") . " ORDER BY orden ASC, id_pack ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($packs as &$p) {
            $p['cursos'] = $this->cursosDePack($p['id_pack']);
        }
        unset($p);
        return $packs;
    }

    public function pack($id) {
        $st = $this->db->prepare("SELECT * FROM packs WHERE id_pack = ?");
        $st->execute([(int) $id]);
        $p = $st->fetch(PDO::FETCH_ASSOC);
        if ($p) {
            $p['cursos'] = $this->cursosDePack($p['id_pack']);
        }
        return $p ?: null;
    }

    public function packPorSlug($slug) {
        $st = $this->db->prepare("SELECT id_pack FROM packs WHERE slug = ? LIMIT 1");
        $st->execute([(string) $slug]);
        $id = $st->fetchColumn();
        return $id ? $this->pack($id) : null;
    }

    public function cursosDePack($idPack) {
        $st = $this->db->prepare("SELECT c.id_curso, c.nombre_curso, c.slug, c.sigla, c.horas_academicas, c.precio, c.precio_usd, c.publicado,
                  (SELECT COUNT(*) FROM curso_videos v WHERE v.id_curso = c.id_curso AND v.estado = 1) AS total_clases
                FROM pack_cursos pc INNER JOIN cursos c ON c.id_curso = pc.id_curso
                WHERE pc.id_pack = ? AND c.estado = 1 ORDER BY pc.orden ASC, c.id_curso ASC");
        $st->execute([(int) $idPack]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Suma de precios sueltos de los cursos del pack (para mostrar el ahorro); null si falta alguno. */
    public static function sumaSueltos(array $pack, $campo = 'precio') {
        $total = 0;
        foreach ($pack['cursos'] as $c) {
            if ((float) ($c[$campo] ?? 0) <= 0) {
                return null;
            }
            $total += (float) $c[$campo];
        }
        return $total;
    }

    /** Horas del pack = suma de las horas de sus cursos. */
    public static function horasPack(array $pack) {
        $h = 0;
        foreach ($pack['cursos'] as $c) {
            $h += (int) $c['horas_academicas'];
        }
        return $h;
    }

    public function materiales($idCurso, $soloActivos = true) {
        $st = $this->db->prepare("SELECT * FROM curso_materiales WHERE id_curso = ?" . ($soloActivos ? " AND estado = 1" : "") . " ORDER BY orden ASC, id_material ASC");
        $st->execute([(int) $idCurso]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // ------------------------------------------------------------------
    // Edicion (admin)
    // ------------------------------------------------------------------

    public function guardarCurso($id, array $d) {
        $st = $this->db->prepare("UPDATE cursos SET nombre_curso = ?, sigla = ?, precio = ?, precio_usd = ?, horas_academicas = ?, resumen = ?, publicado = ?
                                  WHERE id_curso = ? AND modalidad = 'asincrono'");
        return $st->execute([
            $d['nombre'], $d['sigla'], $d['precio'], $d['precio_usd'], (int) $d['horas'], $d['resumen'], $d['publicado'] ? 1 : 0, (int) $id,
        ]);
    }

    public function guardarPack($id, array $d) {
        $st = $this->db->prepare("UPDATE packs SET nombre = ?, descripcion = ?, publico = ?, precio = ?, precio_usd = ?, orden = ?, publicado = ? WHERE id_pack = ?");
        $ok = $st->execute([$d['nombre'], $d['descripcion'], $d['publico'], $d['precio'], $d['precio_usd'], (int) $d['orden'], $d['publicado'] ? 1 : 0, (int) $id]);
        if ($ok && isset($d['cursos']) && is_array($d['cursos'])) {
            $this->db->prepare("DELETE FROM pack_cursos WHERE id_pack = ?")->execute([(int) $id]);
            $ins = $this->db->prepare("INSERT INTO pack_cursos (id_pack, id_curso, orden) VALUES (?, ?, ?)");
            foreach (array_values(array_unique(array_map('intval', $d['cursos']))) as $i => $idCurso) {
                $ins->execute([(int) $id, $idCurso, $i + 1]);
            }
        }
        return $ok;
    }

    public function guardarMaterial(array $d) {
        if (!empty($d['id_material'])) {
            $st = $this->db->prepare("UPDATE curso_materiales SET titulo = ?, tipo = ?, url = ?, orden = ?, estado = ? WHERE id_material = ?");
            return $st->execute([$d['titulo'], $d['tipo'], $d['url'], (int) $d['orden'], $d['estado'] ? 1 : 0, (int) $d['id_material']]);
        }
        $st = $this->db->prepare("INSERT INTO curso_materiales (id_curso, titulo, tipo, url, orden) VALUES (?, ?, ?, ?, ?)");
        return $st->execute([(int) $d['id_curso'], $d['titulo'], $d['tipo'], $d['url'], (int) $d['orden']]);
    }

    public function eliminarMaterial($id) {
        return $this->db->prepare("DELETE FROM curso_materiales WHERE id_material = ?")->execute([(int) $id]);
    }

    // ------------------------------------------------------------------
    // Importacion del Excel (JSON generado fuera del repo)
    // ------------------------------------------------------------------

    /**
     * Crea o actualiza cursos asincronos (por clave_origen), sus clases y materiales, y los packs.
     * No toca precios, horas, publicado ni textos ya editados en el admin. Las clases y materiales de
     * cada curso importado se reemplazan por los del JSON (el progreso de los alumnos se conserva si
     * la misma URL de video sigue en el curso).
     * @return array resumen para mostrar
     */
    public function importar(array $data) {
        if (empty($data['cursos']) || !is_array($data['cursos'])) {
            throw new \InvalidArgumentException('El archivo no tiene la lista "cursos".');
        }
        $res = ['cursos_nuevos' => 0, 'cursos_actualizados' => 0, 'clases' => 0, 'materiales' => 0, 'packs' => 0];
        $idPorClave = [];

        $this->db->beginTransaction();
        try {
            foreach ($data['cursos'] as $c) {
                $clave = substr(preg_replace('/[^a-z0-9_]/', '', strtolower((string) ($c['clave'] ?? ''))), 0, 60);
                $nombre = trim((string) ($c['nombre'] ?? ''));
                if ($clave === '' || $nombre === '') {
                    continue;
                }
                $st = $this->db->prepare("SELECT id_curso FROM cursos WHERE clave_origen = ? AND modalidad = 'asincrono' LIMIT 1");
                $st->execute([$clave]);
                $id = $st->fetchColumn();
                if (!$id) {
                    $slug = $this->slugLibre('cursos', self::slug($nombre));
                    $ins = $this->db->prepare("INSERT INTO cursos (nombre_curso, categoria, fecha_emision, horas_academicas, estado, precio, precio_usd, modalidad, slug, sigla, clave_origen, publicado, lecciones)
                                               VALUES (?, 'Ingeniería', CURDATE(), 0, 1, NULL, NULL, 'asincrono', ?, ?, ?, 0, ?)");
                    $ins->execute([$nombre, $slug, substr((string) ($c['sigla'] ?? ''), 0, 10), $clave, count($c['videos'] ?? [])]);
                    $id = (int) $this->db->lastInsertId();
                    $res['cursos_nuevos']++;
                } else {
                    $res['cursos_actualizados']++;
                }
                $idPorClave[$clave] = (int) $id;

                // Clases: se reemplazan. El progreso guardado apunta a id_video, asi que se reasigna por URL.
                $viejos = $this->db->prepare("SELECT id_video, url_video FROM curso_videos WHERE id_curso = ?");
                $viejos->execute([$id]);
                $idPorUrl = [];
                foreach ($viejos->fetchAll(PDO::FETCH_ASSOC) as $v) {
                    $idPorUrl[$v['url_video']] = (int) $v['id_video'];
                }
                $vigentes = [];
                foreach (($c['videos'] ?? []) as $i => $v) {
                    $url = trim((string) ($v['url'] ?? ''));
                    if ($url === '') {
                        continue;
                    }
                    $titulo = trim((string) ($v['titulo'] ?? '')) ?: ('Clase ' . ($i + 1));
                    $modulo = trim((string) ($v['modulo'] ?? '')) ?: 'Clases';
                    $orden = (int) ($v['orden'] ?? ($i + 1));
                    if (isset($idPorUrl[$url])) {
                        $up = $this->db->prepare("UPDATE curso_videos SET titulo = ?, modulo = ?, orden = ?, estado = 1 WHERE id_video = ?");
                        $up->execute([$titulo, $modulo, $orden, $idPorUrl[$url]]);
                        $vigentes[] = $idPorUrl[$url];
                    } else {
                        $ins = $this->db->prepare("INSERT INTO curso_videos (id_curso, modulo, titulo, url_video, orden, estado) VALUES (?, ?, ?, ?, ?, 1)");
                        $ins->execute([$id, $modulo, $titulo, $url, $orden]);
                        $vigentes[] = (int) $this->db->lastInsertId();
                    }
                    $res['clases']++;
                }
                // Clases que ya no estan en el Excel: se ocultan (no se borran, por el progreso)
                if ($vigentes) {
                    $in = implode(',', array_map('intval', $vigentes));
                    $this->db->prepare("UPDATE curso_videos SET estado = 0 WHERE id_curso = ? AND id_video NOT IN ($in)")->execute([$id]);
                }

                // Materiales: se reemplazan los que vinieron de un import anterior
                $this->db->prepare("DELETE FROM curso_materiales WHERE id_curso = ? AND nota_interna LIKE 'import:%'")->execute([$id]);
                $insM = $this->db->prepare("INSERT INTO curso_materiales (id_curso, titulo, tipo, url, tamano_mb, nota_interna, orden) VALUES (?, ?, ?, ?, ?, ?, ?)");
                foreach (($c['materiales'] ?? []) as $j => $m) {
                    $url = trim((string) ($m['url'] ?? ''));
                    if (!preg_match('#^https://#i', $url)) {
                        continue;
                    }
                    $tam = is_numeric($m['tamano_mb'] ?? null) ? (float) $m['tamano_mb'] : null;
                    $insM->execute([
                        $id, substr(trim((string) ($m['titulo'] ?? 'Material')), 0, 255), substr((string) ($m['tipo'] ?? 'pdf'), 0, 20), $url, $tam,
                        substr('import: ' . trim((string) ($m['nota'] ?? '')), 0, 255), $j + 1,
                    ]);
                    $res['materiales']++;
                }
            }

            foreach (($data['packs'] ?? []) as $i => $p) {
                $codigo = substr(preg_replace('/[^A-Z0-9]/', '', strtoupper((string) ($p['codigo'] ?? ''))), 0, 10);
                $nombre = trim((string) ($p['nombre'] ?? ''));
                if ($codigo === '' || $nombre === '') {
                    continue;
                }
                $st = $this->db->prepare("SELECT id_pack FROM packs WHERE codigo = ?");
                $st->execute([$codigo]);
                $idPack = $st->fetchColumn();
                if (!$idPack) {
                    $tipo = in_array($p['tipo'] ?? '', ['pack', 'ruta', 'integral'], true) ? $p['tipo'] : 'pack';
                    $ins = $this->db->prepare("INSERT INTO packs (codigo, slug, nombre, tipo, publico, incluye, orden, publicado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
                    $ins->execute([$codigo, $this->slugLibre('packs', self::slug($nombre)), $nombre, $tipo,
                        substr((string) ($p['publico'] ?? ''), 0, 255), substr((string) ($p['incluye'] ?? ''), 0, 200), $i + 1]);
                    $idPack = (int) $this->db->lastInsertId();
                    // Los cursos del pack solo se cargan al crearlo: despues los maneja el admin
                    $insC = $this->db->prepare("INSERT IGNORE INTO pack_cursos (id_pack, id_curso, orden) VALUES (?, ?, ?)");
                    foreach (($p['cursos'] ?? []) as $k => $clave) {
                        if (isset($idPorClave[$clave])) {
                            $insC->execute([$idPack, $idPorClave[$clave], $k + 1]);
                        }
                    }
                }
                $res['packs']++;
            }
            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
        return $res;
    }

    private function slugLibre($tabla, $base) {
        $base = $base !== '' ? $base : 'item';
        $slug = $base;
        $n = 2;
        $st = $this->db->prepare("SELECT 1 FROM `$tabla` WHERE slug = ? LIMIT 1");
        while (true) {
            $st->execute([$slug]);
            if (!$st->fetch()) {
                return $slug;
            }
            $slug = substr($base, 0, 85) . '-' . $n++;
        }
    }

    // ------------------------------------------------------------------
    // Matricula y certificados
    // ------------------------------------------------------------------

    /** Ids de curso que entrega un producto ('curso' o 'pack'). */
    public function cursosDeProducto($tipo, $idItem) {
        if ($tipo === 'pack') {
            return array_map(function ($c) { return (int) $c['id_curso']; }, $this->cursosDePack($idItem));
        }
        return [(int) $idItem];
    }

    /**
     * Da acceso a los cursos y reserva el codigo de certificado de cada curso asincrono.
     * Seguro de repetir (no duplica). Devuelve los ids de curso nuevos para este alumno.
     */
    public function matricular($idUsuario, array $idsCurso, $origen) {
        $nuevos = [];
        $chk = $this->db->prepare("SELECT 1 FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ? LIMIT 1");
        $ins = $this->db->prepare("INSERT INTO usuario_cursos (id_usuario, id_curso, origen, fecha_matricula) VALUES (?, ?, ?, NOW())");
        foreach ($idsCurso as $idCurso) {
            $chk->execute([(int) $idUsuario, (int) $idCurso]);
            if (!$chk->fetch()) {
                $ins->execute([(int) $idUsuario, (int) $idCurso, substr((string) $origen, 0, 60)]);
                $nuevos[] = (int) $idCurso;
            }
            $curso = $this->curso($idCurso);
            if ($curso && $curso['modalidad'] === self::MODALIDAD_ASINCRONO) {
                $this->reservarCertificado($idUsuario, $curso);
            }
        }
        return $nuevos;
    }

    private function reservarCertificado($idUsuario, array $curso) {
        $st = $this->db->prepare("SELECT codigo FROM aula_certificados WHERE id_usuario = ? AND id_curso = ?");
        $st->execute([(int) $idUsuario, (int) $curso['id_curso']]);
        if ($st->fetchColumn()) {
            return;
        }
        // Formato fijo: CERT-<SIGLA DEL CURSO>-<DNI> (sin DNI, con el nombre del alumno)
        $st = $this->db->prepare("SELECT nombre, dni FROM usuario WHERE iduser = ?");
        $st->execute([(int) $idUsuario]);
        $al = $st->fetch(PDO::FETCH_ASSOC) ?: [];
        $sigla = CertificadoRegistro::siglaCurso($curso['nombre_curso'] ?? '', (string) ($curso['sigla'] ?? ''));
        $base = CertificadoRegistro::codigoPara($sigla, (string) ($al['dni'] ?? ''), (string) ($al['nombre'] ?? ''));
        if ($base === '') {
            $base = 'CERT-' . $sigla . '-' . (int) $idUsuario; // sin DNI ni nombre (no deberia pasar)
        }
        $base = (new CertificadoRegistro())->codigoLibre($base, $curso['nombre_curso'] ?? '');
        for ($i = 1; $i <= 5; $i++) {
            $codigo = $i === 1 ? $base : substr($base, 0, 56) . '-' . $i;
            try {
                $this->db->prepare("INSERT INTO aula_certificados (id_usuario, id_curso, codigo) VALUES (?, ?, ?)")
                    ->execute([(int) $idUsuario, (int) $curso['id_curso'], $codigo]);
                return;
            } catch (\PDOException $e) {
                // codigo ya usado por otro curso del aula con la misma sigla: se prueba con sufijo
            }
        }
    }

    public function certificadoDe($idUsuario, $idCurso) {
        $st = $this->db->prepare("SELECT * FROM aula_certificados WHERE id_usuario = ? AND id_curso = ?");
        $st->execute([(int) $idUsuario, (int) $idCurso]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /** Certificados automaticos del alumno (cursos asincronos), con datos del curso. */
    public function certificadosDe($idUsuario) {
        $st = $this->db->prepare("SELECT ac.*, c.nombre_curso, c.horas_academicas, c.sigla
                FROM aula_certificados ac INNER JOIN cursos c ON c.id_curso = ac.id_curso
                INNER JOIN usuario_cursos uc ON uc.id_usuario = ac.id_usuario AND uc.id_curso = ac.id_curso
                WHERE ac.id_usuario = ? AND c.estado = 1 ORDER BY c.nombre_curso ASC");
        $st->execute([(int) $idUsuario]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve la ruta del PDF del certificado (lo dibuja y registra en /verificar si aun no existe).
     * @throws \RuntimeException si faltan datos (horas del curso, nombre del alumno)
     */
    public function pdfCertificado($idUsuario, $idCurso, $urlVerificar) {
        $cert = $this->certificadoDe($idUsuario, $idCurso);
        $curso = $this->curso($idCurso);
        if (!$cert || !$curso) {
            throw new \RuntimeException('No hay certificado para este curso.');
        }
        if ($cert['archivo'] && is_file(self::DIR_CERTIFICADOS . $cert['archivo'])) {
            return self::DIR_CERTIFICADOS . $cert['archivo'];
        }
        if ((int) $curso['horas_academicas'] <= 0) {
            throw new \RuntimeException('El certificado de este curso aún se está preparando. Vuelve a intentarlo más tarde o escríbenos.');
        }
        $st = $this->db->prepare("SELECT nombre, dni FROM usuario WHERE iduser = ?");
        $st->execute([(int) $idUsuario]);
        $al = $st->fetch(PDO::FETCH_ASSOC);
        $nombre = trim(preg_replace('/\s+/u', ' ', (string) ($al['nombre'] ?? '')));
        if ($nombre === '') {
            throw new \RuntimeException('Falta tu nombre para el certificado.');
        }

        $fechaEmision = substr((string) $cert['creado'], 0, 10) ?: date('Y-m-d');
        $emision = Certificado::textoEmision($fechaEmision) ?: Certificado::textoEmision(date('Y-m-d'));
        $dir = self::DIR_CERTIFICADOS;
        if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
            throw new \RuntimeException('No se pudo crear la carpeta de certificados.');
        }
        $archivo = $cert['codigo'] . '.pdf';
        $datos = [
            'alumno' => $nombre, 'dni' => (string) ($al['dni'] ?? ''), 'curso' => $curso['nombre_curso'],
            'horas' => (string) (int) $curso['horas_academicas'], 'emision' => $emision, 'periodo' => null, 'modalidad' => 'Virtual',
        ];
        (new Certificado())->guardarPdf($datos, $cert['codigo'], $urlVerificar . $cert['codigo'], $dir . $archivo);

        (new CertificadoRegistro())->registrar([
            'codigo' => $cert['codigo'], 'nombre' => $nombre, 'dni' => $datos['dni'], 'curso' => $datos['curso'], 'horas' => $datos['horas'],
            'periodo' => '', 'fecha_emision' => $emision, 'modalidad' => 'Virtual', 'marca' => 'ICC', 'archivo_pdf' => 'aula/' . $archivo,
        ]);
        $this->db->prepare("UPDATE aula_certificados SET archivo = ?, emitido = NOW() WHERE id = ?")->execute([$archivo, (int) $cert['id']]);
        return $dir . $archivo;
    }

    /** Si el alumno corrige su nombre/documento antes de emitir, nada que rehacer; si ya habia PDFs, se rehacen. */
    public function invalidarPdfs($idUsuario) {
        $st = $this->db->prepare("SELECT id, archivo FROM aula_certificados WHERE id_usuario = ? AND archivo IS NOT NULL");
        $st->execute([(int) $idUsuario]);
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $c) {
            @unlink(self::DIR_CERTIFICADOS . $c['archivo']);
        }
        $this->db->prepare("UPDATE aula_certificados SET archivo = NULL WHERE id_usuario = ?")->execute([(int) $idUsuario]);
    }

    // ------------------------------------------------------------------
    // Ventas
    // ------------------------------------------------------------------

    /** Producto vendible por tipo/id, con nombre y precios; null si no existe o no esta a la venta. */
    public function producto($tipo, $id) {
        if ($tipo === 'pack') {
            $p = $this->pack($id);
            if (!$p || !self::vendible($p) || empty($p['cursos'])) {
                return null;
            }
            return ['tipo' => 'pack', 'id' => (int) $p['id_pack'], 'nombre' => $p['nombre'], 'precio' => (float) $p['precio'], 'precio_usd' => (float) $p['precio_usd'], 'origen' => 'pack:' . $p['codigo']];
        }
        if ($tipo === 'curso') {
            $c = $this->curso($id);
            if (!$c || $c['modalidad'] !== self::MODALIDAD_ASINCRONO || (int) $c['estado'] !== 1 || !self::vendible($c)) {
                return null;
            }
            return ['tipo' => 'curso', 'id' => (int) $c['id_curso'], 'nombre' => $c['nombre_curso'], 'precio' => (float) $c['precio'], 'precio_usd' => (float) $c['precio_usd'], 'origen' => 'curso'];
        }
        return null;
    }

    public function ventaPorReferencia($metodo, $referencia) {
        $st = $this->db->prepare("SELECT * FROM catalogo_ventas WHERE metodo = ? AND referencia = ?");
        $st->execute([$metodo, $referencia]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function venta($id) {
        $st = $this->db->prepare("SELECT * FROM catalogo_ventas WHERE id_venta = ?");
        $st->execute([(int) $id]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function registrarVenta(array $v) {
        $st = $this->db->prepare("INSERT INTO catalogo_ventas (metodo, referencia, tipo, id_item, item_nombre, monto, moneda, estado, id_usuario, nombre, documento, correo, celular, comprobante, resuelto)
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $st->execute([
            $v['metodo'], substr($v['referencia'], 0, 120), $v['tipo'], (int) $v['id_item'], substr($v['item_nombre'], 0, 200),
            $v['monto'], $v['moneda'], $v['estado'], $v['id_usuario'] ?? null, substr((string) $v['nombre'], 0, 200),
            substr((string) $v['documento'], 0, 20), substr((string) $v['correo'], 0, 150), substr((string) $v['celular'], 0, 30),
            $v['comprobante'] ?? null, $v['estado'] === 'pendiente' ? null : date('Y-m-d H:i:s'),
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function cerrarVenta($idVenta, $estado, $idUsuario = null) {
        return $this->db->prepare("UPDATE catalogo_ventas SET estado = ?, id_usuario = COALESCE(?, id_usuario), resuelto = NOW() WHERE id_venta = ?")
            ->execute([$estado, $idUsuario, (int) $idVenta]);
    }

    public function ventas($estado = null, $limite = 200) {
        $sql = "SELECT * FROM catalogo_ventas" . ($estado ? " WHERE estado = ?" : "") . " ORDER BY id_venta DESC LIMIT " . (int) $limite;
        $st = $this->db->prepare($sql);
        $st->execute($estado ? [$estado] : []);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca al alumno por correo o crea su cuenta del aula. Devuelve [id, password|null]:
     * password solo si la cuenta es nueva (para mandarla por correo).
     */
    public function alumnoPorCorreo($correo, $nombre, $dni, $celular, array $pago) {
        $st = $this->db->prepare("SELECT iduser FROM usuario WHERE correo = ? OR usuario = ? ORDER BY iduser ASC LIMIT 1");
        $st->execute([$correo, $correo]);
        $id = $st->fetchColumn();
        if ($id) {
            // Completa el documento si la cuenta no lo tenia (el certificado lo usa)
            if ($dni !== '') {
                $this->db->prepare("UPDATE usuario SET dni = ? WHERE iduser = ? AND (dni IS NULL OR dni = '')")->execute([$dni, (int) $id]);
            }
            return [(int) $id, null];
        }
        // Misma forma de clave que ya usa el checkout (el login del aula compara texto plano)
        $password = substr(bin2hex(random_bytes(6)), 0, 8);
        $ins = $this->db->prepare("INSERT INTO usuario (id_pla, nombre, correo, usuario, password, dni, telefono, n_operacion, m_pagado, banco, fecha_deposito, estatus)
                                   VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)");
        $ins->execute([$nombre, $correo, $correo, $password, $dni, $celular,
            substr((string) ($pago['referencia'] ?? ''), 0, 100), $pago['monto'] ?? 0, substr((string) ($pago['banco'] ?? ''), 0, 50)]);
        return [(int) $this->db->lastInsertId(), $password];
    }
}
