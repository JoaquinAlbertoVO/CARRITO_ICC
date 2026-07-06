<?php
$file = 'app/Views/home/index.php';
$content = file_get_contents($file);

$content = str_replace('"autoplay": {
            "delay": 5000
            }}', '"autoplay": {
            "delay": 5000
            },
            "a11y": true}', $content);

file_put_contents($file, $content);
echo "A11y Swiper applied";
