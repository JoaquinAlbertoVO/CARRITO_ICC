<?php
/**
 * Layout del aula virtual (rediseño 2026-11): marca ICC del checkout v2 (azul ICC, azul marino y
 * verde lima), Tailwind compilado en assets/css/aula.css (tools/tailwind: npm run build:aula) y Alpine.
 */
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$nombreCompleto = trim((string) ($alumno['nombre'] ?? ($_SESSION['aula_nombre'] ?? '')));
$primerNombre = $nombreCompleto !== '' ? mb_convert_case(explode(' ', $nombreCompleto)[0], MB_CASE_TITLE, 'UTF-8') : 'Alumno';
$iniciales = '';
foreach (array_slice(preg_split('/\s+/u', $nombreCompleto), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1, 'UTF-8'), 'UTF-8');
}
$ruta = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
$enInicio = (bool) preg_match('~aula/?$~', $ruta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="csrf" content="<?= $h($token ?? '') ?>">
    <title><?= $h($title ?? 'Aula virtual | ICC') ?></title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/images/logo_icc.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/aula.css?v=1">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-surface font-sans text-ink antialiased">
<a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-2 focus:top-2 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-brand-dark">Saltar al contenido</a>

<header class="sticky top-0 z-40 bg-deep text-white shadow-lg" x-data="{ menu: false }">
    <div class="mx-auto flex h-16 max-w-7xl items-center gap-4 px-4">
        <a href="<?= BASE_URL ?>aula" class="flex shrink-0 items-center gap-3">
            <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC" class="h-9 w-auto">
            <span class="hidden border-l border-white/20 pl-3 font-display text-sm font-bold tracking-wide text-accent sm:block">AULA VIRTUAL</span>
        </a>
        <nav class="ml-4 hidden items-center gap-1 text-sm md:flex" aria-label="Aula">
            <a href="<?= BASE_URL ?>aula" class="rounded-lg px-3 py-2 font-semibold <?= $enInicio ? 'bg-white/10 text-white' : 'text-sky-100 hover:bg-white/10' ?>"><i class="fas fa-th-large mr-1.5" aria-hidden="true"></i>Mis cursos</a>
            <a href="<?= BASE_URL ?>aula#certificados" class="rounded-lg px-3 py-2 font-semibold text-sky-100 hover:bg-white/10"><i class="fas fa-award mr-1.5" aria-hidden="true"></i>Certificados</a>
            <a href="<?= BASE_URL ?>tienda" class="rounded-lg px-3 py-2 font-semibold text-sky-100 hover:bg-white/10"><i class="fas fa-store mr-1.5" aria-hidden="true"></i>Más cursos</a>
        </nav>
        <div class="relative ml-auto">
            <button type="button" @click="menu = !menu" @click.outside="menu = false" :aria-expanded="menu.toString()" class="flex items-center gap-2 rounded-full py-1 pl-1 pr-3 hover:bg-white/10">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent font-display text-sm font-extrabold text-deep"><?= $h($iniciales ?: 'A') ?></span>
                <span class="hidden text-sm font-semibold sm:block"><?= $h($primerNombre) ?></span>
                <i class="fas fa-chevron-down text-xs text-sky-200" aria-hidden="true"></i>
            </button>
            <div x-show="menu" x-cloak x-transition.origin.top.right class="absolute right-0 mt-2 w-60 overflow-hidden rounded-xl bg-white text-ink shadow-xl ring-1 ring-line">
                <div class="border-b border-mist px-4 py-3">
                    <p class="truncate text-sm font-bold"><?= $h($nombreCompleto ?: 'Alumno') ?></p>
                    <p class="truncate text-xs text-muted"><?= $h($alumno['usuario'] ?? '') ?></p>
                </div>
                <a href="<?= BASE_URL ?>aula" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-surface md:hidden"><i class="fas fa-th-large w-4 text-brand"></i>Mis cursos</a>
                <a href="<?= BASE_URL ?>aula#certificados" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-surface md:hidden"><i class="fas fa-award w-4 text-brand"></i>Certificados</a>
                <a href="<?= BASE_URL ?>tienda" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-surface md:hidden"><i class="fas fa-store w-4 text-brand"></i>Más cursos</a>
                <a href="<?= BASE_URL ?>aula/mis_datos" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-surface"><i class="fas fa-id-card w-4 text-brand"></i>Datos del certificado</a>
                <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-surface"><i class="fab fa-whatsapp w-4 text-brand"></i>Soporte</a>
                <a href="<?= BASE_URL ?>aula/logout" class="flex items-center gap-3 border-t border-mist px-4 py-2.5 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-4"></i>Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>

<main id="contenido" class="mx-auto max-w-7xl px-4 pb-16 pt-6 sm:pt-8">
    <?php if (!empty($flash)): ?>
        <div role="status" class="mb-6 flex items-start gap-3 rounded-xl p-4 text-sm <?= $flash['tipo'] === 'ok' ? 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-200' : 'bg-red-50 text-red-800 ring-1 ring-red-200' ?>">
            <i class="fas <?= $flash['tipo'] === 'ok' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> mt-0.5" aria-hidden="true"></i>
            <span><?= $h($flash['texto']) ?></span>
        </div>
    <?php endif; ?>
    <?= $content ?>
</main>

<footer class="border-t border-line bg-white py-6 text-center text-xs text-muted">
    ICC · Instituto de Capacitación Continua · <a href="https://wa.me/51941208020" class="font-semibold text-brand hover:underline" target="_blank" rel="noopener">WhatsApp +51 941 208 020</a>
</footer>
</body>
</html>
