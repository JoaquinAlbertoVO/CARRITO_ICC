<?php
/**
 * Checkout v2 (?diseno=2&oferta=clave): pagina de venta + pago en una sola vista adaptable.
 * Colores y fondo de la marca ICC (azul de la portada/logo, amarillo del multimetro de la mascota).
 * SOLO contenido real (config en App\Helpers\OfertasCheckout + BD). Sin testimonios/fotos/videos
 * hasta que existan los archivos reales: esas secciones se ocultan solas.
 * Estilos: assets/css/checkout-v2.css (se compila con tools/tailwind: npm run build).
 */
$d = $data;
$js = json_encode($d['js'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$fmt = function ($n) { return number_format((float)$n, 2, '.', ''); };
$e = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
$wa = 'https://wa.me/51941208020';
$waComprobante = $wa . '?text=' . rawurlencode('Hola ICC, necesito boleta o factura para mi inscripción a ' . $d['curso'] . '.');
$hayManual = in_array('manual', $d['metodos'], true);
$hayHotmart = in_array('hotmart', $d['metodos'], true);
$tituloPlano = $d['titulo'][0] . ' ' . $d['titulo'][1];
$fondo = BASE_URL . 'assets/images/fondo_icc_hero.jpg';

// Icono del beneficio segun su texto (los textos vienen de la BD)
$iconoBeneficio = function ($t) {
    $t = mb_strtolower($t, 'UTF-8');
    if (strpos($t, 'vida') !== false) return 'fas fa-infinity';
    if (strpos($t, 'certific') !== false) return 'fas fa-award';
    if (strpos($t, 'whatsapp') !== false) return 'fab fa-whatsapp';
    if (strpos($t, 'clases') !== false) return 'fas fa-video';
    if (strpos($t, 'material') !== false) return 'fas fa-folder-open';
    if (strpos($t, 'entregables') !== false) return 'fas fa-tools';
    return 'fas fa-check-circle';
};
// Colores por tarjeta (clases completas para que Tailwind las compile)
$coloresTile = ['bg-brand text-white'];
$bordesModulo = ['border-brand'];
$iconosModulo = ['fas fa-file-alt', 'fas fa-calculator', 'fas fa-project-diagram', 'fas fa-file-invoice-dollar', 'fas fa-clipboard-check', 'fas fa-search'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title><?= $e($tituloPlano) ?> | ICC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/checkout-v2.css?v=10">
    <script>document.documentElement.classList.add('js');</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JPZGM0RZHW"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-JPZGM0RZHW');
    </script>

    <script type="text/javascript">
      window.$crisp=[];
      window.CRISP_WEBSITE_ID="009b5415-0cf9-4522-9ba1-5d84c98c9006";
      (function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();
      // El chat solo aparece despues de pagar
      $crisp.push(["do", "chat:hide"]);
    </script>
</head>

<body class="bg-surface text-ink antialiased pb-24 md:pb-0" x-data="checkoutV2()" x-init="init()">
<a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-2 focus:top-2 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-brand-dark">Saltar al contenido</a>

<!-- Cabecera + barra amarilla de precio -->
<header class="shadow-lg">
    <div class="bg-deep text-white">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
            <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" class="h-9 w-auto">
            <div class="flex items-center gap-4 text-sm">
                <span class="hidden sm:flex items-center gap-1.5 text-sky-100"><i class="fas fa-lock text-emerald-400"></i> Pago seguro</span>
                <a href="<?= $wa ?>" target="_blank" rel="noopener" class="flex min-h-[44px] items-center gap-2 rounded-full bg-emerald-700 hover:bg-emerald-600 px-4 font-semibold text-white shadow">
                    <i class="fab fa-whatsapp"></i><span class="hidden sm:inline">+51 941 208 020</span><span class="sm:hidden">WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</header>
<div class="sticky top-0 z-40 bg-brand-dark text-white text-sm shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-2 flex items-center justify-between gap-3">
            <p class="flex items-center gap-2 min-w-0">
                <i class="fas fa-bolt text-accent"></i>
                <span class="truncate font-bold"><?= $e($d['barraTexto']) ?></span>
            </p>
            <?php if ($d['js']['hastaMs']): ?>
            <span class="shrink-0 rounded-full bg-accent px-3 py-0.5 font-mono text-xs font-bold text-deep" title="Tiempo restante de este precio"><i class="far fa-clock mr-1"></i><span x-text="cuenta">--:--:--</span></span>
            <?php endif; ?>
        </div>
</div>

<main id="contenido">
<!-- Hero -->
<section class="relative overflow-hidden bg-brand-dark bg-cover bg-center text-white" style="background-image: url('<?= $e($fondo) ?>');">
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-deep/40 via-transparent to-deep/20"></div>

    <div class="relative max-w-6xl mx-auto px-4 pb-16 pt-5 lg:pt-8">
        <h1 class="sr-only"><?= $e($tituloPlano) ?></h1>
        <!-- Banner del curso al inicio de la pagina -->
        <img src="<?= BASE_URL ?>assets/images/banner-icc-1600.webp"
             srcset="<?= BASE_URL ?>assets/images/banner-icc-800.webp 800w, <?= BASE_URL ?>assets/images/banner-icc-1600.webp 1600w"
             sizes="(min-width: 1152px) 1120px, calc(100vw - 32px)"
             alt="<?= $e($tituloPlano) ?>: banner del curso" width="1600" height="666" fetchpriority="high"
             class="block w-full rounded-2xl shadow-2xl ring-1 ring-white/20">

        <div class="mx-auto mt-8 max-w-3xl text-center">
            <div class="mb-4 flex flex-wrap justify-center gap-2">
                <span class="rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep">Especialización</span>
                <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-brand-dark"><i class="far fa-clock mr-1"></i><?= (int)$d['horas'] ?> horas académicas</span>
                <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-brand-dark"><i class="far fa-calendar-alt mr-1"></i>Inicio: <?= $e($d['inicioCorto']) ?></span>
            </div>
            <p class="text-base sm:text-lg text-sky-50"><?= $e($d['subtitulo']) ?></p>
            <div class="mt-6 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="#inscripcion" class="flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-7 py-3 font-display text-base font-bold text-deep shadow-lg hover:brightness-95 sm:w-auto">Inscribirme ahora <i class="fas fa-arrow-down" aria-hidden="true"></i></a>
                <a href="#cronograma" class="flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl border border-white/50 px-7 py-3 font-display text-base font-semibold text-white hover:bg-white/10 sm:w-auto">Ver el horario</a>
            </div>
        </div>
    </div>

    <!-- Borde ondulado hacia la siguiente seccion -->
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="absolute bottom-0 left-0 block h-10 w-full sm:h-16" aria-hidden="true"><path d="M0,40 C240,80 480,0 720,30 C960,60 1200,80 1440,20 L1440,80 L0,80 Z" fill="#ffffff"></path></svg>
</section>

<!-- Que incluye -->
<section class="bg-white pb-12 pt-4">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="reveal text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Todo lo que incluye tu inscripción</h2>
        <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($d['beneficios'] as $i => $b): ?>
            <div class="reveal flex items-center gap-4 rounded-2xl bg-mist p-4 transition hover:-translate-y-1 hover:shadow-lg">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl shadow <?= $coloresTile[$i % count($coloresTile)] ?>"><i class="<?= $iconoBeneficio($b) ?>"></i></span>
                <span class="font-semibold text-ink"><?= $e($b) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($d['video'])): ?>
<!-- Video -->
<section class="bg-gradient-to-b from-white to-mist px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h2 class="reveal text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Conoce el curso</h2>
        <div x-data="{ play: false }" class="reveal relative mt-6 aspect-video overflow-hidden rounded-2xl bg-deep shadow-2xl ring-4 ring-white">
            <template x-if="!play">
                <button type="button" @click="play = true" class="group absolute inset-0 h-full w-full" aria-label="Reproducir video del curso">
                    <img src="https://i.ytimg.com/vi/<?= $e($d['video']) ?>/hqdefault.jpg" alt="" loading="lazy" class="h-full w-full object-cover opacity-90">
                    <span class="absolute inset-0 flex items-center justify-center bg-deep/20">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-accent text-3xl text-deep shadow-2xl transition group-hover:scale-110"><i class="fas fa-play ml-1"></i></span>
                    </span>
                </button>
            </template>
            <template x-if="play">
                <iframe src="https://www.youtube.com/embed/<?= $e($d['video']) ?>?autoplay=1&rel=0" title="Video del curso" class="absolute inset-0 h-full w-full" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            </template>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Temario -->
<section id="temario" class="scroll-mt-28 bg-mist py-12">
    <div class="max-w-6xl mx-auto px-4">
        <p class="reveal text-center text-sm font-bold uppercase tracking-wider text-brand">Plan de estudios</p>
        <h2 class="reveal mt-1 text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Temario del curso</h2>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            <?php $n = 0; foreach ($d['temas'] as $titulo => $items): $c = $n % count($coloresTile); $n++; ?>
            <div class="reveal rounded-2xl border-t-4 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg <?= $bordesModulo[$c] ?>" x-data="{ open: window.innerWidth >= 768 }">
                <button type="button" @click="open = !open" :aria-expanded="open.toString()" class="flex w-full items-center gap-3 text-left">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-lg shadow <?= $coloresTile[$c] ?>"><i class="<?= $iconosModulo[$c] ?>"></i></span>
                    <span class="flex-1">
                        <span class="block text-xs font-bold uppercase tracking-wider text-muted">Módulo <?= $n ?></span>
                        <span class="block font-display font-bold text-brand-dark"><?= $e($titulo) ?></span>
                        <span class="block text-xs text-muted"><?= count($items) ?> <?= count($items) === 1 ? 'tema' : 'temas' ?></span>
                    </span>
                    <i class="fas fa-chevron-down text-muted transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <ul x-show="open" x-cloak class="mt-3 space-y-1.5 text-sm text-muted">
                    <?php foreach ($items as $corto => $completo): ?>
                    <li class="flex gap-2"><i class="fas fa-check-circle mt-1 text-xs text-brand"></i><span><?= $e($completo) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($d['extra'])): $x = $d['extra']; ?>
        <div class="reveal relative mt-6 overflow-hidden rounded-2xl bg-brand-dark bg-cover p-6 text-white shadow-xl sm:p-8" style="background-image: url('<?= $e($fondo) ?>');">
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-deep/80 to-brand/40"></div>
            <div class="relative">
                <h3 class="flex items-center gap-3 font-display text-xl sm:text-2xl font-bold"><span class="flex h-11 w-11 items-center justify-center rounded-full bg-accent text-deep shadow-lg"><i class="fas fa-lightbulb"></i></span> <?= $e($x['titulo']) ?></h3>
                <p class="mt-3 max-w-3xl text-sky-50"><?= $e($x['intro']) ?></p>
                <ul class="mt-4 grid gap-2 sm:grid-cols-2 text-sm">
                    <?php foreach ($x['items'] as $it): ?>
                    <li class="flex gap-2 rounded-xl bg-white/10 px-3 py-2"><i class="fas fa-bolt mt-0.5 text-accent"></i><span><?= $e($it) ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <p class="mt-5 inline-flex items-center gap-2 rounded-xl bg-accent px-4 py-3 text-sm font-bold text-deep shadow"><i class="fas fa-gift"></i>Bonus incluido: <?= $e($x['bonus']) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Cronograma -->
<section id="cronograma" class="scroll-mt-28 bg-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <p class="reveal text-center text-sm font-bold uppercase tracking-wider text-brand">Cronograma</p>
        <h2 class="reveal mt-1 text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Empezamos el <?= $e($d['inicioLargo']) ?></h2>
        <p class="reveal mx-auto mt-2 max-w-2xl text-center text-muted"><?= count($d['sesiones']) ?> clases en vivo por Zoom<?php if (!empty($d['hora'])): ?>, de <?= $e($d['hora']) ?> (hora de Perú, Colombia, Ecuador y Panamá)<?php endif; ?>.</p>
        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            <?php foreach ($d['sesiones'] as $i => $s): ?>
            <div class="reveal overflow-hidden rounded-xl bg-white text-center shadow-md ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-lg">
                <div class="py-1.5 text-xs font-bold uppercase tracking-widest <?= $i === 0 ? 'bg-accent text-deep' : 'bg-brand text-white' ?>"><?= $e($s['semana']) ?></div>
                <div class="pt-3 font-display text-5xl font-bold leading-none text-deep"><?= (int)$s['dia'] ?></div>
                <div class="pt-1 text-sm font-semibold uppercase tracking-wide text-muted"><?= $e($s['mes']) ?></div>
                <div class="pt-3 text-xs font-semibold text-brand"><i class="fas fa-video mr-1" aria-hidden="true"></i>Online · Zoom</div>
                <?php if (!empty($d['hora'])): ?><div class="pt-1 text-xs text-muted"><i class="far fa-clock mr-1" aria-hidden="true"></i><?= $e($d['horaCorta']) ?></div><?php endif; ?>
                <div class="py-3"><span class="rounded-full bg-mist px-3 py-1 text-xs font-bold text-brand"><?= $i === 0 ? 'Inicio · ' : '' ?>Clase <?= (int)$s['n'] ?></span></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Escalera de precios -->
<section id="precios" class="scroll-mt-28 bg-mist py-12">
    <div class="max-w-5xl mx-auto px-4">
        <p class="reveal text-center text-sm font-bold uppercase tracking-wider text-brand">Precio por fechas</p>
        <h2 class="reveal mt-1 text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Mientras antes te inscribes, menos pagas</h2>
        <div class="mt-10 grid gap-5 md:grid-cols-3 md:items-end">
            <?php foreach ($d['etapas'] as $et): ?>
            <?php if ($et['estado'] === 'actual'): ?>
            <div class="reveal relative rounded-2xl bg-brand-dark p-7 text-white shadow-2xl ring-2 ring-accent md:-translate-y-2">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-accent px-4 py-1 text-xs font-bold uppercase tracking-wide text-deep shadow"><i class="fas fa-bolt mr-1"></i>Precio de hoy</span>
                <p class="text-sm font-bold uppercase tracking-wide text-sky-100"><?= $e($et['nombre']) ?></p>
                <p class="mt-2 font-display text-5xl font-bold text-accent"><?= $d['simbolo'] ?><?= $fmt($et['precio']) ?></p>
                <p class="mt-2 text-sm text-sky-100"><?= $e($et['rango']) ?></p>
                <a href="#inscripcion" class="mt-5 flex min-h-[44px] items-center justify-center gap-2 rounded-xl bg-accent px-4 py-3 font-display font-bold text-deep shadow hover:brightness-95">Inscribirme por <?= $d['simbolo'] ?><?= $fmt($et['precio']) ?></a>
            <?php elseif ($et['estado'] === 'pasada'): ?>
            <div class="reveal rounded-2xl bg-white p-6 opacity-60 shadow-sm">
                <p class="text-sm font-bold uppercase tracking-wide text-muted"><?= $e($et['nombre']) ?></p>
                <p class="mt-2 font-display text-4xl font-bold text-muted line-through"><?= $d['simbolo'] ?><?= $fmt($et['precio']) ?></p>
                <p class="mt-2 text-sm text-muted"><?= $e($et['rango']) ?> (finalizada)</p>
            <?php else: ?>
            <div class="reveal rounded-2xl bg-white p-6 shadow-md">
                <p class="text-sm font-bold uppercase tracking-wide text-muted"><?= $e($et['nombre']) ?></p>
                <p class="mt-2 font-display text-4xl font-bold text-brand-dark"><?= $d['simbolo'] ?><?= $fmt($et['precio']) ?></p>
                <p class="mt-2 text-sm text-muted"><?= $e($et['rango']) ?></p>
            <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($d['galeria'])): ?>
<!-- Galeria -->
<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="reveal text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Así se trabaja en el curso</h2>
        <div class="mt-8 grid grid-cols-2 gap-3 lg:grid-cols-4">
            <?php foreach ($d['galeria'] as $img): ?>
            <img src="<?= $e($img['url']) ?>" alt="" loading="lazy" class="reveal aspect-[4/3] w-full rounded-2xl object-cover shadow-md">
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($d['testimonios'])): ?>
<?php
$testAnchas = array_filter($d['testimonios'], function ($t) { return $t['ancha']; });
$testVerticales = array_filter($d['testimonios'], function ($t) { return !$t['ancha']; });
?>
<!-- Testimonios (imagenes reales de alumnos) -->
<section class="bg-mist py-12">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="reveal text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Lo que dicen nuestros alumnos</h2>
        <?php foreach ($testAnchas as $t): ?>
        <img src="<?= $e($t['url']) ?>" alt="Opiniones de alumnos de ICC" loading="lazy" class="reveal mx-auto mt-8 w-full max-w-4xl rounded-2xl shadow-xl ring-4 ring-white">
        <?php endforeach; ?>
        <?php if ($testVerticales): ?>
        <div class="mt-8 flex snap-x gap-4 overflow-x-auto pb-4 md:grid md:grid-cols-3 md:overflow-visible lg:grid-cols-4">
            <?php foreach ($testVerticales as $t): ?>
            <img src="<?= $e($t['url']) ?>" alt="Testimonio de un alumno" loading="lazy" class="w-64 shrink-0 snap-center rounded-2xl shadow-md ring-1 ring-black/5 md:w-full">
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- Inscripcion y pago -->
<section id="inscripcion" class="relative scroll-mt-28 overflow-hidden bg-brand-dark bg-cover bg-center py-14" style="background-image: url('<?= $e($fondo) ?>');">
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-deep/70 to-brand-dark/50"></div>
    <div class="relative max-w-3xl mx-auto px-4">
        <p class="text-center text-sm font-bold uppercase tracking-wider text-accent">Inscripción</p>
        <h2 class="mt-1 text-center font-display text-2xl sm:text-3xl font-bold text-white">Completa tu inscripción</h2>

        <div x-show="!success" class="mt-8 space-y-6">
            <div x-show="error" x-cloak id="error-pago" role="alert" tabindex="-1" class="rounded-2xl border-2 border-red-600 bg-red-50 p-4 text-sm font-semibold text-red-800"><i class="fas fa-exclamation-circle mr-2" aria-hidden="true"></i><span x-text="error"></span></div>
            <!-- Paso 1 -->
            <div class="rounded-2xl bg-white p-6 shadow-2xl">
                <h3 class="flex items-center gap-3 font-display text-lg font-bold text-brand-dark"><span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent text-sm font-bold text-deep">1</span> Datos del participante</h3>
                <p class="mt-1 text-sm text-muted">Con estos datos se emite tu certificado.</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="sm:col-span-2 text-sm font-semibold">DNI o documento de identidad
                        <input x-model="dni" aria-required="true" type="text" inputmode="text" autocomplete="off" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand" placeholder="DNI, C.E. o pasaporte">
                    </label>
                    <label class="text-sm font-semibold">Nombres
                        <input x-model="nombre" aria-required="true" type="text" autocomplete="given-name" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand">
                    </label>
                    <label class="text-sm font-semibold">Apellidos
                        <input x-model="apellido" aria-required="true" type="text" autocomplete="family-name" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand">
                    </label>
                    <label class="sm:col-span-2 text-sm font-semibold">Celular / WhatsApp
                        <input x-model="celular" aria-required="true" type="tel" autocomplete="tel" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand" placeholder="+51 987 654 321">
                    </label>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="rounded-2xl bg-white p-6 shadow-2xl">
                <h3 class="flex items-center gap-3 font-display text-lg font-bold text-brand-dark"><span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent text-sm font-bold text-deep">2</span> Método de pago</h3>
                <p class="mt-1 text-sm text-muted">Total a pagar: <strong class="text-brand"><?= $d['simbolo'] ?><?= $fmt($d['precio']) ?> <?= $e($d['moneda']) ?></strong></p>

                <div class="mt-4 flex flex-wrap gap-2 rounded-xl bg-mist p-1.5" role="tablist" aria-label="Método de pago">
                    <?php if ($hayManual): ?>
                    <button type="button" role="tab" :aria-selected="(tab === 'manual').toString()" @click="setTab('manual')" :class="tab === 'manual' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-qrcode mr-1"></i> Yape / Plin</button>
                    <?php endif; ?>
                    <button type="button" role="tab" :aria-selected="(tab === 'paypal').toString()" @click="setTab('paypal')" :class="tab === 'paypal' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-credit-card mr-1"></i> PayPal / Tarjeta</button>
                    <?php if ($hayHotmart): ?>
                    <button type="button" role="tab" :aria-selected="(tab === 'hotmart').toString()" @click="setTab('hotmart')" :class="tab === 'hotmart' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-globe-americas mr-1"></i> Otros métodos</button>
                    <?php endif; ?>
                </div>

                <?php if ($hayManual): ?>
                <!-- Yape / Plin -->
                <div x-show="tab === 'manual'" x-cloak role="tabpanel" class="mt-5">
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="manualMethod = 'yape'" :class="manualMethod === 'yape' ? 'border-purple-500 bg-purple-50 font-bold' : 'border-line'" class="rounded-xl border-2 px-3 py-3 text-sm">Yape</button>
                        <button type="button" @click="manualMethod = 'plin'" :class="manualMethod === 'plin' ? 'border-teal-500 bg-teal-50 font-bold' : 'border-line'" class="rounded-xl border-2 px-3 py-3 text-sm">Plin</button>
                    </div>
                    <div class="mt-5 flex flex-col items-center rounded-2xl bg-surface p-5 text-center">
                        <img :src="manualDetails[manualMethod].qr" :alt="'QR de ' + manualDetails[manualMethod].nombre" class="max-h-72 w-auto rounded-xl shadow-md">
                        <p class="mt-3 text-sm text-muted">Escanea con tu app y paga a nombre de</p>
                        <p class="font-display text-lg font-bold" x-text="manualDetails[manualMethod].titular"></p>
                        <p class="mt-2 text-sm">Monto exacto: <strong class="text-brand">S/ <?= $fmt($d['js']['precioPen']) ?></strong></p>
                        <a :href="manualDetails[manualMethod].qr" :download="'QR-' + manualDetails[manualMethod].nombre + '.jpg'" class="mt-3 inline-flex min-h-[44px] items-center gap-2 rounded-full border border-brand px-5 text-sm font-bold text-brand hover:bg-mist"><i class="fas fa-download" aria-hidden="true"></i> Guardar el QR en mi celular</a>
                        <p class="mt-1 max-w-xs text-xs text-muted">Desde el celular no puedes escanear tu propia pantalla: guarda el QR y ábrelo desde tu app (si permite elegir de la galería) o escanéalo desde otra pantalla.</p>
                    </div>
                    <div class="mt-5">
                        <label class="text-sm font-semibold">Sube la captura de tu pago
                            <span class="mt-1 flex cursor-pointer flex-col items-center rounded-xl border-2 border-dashed border-line bg-surface px-4 py-6 text-center hover:border-brand focus-within:border-brand focus-within:ring-2 focus-within:ring-brand">
                                <i class="fas fa-upload text-2xl text-brand"></i>
                                <span class="mt-2 text-sm font-semibold" x-text="voucherFile ? '✓ ' + voucherFile.name : 'Toca para elegir la imagen o PDF'"></span>
                                <span class="text-xs font-normal text-muted">JPG, PNG o PDF</span>
                                <input type="file" class="sr-only" accept="image/*,application/pdf" @change="voucherFile = $event.target.files[0]">
                            </span>
                        </label>
                    </div>
                    <button type="button" @click="enviarVoucher()" :disabled="enviando" class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-accent px-5 py-4 font-display font-bold text-deep shadow-lg hover:brightness-95 disabled:opacity-60">
                        <i class="fas fa-check-circle"></i> <span x-text="enviando ? 'Enviando…' : 'Confirmar mi inscripción'"></span>
                    </button>
                </div>
                <?php endif; ?>

                <!-- PayPal -->
                <div x-show="tab === 'paypal'" x-cloak role="tabpanel" class="mt-5">
                    <p class="text-sm text-muted">Paga con tu cuenta PayPal o con tarjeta de crédito o débito. PayPal cobra en dólares: <strong class="text-ink">US$ <span x-text="amountInUSD.toFixed(2)"></span></strong>.</p>
                    <div id="paypal-button-container" class="mt-4"></div>
                </div>

                <?php if ($hayHotmart): ?>
                <!-- Hotmart (solo Mexico y solo cuando hay oferta con el precio de esta etapa) -->
                <div x-show="tab === 'hotmart'" x-cloak role="tabpanel" class="mt-5">
                    <p class="text-sm text-muted">Paga con métodos de tu país (transferencia SPEI, OXXO, tarjeta local y más). El precio final se muestra en tu moneda local y puede incluir impuestos locales (por ejemplo, IVA).</p>
                    <template x-if="tab === 'hotmart'">
                        <iframe :src="CFG.hotmart" loading="lazy" allow="payment *" title="Pago con Hotmart" class="mt-4 w-full rounded-xl border border-line/60" style="height: 1900px;"></iframe>
                    </template>
                    <p class="mt-3 text-center text-xs text-muted">¿No carga? <button type="button" @click="window.open(CFG.hotmart, '_blank', 'noopener')" class="underline">Ábrelo en una pestaña nueva</button>. Tus accesos llegan al correo tras confirmarse el pago.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center text-sm text-sky-100">
                <p><i class="fas fa-file-invoice mr-1" aria-hidden="true"></i> ¿Necesitas boleta o factura? Se emite con IGV (18 %) adicional.</p>
                <a href="<?= $e($waComprobante) ?>" target="_blank" rel="noopener" class="mt-2 inline-flex min-h-[44px] items-center gap-2 rounded-full bg-white px-5 font-bold text-brand-dark hover:bg-mist"><i class="fab fa-whatsapp" aria-hidden="true"></i> Pedirla por WhatsApp</a>
            </div>
        </div>

        <!-- Exito -->
        <div x-show="success" x-cloak role="status" aria-live="polite" class="mt-8 rounded-2xl bg-white p-8 text-center shadow-2xl">
            <div class="text-5xl" aria-hidden="true">✅</div>
            <template x-if="metodoUsado === 'manual'">
                <div>
                    <h3 class="mt-3 font-display text-2xl font-bold text-brand-dark">¡Comprobante recibido!</h3>
                    <p class="mt-2 text-muted">Validaremos tu pago y te enviaremos tus accesos. Para agilizarlo, escríbenos por WhatsApp confirmando tus datos.</p>
                    <a href="<?= $wa ?>?text=<?= rawurlencode('Hola, acabo de subir mi comprobante para el curso ' . $d['curso'] . '. Mis nombres son:') ?>" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white shadow-lg"><i class="fab fa-whatsapp text-xl"></i> Escribir por WhatsApp</a>
                </div>
            </template>
            <template x-if="metodoUsado === 'paypal'">
                <div>
                    <h3 class="mt-3 font-display text-2xl font-bold text-brand-dark">¡Pago recibido!</h3>
                    <p class="mt-2 text-muted">En unos minutos recibirás tus credenciales por correo. Si necesitas ayuda, usa el chat de soporte de abajo a la derecha.</p>
                </div>
            </template>
        </div>
    </div>
