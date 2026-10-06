<?php
/**
 * Generacion de certificados en LOTE (un PDF por alumno) y registro en la pagina de verificacion.
 *
 * Solo por consola (en el navegador responde 404). Uso, desde la carpeta del proyecto:
 *   C:\xampp\php\php.exe scripts\generar_certificados_lote.php RUTA\lote.json [--solo-generar]
 *   C:\xampp\php\php.exe scripts\generar_certificados_lote.php RUTA\lote.json --reemitir=CODIGO[,CODIGO...] [--resumen=RUTA\_resumen.csv]
 *
 * El JSON del lote y la lista de alumnos (CSV con columnas Nombre, DNI) viven FUERA del repositorio: llevan
 * datos reales y todo lo que esta en el repo se publica en el sitio. Ver scripts/certificados_lote.ejemplo.json.
 *
 *   - Cada alumno recibe un codigo propio (CERT-<curso>-<10 hex>, no adivinable y estable: repetir el lote da los
 *     mismos codigos), impreso en el certificado; el QR abre https://icc.com.pe/verificar/<codigo>.
 *   - Al terminar envia el lote a /verificar/registrar (necesita CERT_REGISTRO_TOKEN en el .env del servidor).
 *     Si eso falla, los PDF igual quedan listos: importa el _resumen.csv en admin > Registro publico.
 *   - Repetir un lote sobrescribe los mismos archivos; nunca borra otros PDF de la carpeta de salida.
 *
 * --reemitir: vuelve a generar el PDF de UNO O VARIOS alumnos YA registrados, con el mismo codigo, y el QR que abre
 * la verificacion (sirve para los certificados viejos cuyo QR abre el PDF). Toma nombre y DNI del _resumen.csv del
 * lote (por defecto <salida>/_resumen.csv), y curso/horas/periodo/emision/modalidad del JSON: tienen que ser los del
 * lote original. No registra nada ni toca otros archivos: deja los PDF en <salida>/reemision/.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

ini_set('memory_limit', '512M');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require_once __DIR__ . '/../app/Models/Certificado.php';
require_once __DIR__ . '/../app/Libraries/phpqrcode/qrlib.php';
require_once __DIR__ . '/../app/Libraries/fpdf/fpdf.php';

function salir($msg) {
    fwrite(STDERR, "ERROR: $msg\n");
    exit(1);
}

function quitar_acentos($s) {
    return strtr($s, [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n', 'ü' => 'u',
        'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ñ' => 'N', 'Ü' => 'U',
    ]);
}

function sanear($texto) {
    $texto = preg_replace('/[^A-Za-z0-9]/', '_', quitar_acentos($texto));
    return strtoupper(trim(preg_replace('/_+/', '_', $texto), '_'));
}

/**
 * Lee un CSV (acepta BOM, ',' o ';' y UTF-8 o Windows-1252 de Excel) y devuelve [encabezados en minuscula, filas].
 * @return array{0:string[],1:array[]}
 */
function leer_csv($ruta, $que) {
    $raw = @file_get_contents($ruta);
    if ($raw === false) {
        salir("No se pudo leer $que: $ruta");
    }
    $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
    if (!mb_check_encoding($raw, 'UTF-8')) {
        $raw = mb_convert_encoding($raw, 'UTF-8', 'Windows-1252');
    }
    $lineas = array_values(array_filter(preg_split('/\r\n|\r|\n/', $raw), function ($l) { return trim($l) !== ''; }));
    if (count($lineas) < 2) {
        salir("$que esta vacio (debe tener encabezado y al menos una fila): $ruta");
    }
    $sep = substr_count($lineas[0], ';') > substr_count($lineas[0], ',') ? ';' : ',';
    $cab = array_map(function ($c) { return strtolower(trim($c, " \t\"'")); }, str_getcsv($lineas[0], $sep));
    $filas = [];
    foreach (array_slice($lineas, 1) as $l) {
        $filas[] = str_getcsv($l, $sep);
    }
    return [$cab, $filas];
}

