<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $cursoModel = new \App\Models\Curso();
        $cursos_db = $cursoModel->getCursos(1);
        
        $ingenieria_courses = [];
        
        $remove_keywords = [
            'stenergy',
            'puesta a tierra',
            'p.l.c',
            'plc',
            'electricidad basica',
            'electricidad básica',
            'canalizaci'
        ];

        foreach ($cursos_db as $c) {
            $nombre_lower = mb_strtolower($c['nombre_curso'], 'UTF-8');
            
            $should_remove = false;
            foreach ($remove_keywords as $rk) {
                if (mb_strpos($nombre_lower, $rk, 0, 'UTF-8') !== false) {
                    $should_remove = true;
                    break;
                }
            }
            if ($should_remove) continue;

            $cat = mb_strtolower($c['categoria'] ?? '', 'UTF-8');
            if ($cat === 'ingeniería' || $cat === 'ingenieria' || $cat === '') {
                $slug_tmp = mb_strtolower($c['nombre_curso'], 'UTF-8');
                $slug_tmp = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $slug_tmp);
                $slug = str_replace(' ', '_', $slug_tmp);
                $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                $slug = str_replace('_', '-', $slug);


                $precioPreventa = 89.90;
                $precioPreventaUSD = 30.00;
                $fechaProx = 'PRÓXIMAMENTE';
                $horas = $c['horas_academicas'] . " hrs";
                
                $nombreCursoSafe = mb_strtolower($c['nombre_curso'] ?? '', 'UTF-8');
                
                if (strpos($nombreCursoSafe, 'subestaciones') !== false) {
                    $precioPreventa = 99.00;
                    $precioPreventaUSD = 45.00;
                    $fechaProx = '18/08';
                    $horas = '25 hrs';
                } elseif (strpos($nombreCursoSafe, 'condensadores') !== false) {
                    $precioPreventa = 99.00;
                    $precioPreventaUSD = 30.00;
                    $fechaProx = '01/09';
                    $horas = '25 hrs';
                } elseif (strpos($nombreCursoSafe, 'analizador') !== false) {
                    $precioPreventa = 99.00;
                    $precioPreventaUSD = 30.00;
                    $fechaProx = '17/08';
                    $horas = '25 hrs';
                } elseif (strpos($nombreCursoSafe, 'canalizacion') !== false) {
                    $precioPreventa = 100.00;
                    $precioPreventaUSD = 30.00;
                    $fechaProx = '04/08';
                    $horas = '16 hrs';
                } elseif (strpos($nombreCursoSafe, 'terminaciones') !== false) {
                    $precioPreventa = 99.00;
                    $precioPreventaUSD = 30.00;
                    $fechaProx = '26/08';
                    $horas = '15 hrs';
                } elseif (strpos($nombreCursoSafe, 'empalmes') !== false) {
                    $precioPreventa = 99.00;
                    $precioPreventaUSD = 30.00;
                    $fechaProx = '26/08';
                    $horas = '15 hrs';
                } elseif (strpos($nombreCursoSafe, 'variadores') !== false) {
                    $precioPreventa = 99.00;
                    $precioPreventaUSD = 35.00;
                    $fechaProx = '20/08';
                    $horas = '30 hrs';
                } elseif (strpos($nombreCursoSafe, 'electricidad industrial') !== false) {
                    $precioPreventa = 100.00;
                    $precioPreventaUSD = 30.00;
                    $fechaProx = '17/08';
                    $horas = '40 hrs';
                } else {
                    $precioPreventa = $c['precio'] ?? 89.90;
                    $precioPreventaUSD = 30.00;
                }
                
                $ingenieria_courses[] = [
                    "id" => $c['id_curso'],
                    "title" => $c['nombre_curso'],
                    "image" => "assets/images/cursos/" . ($c['foto'] ?: 'default.png'),
                    "price" => number_format($precioPreventa, 2),
                    "price_usd" => number_format($precioPreventaUSD, 2),
                    "date" => $fechaProx,
                    "hours" => $horas,
                    "link" => $slug,
                    "lecciones" => $c['lecciones_reales'] ?? 0
                ];
            }
        }

        $data = [
            'title' => 'Inicio - Instituto de Capacitación Continua',
            'meta_description' => 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería Eléctrica.',
            'ingenieria_courses' => $ingenieria_courses
        ];

        // Llama a la vista app/Views/home/index.php
        $this->view('home/index', $data);
    }

    public function enviar_contacto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Anti-spam Honeypot (campo oculto, si está lleno = bot)
            if (!empty($_POST['telefono_falso'])) {
                // Es un bot, simulamos éxito
                echo "<div class='inner success'><p class='success'>Mensaje enviado (simulado).</p></div>";
                exit;
            }

            $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : "";
            $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : "";
            $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : "";
            $services = isset($_POST['services']) ? htmlspecialchars(trim($_POST['services'])) : "";
            $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : "";
            $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : "";

            if ($name && $email && $message) {
                $to = "informes@icc.com.pe";
                $mail_subject = "Nuevo Contacto Web: " . ($subject ?: 'Sin asunto');
                
                $body = "Nombre: $name\r\n";
                $body .= "Email: $email\r\n";
                if ($phone) $body .= "Teléfono: $phone\r\n";
                if ($services) $body .= "Servicio de interés: $services\r\n";
                $body .= "\r\nMensaje:\r\n$message\r\n";

                $headers = "From: $name <$email>\r\n";
                
                if (mail($to, $mail_subject, $body, $headers)) {
                    echo "<div class='inner success'><p class='success'>Gracias por contactarnos. ¡Te responderemos lo antes posible!</p></div>";
                } else {
                    echo "<div class='inner error'><p class='error'>Ocurrió un error al enviar el correo. Por favor, intenta de nuevo.</p></div>";
                }
            } else {
                echo "<div class='inner error'><p class='error'>Por favor, completa todos los campos requeridos.</p></div>";
            }
            exit;
        }
    }
}

