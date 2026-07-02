<?php
include 'conexion.php';

echo "<h1>Iniciando Migración de Cursos y Matrículas...</h1>";

// 1. Vaciar las tablas para empezar limpios
mysqli_query($conection, "TRUNCATE TABLE cursos");
mysqli_query($conection, "TRUNCATE TABLE usuario_cursos");

// 2. Definir los cursos antiguos y sus columnas en la tabla "inscrito"
$cursos_antiguos = [
    'plc' => ['PROGRAMACION BASICA P.L.C', 'ingenieria'],
    'e_basica' => ['ELECTRICIDAD BASICA', 'ingenieria'],
    's_p_tierra' => ['SISTEMA PUESTA A TIERRA', 'ingenieria'],
    'm_electrico' => ['MOTORES ELECTRICOS', 'ingenieria'],
    'banco_c' => ['BANCO CONDENSADORES', 'ingenieria'],
    'a_facturas_t_e' => ['ANALISIS DE FACTURAS Y EVALUACION DE TARIFAS ELECTRICAS', 'ingenieria'],
    'g_seguridad_t' => ['GESTION Y SEGURIDAD EN EL TRABAJO LEY N° 29783', 'ingenieria'],
    'r_mercado_e' => ['REGULACION DE MERCADO DE ENERGIA', 'ingenieria'],
    'a_redes' => ['CONFIGURACION E INSTALACION DE ANALIZADORES DE REDES', 'ingenieria'],
    'riesgo_e' => ['RIESGO ELECTRICO', 'ingenieria'],
    't_altura' => ['TRABAJO EN ALTURA', 'ingenieria'],
    'e_motores_e' => ['ESPECIALIZACION DE MOTORES ELECTRICOS TRIFASICOS', 'ingenieria'],
    's_p_t_antiguo' => ['SISTEMA PUESTA A TIERRA ANTIGUO', 'ingenieria'],
    'costo_p' => ['COSTOS Y PRESUPUESTOS PARA PROYECTOS ELECTRICOS', 'ingenieria'],
    'idtermo' => ['TERMOGRAFIA INFRARROJA EN SISTEMAS ELECTRICOS', 'ingenieria'],
    'id_residencial' => ['ELECTRICIDAD RESIDENCIAL', 'ingenieria'],
    'id_medicion' => ['MEDICION DE AISLAMIENTO EN BAJA Y MEDIA TENSION', 'ingenieria'],
    'm_t_electricos' => ['MANTENIMIENTO DE TABLEROS ELECTRICOS', 'ingenieria'],
    'redes_electricas' => ['REDES DE DISTRIBUCION DE ENERGIA ELECTRICA', 'ingenieria'],
    't_caliente' => ['TRABAJO EN CALIENTE', 'ingenieria']
];

// 3. Insertar cursos en la nueva tabla 'cursos' y guardar sus nuevos IDs
$mapa_ids = [];
foreach($cursos_antiguos as $columna => $datos) {
    $nombre = $datos[0];
    $categoria = $datos[1];
    mysqli_query($conection, "INSERT INTO cursos (nombre_curso, categoria, horas_academicas) VALUES ('$nombre', '$categoria', 20)");
    $nuevo_id = mysqli_insert_id($conection);
    $mapa_ids[$columna] = $nuevo_id;
    echo "Creado curso: $nombre (ID: $nuevo_id)<br>";
}

// 4. Migrar los alumnos de la tabla 'inscrito' a 'usuario_cursos'
$query_inscritos = mysqli_query($conection, "SELECT * FROM inscrito");
$total_migrados = 0;

while($row = mysqli_fetch_assoc($query_inscritos)) {
    $id_user = $row['id_user'];
    
    // Revisar cada columna de curso
    foreach($mapa_ids as $columna => $id_curso) {
        // En el sistema antiguo, si el valor era > 1 significaba que estaba matriculado
        if(isset($row[$columna]) && $row[$columna] > 1) {
            mysqli_query($conection, "INSERT INTO usuario_cursos (id_usuario, id_curso) VALUES ($id_user, $id_curso)");
            $total_migrados++;
        }
    }
}

echo "<h2>¡Migración Completada!</h2>";
echo "<p>Se crearon " . count($mapa_ids) . " cursos en el nuevo sistema dinámico.</p>";
echo "<p>Se migraron $total_migrados matrículas de alumnos al nuevo sistema.</p>";
echo "<p>Ya puedes borrar este archivo por seguridad.</p>";
?>
