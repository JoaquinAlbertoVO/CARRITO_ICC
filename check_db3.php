<?php
$con = mysqli_connect('localhost', 'root', '');
if(!$con) die("Connection failed: " . mysqli_connect_error());

$tables = ['icccom_icc.ingenieria', 'icccom_icc.derecho'];
$result = [];

foreach($tables as $t) {
    $q = mysqli_query($con, "SHOW COLUMNS FROM $t");
    if($q) {
        $cols = [];
        while($r = mysqli_fetch_assoc($q)) {
            $cols[] = $r['Field'] . ' (' . $r['Type'] . ')';
        }
        $result[$t] = $cols;
    } else {
        $result[$t] = "Table not found or error: " . mysqli_error($con);
    }
}
echo json_encode($result, JSON_PRETTY_PRINT);
?>
