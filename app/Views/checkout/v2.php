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
// PayPal siempre esta disponible; si es el unico metodo (ej. visitante internacional sin
// oferta de Hotmart en esta etapa) no tiene sentido mostrar pestañas para elegir entre uno solo
$totalMetodos = 1 + ($hayManual ? 1 : 0) + ($hayHotmart ? 1 : 0);
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
$iconosModulo = ['fas fa-bolt', 'fas fa-drafting-compass', 'fas fa-tachometer-alt', 'fas fa-shield-alt', 'fas fa-cogs', 'fas fa-plug', 'fas fa-robot'];
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/checkout-v2.css?v=20">
    <!-- El navegador descubre el <img> de Bruno recien al final del HTML (esta muy abajo en la pagina);
         con esto empieza a bajarlo desde ya, para que ya este listo y animando cuando se vea -->
    <link rel="preload" as="image" type="image/webp" href="<?= BASE_URL ?>assets/images/mascota/bruno-idle.webp">
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
                <span class="flex items-center gap-1.5 text-sky-100"><i class="fas fa-lock text-emerald-400"></i> Pago seguro</span>
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
            <span class="hidden shrink-0 rounded-full bg-accent px-3 py-0.5 font-mono text-xs font-bold text-deep sm:inline-block" title="Tiempo restante de este precio"><i class="far fa-clock mr-1"></i><span x-text="cuenta">--:--:--</span></span>
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

<!-- Certificado (modelo referencial: sin firmas ni datos de ninguna persona) -->
<section class="bg-white pb-12 pt-4">
    <div class="max-w-5xl mx-auto px-4">
        <p class="reveal text-center text-sm font-bold uppercase tracking-wider text-brand">Certificación</p>
        <h2 class="reveal mt-1 text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Recibe tu certificado de participación</h2>
        <p class="reveal mx-auto mt-2 max-w-2xl text-center text-muted">Tu inscripción incluye un certificado de participación con código QR, emitido con los datos que registres al inscribirte.</p>
        <figure class="reveal mx-auto mt-8 max-w-3xl">
            <img src="<?= BASE_URL ?>assets/images/certificado-modelo-1600.webp?v=20260924"
                 srcset="<?= BASE_URL ?>assets/images/certificado-modelo-800.webp?v=20260924 800w, <?= BASE_URL ?>assets/images/certificado-modelo-1600.webp?v=20260924 1600w"
                 sizes="(min-width: 768px) 768px, calc(100vw - 32px)"
                 alt="Modelo del certificado de participación de ICC, con código QR" width="1600" height="1131" loading="lazy"
                 class="w-full rounded-2xl shadow-xl ring-1 ring-black/10">
            <figcaption class="mt-3 text-center text-xs text-muted">Modelo referencial del certificado.</figcaption>
        </figure>
    </div>
</section>

