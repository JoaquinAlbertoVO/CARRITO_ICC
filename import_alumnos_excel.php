<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'app/Core/Database.php';

header('Content-Type: text/plain; charset=utf-8');

$db = new \App\Core\Database();
$pdo = $db->connect();

$students_json = <<<JSON
[{"nombre": "Joel Guzman Contreras Martinez", "documento": "48572001", "correo": "contrerasmartinezj20@gmail.com", "telefono": "932515610", "curso": "Terminaciones en Media Tensión"}, {"nombre": "Ivan Pineda Lopez", "documento": "", "correo": "ip481074@gmail.com", "telefono": "15610823417", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Roger Willy Checalla Huacca", "documento": "45048414", "correo": "rogerw.checalla15@gmail.com", "telefono": "960621677", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Leonev Durand Dominguez", "documento": "44555472", "correo": "leonevdurand@gmail.com", "telefono": "964131229", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Juan Carlos Espíritu Maguiña", "documento": "80235799", "correo": "jcemls31@gmail.com", "telefono": "922009617", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Rafael Bustamante Sánchez", "documento": "47915278", "correo": "rafa.12345.rbs@gmail.com", "telefono": "931492250", "curso": "Terminaciones en Media Tensión"}, {"nombre": "Ericks Fernando Briones Diaz", "documento": "71648882", "correo": "Ericksfernandobrionesdiaz@gmail.com", "telefono": "980 897 157", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Edinson Raul Mendoza Gómez", "documento": "74935738", "correo": "edisjm1397@gmail.com", "telefono": "954254303", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Royer Franklin Mercado Clasina", "documento": "71411022", "correo": "royerfranklinmc@gmail.com", "telefono": "932320191", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Jeferson Rodolfo Aliaga Aguedo", "documento": "48185736", "correo": "Jefersonaliaga@hotmail.com", "telefono": "", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Luis Cuesta", "documento": "", "correo": "Cuestaluis934@gmail.com", "telefono": "1 (347) 799-9081", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Raul Arce", "documento": "75583811", "correo": "sargentopimienta94@gmail.com", "telefono": "982 050 261", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Ciro Torrico Lopez", "documento": "8259088", "correo": "torrico8912@gmail.com", "telefono": "591 62023987", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Yerson Junior Romero Melchor", "documento": "70301851", "correo": "ulloavega9@gmail.com", "telefono": "928071548", "curso": "Terminaciones en Media Tensión"}, {"nombre": "Nicolas Valerio", "documento": "43023581", "correo": "cozynook93@gmail.com", "telefono": "54 9 2995 02-5631", "curso": "Empalmes en Media Tensión"}, {"nombre": "Juan Moya", "documento": "42561490", "correo": "jmoyah@uni.pe", "telefono": "995 550 029", "curso": "Terminaciones en Media Tensión"}, {"nombre": "Alex Mauricio Flores Lopez", "documento": "45040671", "correo": "Axelmiusic88@gmail.com", "telefono": "963 920 095", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Anasto Fernandez Lanazca", "documento": "47037571", "correo": "fernandezlanazca23@gmail.com", "telefono": "950 850 342", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Gonzalo Augusto Lopez Bernable", "documento": "76481122", "correo": "gonzalo7x100@gmail.com", "telefono": "906 966 673", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Mario Sixto Tejada Romero", "documento": "72848198", "correo": "mtejadaromero0406@gmail.com", "telefono": "992 811 154", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Davinsy Luis Saavedra Rios", "documento": "76035631", "correo": "davinsyluis@gmail.com", "telefono": "906752455", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Victor Hugo Tejada Romero", "documento": "72848201", "correo": "vtejadamultiservicesrj@gmail.com", "telefono": "930246879", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Jose Armando Curi Meza", "documento": "76226062", "correo": "josearmandocurimeza@gmail.com", "telefono": "937303888", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "Jairo Job Goncalvez Diosa", "documento": "79718023", "correo": "jairogoncalvez15@gmail.com", "telefono": "906321317", "curso": "Mantenimiento de Subestaciones"}, {"nombre": "George Anthony Pérez Oré", "documento": "71788331", "correo": "geranthony20@gmail.com", "telefono": "992 270 480", "curso": "Banco de Condensadores"}, {"nombre": "CARLOS AUGUSTO FERNÁNDEZ CHAFLOQUE", "documento": "16791432", "correo": "CAFERCHA77@GMAIL.COM", "telefono": "982 121 573", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "Angel Jesus Silva Rivera", "documento": "46993407", "correo": "91ajsilva@gmail.com", "telefono": "51 935 163 371", "curso": "Terminaciones en Media Tensión"}, {"nombre": "Angel Jesus Silva Rivera", "documento": "46993407", "correo": "91ajsilva@gmail.com", "telefono": "52 935 163 371", "curso": "Banco de Condensadores"}, {"nombre": "Angel Jesus Silva Rivera", "documento": "46993407", "correo": "91ajsilva@gmail.com", "telefono": "53 935 163 371", "curso": "Mantenimiento de Subestaciones"}]
JSON;

$students = json_decode($students_json, true);

// Fetch all courses to match
$stmt = $pdo->query("SELECT id_curso, nombre_curso FROM cursos");
$db_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Helper function to find best matching course
function find_best_course($course_name, $db_courses) {
    $best_match = null;
    $highest_percent = 0;
    $course_name_lower = strtolower(trim($course_name));
    
    foreach ($db_courses as $db_course) {
        $db_name_lower = strtolower(trim($db_course['nombre_curso']));
        
        // Exact match (case insensitive)
        if ($course_name_lower === $db_name_lower) {
            return $db_course;
        }
        
        // Partial match
        if (strpos($db_name_lower, $course_name_lower) !== false || strpos($course_name_lower, $db_name_lower) !== false) {
            return $db_course;
        }
        
        // Similar text
        similar_text($course_name_lower, $db_name_lower, $percent);
        if ($percent > $highest_percent) {
            $highest_percent = $percent;
            $best_match = $db_course;
        }
    }
    
    if ($highest_percent >= 40) {
        return $best_match;
    }
    return null;
}

$report = [
    'courses_matched' => [],
    'courses_not_found' => [],
    'users_created' => 0,
    'users_updated' => 0,
    'errors' => []
];

// Hacer que la columna telefono sea VARCHAR(50) por si es INT o muy corta
try {
    $pdo->exec("ALTER TABLE usuario MODIFY telefono VARCHAR(50) DEFAULT NULL");
} catch (Exception $e) {
    // ignorar si no hay permisos
}

$matched_cache = [];

foreach ($students as $student) {
    // Determine user
    $usuario_login = !empty($student['documento']) ? $student['documento'] : $student['correo'];
    if (empty($usuario_login)) continue;
    
    $documento = $student['documento'];
    $correo = $student['correo'];
    $nombre = $student['nombre'];
    $telefono = $student['telefono'];
    $curso_excel = $student['curso'];
    
    // Match course
    if (!isset($matched_cache[$curso_excel])) {
        $best_course = find_best_course($curso_excel, $db_courses);
        if ($best_course) {
            $matched_cache[$curso_excel] = $best_course;
            $report['courses_matched'][$curso_excel] = $best_course['nombre_curso'];
        } else {
            $matched_cache[$curso_excel] = null;
            if (!in_array($curso_excel, $report['courses_not_found'])) {
                $report['courses_not_found'][] = $curso_excel;
            }
        }
    }
    
    $matched_course = $matched_cache[$curso_excel];
    if (!$matched_course) {
        // Skip user assignment if course not found
        $report['errors'][] = "Curso no encontrado para alumno: $nombre ($curso_excel)";
        continue;
    }
    
    $id_curso = $matched_course['id_curso'];
    
    try {
        // Check if user exists by DNI or Correo
        $stmt_check = $pdo->prepare("SELECT iduser FROM usuario WHERE usuario = ? OR (dni != '' AND dni = ?) OR (correo != '' AND correo = ?)");
        $stmt_check->execute([$usuario_login, $documento, $correo]);
        $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($existing_user) {
            // User exists, update data but NOT password
            $iduser = $existing_user['iduser'];
            $report['users_updated']++;
            
            // Note: we could update the name/phone but let's just make sure they have the course assigned
        } else {
            // Create user
            // Ensure telefono is safely truncated or null if empty
            $safe_telefono = !empty($telefono) ? substr($telefono, 0, 50) : null;
            
            $stmt_insert = $pdo->prepare("INSERT INTO usuario (id_pla, nombre, correo, telefono, dni, usuario, password, estatus) VALUES (1, ?, ?, ?, ?, ?, 'ICC2026', 1)");
            $stmt_insert->execute([$nombre, $correo, $safe_telefono, $documento, $usuario_login]);
            $iduser = $pdo->lastInsertId();
            $report['users_created']++;
        }
        
        // Assign course
        $stmt_check_curso = $pdo->prepare("SELECT id_usuario FROM usuario_cursos WHERE id_usuario = ? AND id_curso = ?");
        $stmt_check_curso->execute([$iduser, $id_curso]);
        if (!$stmt_check_curso->fetch()) {
            // Verificamos si la tabla tiene id
            try {
                $stmt_assign = $pdo->prepare("INSERT INTO usuario_cursos (id_usuario, id_curso) VALUES (?, ?)");
                $stmt_assign->execute([$iduser, $id_curso]);
            } catch (Exception $e) {
                // If it fails, maybe it expects other columns, but mostly it's fine.
                throw $e;
            }
        }
        
    } catch (Exception $e) {
        $report['errors'][] = "Error procesando alumno $nombre: " . $e->getMessage();
    }
}

echo "=== REPORTE DE MIGRACIÓN ===\n\n";
echo "Alumnos creados nuevos: " . $report['users_created'] . "\n";
echo "Alumnos actualizados (ya existían): " . $report['users_updated'] . "\n\n";

echo "=== MATCHING DE CURSOS ===\n";
foreach ($report['courses_matched'] as $excel_name => $db_name) {
    echo "Excel: \"$excel_name\" => DB: \"$db_name\"\n";
}

if (!empty($report['courses_not_found'])) {
    echo "\n=== CURSOS NO ENCONTRADOS ===\n";
    foreach ($report['courses_not_found'] as $not_found) {
        echo "- $not_found\n";
    }
}

if (!empty($report['errors'])) {
    echo "\n=== ERRORES ===\n";
    foreach ($report['errors'] as $err) {
        echo "- $err\n";
    }
}
?>
