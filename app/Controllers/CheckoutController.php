<?php
namespace App\Controllers;
require_once __DIR__ . '/../Core/Controller.php';
use App\Core\Controller;

class CheckoutController extends Controller {

    public function index() {
        // Obtenemos los parametros de GET si queremos pasarlos directamente a la vista,
        // aunque el Alpine.js en el frontend ya los lee de la URL.
        $this->view('checkout/index', [], false);
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
                    
                    $studentData = [
                        'dni' => $dni,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'curso' => $curso,
                        'fecha' => date('Y-m-d H:i:s')
                    ];
                    
                    $jsonFileName = 'voucher_' . date('Ymd_His') . '_' . $curso . '.json';
                    file_put_contents($uploadDir . $jsonFileName, json_encode($studentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

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