</section>
</main>

<footer class="bg-deep py-8 text-center text-sm text-sky-100">
    <div class="max-w-6xl mx-auto px-4">
        <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC" class="mx-auto h-10 w-auto">
        <p class="mt-3">Medios de pago: Yape · Plin · PayPal · Tarjeta de crédito o débito</p>
        <p class="mt-1">informes@icc.com.pe · <a href="<?= $wa ?>" class="inline-flex min-h-[44px] items-center underline" target="_blank" rel="noopener">+51 941 208 020</a></p>
    </div>
</footer>

<!-- Barra fija en celular -->
<div class="fixed inset-x-0 bottom-0 z-40 border-t border-line/60 bg-white p-3 shadow-[0_-4px_16px_rgba(0,0,0,0.12)] md:hidden">
    <div class="mx-auto flex max-w-md items-center justify-between gap-3">
        <div>
            <p class="font-display text-base font-bold leading-tight text-brand-dark"><?= $e($d['etapaNombre']) ?></p>
            <?php if ($d['js']['hastaMs']): ?><p class="mt-0.5 text-xs font-bold text-red-600"><i class="far fa-clock" aria-hidden="true"></i> <span x-text="cuenta"></span></p><?php else: ?><p class="mt-0.5 text-xs text-muted">Inicio: <?= $e($d['inicioCorto']) ?></p><?php endif; ?>
        </div>
        <a href="#inscripcion" class="rounded-xl bg-accent px-5 py-3 font-display text-sm font-bold text-deep shadow-md">Inscribirme</a>
    </div>
