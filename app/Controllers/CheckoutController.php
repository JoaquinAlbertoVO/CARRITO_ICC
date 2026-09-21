<?php
namespace App\Controllers;
require_once __DIR__ . '/../Core/Controller.php';
use App\Core\Controller;

class CheckoutController extends Controller {

    public function index() {
        $nombreCurso = isset($_GET['curso']) ? trim($_GET['curso']) : '';

        require_once __DIR__ . '/../Models/Curso.php';
        $cursoModel = new \App\Models\Curso();
        $cursoDB = $cursoModel->getCursoByNombre($nombreCurso);

        // Detecta el pais del visitante por IP para sugerir moneda y medios de pago
        // por defecto (?moneda= en la URL sigue pudiendo forzarlo manualmente).
        require_once __DIR__ . '/../Helpers/GeoHelper.php';
        // ?pais=XX es solo para pruebas (forzar "como si" fueramos de otro pais sin
        // depender de la IP real) - nunca lo use un link promocional real.
        $paisDetectado = isset($_GET['pais'])
            ? strtoupper(trim($_GET['pais']))
            : \App\Helpers\GeoHelper::detectarPais();
        $reglasPais = \App\Helpers\GeoHelper::reglasParaPais($paisDetectado);

        // Link de pago de Hotmart para este curso (si existe), para ofrecerlo como
        // alternativa con mas metodos locales a compradores fuera de Peru.
        require_once __DIR__ . '/../Helpers/HotmartLinks.php';
        $hotmartLink = \App\Helpers\HotmartLinks::buscarPorNombre($nombreCurso);

        // Hotmart cobra el precio fijo que se configuro en su producto, asi que si el link
        // trae un precio promocional (?precio= distinto al de lista, o un codigo ?p=) no
        // podemos mandar al comprador ahi: pagaria un monto distinto al del link.
        $precioUrl = isset($_GET['precio']) ? (float)$_GET['precio'] : null;
        $esPrecioLista = $cursoDB && $precioUrl !== null
            && (abs($precioUrl - (float)$cursoDB['precio']) < 0.01
                || abs($precioUrl - (float)$cursoDB['precio_usd']) < 0.01);
        if (!empty($_GET['p']) || ($precioUrl !== null && !$esPrecioLista)) {
            $hotmartLink = null;
        }

        // ?oferta=clave: reemplaza "Temas Principales" solo para este link (ver OfertasCheckout).
        // Si la oferta tiene su propia oferta en Hotmart al precio promocional, se usa ese
        // link (aunque el precio del link no sea el de lista).
        $hotmartOferta = false;
        if ($cursoDB && !empty($_GET['oferta'])) {
            require_once __DIR__ . '/../Helpers/OfertasCheckout.php';
            $monedaLink = strtoupper(trim($_GET['moneda'] ?? $reglasPais['moneda']));
            $linkOfertaHotmart = \App\Helpers\OfertasCheckout::hotmartLink($_GET['oferta'], $monedaLink);
            if ($linkOfertaHotmart !== null) {
                $hotmartLink = $linkOfertaHotmart;
                $hotmartOferta = true;
            }
            $cursoDB = \App\Helpers\OfertasCheckout::ajustarCurso($_GET['oferta'], $cursoDB);
            $temasOferta = \App\Helpers\OfertasCheckout::temasHtml($_GET['oferta']);
            if ($temasOferta !== null) {
                $cursoDB['temas'] = $temasOferta;
            }
            $extra = \App\Helpers\OfertasCheckout::extraAcordeon($_GET['oferta']);
            if ($extra !== null) {
                $cursoDB['extra_titulo'] = $extra['titulo'];
                $cursoDB['extra_html'] = $extra['html'];
            }
        }

        // ?hm=clave: link de prueba que fuerza el recuadro de Hotmart con una oferta de prueba
        // (ver OfertasCheckout::HOTMART_PRUEBAS); solo acepta claves de esa lista.
        if ($cursoDB && !empty($_GET['hm'])) {
            require_once __DIR__ . '/../Helpers/OfertasCheckout.php';
            $linkPrueba = \App\Helpers\OfertasCheckout::HOTMART_PRUEBAS[(string)$_GET['hm']] ?? null;
            if ($linkPrueba !== null) {
                $hotmartLink = $linkPrueba;
                $hotmartOferta = true;
                $reglasPais['metodos'] = ['hotmart'];
            }
        }

        // ?diseno=2: pagina de checkout nueva (checkout/v2.php), solo para ofertas con etapas de
        // precio (OfertasCheckout). El precio lo decide el servidor por fecha, no el link.
        if (($_GET['diseno'] ?? '') === '2' && !empty($_GET['oferta'])) {
            $vistaV2 = $this->datosV2((string)$_GET['oferta'], $cursoDB, $paisDetectado, $reglasPais);
            if ($vistaV2 !== null) {
                $this->view('checkout/v2', $vistaV2, false);
                return;
            }
        }

        $this->view('checkout/index', [
            'cursoDB' => $cursoDB,
            'paisDetectado' => $paisDetectado,
            'monedaSugerida' => $reglasPais['moneda'],
            'metodosDisponibles' => $reglasPais['metodos'],
            'hotmartLink' => $hotmartLink,
            'hotmartOferta' => $hotmartOferta,
        ], false);
    }

