<?php
$html = file_get_contents('app/Views/layouts/main.php');
preg_match_all('/<a[^>]*>.*?<\/a>/is', $html, $links);
foreach ($links[0] as $link) {
    if (!preg_match('/aria-label/', $link) && !preg_match('/[a-zA-Z0-9]/', strip_tags($link))) {
        echo "Link without text/aria: " . htmlspecialchars($link) . "\n";
    }
}
preg_match_all('/<button[^>]*>.*?<\/button>/is', $html, $buttons);
foreach ($buttons[0] as $btn) {
    if (!preg_match('/aria-label/', $btn) && !preg_match('/[a-zA-Z0-9]/', strip_tags($btn))) {
        echo "Button without text/aria: " . htmlspecialchars($btn) . "\n";
    }
}
