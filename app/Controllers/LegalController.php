<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use PDO;

class LegalController extends Controller {
    public function index() {
        header('Location: ' . BASE_URL . 'legal/privacidad');
        exit;
    }

    public function privacidad() {
        $data = [
            'title' => 'Política de Privacidad - ICC',
            'meta_description' => 'Política de Privacidad del Instituto de Capacitación Continua.'
        ];
        $this->view('legal/privacidad', $data);
    }

    public function terminos() {
        $data = [
            'title' => 'Términos de Servicio - ICC',
            'description' => 'Términos de servicio y condiciones de la plataforma del Instituto de Capacitación Continua ICC.'
        ];
        $this->view('legal/terminos', $data);
    }

    public function reclamaciones() {
        $data = [
            'title' => 'Libro de Reclamaciones - ICC',
            'description' => 'Libro de reclamaciones virtual del Instituto de Capacitación Continua.'
        ];
        $this->view('legal/reclamaciones', $data);
    }

    public function reembolsos() {
        $data = [
            'title' => 'Políticas de Reembolso - ICC',
            'description' => 'Políticas de reembolso y devoluciones del Instituto de Capacitación Continua.'
        ];
        $this->view('legal/reembolsos', $data);
    }

    public function procesar_reclamo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Anti-spam Honeypot
            if (!empty($_POST['telefono_falso'])) {
                // Es un bot
                $_SESSION['reclamo_error'] = "Error de validación anti-spam.";
                header('Location: ' . BASE_URL . 'legal/reclamaciones');
                exit;
            }

            $nombres = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $tipo_documento = $_POST['tipo_documento'] ?? '';
            $numero_documento = trim($_POST['numero_documento'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $tipo_bien = $_POST['tipo_bien'] ?? '';
            $monto_reclamado = !empty($_POST['monto_reclamado']) ? $_POST['monto_reclamado'] : null;
            $descripcion_bien = trim($_POST['descripcion_bien'] ?? '');
            $tipo_reclamo = $_POST['tipo_reclamo'] ?? '';
            $detalle_reclamo = trim($_POST['detalle_reclamo'] ?? '');
            $pedido = trim($_POST['pedido'] ?? '');

            if (!$nombres || !$email || !$detalle_reclamo) {
                $_SESSION['reclamo_error'] = "Por favor complete todos los campos obligatorios.";
                header('Location: ' . BASE_URL . 'legal/reclamaciones');
                exit;
            }

            try {
                $db = new Database();
                $pdo = $db->connect();
                
                // Generar código de reclamo único (Ej. 2026-00001)
                $year = date('Y');
                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM libro_reclamaciones WHERE YEAR(fecha_registro) = :year");
                $stmt->execute(['year' => $year]);
                $row = $stmt->fetch();
                $correlativo = str_pad(($row['total'] + 1), 5, '0', STR_PAD_LEFT);
                $codigo_reclamo = $year . '-' . $correlativo;

                $sql = "INSERT INTO libro_reclamaciones 
                        (codigo_reclamo, nombres, apellidos, tipo_documento, numero_documento, direccion, telefono, email, tipo_bien, monto_reclamado, descripcion_bien, tipo_reclamo, detalle_reclamo, pedido) 
                        VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $codigo_reclamo, $nombres, $apellidos, $tipo_documento, $numero_documento, 
                    $direccion, $telefono, $email, $tipo_bien, $monto_reclamado, 
                    $descripcion_bien, $tipo_reclamo, $detalle_reclamo, $pedido
                ]);

                // Enviar correo de confirmación al cliente y a admin
                $subject = "Libro de Reclamaciones: Registro " . $codigo_reclamo;
                $body = "Se ha registrado su reclamo exitosamente.\n\nCódigo: $codigo_reclamo\nNombres: $nombres $apellidos\nTipo: $tipo_reclamo\nDetalle: $detalle_reclamo\nPedido: $pedido\n\nNos contactaremos a la brevedad.";
                
                $headers = "From: ICC Reclamos <informes@icc.com.pe>\r\n";
                // Enviar al cliente
                @mail($email, $subject, $body, $headers);
                // Enviar al admin
                @mail("informes@icc.com.pe", "Nuevo Reclamo Recibido - " . $codigo_reclamo, "Nuevo reclamo de $nombres $apellidos.\nCódigo: $codigo_reclamo\nRevisa la BD para detalles.", $headers);

                $_SESSION['reclamo_exito'] = ['codigo' => $codigo_reclamo];
                header('Location: ' . BASE_URL . 'legal/reclamaciones');
                exit;

            } catch (\Exception $e) {
                $_SESSION['reclamo_error'] = "Ocurrió un error al registrar el reclamo. Inténtelo más tarde. (" . $e->getMessage() . ")";
                header('Location: ' . BASE_URL . 'legal/reclamaciones');
                exit;
            }
        }
    }
}