    /**
     * Datos para checkout/v2.php: precio por etapa segun la fecha (hora de Lima), medios de
     * pago segun el pais y contenido real de la oferta. Devuelve null si la oferta no tiene etapas.
     */
    private function datosV2($clave, $cursoDB, $pais, $reglasPais) {
        require_once __DIR__ . '/../Helpers/OfertasCheckout.php';
        $cfg = \App\Helpers\OfertasCheckout::config($clave);
        if (!$cfg || empty($cfg['etapas'])) {
            return null;
        }

        $moneda = strtoupper(trim($_GET['moneda'] ?? $reglasPais['moneda']));
        if (!in_array($moneda, ['PEN', 'USD'], true)) {
            $moneda = $reglasPais['moneda'];
        }
        $k = $moneda === 'USD' ? 'usd' : 'pen';

        $tz = new \DateTimeZone('America/Lima');
        $etapas = $cfg['etapas'];
        $idx = \App\Helpers\OfertasCheckout::etapaActual($clave);
        $actual = $etapas[$idx];
        $regular = end($etapas);
        $simbolo = $moneda === 'USD' ? 'US$ ' : 'S/ ';

        // Tarjetas de la escalera de precios
        $lista = [];
        foreach ($etapas as $i => $e) {
            if (!empty($e['hasta'])) {
                $rango = 'Hasta el ' . \App\Helpers\OfertasCheckout::fechaLarga($e['hasta'], false);
            } else {
                $prev = $etapas[$i - 1]['hasta'] ?? null;
                $rango = $prev ? 'Desde el ' . \App\Helpers\OfertasCheckout::fechaLarga(date('Y-m-d', strtotime($prev . ' +1 day')), false) : 'Precio de lista';
            }
            $lista[] = [
                'nombre' => $e['nombre'],
                'rango' => $rango,
                'precio' => $e[$k],
                'estado' => $i < $idx ? 'pasada' : ($i === $idx ? 'actual' : 'proxima'),
            ];
        }

        // Aviso del proximo aumento y cuenta regresiva real hasta el fin de la etapa vigente
        $aviso = null;
        $hastaMs = null;
        if (!empty($actual['hasta']) && isset($etapas[$idx + 1])) {
            $sube = date('Y-m-d', strtotime($actual['hasta'] . ' +1 day'));
            $aviso = 'Desde el ' . \App\Helpers\OfertasCheckout::fechaLarga($sube, false) . ' el precio sube a ' . $simbolo . number_format($etapas[$idx + 1][$k], 2);
            $hastaMs = (new \DateTime($actual['hasta'] . ' 23:59:59', $tz))->getTimestamp() * 1000;
        }
        $descuento = $regular[$k] > 0 ? (int)round((1 - $actual[$k] / $regular[$k]) * 100) : 0;

        // Hotmart solo si el pais lo permite (GeoHelper) Y hay una oferta con el precio de esta etapa
        $metodos = $reglasPais['metodos'];
        $linkHotmart = $actual['hotmart'][$moneda] ?? null;
        if (!$linkHotmart) {
            $metodos = array_values(array_diff($metodos, ['hotmart']));
        }

        // Beneficios reales de la BD (sin los que se quitan para esta oferta) + acceso de por vida
        $beneficios = [];
        if ($cursoDB) {
            $cursoDB = \App\Helpers\OfertasCheckout::ajustarCurso($clave, $cursoDB);
            if (preg_match_all('/<li>(.*?)<\/li>/is', $cursoDB['beneficios'] ?? '', $m)) {
                foreach ($m[1] as $li) {
                    $beneficios[] = trim(strip_tags($li));
                }
            }
        }
        array_unshift($beneficios, 'Acceso de por vida al aula virtual');

        // Sesiones del cronograma
        $sesiones = [];
        foreach ($cfg['sesiones'] ?? [] as $n => $f) {
            $sesiones[] = ['n' => $n + 1, 'fecha' => \App\Helpers\OfertasCheckout::fechaLarga($f)];
        }

        // Imagenes reales (testimonios, galeria): si la carpeta esta vacia, la seccion no se muestra
        $imagenes = function ($carpeta) {
            $dir = __DIR__ . '/../../assets/images/' . $carpeta . '/';
            $out = [];
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                foreach (glob($dir . '*.' . $ext) ?: [] as $f) {
                    $out[] = BASE_URL . 'assets/images/' . $carpeta . '/' . basename($f);
                }
            }
            sort($out);
            return $out;
        };

