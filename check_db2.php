<?php
$con = mysqli_connect('localhost', 'root', '');
if(!$con) die("Connection failed: " . mysqli_connect_error());
$q = mysqli_query($con, "SHOW DATABASES");
$dbs = [];
while($r = mysqli_fetch_row($q)) {
    $dbs[] = $r[0];
}
echo json_encode($dbs);
?>
