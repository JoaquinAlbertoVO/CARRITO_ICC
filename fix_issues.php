<?php
// Fix double alt tag in main.php
$fileMain = 'app/Views/layouts/main.php';
$contentMain = file_get_contents($fileMain);
$contentMain = str_replace('alt="Logo de ICC" src="<?= BASE_URL ?>assets/images/resources/icc-logo1.png" alt=""', 'alt="Logo de ICC" src="<?= BASE_URL ?>assets/images/resources/icc-logo1.png"', $contentMain);
$contentMain = str_replace('alt=""', 'alt="Imagen decorativa"', $contentMain); // Fallback for any other empty alts

// Add aria-labels to swiper buttons in index.php and fix spelling
$fileIndex = 'app/Views/home/index.php';
$contentIndex = file_get_contents($fileIndex);
$contentIndex = str_replace('thmǭswiper', 'thm-swiper', $contentIndex); // Fix corrupted swiper class
$contentIndex = preg_replace('/Capac.tate/u', 'Capacítate', $contentIndex);
$contentIndex = preg_replace('/Especial.zate/u', 'Especialízate', $contentIndex);
$contentIndex = preg_replace('/Ingenier.a/u', 'Ingeniería', $contentIndex);
$contentIndex = preg_replace('/El.ctrica/u', 'Eléctrica', $contentIndex);
$contentIndex = preg_replace('/m.s/u', 'más', $contentIndex);

file_put_contents($fileMain, $contentMain);
file_put_contents($fileIndex, $contentIndex);
echo "Fixes applied";
