<?php
$file = 'app/Views/layouts/main.php';
$content = file_get_contents($file);

// Accesibilidad
$content = str_replace('<a href="./"><img width="190"', '<a href="./" aria-label="Inicio"><img width="190" alt="Logo de ICC"', $content);
$content = str_replace('<a href="https://wa.link/myq5iv" target="_black">', '<a href="https://wa.link/myq5iv" target="_blank" aria-label="WhatsApp">', $content);
$content = str_replace('<a href="https://www.facebook.com/icc.com.pe/" target="_black">', '<a href="https://www.facebook.com/icc.com.pe/" target="_blank" aria-label="Facebook">', $content);
$content = str_replace('<a href="https://www.instagram.com/icc.capacitaciones/" target="_black">', '<a href="https://www.instagram.com/icc.capacitaciones/" target="_blank" aria-label="Instagram">', $content);
$content = str_replace('<a href="https://www.linkedin.com/in/empresa-icc-313316253/" target="_black">', '<a href="https://www.linkedin.com/in/empresa-icc-313316253/" target="_blank" aria-label="LinkedIn">', $content);
$content = str_replace('<a href="https://www.tiktok.com/@institutoicc" target="_black">', '<a href="https://www.tiktok.com/@institutoicc" target="_blank" aria-label="TikTok">', $content);
$content = str_replace('<a href="#" class="mobile-nav__toggler">', '<a href="#" class="mobile-nav__toggler" aria-label="Abrir menú de navegación">', $content);

// Ortografia en enlaces del menu
$content = preg_replace('/Ingenier.ctrica/u', 'Ingeniería Eléctrica', $content);
$content = preg_replace('/An.lisis/u', 'Análisis', $content);
$content = preg_replace('/Evaluaci.n/u', 'Evaluación', $content);
$content = preg_replace('/B.sica/u', 'Básica', $content);
$content = preg_replace('/Gesti.n/u', 'Gestión', $content);
$content = preg_replace('/El.ctricos/u', 'Eléctricos', $content);
$content = preg_replace('/Programaci.n/u', 'Programación', $content);
$content = preg_replace('/Regulaci.n/u', 'Regulación', $content);
$content = preg_replace('/Energ.a/u', 'Energía', $content);
$content = preg_replace('/Configuraci.n/u', 'Configuración', $content);
$content = preg_replace('/Instalaci.n/u', 'Instalación', $content);
$content = preg_replace('/Cont.ctanos/u', 'Contáctanos', $content);
$content = preg_replace('/Capacitaci.n/u', 'Capacitación', $content);
$content = preg_replace('/Ingenier.a/u', 'Ingeniería', $content);

file_put_contents($file, $content);
echo "Fixes applied";