</div>

<?php
// Consejos que Bruno muestra al llegar a cada seccion (solo datos reales de la oferta)
$tipsBruno = [];
if (!empty($d['hora'])) {
    $tipsBruno[] = ['sel' => '#cronograma', 'texto' => 'Todas las clases son de ' . $d['hora'] . ' por Zoom.'];
}
$tipsBruno[] = ['sel' => '#precios', 'texto' => 'Hoy el precio es ' . $d['simbolo'] . $fmt($d['precio']) . '.' . ($d['aviso'] ? ' ' . $d['aviso'] . '.' : '')];
$tipsBruno[] = ['sel' => '#inscripcion', 'texto' => 'Completa tus datos y elige cómo pagar. Si tienes dudas, escríbenos.', 'wa' => true];
?>
<!-- Bruno, mascota de ICC: camina con el scroll, salta al dar un consejo y ayuda a navegar -->
<div id="bruno" class="bruno" data-tips="<?= $e(json_encode($tipsBruno, JSON_UNESCAPED_UNICODE)) ?>" data-wa="<?= $e($wa) ?>">
    <div id="bruno-burbuja" class="bruno-burbuja" role="status" aria-live="polite" hidden></div>
    <button type="button" id="bruno-btn" class="bruno-btn" aria-label="Ingeniero Bruno, asistente de ICC. Abrir ayuda" aria-expanded="false">
        <svg viewBox="0 0 180 280" xmlns="http://www.w3.org/2000/svg" class="bruno-svg" overflow="visible" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="b-pelo" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#a5602c"/><stop offset="1" stop-color="#7c4020"/></linearGradient>
                <linearGradient id="b-pelo2" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#8b4a24"/><stop offset="1" stop-color="#7a3f1e"/></linearGradient>
                <linearGradient id="b-chaleco" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#1d3f9c"/><stop offset="1" stop-color="#132c74"/></linearGradient>
                <linearGradient id="b-casco" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#ffffff"/><stop offset="1" stop-color="#dfe6f5"/></linearGradient>
                <clipPath id="b-rec"><path d="M56 110 C50 130 50 170 56 196 L124 196 C130 170 130 130 124 110 C110 104 70 104 56 110 Z"/></clipPath>
            </defs>
            <ellipse cx="90" cy="266" rx="38" ry="6" fill="#000" opacity=".22"/>
            <g class="b-todo">
                <g class="b-pierna b-pierna-i">
                    <rect x="62" y="192" width="24" height="56" rx="10" fill="#10245f"/>
                    <rect x="57" y="242" width="34" height="18" rx="8" fill="#1b1d2a"/><rect x="57" y="252" width="34" height="8" rx="4" fill="#0e0f18"/>
                </g>
                <g class="b-pierna b-pierna-d">
                    <rect x="94" y="192" width="24" height="56" rx="10" fill="#10245f"/>
                    <rect x="89" y="242" width="34" height="18" rx="8" fill="#1b1d2a"/><rect x="89" y="252" width="34" height="8" rx="4" fill="#0e0f18"/>
                </g>
                <g class="b-bob"><g class="b-torso">
                    <g class="b-brazo b-brazo-i">
                        <rect x="47" y="108" width="24" height="64" rx="12" fill="url(#b-pelo2)"/>
                        <circle cx="59" cy="174" r="14" fill="#8b4a24"/><ellipse cx="59" cy="178" rx="7" ry="6" fill="#e3b98c" opacity=".55"/>
                    </g>
                    <g class="b-brazo b-brazo-d">
                        <rect x="109" y="108" width="24" height="64" rx="12" fill="url(#b-pelo2)"/>
                        <circle cx="121" cy="174" r="14" fill="#8b4a24"/><ellipse cx="121" cy="178" rx="7" ry="6" fill="#e3b98c" opacity=".55"/>
                    </g>
                    <ellipse cx="90" cy="112" rx="26" ry="14" fill="#8b4a24"/>
                    <path d="M56 110 C50 130 50 170 56 196 L124 196 C130 170 130 130 124 110 C110 104 70 104 56 110 Z" fill="url(#b-chaleco)"/>
                    <g clip-path="url(#b-rec)">
                        <rect x="40" y="148" width="100" height="8" fill="#d5dcec"/><rect x="40" y="148" width="100" height="2" fill="#f3f6fc"/>
                        <rect x="40" y="172" width="100" height="8" fill="#d5dcec"/><rect x="40" y="172" width="100" height="2" fill="#f3f6fc"/>
                        <rect x="63" y="104" width="7" height="44" fill="#d5dcec" opacity=".9"/><rect x="110" y="104" width="7" height="44" fill="#d5dcec" opacity=".9"/>
                    </g>
                    <path d="M72 106 L90 130 L108 106 Z" fill="#8b4a24"/>
                    <line x1="90" y1="130" x2="90" y2="196" stroke="#0c1f57" stroke-width="2"/>
                    <text x="107" y="143" text-anchor="middle" font-family="'Plus Jakarta Sans','Arial Black',Arial,sans-serif" font-weight="800" font-size="11" fill="#fff">icc</text>
                    <rect x="64" y="132" width="17" height="13" rx="2" fill="#fff" stroke="#b9c6e3" stroke-width=".8"/>
                    <rect x="67" y="135" width="11" height="2" fill="#0050f4"/><rect x="67" y="139" width="8" height="1.6" fill="#94a3c9"/>
                    <rect x="56" y="190" width="68" height="8" rx="2" fill="#12183d"/><rect x="84" y="191" width="12" height="6" rx="1.5" fill="#d5dcec"/>
                    <g class="b-cabeza">
                        <circle cx="54" cy="54" r="13" fill="#8b4a24"/><circle cx="54" cy="55" r="7" fill="#e3b98c"/>
                        <circle cx="126" cy="54" r="13" fill="#8b4a24"/><circle cx="126" cy="55" r="7" fill="#e3b98c"/>
                        <ellipse cx="90" cy="72" rx="42" ry="37" fill="url(#b-pelo)"/>
                        <ellipse cx="90" cy="88" rx="22" ry="17" fill="#e3b98c"/>
                        <ellipse cx="90" cy="79" rx="9" ry="6.2" fill="#2a1811"/><ellipse cx="87.5" cy="77" rx="2.8" ry="1.5" fill="#fff" opacity=".45"/>
                        <path d="M90 84 V90" stroke="#2a1811" stroke-width="2.2" stroke-linecap="round"/>
                        <path class="b-sonrisa" d="M79 91 Q90 101 101 91" stroke="#2a1811" stroke-width="2.4" fill="none" stroke-linecap="round"/>
                        <g class="b-boca"><ellipse cx="90" cy="93" rx="8.5" ry="6.5" fill="#4a1512"/><ellipse cx="90" cy="96" rx="5" ry="2.6" fill="#d9576a"/></g>
                        <circle cx="72" cy="66" r="5.2" fill="#22130d"/><circle cx="73.6" cy="64.4" r="1.7" fill="#fff"/>
                        <circle cx="108" cy="66" r="5.2" fill="#22130d"/><circle cx="109.6" cy="64.4" r="1.7" fill="#fff"/>
                        <g class="b-parpado b-parpado-i"><ellipse cx="72" cy="66" rx="6.6" ry="6.4" fill="#93502a"/></g>
                        <g class="b-parpado b-parpado-d"><ellipse cx="108" cy="66" rx="6.6" ry="6.4" fill="#93502a"/></g>
                        <path d="M63 58 Q72 52 80 56.5" stroke="#5e2f16" stroke-width="2.4" fill="none" stroke-linecap="round"/>
                        <path d="M100 56.5 Q108 52 117 58" stroke="#5e2f16" stroke-width="2.4" fill="none" stroke-linecap="round"/>
                        <path d="M49 52 C48 14 132 14 131 52 Z" fill="url(#b-casco)"/>
                        <path d="M83 19 Q90 16.5 97 19 L97 50 L83 50 Z" fill="#e4ebf8"/>
                        <path d="M113 24 Q127 34 129 51 L119 51 Q119 37 108 26 Z" fill="#cdd7ec" opacity=".85"/>
                        <ellipse cx="66" cy="31" rx="9" ry="4" fill="#fff" opacity=".85" transform="rotate(-28 66 31)"/>
                        <rect x="42" y="47" width="96" height="10" rx="5" fill="#eef2fb" stroke="#bcc8e4" stroke-width="1"/>
                        <rect x="72" y="30" width="36" height="15" rx="3" fill="#fff" stroke="#c9d3ea" stroke-width=".8"/>
                        <text x="90" y="41.5" text-anchor="middle" font-family="'Plus Jakarta Sans','Arial Black',Arial,sans-serif" font-weight="800" font-size="12.5" fill="#0050f4">icc</text>
                    </g>
                </g></g>
            </g>
        </svg>
    </button>
