<?php
mysqli_report(MYSQLI_REPORT_OFF);
$host     = 'localhost';
$user     = 'icccom_icc';
$password = 'bpFsCGU@d0sx@zO';
$db       = 'icccom_icc';
$conection = @mysqli_connect($host, $user, $password, $db);

if (!$conection) {
	echo "Error de Conexion: " . mysqli_connect_error();
}
?>
