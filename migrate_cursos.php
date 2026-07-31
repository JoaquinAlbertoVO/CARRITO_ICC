<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'app/Core/Database.php';

$db = new \App\Core\Database();
try {
    $pdo = $db->connect();
    
    // Crear las columnas primero por si la auto-migración de Curso.php falló
    try { $pdo->exec("ALTER TABLE cursos ADD COLUMN precio_usd DECIMAL(10,2) DEFAULT '30.00'"); } catch(Exception $e) {}
    try { $pdo->exec("ALTER TABLE cursos ADD COLUMN fecha_prox VARCHAR(50) DEFAULT 'PRÓXIMAMENTE'"); } catch(Exception $e) {}
    try { $pdo->exec("ALTER TABLE cursos ADD COLUMN horas_academicas INT(11) DEFAULT 20"); } catch(Exception $e) {}
    
    // Obtener todos los cursos
    $stmt = $pdo->query("SELECT id_curso, nombre_curso FROM cursos");
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $actualizados = 0;
    foreach ($cursos as $c) {
        $id = $c['id_curso'];
        $nombre = mb_strtolower($c['nombre_curso'] ?? '', 'UTF-8');
        
        $precioPEN = 89.90;
        $precioUSD = 30.00;
        $fecha = 'PRÓXIMAMENTE';
        $horas = 20;
        
        if (strpos($nombre, 'subestaciones') !== false) {
            $precioPEN = 99.00; $precioUSD = 45.00; $fecha = '18/08'; $horas = 25;
        } elseif (strpos($nombre, 'condensadores') !== false) {
            $precioPEN = 99.00; $precioUSD = 30.00; $fecha = '01/09'; $horas = 25;
        } elseif (strpos($nombre, 'analizador') !== false) {
            $precioPEN = 99.00; $precioUSD = 30.00; $fecha = '17/08'; $horas = 25;
        } elseif (strpos($nombre, 'canalizacion') !== false || strpos($nombre, 'canalización') !== false) {
            $precioPEN = 100.00; $precioUSD = 30.00; $fecha = '04/08'; $horas = 16;
        } elseif (strpos($nombre, 'terminaciones') !== false) {
            $precioPEN = 99.00; $precioUSD = 30.00; $fecha = '26/08'; $horas = 15;
        } elseif (strpos($nombre, 'empalmes') !== false) {
            $precioPEN = 99.00; $precioUSD = 30.00; $fecha = '26/08'; $horas = 15;
        } elseif (strpos($nombre, 'variadores') !== false) {
            $precioPEN = 99.00; $precioUSD = 35.00; $fecha = '20/08'; $horas = 30;
        } elseif (strpos($nombre, 'electricidad industrial') !== false) {
            $precioPEN = 100.00; $precioUSD = 30.00; $fecha = '17/08'; $horas = 40;
        }

        // Update DB (siempre actualizamos precio y horas, incluso si la fecha es proximamente)
        $update = $pdo->prepare("UPDATE cursos SET precio = ?, precio_usd = ?, fecha_prox = ?, horas_academicas = ? WHERE id_curso = ?");
        $update->execute([$precioPEN, $precioUSD, $fecha, $horas, $id]);
        $actualizados++;
    }
    
    echo "<h1>Migración Completa</h1>";
    echo "<p>Se actualizaron los datos (fechas y precio USD) de $actualizados cursos.</p>";
    echo "<p>Por seguridad, elimina este archivo (migrate_cursos.php) de tu servidor.</p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
