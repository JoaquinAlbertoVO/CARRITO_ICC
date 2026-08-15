<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'app/Core/Database.php';

header('Content-Type: text/plain; charset=utf-8');

$db = new \App\Core\Database();
$pdo = $db->connect();

$students_json = <<<JSON
[{"nombre": "", "documento": "73348435", "correo": "jeffersonherbacio@gmail.com", "telefono": "942309254", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "", "documento": "", "correo": "cervantesuscangao@gmail.com", "telefono": "1 314 104 5146", "curso": "Especialidad en Electricidad Industrial"}, {"nombre": "", "documento": "8259088", "correo": "torrico8912@gmail.com", "telefono": "591 62023987", "curso": "Mantenimiento de Subestaciones"}]
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
    
    // Ensure safe values for integers
    $safe_documento = !empty($documento) ? $documento : null;
    $safe_correo = !empty($correo) ? $correo : null;

    try {
        // Check if user exists by DNI or Correo
        $stmt_check = $pdo->prepare("SELECT iduser FROM usuario WHERE usuario = ? OR (dni IS NOT NULL AND dni = ?) OR (correo IS NOT NULL AND correo = ?)");
        $stmt_check->execute([$usuario_login, $safe_documento, $safe_correo]);
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
            $stmt_insert->execute([$nombre, $safe_correo, $safe_telefono, $safe_documento, $usuario_login]);
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