<?php if (!empty($d['video'])): ?>
<!-- Video -->
<section class="bg-gradient-to-b from-white to-mist px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h2 class="reveal text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Conoce el curso</h2>
        <div x-data="videoCurso()"
             class="reveal relative mt-6 aspect-video overflow-hidden rounded-2xl bg-deep shadow-2xl ring-4 ring-white">
            <template x-if="!play">
                <button type="button" @click="play = true" class="group absolute inset-0 h-full w-full" aria-label="Reproducir video del curso">
                    <img src="https://i.ytimg.com/vi/<?= $e($d['video']) ?>/hqdefault.jpg" alt="" loading="lazy" class="h-full w-full object-cover opacity-90">
                    <span class="absolute inset-0 flex items-center justify-center bg-deep/20">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-accent text-3xl text-deep shadow-2xl transition group-hover:scale-110"><i class="fas fa-play ml-1"></i></span>
                    </span>
                </button>
            </template>
            <template x-if="play">
                <!-- mute=1: es la unica forma de que un navegador deje reproducir un video solo, sin que la
                     persona toque nada antes; el control de volumen del propio reproductor de YouTube queda
                     visible por si alguien quiere subirle el audio. enablejsapi=1 permite reiniciarlo desde
                     el principio cuando la persona llega a esta seccion (ver videoCurso() al final). -->
                <iframe src="https://www.youtube.com/embed/<?= $e($d['video']) ?>?autoplay=1&mute=1&rel=0&playsinline=1&enablejsapi=1" title="Video del curso" class="absolute inset-0 h-full w-full" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
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
            <?php $n = 0; foreach ($d['temas'] as $titulo => $items): $icono = $iconosModulo[$n % count($iconosModulo)]; $colorTile = $coloresTile[$n % count($coloresTile)]; $bordeModulo = $bordesModulo[$n % count($bordesModulo)]; $n++; ?>
            <div class="reveal rounded-2xl border-t-4 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg <?= $bordeModulo ?>" x-data="{ open: window.innerWidth >= 768 }">
                <button type="button" @click="open = !open" :aria-expanded="open.toString()" class="flex w-full items-center gap-3 text-left">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-lg shadow <?= $colorTile ?>"><i class="<?= $icono ?>"></i></span>
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
                <h3 class="flex items-center gap-3 font-display text-xl sm:text-2xl font-bold"><span class="flex h-11 w-11 items-center justify-center rounded-full bg-accent text-deep shadow-lg"><i class="fas fa-robot"></i></span> <?= $e($x['titulo']) ?></h3>
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
        <h2 class="reveal text-center font-display text-2xl sm:text-3xl font-bold text-brand-dark">Equipos y materiales del curso</h2>
        <?php
        // Con pocas fotos se ven grandes (no arrinconadas a un lado); con 4 o mas, cuadricula de 2 / 4 columnas
        $nGal = count($d['galeria']);
        $colsGal = $nGal <= 2 ? 'mx-auto max-w-4xl grid-cols-1 sm:grid-cols-2' : ($nGal === 3 ? 'grid-cols-1 sm:grid-cols-3' : 'grid-cols-2 lg:grid-cols-4');
        ?>
        <div class="mt-8 grid gap-3 sm:gap-4 <?= $colsGal ?>">
            <?php foreach ($d['galeria'] as $img): ?>
            <img src="<?= $e($img['url']) ?>" alt="<?= $e($img['alt'] ?? '') ?>" width="1200" height="900" loading="lazy" class="reveal aspect-[4/3] w-full rounded-2xl object-cover shadow-md">
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($d['testimonios']) || !empty($d['chats'])): ?>
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
        <?php if (!empty($d['chats'])): ?>
        <!-- Capturas de chat de alumnos (recortadas al mensaje) -->
        <div class="mx-auto mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($d['chats'] as $c): ?>
            <img src="<?= $e($c['url']) ?>" alt="<?= $e($c['alt']) ?>" width="678" height="400" loading="lazy" class="reveal w-full rounded-2xl shadow-md ring-1 ring-black/5">
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
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
                    <label class="sm:col-span-2 text-sm font-semibold">DNI o documento de identidad<?php if ($d['moneda'] === 'USD'): ?> <span class="font-normal text-muted">(opcional)</span><?php endif; ?>
                        <input x-model="dni" <?= $d['moneda'] === 'USD' ? '' : 'aria-required="true"' ?> type="text" inputmode="text" autocomplete="off" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand" placeholder="<?= $d['moneda'] === 'USD' ? 'Si tu país no usa DNI, déjalo en blanco' : 'DNI, C.E. o pasaporte' ?>">
                        <?php if ($d['moneda'] === 'USD'): ?><span class="mt-1 block text-xs font-normal text-muted">Si en tu país no existe este documento, puedes dejarlo vacío. Escribe tus nombres y apellidos tal como quieres que salgan en tu certificado.</span><?php endif; ?>
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

                <?php if ($totalMetodos > 1): ?>
                <div class="mt-4 flex flex-wrap gap-2 rounded-xl bg-mist p-1.5" role="tablist" aria-label="Método de pago">
                    <?php if ($hayManual): ?>
                    <button type="button" role="tab" :aria-selected="(tab === 'manual').toString()" @click="setTab('manual')" :class="tab === 'manual' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-qrcode mr-1"></i> Yape / Plin</button>
                    <?php endif; ?>
                    <button type="button" role="tab" :aria-selected="(tab === 'paypal').toString()" @click="setTab('paypal')" :class="tab === 'paypal' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-credit-card mr-1"></i> PayPal / Tarjeta</button>
                    <?php if ($hayHotmart): ?>
                    <button type="button" role="tab" :aria-selected="(tab === 'hotmart').toString()" @click="setTab('hotmart')" :class="tab === 'hotmart' ? 'bg-brand text-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-globe-americas mr-1"></i> Otros métodos</button>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <p class="mt-1 text-sm text-muted">Pagas con PayPal o con tarjeta de crédito o débito.</p>
                <?php endif; ?>

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
                    <p class="mt-2 text-muted">Validaremos tu pago y te enviaremos tus accesos. Cuando esté validado, te enviaremos por WhatsApp el link del grupo del curso. Para agilizarlo, escríbenos confirmando tus datos.</p>
                    <a href="<?= $wa ?>?text=<?= rawurlencode('Hola, acabo de subir mi comprobante para el curso ' . $d['curso'] . '. Mis nombres son:') ?>" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white shadow-lg"><i class="fab fa-whatsapp text-xl"></i> Escribir por WhatsApp</a>
                </div>
            </template>
            <template x-if="metodoUsado === 'paypal'">
                <div>
                    <h3 class="mt-3 font-display text-2xl font-bold text-brand-dark">¡Pago recibido!</h3>
                    <p class="mt-2 text-muted">En unos minutos recibirás tus credenciales por correo. Si necesitas ayuda, usa el chat de soporte de abajo a la derecha.</p>
                    <!-- El link del grupo llega del servidor solo cuando PayPal confirma el pago (no va en el HTML) -->
                    <div x-show="grupo" x-cloak class="mt-5">
                        <p class="text-sm font-semibold text-brand-dark">Únete al grupo de WhatsApp del curso (también te lo enviamos por correo):</p>
                        <a :href="grupo" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-2 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white shadow-lg"><i class="fab fa-whatsapp text-xl"></i> Unirme al grupo</a>
                    </div>
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
$textoPrecio = 'Estás en ' . $d['etapaNombre'] . ': pagas ' . $d['simbolo'] . $fmt($d['precio']);
if ($d['descuento'] > 0) {
    $textoPrecio .= ' (' . $d['descuento'] . '% menos que el precio regular de ' . $d['simbolo'] . $fmt($d['precioRegular']) . ')';
}
$textoPrecio .= '.' . ($d['aviso'] ? ' ' . $d['aviso'] . '.' : '');
$tipsBruno[] = ['sel' => '#precios', 'texto' => $textoPrecio];
$tipsBruno[] = ['sel' => '#inscripcion', 'texto' => 'Completa tus datos y elige cómo pagar.'];
?>
<!-- Bruno, mascota de ICC: foto real animada con IA (fondo ya quitado), sigue el scroll y ayuda a navegar.
     La pose "explica" se carga recien la primera vez que se abre el mensaje (no antes, para no pesar de mas). -->