/** Lista de alumnos (columnas Nombre y, opcional, DNI). */
function leer_alumnos($ruta) {
    list($cab, $filas) = leer_csv($ruta, 'la lista de alumnos');
    $iN = array_search('nombre', $cab, true);
    $iD = array_search('dni', $cab, true);
    if ($iN === false) {
        salir('La lista de alumnos necesita una columna "Nombre" (y opcionalmente "DNI").');
    }
    $out = [];
    foreach ($filas as $f) {
        $nombre = trim($f[$iN] ?? '');
        if ($nombre !== '') {
            $out[] = ['nombre' => $nombre, 'dni' => $iD === false ? '' : trim($f[$iD] ?? '')];
        }
    }
    return $out;
}

/** _resumen.csv de un lote (Nombre, DNI, Codigo, ...): devuelve [codigo en mayusculas => [nombre, dni]]. */
function leer_resumen($ruta) {
    list($cab, $filas) = leer_csv($ruta, 'el _resumen.csv');
    $iN = array_search('nombre', $cab, true);
    $iD = array_search('dni', $cab, true);
    $iC = array_search('codigo', $cab, true);
    if ($iN === false || $iC === false) {
        salir('El _resumen.csv necesita las columnas Nombre y Codigo.');
    }
    $mapa = [];
    foreach ($filas as $f) {
        $codigo = strtoupper(trim($f[$iC] ?? ''));
        if ($codigo !== '') {
            $mapa[$codigo] = ['nombre' => trim($f[$iN] ?? ''), 'dni' => $iD === false ? '' : trim($f[$iD] ?? '')];
        }
    }
    return $mapa;
}

/** Dibuja el certificado de un alumno (con su codigo y el QR de verificacion) y lo guarda como PDF A4 apaisado. */
function crear_pdf(\App\Models\Certificado $modelo, array $d, $nombre, $dni, $codigo, $urlQr, $rutaPdf) {
    $imagen = $modelo->generarImagenCertificado($nombre, $dni, $d['curso'], $d['horas'], $d['emision'], '', $d['periodo'], null, $d['modalidad']);
    $modelo->dibujarCodigo($imagen, $codigo);

    $base = sys_get_temp_dir() . '/cert_' . $codigo;
    imagejpeg($imagen, $base . '.jpg', 100);
    imagedestroy($imagen);
    \QRcode::png($urlQr, $base . '_qr.png', QR_ECLEVEL_M, 10, 0);

    $pdf = new \FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->Image($base . '.jpg', 0, 0, 297, 210);
    list($qx, $qy, $ql) = \App\Models\Certificado::QR_MM;
    $pdf->Image($base . '_qr.png', $qx, $qy, $ql, $ql);
    $pdf->Output('F', $rutaPdf);
    @unlink($base . '.jpg');
    @unlink($base . '_qr.png');
}

function enviar_registro($url, $token, array $certificados) {
    $cuerpo = json_encode(['token' => $token, 'certificados' => $certificados], JSON_UNESCAPED_UNICODE);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true, CURLOPT_POSTFIELDS => $cuerpo, CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'], CURLOPT_TIMEOUT => 60,
    ]);
    $resp = curl_exec($ch);
    $err = curl_error($ch);
    $http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$http, $resp === false ? $err : $resp];
}

