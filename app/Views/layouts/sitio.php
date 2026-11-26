<?php
/**
 * Layout publico de la web con el estilo del checkout v2 (azul ICC, azul marino, verde lima,
 * Inter + Plus Jakarta Sans). Reemplaza por etapas a layouts/main.php (plantilla Zilom + Bootstrap):
 * cada pagina pasa a este layout cuando se reescribe en Tailwind.
 * Estilos: assets/css/sitio.css (tools/tailwind: npm run build:sitio). Sin jQuery ni Bootstrap.
 * Variables opcionales de la vista: $barra_movil (sube el boton de WhatsApp), $pagoPayPal (carga el SDK),
 * $fondo_body (clase de fondo, por defecto bg-white), $margen_pie (espacio antes del pie).
 */
$esc = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$tituloPagina = $title ?? 'ICC Perú - Instituto de Capacitación Continua';
$descripcion = $meta_description ?? 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería.';
$wa = 'https://wa.me/51941208020';

// Seccion activa del menu segun la ruta pedida
$ruta = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
$base = trim((string) parse_url(BASE_URL, PHP_URL_PATH), '/');
if ($base !== '' && strpos($ruta, $base) === 0) {
    $ruta = trim(substr($ruta, strlen($base)), '/');
}
$seccion = explode('/', $ruta)[0];
$menu = [
    ['url' => '', 'texto' => 'Inicio', 'activo' => $seccion === '' || $seccion === 'home'],
    ['url' => 'nosotros', 'texto' => 'Nosotros', 'activo' => $seccion === 'nosotros'],
    ['url' => 'cursos', 'texto' => 'Cursos', 'activo' => $seccion === 'cursos', 'sub' => true],
    ['url' => 'tienda', 'texto' => 'Packs grabados', 'activo' => $seccion === 'tienda'],
    ['url' => 'verificar', 'texto' => 'Verificar certificado', 'activo' => $seccion === 'verificar'],
    ['url' => 'contacto', 'texto' => 'Contáctanos', 'activo' => $seccion === 'contacto'],
];
$cursosMenu = [
    'analizador-de-redes' => 'Analizador de Redes',
    'banco-de-condensadores' => 'Banco de Condensadores',
    'canalizacion-de-tuberias-conduit' => 'Canalización de Tuberías Conduit',
    'especializacion-en-electricidad-industrial' => 'Especialización en Electricidad Industrial',
    'empalmes-termocontraibles-en-mt' => 'Empalmes Termocontraíbles en MT',
    'mantenimiento-de-subestaciones-electricas' => 'Mantenimiento de Subestaciones Eléctricas',
    'terminaciones-termocontraibles-en-mt' => 'Terminaciones Termocontraíbles en MT',
    'variadores-de-frecuencia' => 'Variadores de Frecuencia',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $esc($tituloPagina) ?></title>
    <meta name="description" content="<?= $esc($descripcion) ?>">
    <meta property="og:title" content="<?= $esc($tituloPagina) ?>">
    <meta property="og:description" content="<?= $esc($descripcion) ?>">
    <meta property="og:image" content="<?= $esc($og_image ?? BASE_URL . 'assets/images/resources/logo-icc.png') ?>">
    <meta property="og:url" content="<?= $esc($og_url ?? BASE_URL) ?>">
    <meta property="og:type" content="website">
    <?php if (isset($schema)): ?>
    <script type="application/ld+json"><?= $schema ?></script>
    <?php endif; ?>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/images/logo_icc.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>assets/images/logo_icc.png">
    <link rel="manifest" href="<?= BASE_URL ?>assets/images/favicons/site.webmanifest">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/sitio.css?v=2">
    <?php if (!empty($preload_img)): ?>
    <link rel="preload" as="image" type="image/webp" href="<?= $esc($preload_img) ?>">
    <?php endif; ?>
    <script>document.documentElement.classList.add('js');</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <?php if (!empty($pagoPayPal)): ?>
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD&enable-funding=card"></script>
    <?php endif; ?>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JPZGM0RZHW"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-JPZGM0RZHW');</script>

    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2480034172420246'); fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" alt="" src="https://www.facebook.com/tr?id=2480034172420246&ev=PageView&noscript=1"></noscript>
    <!-- Metricool -->
    <script>function loadScript(a){var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.type="text/javascript",c.src="https://tracker.metricool.com/resources/be.js",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}loadScript(function(){beTracker.t({hash:"7f4d2702c36e51657ae7d91f2c71cf01"})});</script>
</head>
<body class="min-h-screen <?= $fondo_body ?? 'bg-white' ?> font-sans text-ink antialiased<?= !empty($barra_movil) ? ' pb-20 lg:pb-0' : '' ?>" x-data="{ menu: false, cupon: false }" @keydown.escape.window="menu = false; cupon = false">
<a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-2 focus:top-2 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-brand-dark">Saltar al contenido</a>

<!-- Cabecera -->
<header class="sticky top-0 z-40 bg-deep text-white shadow-lg">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-3 px-4">
        <a href="<?= BASE_URL ?>" class="flex shrink-0 items-center" aria-label="ICC - Inicio">
            <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" width="190" height="60" class="h-9 w-auto">
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Menú principal">
            <?php foreach ($menu as $m): if ($m['url'] === 'verificar') continue; ?>
                <?php if (!empty($m['sub'])): ?>
                <div class="relative" x-data="{ abierto: false }" @mouseenter="abierto = true" @mouseleave="abierto = false" @focusout="if (!$el.contains($event.relatedTarget)) abierto = false">
                    <button type="button" @click="abierto = !abierto" :aria-expanded="abierto" aria-haspopup="true"
                            class="flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold <?= $m['activo'] ? 'text-accent' : 'text-sky-100 hover:bg-white/10 hover:text-white' ?>">
                        <?= $esc($m['texto']) ?> <i class="fas fa-chevron-down text-xs transition-transform" :class="abierto && 'rotate-180'" aria-hidden="true"></i>
                    </button>
                    <div x-show="abierto" x-cloak x-transition.opacity class="absolute left-0 top-full w-80 pt-2">
                        <div class="rounded-2xl bg-white p-2 text-ink shadow-xl ring-1 ring-black/5">
                            <a href="<?= BASE_URL ?>cursos" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-bold text-brand hover:bg-mist">Todos los cursos <i class="fas fa-arrow-right text-xs" aria-hidden="true"></i></a>
                            <a href="<?= BASE_URL ?>cursos/ingenieria" class="block rounded-xl px-3 py-2.5 text-sm font-semibold text-deep hover:bg-mist">Especialidades de Ingeniería Eléctrica</a>
                            <div class="my-1 border-t border-line/60"></div>
                            <?php foreach ($cursosMenu as $slug => $nombre): ?>
                            <a href="<?= BASE_URL ?>cursos/detalle/<?= $slug ?>" class="block rounded-xl px-3 py-2 text-sm text-muted hover:bg-mist hover:text-deep"><?= $esc($nombre) ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?= BASE_URL . $m['url'] ?>" <?= $m['activo'] ? 'aria-current="page"' : '' ?>
                   class="rounded-lg px-3 py-2 text-sm font-semibold <?= $m['activo'] ? 'text-accent' : 'text-sky-100 hover:bg-white/10 hover:text-white' ?>"><?= $esc($m['texto']) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="flex items-center gap-2">
            <!-- Ubicacion del visitante -->
            <div class="relative hidden sm:block">
                <button type="button" class="btnOpenUbigeo flex items-center gap-2 rounded-lg px-2 py-1.5 text-left hover:bg-white/10" title="Cambiar mi ubicación">
                    <i class="fas fa-map-marker-alt text-accent" aria-hidden="true"></i>
                    <span class="flex flex-col text-xs leading-tight">
                        <span class="text-sky-100">Ubicación</span>
                        <span class="headerLocationText max-w-[9rem] truncate font-bold">Lima, Lima</span>
                    </span>
                </button>
                <div class="locationPopover absolute right-0 top-full z-50 mt-3 w-72 rounded-2xl bg-white p-5 text-ink shadow-xl ring-1 ring-black/5" style="display:none">
                    <button type="button" class="btnClosePopover absolute right-2 top-2 flex h-9 w-9 items-center justify-center rounded-lg text-xl text-muted hover:bg-mist" aria-label="Cerrar">&times;</button>
                    <p class="font-display font-bold text-deep">Estás navegando en:</p>
                    <p class="popoverLocationText mt-1 text-sm text-muted">Lima, Lima</p>
                    <div class="mt-4 flex gap-2">
                        <button type="button" class="btnConfirmLocation flex-1 rounded-xl bg-brand px-3 py-2 text-sm font-bold text-white hover:bg-brand-dark">Confirmar</button>
                        <button type="button" class="btnChangeLocation flex-1 rounded-xl border border-brand px-3 py-2 text-sm font-bold text-brand hover:bg-mist">Cambiar</button>
                    </div>
                </div>
            </div>
            <button type="button" @click="cupon = true" class="hidden rounded-lg border border-white/30 px-3 py-2 text-xs font-bold tracking-wide text-white hover:bg-white/10 md:inline-flex md:items-center md:gap-1.5">
                <i class="fab fa-tiktok" aria-hidden="true"></i> Cupón
            </button>
            <a href="<?= BASE_URL ?>aula" class="inline-flex min-h-[40px] items-center gap-2 rounded-lg bg-accent px-4 text-sm font-bold text-deep hover:brightness-95">
                <i class="fas fa-user-graduate" aria-hidden="true"></i><span class="hidden sm:inline">Aula virtual</span><span class="sm:hidden">Aula</span>
            </a>
            <button type="button" @click="menu = !menu" :aria-expanded="menu" aria-controls="menu-movil" class="flex h-10 w-10 items-center justify-center rounded-lg text-xl hover:bg-white/10 lg:hidden" aria-label="Abrir menú">
                <i class="fas" :class="menu ? 'fa-times' : 'fa-bars'" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <!-- Menu en celular -->
    <div id="menu-movil" x-show="menu" x-cloak x-transition class="max-h-[calc(100vh-4rem)] overflow-y-auto border-t border-white/10 bg-deep lg:hidden">
        <nav class="mx-auto max-w-6xl px-4 py-3" aria-label="Menú principal">
            <?php foreach ($menu as $m): ?>
                <?php if (!empty($m['sub'])): ?>
                <div x-data="{ abierto: false }">
                    <button type="button" @click="abierto = !abierto" :aria-expanded="abierto" class="flex w-full items-center justify-between rounded-xl px-3 py-3 text-left font-semibold <?= $m['activo'] ? 'text-accent' : 'text-white' ?>">
                        <?= $esc($m['texto']) ?> <i class="fas fa-chevron-down text-xs transition-transform" :class="abierto && 'rotate-180'" aria-hidden="true"></i>
                    </button>
                    <div x-show="abierto" x-cloak class="mb-2 ml-3 border-l border-white/20 pl-3">
                        <a href="<?= BASE_URL ?>cursos" class="block rounded-lg px-3 py-2 text-sm font-bold text-accent">Todos los cursos</a>
                        <a href="<?= BASE_URL ?>cursos/ingenieria" class="block rounded-lg px-3 py-2 text-sm text-sky-100">Especialidades de Ingeniería Eléctrica</a>
                        <?php foreach ($cursosMenu as $slug => $nombre): ?>
                        <a href="<?= BASE_URL ?>cursos/detalle/<?= $slug ?>" class="block rounded-lg px-3 py-2 text-sm text-sky-100"><?= $esc($nombre) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?= BASE_URL . $m['url'] ?>" class="block rounded-xl px-3 py-3 font-semibold <?= $m['activo'] ? 'text-accent' : 'text-white' ?>"><?= $esc($m['texto']) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="mt-2 grid grid-cols-2 gap-2 border-t border-white/10 pt-4">
                <button type="button" class="btnOpenUbigeo flex items-center gap-2 rounded-xl border border-white/20 px-3 py-3 text-left text-sm" @click="menu = false">
                    <i class="fas fa-map-marker-alt text-accent" aria-hidden="true"></i><span class="headerLocationText truncate">Lima, Lima</span>
                </button>
                <button type="button" @click="menu = false; cupon = true" class="flex items-center justify-center gap-2 rounded-xl border border-white/20 px-3 py-3 text-sm font-bold">
                    <i class="fab fa-tiktok" aria-hidden="true"></i> Ingresar cupón
                </button>
            </div>
        </nav>
    </div>
</header>

<main id="contenido">
<?= $content ?>
</main>

<!-- Pie -->
<footer class="bg-deep text-sky-100<?= !empty($margen_pie) ? ' mt-16' : '' ?>">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" width="160" height="50" class="h-10 w-auto" loading="lazy">
            <p class="mt-4 text-sm leading-relaxed">Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería Eléctrica.</p>
            <div class="mt-5 flex gap-2">
                <a href="<?= $wa ?>" target="_blank" rel="noopener" aria-label="WhatsApp" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-lg hover:bg-accent hover:text-deep"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                <a href="https://www.facebook.com/profile.php?id=61570845450403" target="_blank" rel="noopener" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-lg hover:bg-accent hover:text-deep"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                <a href="https://www.tiktok.com/@icc_capacitaciones_int" target="_blank" rel="noopener" aria-label="TikTok" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-lg hover:bg-accent hover:text-deep"><i class="fab fa-tiktok" aria-hidden="true"></i></a>
            </div>
        </div>
        <div>
            <h2 class="font-display text-base font-bold text-white">Cursos</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="<?= BASE_URL ?>cursos" class="hover:text-accent">Todos los cursos</a></li>
                <li><a href="<?= BASE_URL ?>cursos/ingenieria" class="hover:text-accent">Ingeniería Eléctrica</a></li>
                <li><a href="<?= BASE_URL ?>tienda" class="hover:text-accent">Packs de cursos grabados</a></li>
                <li><a href="<?= BASE_URL ?>verificar" class="hover:text-accent">Verificar certificado</a></li>
                <li><a href="<?= BASE_URL ?>aula" class="hover:text-accent">Aula virtual</a></li>
            </ul>
        </div>
        <div>
            <h2 class="font-display text-base font-bold text-white">Enlaces</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="<?= BASE_URL ?>nosotros" class="hover:text-accent">Nosotros</a></li>
                <li><a href="<?= BASE_URL ?>contacto" class="hover:text-accent">Contáctanos</a></li>
                <li><a href="<?= BASE_URL ?>legal/privacidad" class="hover:text-accent">Política de Privacidad</a></li>
                <li><a href="<?= BASE_URL ?>legal/terminos" class="hover:text-accent">Términos de Servicio</a></li>
                <li><a href="<?= BASE_URL ?>legal/reclamaciones" class="inline-flex items-center gap-2 font-bold text-accent hover:underline"><i class="fas fa-book" aria-hidden="true"></i> Libro de Reclamaciones</a></li>
            </ul>
        </div>
        <div>
            <h2 class="font-display text-base font-bold text-white">Contáctanos</h2>
            <ul class="mt-4 space-y-3 text-sm">
                <li><a href="mailto:informes@icc.com.pe" class="flex items-center gap-3 hover:text-accent"><i class="fas fa-envelope w-4 text-accent" aria-hidden="true"></i> informes@icc.com.pe</a></li>
                <li><a href="tel:+51941208020" class="flex items-center gap-3 hover:text-accent"><i class="fas fa-phone-alt w-4 text-accent" aria-hidden="true"></i> +51 941 208 020</a></li>
                <li><a href="<?= $wa ?>" target="_blank" rel="noopener" class="flex items-center gap-3 hover:text-accent"><i class="fab fa-whatsapp w-4 text-accent" aria-hidden="true"></i> Escríbenos por WhatsApp</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-5 text-xs sm:flex-row sm:justify-between">
            <p>© <?= date('Y') ?> Instituto de Capacitación Continua S.R.L. · RUC 20602400159</p>
            <p>Medios de pago: Yape · Plin · PayPal · Tarjeta de crédito o débito</p>
        </div>
    </div>
</footer>

<!-- Modal: cupon de TikTok -->
<div x-show="cupon" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-deep/70 p-4" @click.self="cupon = false"
     role="dialog" aria-modal="true" aria-labelledby="cupon-titulo" x-data="cuponTiktok()" x-effect="if (cupon) abrir()">
    <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl">
        <button type="button" @click="cupon = false" class="absolute right-2 top-2 flex h-10 w-10 items-center justify-center rounded-lg text-2xl text-muted hover:bg-mist" aria-label="Cerrar">&times;</button>
        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-mist text-xl text-brand"><i class="fab fa-tiktok" aria-hidden="true"></i></span>
        <h2 id="cupon-titulo" class="mt-3 font-display text-xl font-bold text-deep">Ingresar cupón</h2>
        <p class="mt-1 text-sm text-muted">Escribe el código que viste en nuestro TikTok.</p>
        <form class="mt-5" @submit.prevent="enviar()">
            <label for="tiktok-coupon-input" class="sr-only">Código del cupón</label>
            <input id="tiktok-coupon-input" type="text" x-model="codigo" x-ref="campo" autocomplete="off" placeholder="Escribe tu código aquí"
                   class="w-full rounded-xl border border-line px-4 py-3 text-center font-mono uppercase tracking-wider focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand">
            <p x-show="error" x-cloak class="mt-2 text-sm font-semibold text-red-600" role="alert">Cupón no válido o expirado.</p>
            <button type="submit" class="mt-4 w-full rounded-xl bg-accent px-5 py-3 font-display font-bold text-deep hover:brightness-95">Aplicar cupón</button>
        </form>
    </div>
</div>

<!-- Modal: ubicacion del visitante -->
<div id="ubigeoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-deep/70 p-4" role="dialog" aria-modal="true" aria-labelledby="ubigeoModalLabel">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <button type="button" id="btnCloseModalUbigeo" class="absolute right-2 top-2 flex h-10 w-10 items-center justify-center rounded-lg text-2xl text-muted hover:bg-mist" aria-label="Cerrar">&times;</button>
        <h2 id="ubigeoModalLabel" class="font-display text-xl font-bold text-deep">Elige tu ubicación</h2>
        <p class="mt-1 text-sm text-muted">Conocer tu ubicación nos ayuda a ofrecerte cursos más relevantes para tu zona.</p>
        <form id="ubigeoForm" class="mt-5 space-y-3">
            <div>
                <label for="selPais" class="mb-1 block text-sm font-semibold text-deep">País</label>
                <select id="selPais" required class="campo-ubigeo"><option value="Perú">Perú</option></select>
            </div>
            <div id="container-peru" class="space-y-3">
                <div>
                    <label for="selDepartamento" class="mb-1 block text-sm font-semibold text-deep">Departamento</label>
                    <select id="selDepartamento" class="campo-ubigeo"><option value="">Selecciona</option></select>
                </div>
                <div>
                    <label for="selProvincia" class="mb-1 block text-sm font-semibold text-deep">Provincia</label>
                    <select id="selProvincia" class="campo-ubigeo" disabled><option value="">Selecciona</option></select>
                </div>
                <div>
                    <label for="selDistrito" class="mb-1 block text-sm font-semibold text-deep">Distrito</label>
                    <select id="selDistrito" class="campo-ubigeo" disabled><option value="">Selecciona</option></select>
                </div>
            </div>
            <div id="container-extranjero" style="display:none">
                <label for="selCiudadExtranjera" class="mb-1 block text-sm font-semibold text-deep">Estado / Ciudad</label>
                <select id="selCiudadExtranjera" class="campo-ubigeo"><option value="">Selecciona</option></select>
            </div>
            <button type="submit" class="mt-2 w-full rounded-xl bg-brand px-5 py-3 font-display font-bold text-white hover:bg-brand-dark">Guardar</button>
        </form>
    </div>
</div>

<!-- Aviso de cookies -->
<div id="notif-pref-box" class="fixed inset-x-0 bottom-0 z-50 hidden border-t-4 border-accent bg-deep text-sky-100 shadow-[0_-4px_16px_rgba(0,0,0,0.25)]">
    <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm leading-relaxed">Utilizamos cookies para personalizar tu experiencia, analizar nuestro tráfico y recordar tus preferencias (como tu país). Al continuar navegando, aceptas nuestra <a href="<?= BASE_URL ?>legal/privacidad" class="font-semibold text-accent underline">Política de Privacidad</a>.</p>
        <button type="button" id="btn-aceptar-pref" class="shrink-0 rounded-xl bg-accent px-5 py-2.5 text-sm font-bold text-deep hover:brightness-95">Aceptar cookies</button>
    </div>
</div>

<!-- Boton flotante de WhatsApp -->
<a href="https://wa.link/myq5iv" target="_blank" rel="noopener" aria-label="Contactar por WhatsApp"
   class="wa-flotante fixed <?= !empty($barra_movil) ? 'bottom-24 lg:bottom-5' : 'bottom-5' ?> right-5 z-30 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-3xl text-white shadow-lg hover:brightness-95">
    <i class="fab fa-whatsapp" aria-hidden="true"></i>
</a>

<script>
// Cupones de TikTok: llevan al checkout con el precio del cupon
function cuponTiktok() {
    var cupones = {
        'TIKTOK-FACTURAS': { curso: 'Análisis de facturas y Evaluación de Tarifas E.', precio: 50, moneda: 'PEN' },
        'TIKTOK-BANCO': { curso: 'Banco de Condensadores', precio: 50, moneda: 'PEN' },
        'TIKTOK-ELECTRICIDAD': { curso: 'Electricidad Básica', precio: 50, moneda: 'PEN' },
        'TIKTOK-GESTION': { curso: 'Gestión y Seguridad en el Trabajo Ley Nº29783', precio: 50, moneda: 'PEN' },
        'TIKTOK-MOTORES': { curso: 'Motores Eléctricos', precio: 50, moneda: 'PEN' },
        'TIKTOK-PLC': { curso: 'Programación Básica de PLC', precio: 50, moneda: 'PEN' },
        'TIKTOK-TIERRA': { curso: 'Sistema Puesta a Tierra', precio: 50, moneda: 'PEN' },
        'TIKTOK-REGULACION': { curso: 'Regulación del Mercado de Energía', precio: 50, moneda: 'PEN' },
        'TIKTOK-REDES': { curso: 'Configuración e Instalación de Analizadores de redes', precio: 50, moneda: 'PEN' },
        'CUPON-TERMOCONTRAIBLES-VIRTUAL': { curso: 'Terminaciones Termocontraibles MT (Virtual)', precio: 150, moneda: 'PEN' },
        'CUPON-TERMOCONTRAIBLES-SEMI': { curso: 'Terminaciones Termocontraibles MT (Semipresencial)', precio: 350, moneda: 'PEN' },
        'CUPON-REDES-VIRTUAL': { curso: 'Analizador de Redes BT (Virtual)', precio: 150, moneda: 'PEN' },
        'CUPON-REDES-SEMI': { curso: 'Analizador de Redes BT (Semipresencial)', precio: 250, moneda: 'PEN' },
        'CUPON-CONDUIT-VIRTUAL': { curso: 'Canalizaciones Tubería Conduit (Virtual)', precio: 100, moneda: 'PEN' },
        'CUPON-CONDUIT-SEMI': { curso: 'Canalizaciones Tubería Conduit (Semipresencial)', precio: 350, moneda: 'PEN' },
        'CUPON-VARIADORES-VIRTUAL': { curso: 'Variadores en Velocidad (Virtual)', precio: 150, moneda: 'PEN' },
        'CUPON-VARIADORES-SEMI': { curso: 'Variadores en Velocidad (Semipresencial)', precio: 450, moneda: 'PEN' },
        'CUPON-EMPALME-SEMI': { curso: 'Empalme Autocontraible 3 M (Semipresencial)', precio: 750, moneda: 'PEN' },
        'CUPON-BANCO-VIRTUAL': { curso: 'Banco de Condensadores (Virtual)', precio: 150, moneda: 'PEN' },
        'CUPON-BANCO-SEMI': { curso: 'Banco de Condensadores (Semipresencial)', precio: 450, moneda: 'PEN' }
    };
    return {
        codigo: '',
        error: false,
        abrir: function () {
            var campo = this.$refs.campo;
            this.codigo = ''; this.error = false; campo.value = '';
            setTimeout(function () { campo.focus(); }, 80);
        },
        enviar: function () {
            var c = this.codigo.trim().toUpperCase();
            if (!c) return;
            var d = cupones[c];
            if (!d) { this.error = true; return; }
            window.location.href = '<?= BASE_URL ?>checkout?curso=' + encodeURIComponent(d.curso) + '&precio=' + encodeURIComponent(d.precio) + '&moneda=' + encodeURIComponent(d.moneda);
        }
    };
}

// Ubicacion del visitante (mismo flujo y cookies que el layout anterior)
document.addEventListener('DOMContentLoaded', function () {
    function getCookie(n) { var m = document.cookie.match(new RegExp('(^| )' + n + '=([^;]+)')); return m ? m[2] : null; }
    function setCookie(n, v, dias) { var d = new Date(); d.setTime(d.getTime() + dias * 864e5); document.cookie = n + '=' + v + ';expires=' + d.toUTCString() + ';path=/'; }
    function leer(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }
    function guardar(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }

    var modal = document.getElementById('ubigeoModal');
    function abrirModal() { modal.classList.remove('hidden'); modal.classList.add('flex'); document.getElementById('selPais').focus(); }
    function cerrarModal() { modal.classList.add('hidden'); modal.classList.remove('flex'); }
    modal.addEventListener('click', function (e) { if (e.target === modal) cerrarModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !modal.classList.contains('hidden')) cerrarModal(); });

    var pais = document.getElementById('selPais'), dep = document.getElementById('selDepartamento'),
        prov = document.getElementById('selProvincia'), dist = document.getElementById('selDistrito'),
        ciudad = document.getElementById('selCiudadExtranjera'),
        contPeru = document.getElementById('container-peru'), contExt = document.getElementById('container-extranjero');
    var ubigeo = null, paises = {}, cargando = false;

    function opciones(sel, lista) {
        sel.innerHTML = '<option value="">Selecciona</option>';
        lista.forEach(function (v) { var o = document.createElement('option'); o.value = v; o.textContent = v; sel.appendChild(o); });
    }
    function unicos(filtro, campo) {
        var s = {}; ubigeo.forEach(function (i) { if (filtro(i)) s[i[campo]] = 1; }); return Object.keys(s).sort();
    }
    function initUbigeo() {
        if (cargando) return;
        cargando = true;
        fetch('<?= BASE_URL ?>assets/js/paises_estados.json').then(function (r) { return r.json(); }).then(function (data) {
            paises = data;
            Object.keys(data).sort().forEach(function (p) { var o = document.createElement('option'); o.value = p; o.textContent = p; pais.appendChild(o); });
        }).catch(function (e) { console.error('Error loading paises', e); });
        fetch('<?= BASE_URL ?>assets/js/ubigeo.json').then(function (r) { return r.json(); }).then(function (data) {
            ubigeo = data;
            opciones(dep, unicos(function () { return true; }, 'departamento'));
            pais.dispatchEvent(new Event('change'));
        }).catch(function (e) { console.error('Error loading ubigeo', e); });
    }

    pais.addEventListener('change', function () {
        var peru = this.value === 'Perú';
        contPeru.style.display = peru ? '' : 'none';
        contExt.style.display = peru ? 'none' : '';
        dep.required = prov.required = dist.required = peru;
        ciudad.required = !peru;
        if (!peru) opciones(ciudad, (paises[this.value] || []).slice().sort());
    });
    dep.addEventListener('change', function () {
        var v = this.value;
        opciones(dist, []); dist.disabled = true;
        opciones(prov, v ? unicos(function (i) { return i.departamento === v; }, 'provincia') : []);
        prov.disabled = !v;
    });
    prov.addEventListener('change', function () {
        var v = this.value, d = dep.value;
        opciones(dist, v ? unicos(function (i) { return i.departamento === d && i.provincia === v; }, 'distrito') : []);
        dist.disabled = !v;
    });

    document.getElementById('ubigeoForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var p = pais.value, payload = { pais: p };
        if (p === 'Perú') { payload.departamento = dep.value; payload.provincia = prov.value; payload.distrito = dist.value; }
        else { payload.ciudad = ciudad.value; }
        fetch('<?= BASE_URL ?>visitor/saveLocation', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) })
            .then(function (r) { return r.json(); }).then(function (res) {
                setCookie('visitor_location_saved_v2', '1', 30);
                var txt = '';
                if (p === 'Perú') {
                    txt = payload.departamento;
                    if (payload.provincia && payload.provincia !== payload.departamento) txt += ', ' + payload.provincia;
                    if (payload.distrito && payload.distrito !== payload.provincia) txt += ', ' + payload.distrito;
                } else { txt = payload.ciudad; }
                if (!txt) txt = p;
                guardar('visitor_location_text', txt);
                document.querySelectorAll('.headerLocationText').forEach(function (el) { el.textContent = txt; });
                cerrarModal();
                if (res.success && typeof gtag === 'function') {
                    gtag('event', 'location_selected', { event_category: 'Visitor Location', event_label: p === 'Perú' ? (payload.departamento + '-' + payload.provincia + '-' + payload.distrito) : (p + '-' + payload.ciudad) });
                }
            }).catch(function (err) { console.error(err); setCookie('visitor_location_saved_v2', '1', 30); cerrarModal(); });
    });
    document.getElementById('btnCloseModalUbigeo').addEventListener('click', function () {
        setCookie('visitor_location_saved_v2', '1', 1); // No molestar por 1 dia
        cerrarModal();
    });

    var guardado = leer('visitor_location_text');
    if (guardado) document.querySelectorAll('.headerLocationText').forEach(function (el) { el.textContent = guardado; });
    function popovers(mostrar) { document.querySelectorAll('.locationPopover').forEach(function (p) { p.style.display = mostrar ? 'block' : 'none'; }); }
    if (!getCookie('visitor_location_saved_v2')) {
        popovers(true);
        document.querySelectorAll('.popoverLocationText').forEach(function (el) { el.textContent = guardado || 'Lima, Lima'; });
    }

    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.btnOpenUbigeo')) { e.preventDefault(); popovers(false); initUbigeo(); abrirModal(); }
        if (e.target.closest('.btnConfirmLocation')) {
            setCookie('visitor_location_saved_v2', '1', 30); popovers(false);
            if (!leer('visitor_location_text')) guardar('visitor_location_text', 'Lima, Lima');
        }
        if (e.target.closest('.btnChangeLocation')) { popovers(false); initUbigeo(); abrirModal(); }
        if (e.target.closest('.btnClosePopover')) { setCookie('visitor_location_saved_v2', '1', 1); popovers(false); }
    });

    // Aviso de cookies
    var aviso = document.getElementById('notif-pref-box');
    if (!leer('pref_aceptadas_v1')) setTimeout(function () { aviso.classList.remove('hidden'); }, 500);
    document.getElementById('btn-aceptar-pref').addEventListener('click', function () {
        guardar('pref_aceptadas_v1', 'true'); aviso.classList.add('hidden');
    });

    // Aparicion suave de secciones (clase .reveal), igual que el checkout v2
    var revelar = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (es) {
            es.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); } });
        }, { rootMargin: '0px 0px -10% 0px' });
        revelar.forEach(function (el) { io.observe(el); });
    } else {
        revelar.forEach(function (el) { el.classList.add('is-visible'); });
    }
});
</script>
</body>
</html>