</div>

<script>
(function () {
    const el = document.getElementById('bruno');
    if (!el) return;
    try { if (localStorage.getItem('bruno_oculto') === '1') { el.remove(); return; } } catch (e) {}

    const reduceSistema = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let reduce = reduceSistema; // se respeta, salvo que la persona active la animacion desde el menu de Bruno
    try { if (reduceSistema && localStorage.getItem('bruno_anim') === '1') { reduce = false; el.classList.add('anim-on'); } } catch (e) {}
    const btn = document.getElementById('bruno-btn');
    const burbuja = document.getElementById('bruno-burbuja');
    const tips = JSON.parse(el.dataset.tips || '[]');
    const wa = el.dataset.wa;
    let ultimo = window.scrollY, ticking = false, caminaT = null, ocultaT = null, x = 8;

    function posicionarBurbuja() {
        burbuja.classList.toggle('bruno-burbuja-der', x + 240 > window.innerWidth);
    }

    function actualizar() {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        const prog = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0;
        const margen = 8, ancho = el.offsetWidth;
        x = margen + prog * (window.innerWidth - ancho - margen * 2);
        el.style.transform = 'translateX(' + x.toFixed(1) + 'px)';
        const dif = window.scrollY - ultimo;
        if (Math.abs(dif) > 2) {
            if (!reduce) {
                el.classList.add('camina');
                clearTimeout(caminaT);
                caminaT = setTimeout(() => el.classList.remove('camina'), 220);
            }
        }
        ultimo = window.scrollY;
        ticking = false;
        posicionarBurbuja();
    }
    window.addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(actualizar); } }, { passive: true });
    window.addEventListener('resize', actualizar);
    actualizar();

    function animar(clase, ms) {
        if (reduce) return;
        el.classList.remove(clase);
        void el.offsetWidth;
        el.classList.add(clase);
        setTimeout(() => el.classList.remove(clase), ms);
    }
    const saltar = () => animar('salta', 900);
    let hablaT = null;
    function hablar() {
        if (reduce) return;
        el.classList.add('habla');
        clearTimeout(hablaT);
        hablaT = setTimeout(() => el.classList.remove('habla'), 2600);
    }

    function cerrar() {
        el.classList.remove('arriba', 'habla');
        burbuja.hidden = true;
        burbuja.textContent = '';
        btn.setAttribute('aria-expanded', 'false');
        clearTimeout(ocultaT);
    }

    function enlace(texto, href, ext) {
        const a = document.createElement('a');
        a.textContent = texto;
        a.href = href;
        a.className = 'bruno-accion';
        if (ext) { a.target = '_blank'; a.rel = 'noopener'; }
        a.addEventListener('click', cerrar);
        return a;
    }

    function mostrar(texto, acciones, autocierre) {
        burbuja.textContent = '';
        const cerrarBtn = document.createElement('button');
        cerrarBtn.type = 'button';
        cerrarBtn.className = 'bruno-cerrar';
        cerrarBtn.setAttribute('aria-label', 'Cerrar mensaje');
        cerrarBtn.textContent = '×';
        cerrarBtn.addEventListener('click', cerrar);
        const p = document.createElement('p');
        p.textContent = texto;
        burbuja.append(cerrarBtn, p);
        (acciones || []).forEach(a => burbuja.appendChild(a));
        burbuja.hidden = false;
        el.classList.add('arriba');
        posicionarBurbuja();
        saltar();
        hablar();
        clearTimeout(ocultaT);
        if (autocierre) ocultaT = setTimeout(cerrar, 6500);
    }

    function menu() {
        const ocultar = document.createElement('button');
        ocultar.type = 'button';
        ocultar.className = 'bruno-accion bruno-accion-sec';
        ocultar.textContent = 'Ocultar a Bruno';
        ocultar.addEventListener('click', () => {
            try { localStorage.setItem('bruno_oculto', '1'); } catch (e) {}
            el.remove();
        });
        const acciones = [
            enlace('Ver el horario', '#cronograma'),
            enlace('Inscribirme', '#inscripcion'),
            enlace('Hablar por WhatsApp', wa, true)
        ];
        // Si el dispositivo tiene las animaciones desactivadas, Bruno queda quieto: se ofrece activarlas (o desactivarlas de nuevo)
        if (reduceSistema) {
            const anim = document.createElement('button');
            anim.type = 'button';
            anim.className = 'bruno-accion bruno-accion-sec';
            anim.textContent = reduce ? 'Activar animaciones de Bruno' : 'Desactivar animaciones';
            anim.addEventListener('click', () => {
                try { localStorage.setItem('bruno_anim', reduce ? '1' : '0'); } catch (e) {}
                reduce = !reduce;
                el.classList.toggle('anim-on', !reduce);
                cerrar();
                if (!reduce) animar('saluda', 1350);
            });
            acciones.push(anim);
        }
        acciones.push(ocultar);
        mostrar('Hola, soy Bruno, el ingeniero de ICC. ¿Te ayudo?', acciones, false);
        btn.setAttribute('aria-expanded', 'true');
    }

    btn.addEventListener('click', () => { if (burbuja.hidden) { animar('saluda', 1350); menu(); } else { cerrar(); } });

    // Consejos automaticos: una sola vez por seccion y sin interrumpir mientras se escribe
    const escribiendo = () => /^(INPUT|TEXTAREA)$/.test((document.activeElement || {}).tagName || '');
    if ('IntersectionObserver' in window) {
        tips.forEach(t => {
            const sec = document.querySelector(t.sel);
            if (!sec) return;
            const io = new IntersectionObserver((entradas) => {
                entradas.forEach(en => {
                    if (!en.isIntersecting || escribiendo() || !burbuja.hidden) return;
                    io.disconnect();
                    mostrar(t.texto, t.wa ? [enlace('Escribir por WhatsApp', wa, true)] : [], true);
                });
            }, { threshold: 0.35 });
            io.observe(sec);
        });
    }

    // De vez en cuando saluda solo (si no hay un mensaje abierto ni se esta escribiendo)
    setInterval(() => { if (!reduce && burbuja.hidden && !document.hidden && !escribiendo()) animar('saluda', 1350); }, 9000);

    // Saludo inicial (una vez por visita)
    try {
        if (!sessionStorage.getItem('bruno_saludo')) {
            sessionStorage.setItem('bruno_saludo', '1');
            setTimeout(() => { if (burbuja.hidden && !escribiendo()) animar('saluda', 1350); mostrar('Hola, soy Bruno. Toca si necesitas ayuda.', [], true); }, 5000);
        }
    } catch (e) {}
})();
</script>

