<?php
/**
 * Checkout v2 (?diseno=2&oferta=clave): pagina de venta + pago en una sola vista adaptable.
 * Diseno basado en el boceto de Stitch, pero SOLO con contenido real (config en
 * App\Helpers\OfertasCheckout + BD). Sin testimonios/fotos/videos hasta que existan los archivos
 * reales: las secciones se ocultan solas. Estilos: assets/css/checkout-v2.css (ver tools/tailwind).
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/checkout-v2.css?v=1">
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

<!-- Cabecera + barra de precio -->
<header class="sticky top-0 z-40 shadow-md">
    <div class="bg-navy text-white">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
            <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" class="h-9 w-auto">
            <div class="flex items-center gap-4 text-sm">
                <span class="hidden sm:flex items-center gap-1.5 text-slate-300"><i class="fas fa-lock text-emerald-400"></i> Pago seguro</span>
                <a href="<?= $wa ?>" target="_blank" rel="noopener" class="flex items-center gap-2 rounded-full bg-white/10 hover:bg-white/20 px-3 py-1.5 font-semibold">
                    <i class="fab fa-whatsapp text-emerald-400"></i><span class="hidden sm:inline">+51 941 208 020</span><span class="sm:hidden">WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
    <div class="bg-brand text-white text-sm">
        <div class="max-w-6xl mx-auto px-4 py-2 flex items-center justify-between gap-3">
            <p class="flex items-center gap-2 min-w-0">
                <i class="fas fa-bolt text-accent"></i>
                <span class="truncate font-semibold"><?= $e($d['etapaNombre']) ?>: <?= $d['simbolo'] ?><?= $fmt($d['precio']) ?><?php if ($d['aviso']): ?><span class="hidden sm:inline font-normal"> · <?= $e($d['aviso']) ?></span><?php endif; ?></span>
            </p>
            <?php if ($d['js']['hastaMs']): ?>
            <span class="shrink-0 rounded-full bg-navy px-3 py-0.5 font-mono text-xs font-bold" title="Tiempo restante de este precio"><i class="far fa-clock mr-1"></i><span x-text="cuenta">--:--:--</span></span>
            <?php endif; ?>
        </div>
    </div>
</header>

<main>
<!-- Hero -->
<section class="bg-navy text-white">
    <div class="max-w-6xl mx-auto px-4 py-10 lg:py-14 grid lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-7">
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="rounded-full bg-brand px-3 py-1 text-xs font-bold uppercase tracking-wide">Especialización</span>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold"><i class="far fa-clock mr-1"></i><?= (int)$d['horas'] ?> horas académicas</span>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold"><i class="far fa-calendar-alt mr-1"></i>Inicio: <?= $e($d['inicioCorto']) ?></span>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight">
                <?= $e($d['titulo'][0]) ?> <span class="text-accent"><?= $e($d['titulo'][1]) ?></span>
            </h1>
            <p class="mt-4 text-slate-300 text-base sm:text-lg max-w-2xl"><?= $e($d['subtitulo']) ?></p>

            <div class="mt-6 inline-flex items-center gap-3 rounded-xl bg-white/10 p-3 pr-5">
                <img src="<?= BASE_URL . $e($d['docente']['foto']) ?>" alt="<?= $e($d['docente']['nombre']) ?>" class="h-14 w-14 rounded-full object-cover object-top border-2 border-accent" width="56" height="56">
                <div>
                    <p class="font-display font-bold leading-tight"><?= $e($d['docente']['nombre']) ?></p>
                    <p class="text-sm text-slate-300"><?= $e($d['docente']['cargo']) ?></p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="rounded-2xl bg-white text-ink p-6 shadow-2xl">
                <div class="flex items-center justify-between gap-2">
                    <span class="rounded-full bg-brand px-3 py-1 text-xs font-bold uppercase tracking-wide text-white"><?= $e($d['etapaNombre']) ?></span>
                    <?php if ($d['descuento'] > 0): ?><span class="rounded-full bg-red-600 px-3 py-1 text-xs font-bold text-white">-<?= (int)$d['descuento'] ?>%</span><?php endif; ?>
                </div>
                <div class="mt-4 flex items-end gap-2">
                    <span class="font-display text-5xl font-extrabold"><?= $d['simbolo'] ?><?= $fmt($d['precio']) ?></span>
                    <span class="pb-2 text-sm font-semibold text-muted"><?= $e($d['moneda']) ?></span>
                </div>
                <p class="mt-1 text-sm text-muted">Precio regular <span class="line-through"><?= $d['simbolo'] ?><?= $fmt($d['precioRegular']) ?></span></p>
                <?php if ($d['aviso']): ?>
                <p class="mt-3 rounded-lg bg-amber-50 px-3 py-2 text-sm font-medium text-amber-900"><i class="fas fa-arrow-up mr-1"></i><?= $e($d['aviso']) ?></p>
                <?php endif; ?>
                <ul class="mt-5 space-y-2 text-sm">
                    <?php foreach ($d['beneficios'] as $b): ?>
                    <li class="flex gap-2"><i class="fas fa-check-circle mt-0.5 text-emerald-600"></i><span><?= $e($b) ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <a href="#inscripcion" class="mt-6 flex items-center justify-center gap-2 rounded-xl bg-brand px-5 py-4 font-display text-base font-bold text-white shadow-lg hover:bg-brand-soft">
                    Inscribirme por <?= $d['simbolo'] ?><?= $fmt($d['precio']) ?> <i class="fas fa-arrow-down"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($d['video'])): ?>
<!-- Video -->
<section class="max-w-4xl mx-auto px-4 py-12">
    <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-center">Conoce el curso</h2>
    <div x-data="{ play: false }" class="relative mt-6 aspect-video overflow-hidden rounded-2xl bg-navy shadow-lg">
        <template x-if="!play">
            <button type="button" @click="play = true" class="group absolute inset-0 h-full w-full" aria-label="Reproducir video del curso">
                <img src="https://i.ytimg.com/vi/<?= $e($d['video']) ?>/hqdefault.jpg" alt="" loading="lazy" class="h-full w-full object-cover opacity-80">
                <span class="absolute inset-0 flex items-center justify-center">
                    <span class="flex h-20 w-20 items-center justify-center rounded-full bg-brand text-3xl text-white shadow-2xl transition group-hover:scale-110"><i class="fas fa-play ml-1"></i></span>
                </span>
            </button>
        </template>
        <template x-if="play">
            <iframe src="https://www.youtube.com/embed/<?= $e($d['video']) ?>?autoplay=1&rel=0" title="Video del curso" class="absolute inset-0 h-full w-full" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        </template>
    </div>
</section>
<?php endif; ?>

<!-- Temario -->
<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <p class="text-center text-sm font-bold uppercase tracking-wider text-brand">Plan de estudios</p>
        <h2 class="mt-1 text-center font-display text-2xl sm:text-3xl font-extrabold">Temario del curso</h2>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            <?php $n = 0; foreach ($d['temas'] as $titulo => $items): $n++; ?>
            <div class="rounded-2xl border border-line/60 bg-surface p-5" x-data="{ open: window.innerWidth >= 768 }">
                <button type="button" @click="open = !open" class="flex w-full items-center gap-3 text-left">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand text-sm font-bold text-white"><?= $n ?></span>
                    <span class="flex-1 font-display font-bold"><?= $e($titulo) ?></span>
                    <i class="fas fa-chevron-down text-muted transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <ul x-show="open" x-cloak class="mt-3 space-y-1.5 text-sm text-muted">
                    <?php foreach ($items as $corto => $completo): ?>
                    <li class="flex gap-2"><i class="fas fa-check mt-1 text-xs text-brand"></i><span><?= $e($completo) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($d['extra'])): $x = $d['extra']; ?>
        <div class="mt-6 rounded-2xl bg-navy p-6 text-white sm:p-8">
            <h3 class="flex items-center gap-2 font-display text-xl sm:text-2xl font-extrabold"><i class="fas fa-robot text-accent"></i> <?= $e($x['titulo']) ?></h3>
            <p class="mt-2 max-w-3xl text-slate-300"><?= $e($x['intro']) ?></p>
            <ul class="mt-4 grid gap-2 sm:grid-cols-2 text-sm">
                <?php foreach ($x['items'] as $it): ?>
                <li class="flex gap-2"><i class="fas fa-bolt mt-1 text-accent"></i><span><?= $e($it) ?></span></li>
                <?php endforeach; ?>
            </ul>
            <p class="mt-5 rounded-xl bg-accent/15 px-4 py-3 text-sm font-semibold text-accent"><i class="fas fa-gift mr-2"></i>Bonus incluido: <?= $e($x['bonus']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Cronograma -->
<section class="max-w-6xl mx-auto px-4 py-12">
    <p class="text-center text-sm font-bold uppercase tracking-wider text-brand">Cronograma</p>
    <h2 class="mt-1 text-center font-display text-2xl sm:text-3xl font-extrabold">Empezamos el <?= $e($d['inicioLargo']) ?></h2>
    <p class="mx-auto mt-2 max-w-2xl text-center text-muted"><?= count($d['sesiones']) ?> clases en vivo por Zoom<?php if (!empty($d['hora'])): ?>, de <?= $e($d['hora']) ?><?php endif; ?>.</p>
    <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
        <?php foreach ($d['sesiones'] as $s): ?>
        <div class="rounded-xl border border-line/60 bg-white p-4 text-center shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-brand">Clase <?= (int)$s['n'] ?></p>
            <p class="mt-1 font-display font-bold leading-snug"><?= $e(ucfirst($s['fecha'])) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Escalera de precios -->
<section class="bg-white py-12">
    <div class="max-w-5xl mx-auto px-4">
        <p class="text-center text-sm font-bold uppercase tracking-wider text-brand">Precio por fechas</p>
        <h2 class="mt-1 text-center font-display text-2xl sm:text-3xl font-extrabold">Mientras antes te inscribes, menos pagas</h2>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <?php foreach ($d['etapas'] as $et): ?>
            <?php if ($et['estado'] === 'actual'): ?>
            <div class="relative rounded-2xl border-2 border-brand bg-white p-6 shadow-xl">
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-brand px-4 py-1 text-xs font-bold uppercase tracking-wide text-white">Precio de hoy</span>
            <?php elseif ($et['estado'] === 'pasada'): ?>
            <div class="rounded-2xl border border-line/60 bg-surface p-6 opacity-60">
            <?php else: ?>
            <div class="rounded-2xl border border-line/60 bg-surface p-6">
            <?php endif; ?>
                <p class="text-sm font-bold uppercase tracking-wide text-muted"><?= $e($et['nombre']) ?></p>
                <p class="mt-2 font-display text-4xl font-extrabold <?= $et['estado'] === 'actual' ? 'text-brand' : '' ?> <?= $et['estado'] === 'pasada' ? 'line-through' : '' ?>"><?= $d['simbolo'] ?><?= $fmt($et['precio']) ?></p>
                <p class="mt-2 text-sm text-muted"><?= $e($et['rango']) ?><?= $et['estado'] === 'pasada' ? ' (finalizada)' : '' ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($d['galeria'])): ?>
<!-- Galeria -->
<section class="max-w-6xl mx-auto px-4 py-12">
    <h2 class="text-center font-display text-2xl sm:text-3xl font-extrabold">Así se trabaja en el curso</h2>
    <div class="mt-8 grid grid-cols-2 gap-3 lg:grid-cols-4">
        <?php foreach ($d['galeria'] as $img): ?>
        <img src="<?= $e($img) ?>" alt="" loading="lazy" class="aspect-[4/3] w-full rounded-xl object-cover shadow-sm">
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($d['testimonios'])): ?>
<!-- Testimonios (capturas reales) -->
<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-center font-display text-2xl sm:text-3xl font-extrabold">Lo que dicen nuestros alumnos</h2>
        <div class="mt-8 flex snap-x gap-4 overflow-x-auto pb-4 md:grid md:grid-cols-3 md:overflow-visible lg:grid-cols-4">
            <?php foreach ($d['testimonios'] as $img): ?>
            <img src="<?= $e($img) ?>" alt="Testimonio de un alumno" loading="lazy" class="w-64 shrink-0 snap-center rounded-xl border border-line/60 shadow-sm md:w-full">
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Inscripcion y pago -->
<section id="inscripcion" class="bg-mist py-12 scroll-mt-28">
    <div class="max-w-3xl mx-auto px-4">
        <p class="text-center text-sm font-bold uppercase tracking-wider text-brand">Inscripción</p>
        <h2 class="mt-1 text-center font-display text-2xl sm:text-3xl font-extrabold">Completa tu inscripción</h2>

        <div x-show="!success" class="mt-8 space-y-6">
            <!-- Paso 1 -->
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="flex items-center gap-3 font-display text-lg font-bold"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand text-sm text-white">1</span> Datos del participante</h3>
                <p class="mt-1 text-sm text-muted">Con estos datos se emite tu certificado.</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="sm:col-span-2 text-sm font-semibold">DNI o documento de identidad
                        <input x-model="dni" type="text" inputmode="text" autocomplete="off" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30" placeholder="DNI, C.E. o pasaporte">
                    </label>
                    <label class="text-sm font-semibold">Nombres
                        <input x-model="nombre" type="text" autocomplete="given-name" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">
                    </label>
                    <label class="text-sm font-semibold">Apellidos
                        <input x-model="apellido" type="text" autocomplete="family-name" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">
                    </label>
                    <label class="sm:col-span-2 text-sm font-semibold">Celular / WhatsApp
                        <input x-model="celular" type="tel" autocomplete="tel" class="mt-1 w-full rounded-xl border border-line bg-surface px-4 py-3 font-normal focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30" placeholder="+51 987 654 321">
                    </label>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="flex items-center gap-3 font-display text-lg font-bold"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand text-sm text-white">2</span> Método de pago</h3>
                <p class="mt-1 text-sm text-muted">Total a pagar: <strong class="text-brand"><?= $d['simbolo'] ?><?= $fmt($d['precio']) ?> <?= $e($d['moneda']) ?></strong></p>

                <div class="mt-4 flex flex-wrap gap-2 rounded-xl bg-mist p-1.5">
                    <?php if ($hayManual): ?>
                    <button type="button" @click="setTab('manual')" :class="tab === 'manual' ? 'bg-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-qrcode mr-1"></i> Yape / Plin</button>
                    <?php endif; ?>
                    <button type="button" @click="setTab('paypal')" :class="tab === 'paypal' ? 'bg-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-credit-card mr-1"></i> PayPal / Tarjeta</button>
                    <?php if ($hayHotmart): ?>
                    <button type="button" @click="setTab('hotmart')" :class="tab === 'hotmart' ? 'bg-white shadow font-bold' : 'text-muted'" class="flex-1 rounded-lg px-3 py-2.5 text-sm"><i class="fas fa-globe-americas mr-1"></i> Otros métodos</button>
                    <?php endif; ?>
                </div>

                <?php if ($hayManual): ?>
                <!-- Yape / Plin -->
                <div x-show="tab === 'manual'" x-cloak class="mt-5">
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="manualMethod = 'yape'" :class="manualMethod === 'yape' ? 'border-purple-500 bg-purple-50 font-bold' : 'border-line'" class="rounded-xl border-2 px-3 py-3 text-sm">Yape</button>
                        <button type="button" @click="manualMethod = 'plin'" :class="manualMethod === 'plin' ? 'border-teal-500 bg-teal-50 font-bold' : 'border-line'" class="rounded-xl border-2 px-3 py-3 text-sm">Plin</button>
                    </div>
                    <div class="mt-5 flex flex-col items-center rounded-2xl bg-surface p-5 text-center">
                        <img :src="manualDetails[manualMethod].qr" :alt="'QR de ' + manualDetails[manualMethod].nombre" class="max-h-72 w-auto rounded-xl shadow-md">
                        <p class="mt-3 text-sm text-muted">Escanea con tu app y paga a nombre de</p>
                        <p class="font-display text-lg font-bold" x-text="manualDetails[manualMethod].titular"></p>
                        <p class="mt-2 text-sm">Monto exacto: <strong class="text-brand">S/ <?= $fmt($d['js']['precioPen']) ?></strong></p>
                    </div>
                    <div class="mt-5">
                        <label class="text-sm font-semibold">Sube la captura de tu pago
                            <span class="mt-1 flex cursor-pointer flex-col items-center rounded-xl border-2 border-dashed border-line bg-surface px-4 py-6 text-center hover:border-brand">
                                <i class="fas fa-upload text-2xl text-brand"></i>
                                <span class="mt-2 text-sm font-semibold" x-text="voucherFile ? '✓ ' + voucherFile.name : 'Toca para elegir la imagen o PDF'"></span>
                                <span class="text-xs font-normal text-muted">JPG, PNG o PDF</span>
                                <input type="file" class="hidden" accept="image/*,application/pdf" @change="voucherFile = $event.target.files[0]">
                            </span>
                        </label>
                    </div>
                    <button type="button" @click="enviarVoucher()" :disabled="enviando" class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-brand px-5 py-4 font-display font-bold text-white shadow-lg hover:bg-brand-soft disabled:opacity-60">
                        <i class="fas fa-check-circle"></i> <span x-text="enviando ? 'Enviando…' : 'Confirmar mi inscripción'"></span>
                    </button>
                </div>
                <?php endif; ?>

                <!-- PayPal -->
                <div x-show="tab === 'paypal'" x-cloak class="mt-5">
                    <p class="text-sm text-muted">Paga con tu cuenta PayPal o con tarjeta de crédito o débito. PayPal cobra en dólares: <strong class="text-ink">US$ <span x-text="amountInUSD.toFixed(2)"></span></strong>.</p>
                    <div id="paypal-button-container" class="mt-4"></div>
                </div>

                <?php if ($hayHotmart): ?>
                <!-- Hotmart (solo Mexico y solo cuando hay oferta con el precio de esta etapa) -->
                <div x-show="tab === 'hotmart'" x-cloak class="mt-5">
                    <p class="text-sm text-muted">Paga con métodos de tu país (transferencia SPEI, OXXO, tarjeta local y más). El precio final se muestra en tu moneda local y puede incluir impuestos locales (por ejemplo, IVA).</p>
                    <template x-if="tab === 'hotmart'">
                        <iframe :src="CFG.hotmart" loading="lazy" allow="payment *" title="Pago con Hotmart" class="mt-4 w-full rounded-xl border border-line/60" style="height: 1900px;"></iframe>
                    </template>
                    <p class="mt-3 text-center text-xs text-muted">¿No carga? <button type="button" @click="window.open(CFG.hotmart, '_blank', 'noopener')" class="underline">Ábrelo en una pestaña nueva</button>. Tus accesos llegan al correo tras confirmarse el pago.</p>
                </div>
                <?php endif; ?>
            </div>

            <p class="text-center text-sm text-muted"><i class="fas fa-file-invoice mr-1"></i> ¿Necesitas boleta o factura? <a href="<?= $e($waComprobante) ?>" target="_blank" rel="noopener" class="font-semibold text-brand underline">Pídela por WhatsApp</a>. Se emite con IGV (18 %) adicional.</p>
        </div>

        <!-- Exito -->
        <div x-show="success" x-cloak class="mt-8 rounded-2xl bg-white p-8 text-center shadow-sm">
            <div class="text-5xl">✅</div>
            <template x-if="metodoUsado === 'manual'">
                <div>
                    <h3 class="mt-3 font-display text-2xl font-bold">¡Comprobante recibido!</h3>
                    <p class="mt-2 text-muted">Validaremos tu pago y te enviaremos tus accesos. Para agilizarlo, escríbenos por WhatsApp confirmando tus datos.</p>
                    <a href="<?= $wa ?>?text=<?= rawurlencode('Hola, acabo de subir mi comprobante para el curso ' . $d['curso'] . '. Mis nombres son:') ?>" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 font-bold text-white shadow-lg"><i class="fab fa-whatsapp text-xl"></i> Escribir por WhatsApp</a>
                </div>
            </template>
            <template x-if="metodoUsado === 'paypal'">
                <div>
                    <h3 class="mt-3 font-display text-2xl font-bold">¡Pago recibido!</h3>
                    <p class="mt-2 text-muted">En unos minutos recibirás tus credenciales por correo. Si necesitas ayuda, usa el chat de soporte de abajo a la derecha.</p>
                </div>
            </template>
        </div>
    </div>
</section>
</main>

<footer class="bg-navy py-8 text-center text-sm text-slate-300">
    <div class="max-w-6xl mx-auto px-4">
        <p class="font-semibold text-white">ICC · Instituto de Capacitación Continua</p>
        <p class="mt-1">Medios de pago: Yape · Plin · PayPal · Tarjeta de crédito o débito</p>
        <p class="mt-1">informes@icc.com.pe · <a href="<?= $wa ?>" class="underline" target="_blank" rel="noopener">+51 941 208 020</a></p>
    </div>
</footer>

<!-- Barra fija en celular -->
<div class="fixed inset-x-0 bottom-0 z-40 border-t border-line/60 bg-white p-3 shadow-[0_-4px_16px_rgba(0,0,0,0.08)] md:hidden">
    <div class="mx-auto flex max-w-md items-center justify-between gap-3">
        <div>
            <p class="font-display text-xl font-extrabold leading-none"><?= $d['simbolo'] ?><?= $fmt($d['precio']) ?> <span class="text-xs font-semibold text-muted line-through"><?= $d['simbolo'] ?><?= $fmt($d['precioRegular']) ?></span></p>
            <?php if ($d['js']['hastaMs']): ?><p class="mt-0.5 text-xs font-semibold text-red-600"><i class="far fa-clock"></i> <span x-text="cuenta"></span></p><?php endif; ?>
        </div>
        <a href="#inscripcion" class="rounded-xl bg-brand px-5 py-3 font-display text-sm font-bold text-white shadow-md">Inscribirme</a>
    </div>
</div>

<script>
    const CFG = <?= $js ?>;

    function checkoutV2() {
        return {
            tab: null,
            manualMethod: 'yape',
            voucherFile: null,
            dni: '', nombre: '', apellido: '', celular: '',
            enviando: false,
            success: false,
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

            datosCompletos() {
                return this.dni.trim() && this.nombre.trim() && this.apellido.trim() && this.celular.trim();
            },

            enviarVoucher() {
                if (!this.datosCompletos()) {
                    alert('Por favor, completa tu DNI, nombres, apellidos y celular.');
                    return;
                }
                if (!this.voucherFile) {
                    alert('Por favor, adjunta la captura de tu pago para continuar.');
                    return;
                }
                const fd = new FormData();
                fd.append('voucher', this.voucherFile);
                fd.append('curso', CFG.curso);
                fd.append('dni', this.dni);
                fd.append('nombre', this.nombre);
                fd.append('apellido', this.apellido);
                fd.append('celular', this.celular);

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
                            alert('Ocurrió un error: ' + (data.error || 'Error desconocido'));
                        }
                    })
                    .catch(() => alert('Error de conexión al subir el comprobante. Intenta nuevamente.'))
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
                            alert('Por favor, completa tus datos (DNI, nombres, apellidos y celular) antes de pagar.');
                            return actions.reject();
                        }
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
                        alert('Hubo un inconveniente con el pago en PayPal. Por favor, intenta de nuevo.');
                    }
                }).render('#paypal-button-container');
            }
        };
    }
</script>
</body>
</html>
