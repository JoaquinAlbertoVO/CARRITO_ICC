<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\VisitorLocation;

class VisitorController extends Controller {

    public function saveLocation() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $departamento = $data['departamento'] ?? '';
            $provincia = $data['provincia'] ?? '';
            $distrito = $data['distrito'] ?? '';
            
            if (empty($departamento) || empty($provincia) || empty($distrito)) {
                echo json_encode(['success' => false, 'message' => 'Faltan datos']);
                return;
            }
            
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            
            $model = new VisitorLocation();
            $result = $model->saveLocation($ip, $departamento, $provincia, $distrito);
            
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error en base de datos']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }
}