        return [
            'clave' => $clave,
            'curso' => $cfg['curso'],
            'titulo' => $cfg['titulo'],
            'subtitulo' => $cfg['subtitulo'],
            'horas' => $cfg['horas'],
            'inicioLargo' => \App\Helpers\OfertasCheckout::fechaLarga($cfg['inicio']),
            'inicioCorto' => \App\Helpers\OfertasCheckout::fechaLarga($cfg['inicio'], false),
            'docente' => $cfg['docente'],
            'video' => $cfg['video'] ?? null,
            'hora' => $cfg['hora'] ?? '',
            'sesiones' => $sesiones,
            'temas' => $cfg['temas'],
            'extra' => $cfg['extra'] ?? null,
            'beneficios' => $beneficios,
            'etapas' => $lista,
            'etapaNombre' => $actual['nombre'],
            'aviso' => $aviso,
            'descuento' => $descuento,
            'moneda' => $moneda,
            'simbolo' => $simbolo,
            'precio' => $actual[$k],
            'precioRegular' => $regular[$k],
            'testimonios' => $imagenes('testimonios'),
            'galeria' => $imagenes('galeria'),
            'paisDetectado' => $pais,
            'metodos' => $metodos,
            'js' => [
                'curso' => $cfg['curso'],
                'moneda' => $moneda,
                'precioPen' => $actual['pen'],
                'precioUsd' => $actual['usd'],
                'tipoCambio' => 3.80,
                'metodos' => $metodos,
                'hotmart' => $linkHotmart,
                'hastaMs' => $hastaMs,
                'base' => BASE_URL,
            ],
        ];
    }

    public function voucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            
            if (isset($_FILES['voucher']) && $_FILES['voucher']['error'] === UPLOAD_ERR_OK) {
                $curso = isset($_POST['curso']) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['curso']) : 'curso_desconocido';
                $uploadDir = __DIR__ . '/../../assets/img/vouchers/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExt = strtolower(pathinfo($_FILES['voucher']['name'], PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
                
                if (!in_array($fileExt, $allowedExts)) {
                    echo json_encode(['success' => false, 'error' => 'Formato no permitido (solo JPG, PNG, PDF)']);
                    return;
                }

                $fileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.' . $fileExt;
                $destination = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['voucher']['tmp_name'], $destination)) {
                    
                    // Guardar datos del estudiante en un JSON
                    $dni = isset($_POST['dni']) ? strip_tags($_POST['dni']) : '';
                    $nombre = isset($_POST['nombre']) ? strip_tags($_POST['nombre']) : '';
                    $apellido = isset($_POST['apellido']) ? strip_tags($_POST['apellido']) : '';
                    $celular = isset($_POST['celular']) ? strip_tags($_POST['celular']) : '';
                    
                    $studentData = [
                        'dni' => $dni,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'celular' => $celular,
                        'curso' => $curso,
                        'fecha' => date('Y-m-d H:i:s')
                    ];
                    
                    $jsonFileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.json';
                    file_put_contents($uploadDir . $jsonFileName, json_encode($studentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                    // --- ALERTA POR WHATSAPP (CALLMEBOT) ---
                    // IMPORTANTE: Reemplaza estos datos con tu numero y tu API key de CallMeBot
                    $whatsapp_phone = ""; // Ej: +51999999999 (con el simbolo + y el codigo de pais)
                    $whatsapp_apikey = ""; // Ej: 123456
                    
                    if (!empty($whatsapp_phone) && !empty($whatsapp_apikey)) {
                        $mensaje_wa = "💰 *¡NUEVO PAGO REGISTRADO!* 💰\n\n";
                        $mensaje_wa .= "👤 *Alumno:* " . $nombre . " " . $apellido . "\n";
                        $mensaje_wa .= "🪪 *DNI:* " . $dni . "\n";
                        $mensaje_wa .= "📱 *Celular:* " . $celular . "\n";
                        $mensaje_wa .= "🎓 *Curso:* " . str_replace('_', ' ', $curso) . "\n\n";
                        $mensaje_wa .= "Revisa tu panel de administración para ver el voucher subido.";
                        
                        $url_wa = "https://api.callmebot.com/whatsapp.php?phone=" . urlencode($whatsapp_phone) . "&text=" . urlencode($mensaje_wa) . "&apikey=" . urlencode($whatsapp_apikey);
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url_wa);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout corto para no retrasar al usuario
                        curl_exec($ch);
                        curl_close($ch);
                    }
                    // ----------------------------------------

                    echo json_encode(['success' => true, 'file' => $fileName]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error al mover el archivo']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'No se subio el archivo o hubo un error en la subida']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
        }
    }

    /**
     * El navegador llega aqui despues de que el boton de PayPal reporta "capture" exitoso.
     * NO nos fiamos de eso: volvemos a preguntarle a PayPal (servidor a servidor) el estado
     * real de esa orden, y solo si PayPal confirma COMPLETED guardamos la venta y matriculamos
     * al alumno. Asi una orden nunca queda sin registro, y nadie puede "forzar" el exito desde
     * la consola del navegador sin haber pagado de verdad.
     */
    public function paypal_confirm() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        // n_operacion y dni son varchar(100)/varchar(20) en la tabla usuario: recortamos
        // aqui para que un ID de orden o un documento fuera de rango nunca tumbe el insert
        // completo (esto es justo lo que le paso al webhook de Hotmart con su dato de prueba).
        $orderId  = isset($input['orderID']) ? substr(trim($input['orderID']), 0, 100) : '';
        $curso    = isset($input['curso']) ? trim($input['curso']) : 'Curso no identificado';
        $dni      = isset($input['dni']) ? substr(strip_tags(trim($input['dni'])), 0, 20) : '';
        $nombre   = isset($input['nombre']) ? strip_tags(trim($input['nombre'])) : '';
        $apellido = isset($input['apellido']) ? strip_tags(trim($input['apellido'])) : '';
        $celular  = isset($input['celular']) ? strip_tags(trim($input['celular'])) : '';

        if (empty($orderId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Falta el orderID de PayPal']);
            return;
        }

        require_once __DIR__ . '/../Libraries/PayPalClient.php';
        require_once __DIR__ . '/../Core/Database.php';

        $logFile = __DIR__ . '/../../api/paypal_log.txt';

        try {
            $paypal = new \App\Libraries\PayPalClient();
            $order = $paypal->verifyOrder($orderId);
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR VERIFICACION: " . $e->getMessage() . " (Orden $orderId)\n", FILE_APPEND);
            http_response_code(502);
            echo json_encode(['success' => false, 'error' => 'No se pudo verificar el pago con PayPal. Intenta de nuevo o escribenos por el chat con tu numero de orden: ' . $orderId]);
            return;
        }

        // Fuente de verdad: el estado que PayPal reporta de su propia orden, nunca lo que diga el navegador
        if (empty($order['status']) || $order['status'] !== 'COMPLETED') {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | RECHAZADO (estado " . ($order['status'] ?? 'desconocido') . "): Orden $orderId\n", FILE_APPEND);
            http_response_code(402);
            echo json_encode(['success' => false, 'error' => 'PayPal no confirma este pago como completado.']);
            return;
        }

        $purchaseUnit  = $order['purchase_units'][0] ?? [];
        $monto         = $purchaseUnit['amount']['value'] ?? 0;
        $monedaPagada  = $purchaseUnit['amount']['currency_code'] ?? 'USD';

        // Piso de seguridad: el precio viaja en el navegador (?precio=), asi que no se matricula un
        // pago MUY por debajo del precio de lista del curso (ej. alguien que edito el link a 0.10).
        // El piso es solo el 20 % de la lista, para no afectar promociones reales (S/ 39.90 = 22 %).
        // Nota: pruebas de centavos por este checkout ya no matriculan (usar Hotmart o una oferta real).
        try {
            require_once __DIR__ . '/../Models/Curso.php';
            $cursoLista = (new \App\Models\Curso())->getCursoByNombre($curso);
            if ($cursoLista && (float)($cursoLista['precio'] ?? 0) > 0 && $monedaPagada === 'USD') {
                $pisoUsd = ((float)$cursoLista['precio'] / 3.80) * 0.20;
                if ((float)$monto < $pisoUsd) {
                    file_put_contents($logFile, date('Y-m-d H:i:s') . " | MONTO SOSPECHOSO (pago $monto $monedaPagada, piso " . round($pisoUsd, 2) . "): Orden $orderId - Curso: $curso - NO matriculado\n", FILE_APPEND);
                    http_response_code(402);
                    echo json_encode(['success' => false, 'error' => 'El monto pagado no coincide con el precio del curso. Escribenos por el chat con tu numero de orden: ' . $orderId]);
                    return;
                }
            }
        } catch (\Throwable $e) {
            // Si no se puede validar el precio, no bloqueamos una venta que PayPal ya confirmo
        }

        $payer         = $order['payer'] ?? [];
        $emailPaypal   = $payer['email_address'] ?? '';
        $nombrePaypal  = trim(($payer['name']['given_name'] ?? '') . ' ' . ($payer['name']['surname'] ?? ''));

        // Preferimos los datos que el alumno escribio (para el certificado); si faltan, usamos los de PayPal
        $nombreFinal = $nombre !== '' ? trim($nombre . ' ' . $apellido) : ($nombrePaypal ?: 'Alumno PayPal');
        $emailFinal  = $emailPaypal ?: (preg_replace('/[^a-z0-9]/', '', strtolower($nombreFinal)) . '_' . substr($orderId, -6) . '@paypal.icc.com.pe');

        try {
            $db = new \App\Core\Database();
            $pdo = $db->connect();

            // Evitar duplicar la venta si el navegador reintenta este fetch (ej. el usuario recarga)
            $stmtDup = $pdo->prepare("SELECT iduser FROM usuario WHERE n_operacion = ? AND banco = 'PAYPAL' LIMIT 1");
            $stmtDup->execute([$orderId]);
            $existente = $stmtDup->fetch();

            $esCuentaNueva = false;

            if ($existente) {
                $id_usuario = $existente['iduser'];
            } else {
                $stmtUser = $pdo->prepare("SELECT iduser FROM usuario WHERE correo = ? LIMIT 1");
                $stmtUser->execute([$emailFinal]);
                $user = $stmtUser->fetch();

                if ($user) {
                    $id_usuario = $user['iduser'];
                } else {
                    $esCuentaNueva = true;
                    $password = substr(md5(uniqid()), 0, 8);
                    $sql = "INSERT INTO usuario (id_pla, nombre, correo, usuario, password, dni, telefono, n_operacion, m_pagado, banco, fecha_deposito, estatus)
                            VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, 'PAYPAL', NOW(), 1)";
                    $stmtInsert = $pdo->prepare($sql);
                    $stmtInsert->execute([$nombreFinal, $emailFinal, $emailFinal, $password, $dni, $celular, $orderId, $monto]);
                    $id_usuario = $pdo->lastInsertId();
                }
            }

            // Matricular en el curso (mismo criterio que ya usa el webhook de Hotmart)
            $stmtCurso = $pdo->prepare("SELECT id_curso FROM cursos WHERE nombre_curso LIKE ? LIMIT 1");
            $stmtCurso->execute(['%' . substr($curso, 0, 15) . '%']);
            $cursoData = $stmtCurso->fetch();

            if ($cursoData) {
                $id_curso = $cursoData['id_curso'];
                // La PK real de usuario_cursos es id_matricula, no "id" (mismo bug que tenia
                // el webhook de Hotmart original, heredado antes de que lo descubrieramos).
                $stmtCheck = $pdo->prepare("SELECT id_matricula FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?");
                $stmtCheck->execute([$id_usuario, $id_curso]);
                if (!$stmtCheck->fetch()) {
                    $stmtLink = $pdo->prepare("INSERT INTO usuario_cursos (id_usuario, id_curso) VALUES (?, ?)");
                    $stmtLink->execute([$id_usuario, $id_curso]);
                }
            }

            file_put_contents($logFile, date('Y-m-d H:i:s') . " | VENTA PAYPAL OK: $nombreFinal ($emailFinal) - Orden $orderId - $monto $monedaPagada - Curso: $curso\n", FILE_APPEND);

            // Solo a cuentas nuevas: mandar las credenciales por correo
            if ($esCuentaNueva) {
                require_once __DIR__ . '/../Helpers/Mailer.php';
                $enviado = \App\Helpers\Mailer::enviarBienvenida($emailFinal, $nombreFinal, $emailFinal, $password, $curso);
                file_put_contents($logFile, date('Y-m-d H:i:s') . ' | ' . ($enviado ? 'Correo de bienvenida enviado a ' : 'FALLO al enviar correo de bienvenida a ') . "$emailFinal\n", FILE_APPEND);
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR BD: " . $e->getMessage() . " (Orden $orderId, ya pagada en PayPal)\n", FILE_APPEND);
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Tu pago en PayPal fue exitoso pero hubo un error al registrarlo. Escribenos por el chat con tu numero de orden: ' . $orderId]);
        }
    }

    // ============================================================
    // CHECKOUT DE ST ENERGY (marca aparte, matricula en WordPress
    // via la API del sistema react-cours, no toca la BD de ICC)
    // ============================================================

    public function stenergy() {
        $this->view('checkout/stenergy', [], false);
    }

    public function stenergy_confirm() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        $orderId  = isset($input['orderID']) ? substr(trim($input['orderID']), 0, 100) : '';
        $dni      = isset($input['dni']) ? substr(strip_tags(trim($input['dni'])), 0, 20) : '';
        $nombre   = isset($input['nombre']) ? strip_tags(trim($input['nombre'])) : '';
        $apellido = isset($input['apellido']) ? strip_tags(trim($input['apellido'])) : '';
        $celular  = isset($input['celular']) ? substr(strip_tags(trim($input['celular'])), 0, 50) : '';
        $email    = isset($input['email']) ? strip_tags(trim($input['email'])) : '';

        if (empty($orderId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Falta el orderID de PayPal']);
            return;
        }

        require_once __DIR__ . '/../Libraries/PayPalClient.php';
        require_once __DIR__ . '/../Libraries/StEnergyClient.php';

        $logFile = __DIR__ . '/../../api/stenergy_log.txt';

        // 1. Verificar la orden contra PayPal (misma cuenta que ICC, servidor a servidor)
        try {
            $paypal = new \App\Libraries\PayPalClient();
            $order = $paypal->verifyOrder($orderId);
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . ' | ERROR VERIFICACION: ' . $e->getMessage() . " (Orden $orderId)\n", FILE_APPEND);
            http_response_code(502);
            echo json_encode(['success' => false, 'error' => 'No se pudo verificar el pago con PayPal.']);
            return;
        }

        if (empty($order['status']) || $order['status'] !== 'COMPLETED') {
            file_put_contents($logFile, date('Y-m-d H:i:s') . ' | RECHAZADO (estado ' . ($order['status'] ?? 'desconocido') . "): Orden $orderId\n", FILE_APPEND);
            http_response_code(402);
            echo json_encode(['success' => false, 'error' => 'PayPal no confirma este pago como completado.']);
            return;
        }

        $purchaseUnit = $order['purchase_units'][0] ?? [];
        $monto        = $purchaseUnit['amount']['value'] ?? 0;
        $monedaPagada = $purchaseUnit['amount']['currency_code'] ?? 'USD';
        $payer        = $order['payer'] ?? [];
        $emailPaypal  = $payer['email_address'] ?? '';

        $emailFinal  = $email ?: $emailPaypal;
        $nombrePaypal = trim(($payer['name']['given_name'] ?? '') . ' ' . ($payer['name']['surname'] ?? ''));
        $nombreFinal = $nombre !== '' ? trim($nombre . ' ' . $apellido) : ($nombrePaypal ?: 'Alumno ST Energy');

        if (empty($emailFinal)) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR: pago confirmado pero sin correo del comprador (Orden $orderId)\n", FILE_APPEND);
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Tu pago fue exitoso pero nos falta tu correo para matricularte. Escribenos por WhatsApp con tu numero de orden: ' . $orderId]);
            return;
        }

        // 2. Matricular en WordPress via enroll-wp.
        // Curso 1: "Terminaciones Termocontraibles - 29/09/2026" (course_id confirmado: 4043)
        $resultadoTerminaciones = null;
        try {
            $stEnergy = new \App\Libraries\StEnergyClient();
            $res = $stEnergy->enrollCourse(4043, $emailFinal, $nombreFinal, $dni);
            $resultadoTerminaciones = $res['data'];
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ENROLL Terminaciones Termocontraibles (course_id 4043): HTTP {$res['code']} - {$res['raw']} ($nombreFinal / $emailFinal)\n", FILE_APPEND);
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . ' | ERROR ENROLL Terminaciones: ' . $e->getMessage() . " ($nombreFinal / $emailFinal)\n", FILE_APPEND);
        }

        // Curso 2: "Empalmes Termocontraibles - 29/09/2026" - TODAVIA NO EXISTE EN WORDPRESS
        // (confirmado con el equipo). En cuanto lo creen alla, reemplazar este bloque por
        // otra llamada a enrollCourse() con el course_id real, igual que arriba.
        file_put_contents($logFile, date('Y-m-d H:i:s') . " | PENDIENTE MANUAL: falta matricular tambien en 'Empalmes Termocontraibles - 29/09/2026' (el curso aun no existe en WordPress) - $nombreFinal ($emailFinal) - Orden $orderId\n", FILE_APPEND);

        file_put_contents($logFile, date('Y-m-d H:i:s') . " | VENTA ST ENERGY OK: $nombreFinal ($emailFinal) - Orden $orderId - $monto $monedaPagada - DNI $dni - Cel $celular\n", FILE_APPEND);

        echo json_encode([
            'success' => true,
            'enrollTerminaciones' => $resultadoTerminaciones,
        ]);
    }

    /**
     * Comprobante de Yape/Plin subido desde el checkout de ST Energy. Mismo patron
     * que CheckoutController::voucher() (ICC), pero en su propia carpeta -- el
     * equipo de ST Energy lo revisa a mano y registra la venta en su propio
     * sistema (react-cours), como ya hacen hoy con sus comprobantes.
     */
    public function stenergy_voucher() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
            return;
        }

        if (!isset($_FILES['voucher']) || $_FILES['voucher']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'No se subio el archivo o hubo un error en la subida']);
            return;
        }

        $curso = isset($_POST['curso']) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['curso']) : 'curso_desconocido';
        $uploadDir = __DIR__ . '/../../assets/img/vouchers_stenergy/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($_FILES['voucher']['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($fileExt, $allowedExts)) {
            echo json_encode(['success' => false, 'error' => 'Formato no permitido (solo JPG, PNG, PDF)']);
            return;
        }

        $fileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.' . $fileExt;
        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['voucher']['tmp_name'], $destination)) {
            echo json_encode(['success' => false, 'error' => 'Error al mover el archivo']);
            return;
        }

        $studentData = [
            'email'    => isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '',
            'dni'      => isset($_POST['dni']) ? strip_tags(trim($_POST['dni'])) : '',
            'nombre'   => isset($_POST['nombre']) ? strip_tags(trim($_POST['nombre'])) : '',
            'apellido' => isset($_POST['apellido']) ? strip_tags(trim($_POST['apellido'])) : '',
            'celular'  => isset($_POST['celular']) ? strip_tags(trim($_POST['celular'])) : '',
            'curso'    => $curso,
            'precio'   => isset($_POST['precio']) ? strip_tags(trim($_POST['precio'])) : '',
            'moneda'   => isset($_POST['moneda']) ? strip_tags(trim($_POST['moneda'])) : '',
            'metodo'   => isset($_POST['metodo']) ? strip_tags(trim($_POST['metodo'])) : '',
            'fecha'    => date('Y-m-d H:i:s'),
        ];

        $jsonFileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.json';
        file_put_contents($uploadDir . $jsonFileName, json_encode($studentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo json_encode(['success' => true, 'file' => $fileName]);
    }
}
