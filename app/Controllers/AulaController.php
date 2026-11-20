<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Catalogo;

/**
 * Aula virtual del alumno.
 * - Cursos en vivo: como siempre (certificado lo emite/sube el admin; el alumno lo solicita al terminar).
 * - Cursos grabados (catalogo de packs): certificado descargable desde que entra, una vez que confirma
 *   el nombre y documento con que debe salir.
 */
class AulaController extends Controller {

    private $uid;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['aula_uid'])) {
            header('Location: ' . BASE_URL . 'aula/login');
            exit;
        }
        $this->uid = (int) $_SESSION['aula_uid'];
    }

    // ---------------- utilidades ----------------

    private function token() {
        if (empty($_SESSION['aula_csrf'])) {
            $_SESSION['aula_csrf'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['aula_csrf'];
    }

    private function postValido() {
        return $_SERVER['REQUEST_METHOD'] === 'POST'
            && hash_equals($this->token(), (string) ($_POST['_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '')));
    }

    private function alumno() {
        $st = (new \App\Core\Database())->connect()->prepare("SELECT * FROM usuario WHERE iduser = ?");
        $st->execute([$this->uid]);
        return $st->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    /** Id de YouTube de un enlace (youtu.be, watch?v=, embed/, shorts/) o null. */
    public static function youtubeId($url) {
        if (preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', (string) $url, $m)) {
            return $m[1];
        }
        return null;
    }

    private function flash($tipo = null, $texto = null) {
        if ($tipo !== null) {
            $_SESSION['aula_flash'] = ['tipo' => $tipo, 'texto' => $texto];
            return null;
        }
        $f = $_SESSION['aula_flash'] ?? null;
        unset($_SESSION['aula_flash']);
        return $f;
    }

    /**
     * Certificados de cursos EN VIVO emitidos por lote o sueltos (registro de /verificar), buscados por el DNI
     * del alumno y SOLO para cursos en los que esta matriculado. Devuelve [id_curso => fila].
     */
    private function certificadosRegistrados(array $cursos) {
        $dni = preg_replace('/\s+/', '', (string) ($this->alumno()['dni'] ?? ''));
        if (strlen($dni) < 6 || trim($dni, '0') === '') {
            return [];
        }
        $db = (new \App\Core\Database())->connect();
        try {
            // El nombre del curso puede venir con o sin tildes: la collation general_ci las iguala
            $st = $db->prepare("SELECT codigo, curso, fecha_emision, archivo_pdf FROM certificados_emitidos
                WHERE dni = ? AND estado = 'vigente' AND curso LIKE ?
                  AND codigo NOT IN (SELECT codigo FROM aula_certificados) ORDER BY id DESC LIMIT 1");
        } catch (\PDOException $e) {
            return []; // aun no existe el registro de /verificar en esta base
        }
        $out = [];
        foreach ($cursos as $c) {
            if (($c['modalidad'] ?? 'en_vivo') === Catalogo::MODALIDAD_ASINCRONO) {
                continue;
            }
            try {
                $st->execute([$dni, '%' . $c['nombre_curso'] . '%']);
            } catch (\PDOException $e) {
                return [];
            }
            if ($r = $st->fetch(\PDO::FETCH_ASSOC)) {
                $r['id_curso'] = (int) $c['id_curso'];
                $r['pdf'] = self::pdfPublico($r['archivo_pdf']);
                $out[(int) $c['id_curso']] = $r;
            }
        }
        return $out;
    }

    /** URL del PDF si existe dentro de assets/certificados/ (los del lote se guardan con rutas de distintas formas). */
    private static function pdfPublico($ruta) {
        $ruta = ltrim(str_replace('\\', '/', (string) $ruta), '/');
        if ($ruta === '' || strpos($ruta, '..') !== false) {
            return null;
        }
        foreach ([$ruta, 'assets/certificados/' . $ruta] as $r) {
            if (strpos($r, 'assets/certificados/') === 0 && is_file(__DIR__ . '/../../' . $r)) {
                return BASE_URL . implode('/', array_map('rawurlencode', explode('/', $r)));
            }
        }
        return null;
    }

    private function base(array $extra) {
        return $extra + [
            'alumno' => $this->alumno(), 'token' => $this->token(), 'flash' => $this->flash(),
        ];
    }

    // ---------------- paginas ----------------

    public function index() {
        $cursoModel = new \App\Models\Curso();
        $cat = new Catalogo();
        $cursos = $cursoModel->getCursosByEstudiante($this->uid);

        // Cursos grabados matriculados a mano desde el admin: se les reserva el certificado aqui
        $ids = array_map(function ($c) { return (int) $c['id_curso']; }, $cursos);
        if ($ids) {
            $cat->matricular($this->uid, $ids, 'admin');
        }
        $certAuto = [];
        foreach ($cat->certificadosDe($this->uid) as $c) {
            $certAuto[(int) $c['id_curso']] = $c;
        }

        $continuar = null;
        foreach ($cursos as &$c) {
            $videos = $cursoModel->getVideosByCurso($c['id_curso']);
            $vistos = array_map('intval', $cursoModel->getProgresoVideos($this->uid, $c['id_curso']));
            $c['total'] = count($videos);
            $c['vistos'] = count(array_intersect($vistos, array_map(function ($v) { return (int) $v['id_video']; }, $videos)));
            $c['progreso'] = $c['total'] ? (int) round($c['vistos'] * 100 / $c['total']) : 0;
            $full = $cat->curso($c['id_curso']);
            $c['modalidad'] = $full['modalidad'] ?? 'en_vivo';
            $c['certificado'] = $certAuto[(int) $c['id_curso']] ?? null;
            $c['miniatura'] = null;
            foreach ($videos as $v) {
                if ($id = self::youtubeId($v['url_video'])) {
                    $c['miniatura'] = 'https://i.ytimg.com/vi/' . $id . '/hqdefault.jpg';
                    break;
                }
            }
            if ($c['vistos'] > 0 && $c['progreso'] < 100 && (!$continuar || $c['progreso'] > $continuar['progreso'])) {
                $continuar = $c;
            }
        }
        unset($c);

        $subidos = $cursoModel->getCertificadosUsuario($this->uid);
        $conSubido = array_map(function ($s) { return (int) ($s['id_curso'] ?? 0); }, $subidos);
        $registrados = array_diff_key($this->certificadosRegistrados($cursos), array_flip($conSubido));
        foreach ($cursos as &$c) {
            $c['cert_registrado'] = $registrados[(int) $c['id_curso']] ?? null;
        }
        unset($c);

        $this->view('aula/index', $this->base([
            'title' => 'Mi aula | ICC', 'cursos' => $cursos, 'continuar' => $continuar,
            'certificadosSubidos' => $subidos,
            'certificadosAuto' => array_values($certAuto),
            'certificadosRegistrados' => array_values($registrados),
        ]), 'layouts/aula');
    }

    public function curso($id = 0) {
        $id = (int) $id;
        $cursoModel = new \App\Models\Curso();
        if ($id <= 0 || !$cursoModel->checkAccesoEstudiante($this->uid, $id)) {
            $this->view('aula/error', $this->base(['title' => 'Sin acceso | ICC', 'mensaje' => 'No tienes acceso a este curso. Si ya pagaste, escríbenos y lo revisamos.']), 'layouts/aula');
            return;
        }
        $cat = new Catalogo();
        $curso = $cat->curso($id);
        if (!$curso || (int) $curso['estado'] !== 1) {
            $this->view('aula/error', $this->base(['title' => 'Curso no disponible | ICC', 'mensaje' => 'Este curso no está disponible.']), 'layouts/aula');
            return;
        }
        $asincrono = $curso['modalidad'] === Catalogo::MODALIDAD_ASINCRONO;
        if ($asincrono) {
            $cat->matricular($this->uid, [$id], 'admin'); // reserva el certificado si faltaba
        }

        $videos = $cursoModel->getVideosByCurso($id);
        $vistos = array_map('intval', $cursoModel->getProgresoVideos($this->uid, $id));
        $clases = [];
        foreach ($videos as $i => $v) {
            $yt = self::youtubeId($v['url_video']);
            $clases[] = [
                'id' => (int) $v['id_video'], 'n' => $i + 1, 'titulo' => $v['titulo'], 'modulo' => $v['modulo'] ?: 'Clases',
                'duracion' => ($v['duracion'] ?? '') !== '0:00' ? ($v['duracion'] ?? '') : '', 'descripcion' => $v['descripcion'] ?? '',
                'yt' => $yt, 'url' => $yt ? null : $v['url_video'], 'visto' => in_array((int) $v['id_video'], $vistos, true),
            ];
        }
        // Empieza en la primera clase sin ver (o en la que pide la URL)
        $actual = 0;
        foreach ($clases as $i => $c) {
            if (!$c['visto']) {
                $actual = $i;
                break;
            }
        }
        if (isset($_GET['clase'])) {
            foreach ($clases as $i => $c) {
                if ($c['id'] === (int) $_GET['clase']) {
                    $actual = $i;
                }
            }
        }

        $subido = $asincrono ? null : $this->certificadoSubido($cursoModel, $id);
        $registrado = null;
        if (!$asincrono && !$subido) {
            $registrado = $this->certificadosRegistrados([$curso])[$id] ?? null;
        }

        $this->view('aula/curso', $this->base([
            'certificadoRegistrado' => $registrado,
            'title' => $curso['nombre_curso'] . ' | Aula ICC', 'curso' => $curso, 'asincrono' => $asincrono, 'clases' => $clases, 'actual' => $actual,
            'materiales' => $cat->materiales($id), 'certificado' => $asincrono ? $cat->certificadoDe($this->uid, $id) : null,
            'estadoCertificado' => $asincrono ? null : (int) $cursoModel->getEstadoCertificado($this->uid, $id),
            'certificadoSubido' => $subido,
        ]), 'layouts/aula');
    }

    private function certificadoSubido($cursoModel, $idCurso) {
        foreach ($cursoModel->getCertificadosUsuario($this->uid) as $c) {
            if (isset($c['id_curso']) && (int) $c['id_curso'] === (int) $idCurso) {
                return $c;
            }
        }
        return null;
    }

    /** POST (fetch): marca o desmarca una clase como vista. Devuelve el progreso del curso. */
    public function progreso() {
        header('Content-Type: application/json');
        if (!$this->postValido()) {
            http_response_code(403);
            echo json_encode(['ok' => false]);
            return;
        }
        $idCurso = (int) ($_POST['id_curso'] ?? 0);
        $idVideo = (int) ($_POST['id_video'] ?? 0);
        $cursoModel = new \App\Models\Curso();
        if (!$cursoModel->checkAccesoEstudiante($this->uid, $idCurso)) {
            http_response_code(403);
            echo json_encode(['ok' => false]);
            return;
        }
        $videos = array_map(function ($v) { return (int) $v['id_video']; }, $cursoModel->getVideosByCurso($idCurso));
        if (!in_array($idVideo, $videos, true)) {
            http_response_code(404);
            echo json_encode(['ok' => false]);
            return;
        }
        $db = (new \App\Core\Database())->connect();
        if (!empty($_POST['visto'])) {
            $st = $db->prepare("SELECT 1 FROM progreso_videos WHERE id_usuario = ? AND id_curso = ? AND id_video = ?");
            $st->execute([$this->uid, $idCurso, $idVideo]);
            if (!$st->fetch()) {
                $db->prepare("INSERT INTO progreso_videos (id_usuario, id_curso, id_video) VALUES (?, ?, ?)")->execute([$this->uid, $idCurso, $idVideo]);
            }
        } else {
            $db->prepare("DELETE FROM progreso_videos WHERE id_usuario = ? AND id_curso = ? AND id_video = ?")->execute([$this->uid, $idCurso, $idVideo]);
        }
        $vistos = array_intersect(array_map('intval', $cursoModel->getProgresoVideos($this->uid, $idCurso)), $videos);
        echo json_encode(['ok' => true, 'vistos' => count($vistos), 'total' => count($videos),
            'progreso' => $videos ? (int) round(count($vistos) * 100 / count($videos)) : 0]);
    }

    /** Compatibilidad con el formulario viejo (aula/marcar_progreso). */
    public function marcar_progreso() {
        header('Location: ' . BASE_URL . 'aula' . (isset($_POST['id_curso']) ? '/curso/' . (int) $_POST['id_curso'] : ''));
        exit;
    }

    /** Cursos en vivo: el alumno avisa que termino para que el admin le emita el certificado. */
    public function solicitar_certificado() {
        $idCurso = (int) ($_POST['id_curso'] ?? 0);
        if ($this->postValido() && (new \App\Models\Curso())->checkAccesoEstudiante($this->uid, $idCurso)) {
            $db = (new \App\Core\Database())->connect();
            $db->prepare("UPDATE usuario_cursos SET estado_certificado = 1 WHERE id_usuario = ? AND id_curso = ? AND (estado_certificado IS NULL OR estado_certificado = 0)")
                ->execute([$this->uid, $idCurso]);
            $this->flash('ok', 'Listo: avisamos al equipo para emitir tu certificado.');
        }
        header('Location: ' . BASE_URL . 'aula/curso/' . $idCurso);
        exit;
    }

    /** Descarga del certificado de un curso grabado (lo dibuja la primera vez). */
    public function certificado($idCurso = 0) {
        $idCurso = (int) $idCurso;
        $cat = new Catalogo();
        if (!(new \App\Models\Curso())->checkAccesoEstudiante($this->uid, $idCurso) || !$cat->certificadoDe($this->uid, $idCurso)) {
            $this->flash('error', 'Ese certificado no está disponible en tu cuenta.');
            header('Location: ' . BASE_URL . 'aula');
            exit;
        }
        $al = $this->alumno();
        if (empty($al['datos_cert_ok'])) {
            header('Location: ' . BASE_URL . 'aula/mis_datos?certificado=' . $idCurso);
            exit;
        }
        try {
            $ruta = $cat->pdfCertificado($this->uid, $idCurso, BASE_URL . 'verificar/');
        } catch (\Throwable $e) {
            error_log('Aula certificado ' . $this->uid . '/' . $idCurso . ': ' . $e->getMessage());
            $this->flash('error', $e instanceof \RuntimeException ? $e->getMessage() : 'No pudimos generar tu certificado. Inténtalo más tarde o escríbenos.');
            header('Location: ' . BASE_URL . 'aula/curso/' . $idCurso);
            exit;
        }
        $curso = $cat->curso($idCurso);
        $nombre = 'Certificado ICC - ' . preg_replace('/[^\p{L}\p{N} ]+/u', '', $curso['nombre_curso']) . '.pdf';
        header('Content-Type: application/pdf');
        header('Content-Length: ' . filesize($ruta));
        header("Content-Disposition: attachment; filename=\"certificado.pdf\"; filename*=UTF-8''" . rawurlencode($nombre));
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, no-store');
        readfile($ruta);
        exit;
    }

    /** Confirmar nombre y documento del certificado (una vez; luego los cambia soporte). */
    public function mis_datos() {
        $al = $this->alumno();
        $idCert = (int) ($_GET['certificado'] ?? $_POST['certificado'] ?? 0);
        $cat = new Catalogo();
        $emitidos = array_filter($cat->certificadosDe($this->uid), function ($c) { return !empty($c['emitido']); });
        $bloqueado = !empty($al['datos_cert_ok']) && count($emitidos) > 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->postValido()) {
                $this->flash('error', 'La página venció. Vuelve a intentarlo.');
            } elseif ($bloqueado) {
                $this->flash('error', 'Tus certificados ya se emitieron con estos datos. Para corregirlos escríbenos por WhatsApp.');
            } else {
                $nombre = trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($_POST['nombre'] ?? ''))));
                // El documento solo se completa si falta: con el se buscan certificados del registro, asi que
                // cambiarlo permitiria ver los de otra persona. Las correcciones las hace soporte.
                $docActual = trim((string) ($al['dni'] ?? ''));
                $doc = ($docActual !== '' && trim($docActual, '0') !== '')
                    ? $docActual
                    : preg_replace('/[^A-Za-z0-9-]/', '', (string) ($_POST['dni'] ?? ''));
                if (mb_strlen($nombre) < 5 || strpos($nombre, ' ') === false) {
                    $this->flash('error', 'Escribe tu nombre completo (nombres y apellidos).');
                } else {
                    $db = (new \App\Core\Database())->connect();
                    $db->prepare("UPDATE usuario SET nombre = ?, dni = ?, datos_cert_ok = 1 WHERE iduser = ?")->execute([mb_substr($nombre, 0, 200), substr($doc, 0, 20), $this->uid]);
                    $_SESSION['aula_nombre'] = $nombre;
                    $cat->invalidarPdfs($this->uid);
                    if ($idCert) {
                        header('Location: ' . BASE_URL . 'aula/certificado/' . $idCert);
                        exit;
                    }
                    $this->flash('ok', 'Datos guardados. Ya puedes descargar tus certificados.');
                    header('Location: ' . BASE_URL . 'aula');
                    exit;
                }
            }
            header('Location: ' . BASE_URL . 'aula/mis_datos' . ($idCert ? '?certificado=' . $idCert : ''));
            exit;
        }
        $this->view('aula/mis_datos', $this->base(['title' => 'Mis datos | Aula ICC', 'idCert' => $idCert, 'bloqueado' => $bloqueado]), 'layouts/aula');
    }
}
