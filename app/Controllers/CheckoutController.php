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
        
        $this->view('checkout/index', ['cursoDB' => $cursoDB], false);
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
}
