<?php
require_once "app/Core/Database.php";
$db = new \App\Core\Database();
$pdo = $db->connect();
$stmt = $pdo->query("SELECT * FROM curso_videos LIMIT 10");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($videos);