<script>
    const CFG = <?= $js ?>;

    // Aparicion suave de las secciones al hacer scroll
    (function () {
        const els = document.querySelectorAll('.reveal');
        if (!('IntersectionObserver' in window)) { els.forEach(el => el.classList.add('is-visible')); return; }
        const io = new IntersectionObserver((entries) => {
            entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); } });
        }, { threshold: 0.12 });
        els.forEach(el => io.observe(el));
    })();

    function checkoutV2() {
        return {
            tab: null,
            manualMethod: 'yape',
            voucherFile: null,
            dni: '', nombre: '', apellido: '', celular: '',
            enviando: false,
            success: false,
            error: '',
            metodoUsado: null,
            cuenta: '--:--:--',
            manualDetails: {
                yape: { qr: CFG.base + 'assets/images/Yape.jpg', titular: 'Mariela Ma.', nombre: 'Yape' },
                plin: { qr: CFG.base + 'assets/images/plin.jpg', titular: 'Ricardo Cardenas', nombre: 'Plin' }
            },

            // PayPal cobra siempre en dolares: en dolares se cobra el precio en USD de la etapa;
            // si el visitante ve soles, el equivalente al mismo cambio que usa el resto del sitio.
            get amountInUSD() {
                return CFG.moneda === 'USD' ? CFG.precioUsd : parseFloat((CFG.precioPen / CFG.tipoCambio).toFixed(2));
            },

            init() {
                this.tab = CFG.metodos.includes('manual') ? 'manual' : 'paypal';
                if (this.tab === 'paypal') setTimeout(() => this.renderPayPal(), 100);
                this.iniciarCuenta();
            },

            setTab(t) {
                this.tab = t;
                this.track(t);
                if (t === 'paypal') setTimeout(() => this.renderPayPal(), 50);
            },

            track(metodo) {
                try {
                    gtag('event', 'begin_checkout', {
                        currency: CFG.moneda,
                        value: CFG.moneda === 'USD' ? CFG.precioUsd : CFG.precioPen,
                        items: [{ item_name: CFG.curso }],
                        payment_provider: metodo,
                        transport_type: 'beacon'
                    });
                } catch (e) {}
            },

            // Cuenta regresiva REAL hasta el fin del precio de esta etapa (fecha fija del servidor)
            iniciarCuenta() {
                if (!CFG.hastaMs) return;
                const tick = () => {
                    const s = Math.floor((CFG.hastaMs - Date.now()) / 1000);
                    if (s <= 0) {
                        this.cuenta = '00:00:00';
                        // Recarga una sola vez para tomar el precio de la etapa siguiente
                        try {
                            if (!sessionStorage.getItem('v2_recarga')) { sessionStorage.setItem('v2_recarga', '1'); location.reload(); }
                        } catch (e) {}
                        return;
                    }
                    const d = Math.floor(s / 86400), h = Math.floor(s % 86400 / 3600), m = Math.floor(s % 3600 / 60), x = s % 60;
                    this.cuenta = (d > 0 ? d + 'd ' : '') + [h, m, x].map(n => String(n).padStart(2, '0')).join(':');
                };
                tick();
                setInterval(tick, 1000);
            },

            mostrarError(msg) {
                this.error = msg;
                this.$nextTick(() => {
                    const el = document.getElementById('error-pago');
                    if (el) { el.scrollIntoView({ behavior: 'smooth', block: 'center' }); el.focus({ preventScroll: true }); }
                });
            },

            datosCompletos() {
                return this.dni.trim() && this.nombre.trim() && this.apellido.trim() && this.celular.trim();
            },

            enviarVoucher() {
                if (!this.datosCompletos()) {
                    this.mostrarError('Por favor, completa tu DNI, nombres, apellidos y celular.');
                    return;
                }
                if (!this.voucherFile) {
                    this.mostrarError('Por favor, adjunta la captura de tu pago para continuar.');
                    return;
                }
                const fd = new FormData();
                fd.append('voucher', this.voucherFile);
                fd.append('curso', CFG.curso);
                fd.append('dni', this.dni);
                fd.append('nombre', this.nombre);
                fd.append('apellido', this.apellido);
                fd.append('celular', this.celular);

                this.error = '';
                this.enviando = true;
                fetch(CFG.base + 'checkout/voucher', { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            this.success = true;
                            this.metodoUsado = 'manual';
                            this.voucherFile = null;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            this.mostrarError('Ocurrió un error: ' + (data.error || 'Error desconocido'));
                        }
                    })
                    .catch(() => this.mostrarError('Error de conexión al subir el comprobante. Intenta nuevamente.'))
                    .finally(() => { this.enviando = false; });
            },

            renderPayPal() {
                const contenedor = document.getElementById('paypal-button-container');
                if (!contenedor || contenedor.children.length > 0) return;
                if (typeof paypal === 'undefined') { console.error('PayPal SDK no disponible.'); return; }
                const self = this;
                paypal.Buttons({
                    onClick: function (data, actions) {
                        // No se abre el pago de PayPal sin los datos del alumno
                        if (!self.datosCompletos()) {
                            self.mostrarError('Por favor, completa tus datos (DNI, nombres, apellidos y celular) antes de pagar.');
                            return actions.reject();
                        }
                        self.error = '';
                        return actions.resolve();
                    },
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: { currency_code: 'USD', value: self.amountInUSD.toString() },
                                description: 'Acceso al curso: ' + CFG.curso
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        return actions.order.capture().then(function () {
                            // El dinero ya se movio en PayPal: se muestra el exito de inmediato y el
                            // servidor registra la venta verificando la orden con PayPal (best-effort).
                            self.success = true;
                            self.metodoUsado = 'paypal';
                            if (typeof $crisp !== 'undefined') {
                                $crisp.push(['do', 'chat:show']);
                                setTimeout(() => $crisp.push(['do', 'chat:open']), 500);
                            }
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            fetch(CFG.base + 'checkout/paypal_confirm', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    orderID: data.orderID, curso: CFG.curso,
                                    dni: self.dni, nombre: self.nombre, apellido: self.apellido, celular: self.celular
                                })
                            })
                            .then(r => r.json())
                            .then(resp => { if (!resp.success) console.error('No se pudo registrar la venta de PayPal:', resp.error, data.orderID); })
                            .catch(err => console.error('Error confirmando PayPal (orden ' + data.orderID + '):', err));
                        });
                    },
                    onError: function (err) {
                        console.error('PayPal Error:', err);
                        self.mostrarError('Hubo un inconveniente con el pago en PayPal. Por favor, intenta de nuevo.');
                    }
                }).render('#paypal-button-container');
            }
        };
    }
</script>
</body>
</html>
