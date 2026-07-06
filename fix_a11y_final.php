<?php
$file = 'app/Views/layouts/main.php';
$content = file_get_contents($file);

// 1. Fix viewport user-scalable
$content = str_replace('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />', '<meta name="viewport" content="width=device-width, initial-scale=1.0" />', $content);

// 2. Fix empty links
$content = str_replace('<a href="#"><span class="icon-shopping-cart"></span></a>', '<a href="#" aria-label="Carrito de compras"><span class="icon-shopping-cart"></span></a>', $content);
$content = str_replace('<a href="./"><img width="160" height="60" src="<?= BASE_URL ?>assets/images/resources/icc-logo1.png" alt="Imagen decorativa"></a>', '<a href="./" aria-label="Inicio"><img width="160" height="60" src="<?= BASE_URL ?>assets/images/resources/icc-logo1.png" alt="Imagen decorativa"></a>', $content);
$content = str_replace('<a href="https://www.linkedin.com/in/empresa-icc-313316253//" target="_black"><i class="fab fa-linkedin"></i></a>', '<a href="https://www.linkedin.com/in/empresa-icc-313316253//" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>', $content);
$content = str_replace('<a href="https://wa.link/myq5iv" target="_black" class="fab fa-whatsapp"></a>', '<a href="https://wa.link/myq5iv" target="_blank" class="fab fa-whatsapp" aria-label="WhatsApp"></a>', $content);
$content = str_replace('<a href="https://www.facebook.com/icc.com.pe/" target="_black" class="fab fa-facebook-square"></a>', '<a href="https://www.facebook.com/icc.com.pe/" target="_blank" class="fab fa-facebook-square" aria-label="Facebook"></a>', $content);
$content = str_replace('<a href="https://www.instagram.com/icc.capacitaciones/" target="_black" class="fab fa-instagram"></a>', '<a href="https://www.instagram.com/icc.capacitaciones/" target="_blank" class="fab fa-instagram" aria-label="Instagram"></a>', $content);
$content = str_replace('<a href="https://www.linkedin.com/in/empresa-icc-313316253/" target="_black" class="fab fa-linkedin"></a>', '<a href="https://www.linkedin.com/in/empresa-icc-313316253/" target="_blank" class="fab fa-linkedin" aria-label="LinkedIn"></a>', $content);
$content = str_replace('<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>', '<a href="#" data-target="html" class="scroll-to-target scroll-to-top" aria-label="Volver arriba"><i class="fa fa-angle-up"></i></a>', $content);
$content = str_replace('<a target="blank" href="https://wa.link/myq5iv" class="scroll-to-target scroll-to-top btn-whatsapp-pulse"><i style="font-size: 40px;" class="fab fa-whatsapp"></i></a>', '<a target="_blank" href="https://wa.link/myq5iv" class="scroll-to-target scroll-to-top btn-whatsapp-pulse" aria-label="Contactar por WhatsApp"><i style="font-size: 40px;" class="fab fa-whatsapp"></i></a>', $content);

// 3. Fix main landmark issue
$content = str_replace('<div class="page-wrapper">', '<div class="page-wrapper"><main>', $content);
$content = str_replace('</body>', '</main></body>', $content);

file_put_contents($file, $content);
echo "Fixes applied";
