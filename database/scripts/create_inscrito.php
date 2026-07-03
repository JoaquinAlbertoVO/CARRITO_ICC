<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=prueba1;charset=utf8', 'root', '');
    $pdo->exec($argv[1]);
    echo 'Tabla inscrito creada correctamente';
} catch(Exception $e) {
    echo $e->getMessage();
}