<div id="bruno" class="bruno" data-tips="<?= $e(json_encode($tipsBruno, JSON_UNESCAPED_UNICODE)) ?>" data-wa="<?= $e($wa) ?>">
    <div id="bruno-burbuja" class="bruno-burbuja" role="status" aria-live="polite" hidden></div>
    <div class="b-escena">
        <div class="b-sombra"></div>
        <button type="button" id="bruno-btn" class="bruno-btn" aria-label="Ingeniero Bruno, asistente de ICC. Abrir ayuda" aria-expanded="false">
            <img class="bruno-img bruno-img-normal" alt=""
                 src="<?= BASE_URL ?>assets/images/mascota/bruno-idle.webp"
                 data-anim="<?= BASE_URL ?>assets/images/mascota/bruno-idle.webp"
                 data-quieto="<?= BASE_URL ?>assets/images/mascota/bruno-idle.png"
                 width="240" height="372" decoding="async">
            <img class="bruno-img bruno-img-explica" alt=""
                 data-anim="<?= BASE_URL ?>assets/images/mascota/bruno-explica.webp"
                 data-quieto="<?= BASE_URL ?>assets/images/mascota/bruno-explica.png"
                 width="240" height="386" decoding="async" loading="lazy">
        </button>
    </div>
</div>

