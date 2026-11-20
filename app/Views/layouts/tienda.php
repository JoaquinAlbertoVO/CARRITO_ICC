<?php
/**
 * Layout de la tienda de packs y cursos grabados. Misma marca que el checkout v2 (azul ICC, azul
 * marino y verde lima). Estilos: assets/css/aula.css (tools/tailwind: npm run build:aula).
 */
$tituloPagina = isset($title) ? $title : 'Cursos grabados y packs | ICC';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Cursos grabados de electricidad industrial de ICC: compra por curso o por pack, avanza a tu ritmo y descarga tu certificado de cada curso.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/aula.css?v=1">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <?php if (!empty($pagoPayPal)): ?>
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD&enable-funding=card"></script>
    <?php endif; ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JPZGM0RZHW"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-JPZGM0RZHW');</script>
</head>
<body class="min-h-screen bg-surface font-sans text-ink antialiased">
<a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-2 focus:top-2 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-brand-dark">Saltar al contenido</a>
<header class="bg-deep text-white">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
        <a href="<?= BASE_URL ?>" class="flex items-center"><img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" class="h-9 w-auto"></a>
        <nav class="flex items-center gap-2 text-sm sm:gap-4">
            <a href="<?= BASE_URL ?>tienda" class="hidden rounded-lg px-3 py-2 font-semibold text-sky-100 hover:bg-white/10 sm:inline-block">Cursos y packs</a>
            <a href="<?= BASE_URL ?>aula" class="inline-flex min-h-[40px] items-center gap-2 rounded-lg bg-accent px-4 font-bold text-deep hover:brightness-95"><i class="fas fa-user-graduate" aria-hidden="true"></i> Aula virtual</a>
        </nav>
    </div>
</header>
<main id="contenido">
    <?= $content ?>
</main>
<footer class="mt-16 bg-deep py-8 text-sm text-sky-100">
    <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 sm:flex-row sm:items-center sm:justify-between">
        <p>© <?= date('Y') ?> Instituto de Capacitación Continua S.R.L. · RUC 20602400159</p>
        <p class="flex gap-4">
            <a href="https://wa.me/51941208020" class="hover:text-white" target="_blank" rel="noopener"><i class="fab fa-whatsapp" aria-hidden="true"></i> +51 941 208 020</a>
            <a href="<?= BASE_URL ?>verificar" class="hover:text-white">Verificar certificado</a>
        </p>
    </div>
</footer>
</body>
</html>
