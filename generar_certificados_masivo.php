<?php
// Script temporal de generación masiva de certificados.
// Ejecutar una sola vez: php generar_certificados_masivo.php
// Se puede borrar después de usarlo.

require_once __DIR__ . '/app/Models/Certificado.php';
require_once __DIR__ . '/app/Libraries/phpqrcode/qrlib.php';
require_once __DIR__ . '/app/Libraries/fpdf/fpdf.php';

$BASE_URL = 'https://icc.com.pe/';

$curso = 'Especialización de Electricidad Industrial';
$codigo_curso = 'EEI';
$horas = '30';
$categoria = '';
$texto_realizado = 'Realizado del 1 de Setiembre al 19 de Setiembre del 2026';
$fecha_emision = '20 de Setiembre del 2026';

$alumnos = [
    ['nombre' => 'Ivan Pineda Lopez',                    'dni' => ''],
    ['nombre' => 'Juan Carlos Espíritu Maguiña',          'dni' => '80235799'],
    ['nombre' => 'Royer Franklin Mercado Clasina',        'dni' => '71411022'],
    ['nombre' => 'Jeferson Rodolfo Aliaga Aguedo',        'dni' => '48185736'],
    ['nombre' => 'Luis Cuesta',                           'dni' => ''],
    ['nombre' => 'Raul Arce',                             'dni' => '75583811'],
    ['nombre' => 'Ciro Torrico Lopez',                    'dni' => '08259088'],
    ['nombre' => 'Carlos Augusto Fernández Chafloque',    'dni' => '16791432'],
    ['nombre' => 'Jefferson Herbacio Ibarra',             'dni' => '73348435'],
    ['nombre' => 'Oscar Alberto Cervantes Uscanga',       'dni' => ''],
    ['nombre' => 'Marlon Steven Vargas De La Cruz',       'dni' => '71327759'],
    ['nombre' => 'Jhon Michel Pariona Achull',            'dni' => '60049684'],
    ['nombre' => 'Mauricio Javier Chaman Ramos',          'dni' => '46082853'],
];

function quitar_acentos($str) {
    $map = [
        'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
        'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',
        'ñ'=>'n','Ñ'=>'N','ü'=>'u','Ü'=>'U',
    ];
    return strtr($str, $map);
}

function sanear($texto) {
    $texto = quitar_acentos($texto);
    $texto = preg_replace('/[^A-Za-z0-9]/', '_', $texto);
    $texto = preg_replace('/_+/', '_', $texto);
    return strtoupper(trim($texto, '_'));
}

$curso_saneado = sanear($curso);

$dir_repo = __DIR__ . '/assets/certificados/' . $curso_saneado . '/';
$dir_escritorio = 'C:/Users/Joaquin/Desktop/Certificados_' . $curso_saneado . '/';

foreach ([$dir_repo, $dir_escritorio] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    // Limpiar archivos de una corrida anterior (nombres antiguos incluidos)
    foreach (glob($dir . '*.pdf') as $viejo) {
        unlink($viejo);
    }
}

$font_bold = __DIR__ . '/app/Views/admin/cursos/arialbd.ttf';

$certModel = new \App\Models\Certificado();

$log = [];

foreach ($alumnos as $al) {
    $nombre = trim($al['nombre']);
    $dni = trim($al['dni']);

    $imagen = $certModel->generarImagenCertificado($nombre, $dni, $curso, $horas, $fecha_emision, $categoria, $texto_realizado);

    $nombre_saneado = sanear($nombre);
    $identificador = $dni !== '' ? $dni : $nombre_saneado;
    $codigo = 'CERT-' . $codigo_curso . '-' . str_replace('_', '-', $identificador);

    // Dibujar el código sobre la imagen, arriba de la fecha de emisión
    $blanco = imagecolorallocate($imagen, 255, 255, 255);
    imagettftext($imagen, 18, 0, 80, 1115, $blanco, $font_bold, "Código: " . $codigo);

    $filename_base = $codigo;

    $filepath_jpg = $dir_repo . $filename_base . '.jpg';
    imagejpeg($imagen, $filepath_jpg, 100);
    imagedestroy($imagen);

    $filename_pdf = $filename_base . '.pdf';
    $filepath_pdf = $dir_repo . $filename_pdf;

    $url_qr = $BASE_URL . 'assets/certificados/' . $curso_saneado . '/' . $filename_pdf;
    $filepath_qr = $dir_repo . $filename_base . '_qr.png';

    $old_error_reporting = error_reporting();
    error_reporting($old_error_reporting & ~E_DEPRECATED & ~E_USER_DEPRECATED);
    \QRcode::png($url_qr, $filepath_qr, QR_ECLEVEL_M, 10, 0);
    error_reporting($old_error_reporting);

    $pdf = new \FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->Image($filepath_jpg, 0, 0, 297, 210);
    $pdf->Image($filepath_qr, 13.4, 174.7, 27.5, 27.5);
    $pdf->Output('F', $filepath_pdf);

    if (file_exists($filepath_jpg)) unlink($filepath_jpg);
    if (file_exists($filepath_qr)) unlink($filepath_qr);

    // Copiar también al escritorio para las asesoras
    copy($filepath_pdf, $dir_escritorio . $filename_pdf);

    $log[] = [
        'nombre' => $nombre,
        'dni' => $dni !== '' ? $dni : '(SIN DNI)',
        'codigo' => $codigo,
        'url_qr' => $url_qr,
        'archivo' => $filename_pdf,
    ];

    echo "OK: {$nombre} -> {$filename_pdf}\n";
}

echo "\nListo. " . count($log) . " certificados generados.\n";
echo "Repo: {$dir_repo}\n";
echo "Escritorio: {$dir_escritorio}\n";

$csv = "Nombre,DNI,Codigo,Archivo,URL_QR\n";
foreach ($log as $row) {
    $csv .= '"' . $row['nombre'] . '","' . $row['dni'] . '","' . $row['codigo'] . '","' . $row['archivo'] . '","' . $row['url_qr'] . "\"\n";
}
file_put_contents($dir_escritorio . '_resumen.csv', $csv);
echo "Resumen guardado en: {$dir_escritorio}_resumen.csv\n";