// ---- Argumentos y configuracion del lote ----
$args = array_slice($argv, 1);
$soloGenerar = in_array('--solo-generar', $args, true);
$reemitir = [];
$resumenRuta = null;
$posicionales = [];
foreach ($args as $a) {
    if ($a === '--solo-generar') {
        continue;
    } elseif (strpos($a, '--reemitir=') === 0) {
        $reemitir = array_values(array_filter(array_map(function ($c) { return strtoupper(trim($c)); }, explode(',', substr($a, 11)))));
    } elseif (strpos($a, '--resumen=') === 0) {
        $resumenRuta = substr($a, 10);
    } else {
        $posicionales[] = $a;
    }
}
if (!$posicionales) {
    salir('Falta la ruta del JSON del lote. Ejemplo: scripts/certificados_lote.ejemplo.json');
}
$cfg = json_decode((string) @file_get_contents($posicionales[0]), true);
if (!is_array($cfg)) {
    salir('No se pudo leer el JSON del lote: ' . $posicionales[0]);
}
$requeridos = $reemitir ? ['curso', 'codigo_curso', 'horas', 'emision', 'salida'] : ['curso', 'codigo_curso', 'horas', 'emision', 'lista', 'salida'];
foreach ($requeridos as $k) {
    if (empty($cfg[$k])) {
        salir("Falta \"$k\" en el JSON del lote.");
    }
}
$datos = [
    'curso' => $cfg['curso'],
    'horas' => (string) $cfg['horas'],
    'periodo' => !empty($cfg['periodo']) ? $cfg['periodo'] : null,
    'emision' => $cfg['emision'],
    'modalidad' => !empty($cfg['modalidad']) ? $cfg['modalidad'] : null,
];
$codigoCurso = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $cfg['codigo_curso']));
$urlBase = rtrim($cfg['url_base'] ?? 'https://icc.com.pe', '/');   // donde esta el sistema (registro y API)
$marca = strtoupper($cfg['marca'] ?? 'ICC') === 'ST' ? 'ST' : 'ICC';
// Direccion que lleva el QR: por defecto <url_base>/verificar/ ; para ST Energy, "https://verifica.stenergyedu.com/"
$urlVerificacion = !empty($cfg['url_verificacion']) ? rtrim($cfg['url_verificacion'], '/') . '/' : $urlBase . '/verificar/';
$salida = rtrim(str_replace('\\', '/', $cfg['salida']), '/') . '/';
$copia = !empty($cfg['copia']) ? rtrim(str_replace('\\', '/', $cfg['copia']), '/') . '/' : null;
$modelo = new \App\Models\Certificado();

// ---- Modo --reemitir: mismo codigo, QR nuevo ----
if ($reemitir) {
    $mapa = leer_resumen($resumenRuta ?? ($salida . '_resumen.csv'));
    $dirRe = $salida . 'reemision/';
    if (!is_dir($dirRe) && !mkdir($dirRe, 0777, true)) {
        salir("No se pudo crear la carpeta: $dirRe");
    }
    $hechos = 0;
    foreach ($reemitir as $codigo) {
        if (!isset($mapa[$codigo])) {
            fwrite(STDERR, "  NO ESTA en el _resumen.csv: $codigo (revisa el codigo o pasa --resumen=RUTA)\n");
            continue;
        }
        $al = $mapa[$codigo];
        $archivo = rtrim(substr(sanear($al['nombre']), 0, 60), '_') . '_' . $codigo . '_QR_NUEVO.pdf';
        crear_pdf($modelo, $datos, $al['nombre'], $al['dni'], $codigo, $urlVerificacion . $codigo, $dirRe . $archivo);
        echo "  OK  {$al['nombre']} -> $archivo\n";
        $hechos++;
    }
    echo "\n$hechos certificados reemitidos en $dirRe\n(el registro no se toca: siguen verificandose con el mismo codigo)\n";
    exit($hechos === count($reemitir) ? 0 : 1);
}