<script>
(function () {
    const el = document.getElementById('bruno');
    if (!el) return;
    try { if (localStorage.getItem('bruno_oculto') === '1') { el.remove(); return; } } catch (e) {}

    const reduceSistema = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let reduce = reduceSistema; // se respeta, salvo que la persona active la animacion desde el menu de Bruno
    try { if (reduceSistema && localStorage.getItem('bruno_anim') === '1') { reduce = false; } } catch (e) {}
    const btn = document.getElementById('bruno-btn');
    const burbuja = document.getElementById('bruno-burbuja');
    const imgNormal = el.querySelector('.bruno-img-normal');
    const imgExplica = el.querySelector('.bruno-img-explica');
    const tips = JSON.parse(el.dataset.tips || '[]');
    const wa = el.dataset.wa;
    let ultimo = window.scrollY, ticking = false, ocultaT = null, x = 8;

    // Segun el modo (animado o fijo), usa el .webp con movimiento o el .png quieto de cada pose.
    // La pose "explica" (tablero) recien carga su imagen la primera vez que hace falta, para no pesar
    // desde el inicio si la persona nunca abre el mensaje de Bruno.
    function aplicarImagen(img) {
        if (!img) return;
        const src = reduce ? img.dataset.quieto : img.dataset.anim;
        if (img.src !== src) img.src = src;
    }
    aplicarImagen(imgNormal);

    function posicionarBurbuja() {
        burbuja.classList.toggle('bruno-burbuja-der', x + 240 > window.innerWidth);
    }

    function actualizar() {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        const prog = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0;
        const margen = 8, ancho = el.offsetWidth;
        x = margen + prog * (window.innerWidth - ancho - margen * 2);
        el.style.transform = 'translateX(' + x.toFixed(1) + 'px)';
        ultimo = window.scrollY;
        ticking = false;
        posicionarBurbuja();
    }
    window.addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(actualizar); } }, { passive: true });
    window.addEventListener('resize', actualizar);
    actualizar();

    function cerrar() {
        el.classList.remove('arriba');
        burbuja.hidden = true;
        burbuja.textContent = '';
        btn.setAttribute('aria-expanded', 'false');
        clearTimeout(ocultaT);
    }

    // Texto real (ya armado en PHP con los datos de la oferta) de cada seccion, para poder
    // mostrarlo de una vez al tocar un boton del menu, sin depender de que el scroll lo detecte
    // (eso solo pasa una vez por seccion, y si la persona ya paso por ahi antes, no vuelve a salir)
    function textoTip(sel) {
        const t = tips.find(x => x.sel === sel);
        return t ? t.texto : '';
    }

    function enlace(texto, href, ext, tipTexto) {
        const a = document.createElement('a');
        a.textContent = texto;
        a.href = href;
        a.className = 'bruno-accion';
        if (ext) { a.target = '_blank'; a.rel = 'noopener'; }
        a.addEventListener('click', () => {
            cerrar();
            if (tipTexto) setTimeout(() => mostrar(tipTexto, [], true), 350);
        });
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
        aplicarImagen(imgExplica);
        posicionarBurbuja();
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
        const textoInscribirme = [textoTip('#precios'), textoTip('#inscripcion')].filter(Boolean).join(' ');
        const acciones = [
            enlace('Ver el horario', '#cronograma', false, textoTip('#cronograma')),
            enlace('Ver precios', '#precios', false, textoTip('#precios')),
            enlace('Inscribirme', '#inscripcion', false, textoInscribirme)
        ];
        // Si el dispositivo tiene las animaciones desactivadas, Bruno se ve quieto (foto fija): se ofrece activarlas (o desactivarlas de nuevo)
        if (reduceSistema) {
            const anim = document.createElement('button');
            anim.type = 'button';
            anim.className = 'bruno-accion bruno-accion-sec';
            anim.textContent = reduce ? 'Activar animación de Bruno' : 'Congelar a Bruno';
            anim.addEventListener('click', () => {
                try { localStorage.setItem('bruno_anim', reduce ? '1' : '0'); } catch (e) {}
                reduce = !reduce;
                aplicarImagen(imgNormal);
                aplicarImagen(imgExplica);
                cerrar();
            });
            acciones.push(anim);
        }
        acciones.push(ocultar);
        mostrar('Hola, soy Bruno, el ingeniero de ICC. ¿Te ayudo?', acciones, false);
        btn.setAttribute('aria-expanded', 'true');
    }

    btn.addEventListener('click', () => { burbuja.hidden ? menu() : cerrar(); });

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

    // Saludo inicial (una vez por visita): la pose normal ya saluda con la mano en su propio loop
    try {
        if (!sessionStorage.getItem('bruno_saludo')) {
            sessionStorage.setItem('bruno_saludo', '1');
            setTimeout(() => { if (burbuja.hidden && !escribiendo()) mostrar('Hola, soy Bruno. Toca si necesitas ayuda.', [], true); }, 5000);
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

    // Video del curso: arranca solo (mudo) apenas termina de cargar la pagina, sin esperar el scroll ni un
    // clic; se crea despues del evento "load" para no competir con el banner y el resto de la pagina.
    // Como la seccion queda mas abajo, cuando la persona llega a verla por primera vez se reinicia desde
    // el principio (comando al reproductor de YouTube), asi no lo encuentra a mitad.
    function videoCurso() {
        return {
            play: false,
            init() {
                const arrancar = () => { this.play = true; };
                if (document.readyState === 'complete') arrancar();
                else window.addEventListener('load', arrancar, { once: true });
                if (!('IntersectionObserver' in window)) return;
                new IntersectionObserver((entradas, obs) => {
                    entradas.forEach(en => {
                        if (!en.isIntersecting) return;
                        obs.disconnect();
                        this.desdeElPrincipio();
                    });
                }, { threshold: 0.4 }).observe(this.$el);
            },
            desdeElPrincipio() {
                const f = this.$el.querySelector('iframe');
                if (!f || !f.contentWindow) return; // todavia no se creo: ya va a empezar desde el principio
                const orden = (func, args) => f.contentWindow.postMessage(JSON.stringify({ event: 'command', func: func, args: args || [] }), '*');
                orden('seekTo', [0, true]);
                orden('playVideo');
            }
        };
    }

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
            grupo: '',
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
                // En los links en dolares (extranjero) el documento es opcional: no todos los paises usan DNI
                const docOk = CFG.moneda === 'USD' || this.dni.trim();
                return docOk && this.nombre.trim() && this.apellido.trim() && this.celular.trim();
            },

            textoFaltan() {
                return CFG.moneda === 'USD' ? 'tus nombres, apellidos y celular' : 'tu DNI, nombres, apellidos y celular';
            },

            enviarVoucher() {
                if (!this.datosCompletos()) {
                    this.mostrarError('Por favor, completa ' + this.textoFaltan() + '.');
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
                fd.append('monto', CFG.precioPen);

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
                            self.mostrarError('Por favor, completa ' + self.textoFaltan() + ' antes de pagar.');
                            return actions.reject();
                        }
                        self.error = '';
                        return actions.resolve();
                    },
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: { currency_code: 'USD', value: self.amountInUSD.toFixed(2) },
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
                                    orderID: data.orderID, curso: CFG.curso, prueba: CFG.prueba || '',
                                    dni: self.dni, nombre: self.nombre, apellido: self.apellido, celular: self.celular
                                })
                            })
                            .then(r => r.json())
                            .then(resp => {
                                if (!resp.success) console.error('No se pudo registrar la venta de PayPal:', resp.error, data.orderID);
                                else if (resp.grupo) self.grupo = resp.grupo;
                            })
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
