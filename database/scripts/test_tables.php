<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=prueba1;charset=utf8', 'root', '');
    $stmt = $pdo->query('SHOW TABLES');
    print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
} catch(Exception $e) {
    echo $e->getMessage();
}