// ---- Modo lote ----
if ($marca === 'ST') {
    fwrite(STDERR, "AVISO: marca ST Energy. El PDF se dibuja con el DISENO DE ICC (logo, firmas y sellos de ICC); si los certificados de ST Energy
" .
        "llevan otro diseno, usa este script solo para el registro/QR o pide adaptar el diseno antes de entregarlos.

");
}
$token = (string) ($cfg['token'] ?? getenv('CERT_REGISTRO_TOKEN') ?: '');
if ($token === '') {
    salir('Falta "token" en el JSON del lote (o la variable CERT_REGISTRO_TOKEN): es el mismo del .env del servidor.');
}
foreach (array_filter([$salida, $copia]) as $d) {
    if (!is_dir($d) && !mkdir($d, 0777, true)) {
        salir("No se pudo crear la carpeta: $d");
    }
}

$alumnos = leer_alumnos($cfg['lista']);
echo count($alumnos) . " alumnos en la lista. Curso: {$datos['curso']} ({$datos['horas']} h)\n";

$registros = [];
$vistos = [];

foreach ($alumnos as $al) {
    $nombre = $al['nombre'];
    $dni = $al['dni'];
    $ident = $dni !== '' ? $dni : sanear($nombre);
    // Codigo estable por alumno y curso (HMAC con el token): repetir el lote no crea codigos nuevos,
    // y no se puede deducir del DNI.
    $codigo = 'CERT-' . $codigoCurso . '-' . strtoupper(substr(hash_hmac('sha256', $codigoCurso . '|' . $ident, $token), 0, 10));
    if (isset($vistos[$codigo])) {
        echo "  OMITIDO (repetido en la lista): $nombre\n";
        continue;
    }
    $vistos[$codigo] = true;

    $urlQr = $urlVerificacion . $codigo;
    // (el nombre se acorta: Windows no admite rutas de mas de ~260 caracteres)
    $archivo = rtrim(substr(sanear($nombre), 0, 60), '_') . '_' . $codigo . '.pdf';
    crear_pdf($modelo, $datos, $nombre, $dni, $codigo, $urlQr, $salida . $archivo);
    if ($copia) {
        copy($salida . $archivo, $copia . $archivo);
    }

    $registros[] = [
        'codigo' => $codigo, 'nombre' => $nombre, 'dni' => $dni, 'curso' => $datos['curso'], 'horas' => $datos['horas'],
        'periodo' => $datos['periodo'] ?? '', 'fecha_emision' => $datos['emision'], 'modalidad' => $datos['modalidad'] ?? '', 'marca' => $marca,
        'archivo_pdf' => $archivo, 'url_qr' => $urlQr,
    ];
    echo "  OK  $nombre -> $archivo\n";
}

// _resumen.csv: respaldo para importar a mano (admin > Registro publico) y listado para las asesoras
$csv = "\xEF\xBB\xBF\"Nombre\",\"DNI\",\"Codigo\",\"Archivo\",\"URL_QR\"\n";
foreach ($registros as $r) {
    $csv .= '"' . implode('","', [$r['nombre'], $r['dni'], $r['codigo'], $r['archivo_pdf'], $r['url_qr']]) . "\"\n";
}
file_put_contents($salida . '_resumen.csv', $csv);
if ($copia) {
    copy($salida . '_resumen.csv', $copia . '_resumen.csv');
}
echo "\n" . count($registros) . " certificados generados en $salida\n";

// ---- Registro en la pagina de verificacion ----
if ($soloGenerar) {
    echo "(--solo-generar: NO se registraron en el sitio; importa el _resumen.csv en admin > Registro publico)\n";
    exit(0);
}
$lote = array_map(function ($r) { unset($r['url_qr']); return $r; }, $registros);
$tot = ['registrados' => 0, 'omitidos' => 0];
foreach (array_chunk($lote, 200) as $parte) {
    list($http, $cuerpo) = enviar_registro($urlBase . '/verificar/registrar', $token, $parte);
    $j = json_decode((string) $cuerpo, true);
    if ($http === 200 && !empty($j['ok'])) {
        $tot['registrados'] += (int) $j['registrados'];
        $tot['omitidos'] += (int) $j['omitidos'];
    } else {
        $motivo = $j['error'] ?? trim(substr((string) $cuerpo, 0, 120));
        fwrite(STDERR, "\nNO SE PUDO REGISTRAR en el sitio (HTTP $http: $motivo).\n");
        fwrite(STDERR, "Los PDF estan listos. Importa " . $salida . "_resumen.csv en admin > Registro publico.\n");
        exit(2);
    }
}
echo "Registrados en el sitio: {$tot['registrados']} (omitidos: {$tot['omitidos']}). Ya se pueden verificar en $urlBase/verificar\n";
