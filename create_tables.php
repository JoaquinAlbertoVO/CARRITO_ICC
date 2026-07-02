<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=prueba1;charset=utf8', 'root', '');
    $pdo->exec($argv[1]);
    echo 'Tablas de prueba creadas correctamente';
} catch(Exception $e) {
    echo $e->getMessage();
}

