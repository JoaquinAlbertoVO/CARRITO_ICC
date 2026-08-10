<?php
require_once "app/Core/Database.php";
$db = new \App\Core\Database();
$pdo = $db->connect();

try {
    // Add columns if they don't exist
    $columns = ['resumen', 'temas', 'beneficios', 'programacion'];
    foreach ($columns as $col) {
        try {
            $pdo->exec("ALTER TABLE cursos ADD COLUMN {$col} TEXT NULL");
            echo "Columna {$col} agregada.<br>\n";
        } catch (\PDOException $e) {
            // Error 1060: Duplicate column name
            if ($e->getCode() == '42S21' || strpos($e->getMessage(), 'Duplicate column name') !== false) {
                // Column already exists, ignore
            } else {
                throw $e;
            }
        }
    }

    $temas = '<ul style="list-style: none; padding: 0;">
    <li>✅ MÓDULO 1: FUNDAMENTOS DE ELECTROTECNIA</li>
    <li>✅ MÓDULO 2: INSTRUMENTOS ELÉCTRICOS</li>
    <li>✅ MÓDULO 3: PROTECCIONES ELÉCTRICAS</li>
    <li>✅ MÓDULO 4: INTERPRETACIÓN DE PLANOS ELÉCTRICOS</li>
    <li>✅ MÓDULO 5: TRANSFORMADORES ELÉCTRICOS</li>
    <li>✅ MÓDULO 6: MOTORES ELÉCTRICOS INDUSTRIALES</li>
    <li>✅ MÓDULO 7: EQUIPOS DE AUTOMATIZACIÓN</li>
    <li>✅ MÓDULO 8: AUTOMATIZACIÓN INDUSTRIAL</li>
    <li>✅ MÓDULO 9: MANTENIMIENTO ELÉCTRICO INDUSTRIAL</li>
</ul>';

    $programacion = '<p class="text-muted mb-2"><strong>Programación virtual (Hora: Pan – Per – Col – Ecu)</strong></p>
<ul style="list-style: none; padding: 0;">
    <li>📅 <strong>17/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>19/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>24/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>26/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>31/08:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>02/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>07/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>09/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>14/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
    <li>📅 <strong>16/09:</strong> Zoom en VIVO de 7:00 p.m. a 9:00 p.m.</li>
</ul>';

    $stmt = $pdo->prepare("UPDATE cursos SET temas = :temas, programacion = :programacion WHERE nombre_curso LIKE '%electricidad industrial%'");
    $stmt->execute([
        ':temas' => $temas,
        ':programacion' => $programacion
    ]);

    echo "Curso de Electricidad Industrial actualizado: " . $stmt->rowCount() . " filas afectadas.<br>\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
