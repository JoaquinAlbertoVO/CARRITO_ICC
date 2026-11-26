<?php
/**
 * Checkout clasico (checkout?curso=&precio=&moneda=): Yape/Plin con voucher, PayPal y Hotmart.
 * Estilo del checkout v2 (assets/css/sitio.css, tools/tailwind: npm run build:sitio).
 * El script de pago de abajo (checkoutApp/adminPanel) no se cambio en el rediseño: conserva los ids
 * y clases que usa (.checkout-container, .accordion-content, #btn_submit_manual, #paypal-button-container...).
 */
$nombreCursoGA = isset($_GET['curso']) ? htmlspecialchars($_GET['curso']) : 'Express';
$cursoCk = (isset($data['cursoDB']) && $data['cursoDB']) ? $data['cursoDB'] : null;
$campoCk = 'w-full rounded-xl border border-line bg-white px-4 py-3 text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand';
$acordeones = [];
if ($cursoCk) {
    if (!empty($cursoCk['resumen'])) $acordeones[] = [1, 'fas fa-bolt', 'Resumen del curso', $cursoCk['resumen']];
    if (!empty($cursoCk['temas'])) $acordeones[] = [2, 'fas fa-list-ul', 'Temas principales', $cursoCk['temas']];
    if (!empty($cursoCk['extra_html'])) $acordeones[] = [5, 'fas fa-robot', htmlspecialchars($cursoCk['extra_titulo']), $cursoCk['extra_html']];
    if (!empty($cursoCk['beneficios'])) $acordeones[] = [3, 'fas fa-award', 'Beneficios', $cursoCk['beneficios']];
    if (!empty($cursoCk['programacion'])) $acordeones[] = [4, 'fas fa-calendar-alt', 'Programación y horarios', $cursoCk['programacion']];
}
$primerAcordeon = $acordeones ? $acordeones[0][0] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Pasarela de Pago - <?= $nombreCursoGA ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/sitio.css?v=2">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JPZGM0RZHW"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-JPZGM0RZHW');
    </script>

    <!-- Crisp Chat -->
    <script type="text/javascript">
      window.$crisp=[];
      window.CRISP_WEBSITE_ID="009b5415-0cf9-4522-9ba1-5d84c98c9006";
      (function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();
      // Ocultar el chat al inicio para que solo aparezca después de pagar
      $crisp.push(["do", "chat:hide"]);
    </script>
</head>

<body class="min-h-screen bg-surface pb-20 font-sans text-ink antialiased lg:pb-0">
<a href="#pago" class="sr-only focus:not-sr-only focus:fixed focus:left-2 focus:top-2 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-brand-dark">Saltar al pago</a>

<header class="bg-deep text-white shadow-lg">
    <div class="mx-auto flex h-14 max-w-6xl items-center justify-between px-4">
        <a href="<?= BASE_URL ?>" aria-label="ICC - Inicio"><img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC - Instituto de Capacitación Continua" class="h-9 w-auto"></a>
        <span class="flex items-center gap-1.5 text-sm text-sky-100"><i class="fas fa-lock text-emerald-400" aria-hidden="true"></i> Pago seguro</span>
    </div>
</header>

<div class="checkout-container" x-data="checkoutApp()" x-init="init()">
    <!-- Titulo del curso -->
    <section class="relative overflow-hidden bg-brand-dark bg-cover bg-center text-white" style="background-image: url('<?= BASE_URL ?>assets/images/fondo_icc_hero.jpg');">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-deep/60 via-deep/20 to-deep/30"></div>
        <div class="relative mx-auto max-w-6xl px-4 pb-14 pt-8">
            <span class="inline-block rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep">Inscripción</span>
            <?php if ($cursoCk && !empty($cursoCk['titulo_html'])): ?>
            <h1 class="mt-3 max-w-3xl font-display text-3xl font-extrabold leading-tight sm:text-4xl"><?= $cursoCk['titulo_html'] ?></h1>
            <?php else: ?>
            <h1 x-text="courseName" class="mt-3 max-w-3xl font-display text-3xl font-extrabold leading-tight sm:text-4xl">Cargando curso...</h1>
            <?php endif; ?>
        </div>
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="absolute bottom-0 left-0 block h-8 w-full sm:h-12" aria-hidden="true"><path d="M0,40 C240,80 480,0 720,30 C960,60 1200,80 1440,20 L1440,80 L0,80 Z" fill="#f5f7fb"></path></svg>
    </section>

    <main class="mx-auto grid max-w-6xl grid-cols-1 gap-8 px-4 pb-16 pt-4 lg:grid-cols-2">

        <!-- Columna izquierda: informacion del curso -->
        <div class="space-y-6">
            <div class="overflow-hidden rounded-2xl bg-deep shadow-xl ring-1 ring-black/5">
                <div class="aspect-video">
                    <iframe class="h-full w-full" title="Video promocional del curso" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
                            :src="courseName.toLowerCase().includes('condensadores') ? 'https://www.youtube.com/embed/8TLJJCuo8Yg?rel=0' : (courseName.toLowerCase().includes('terminaciones') ? 'https://www.youtube.com/embed/EFj6mLwhkjg?rel=0' : (courseName.toLowerCase().includes('industrial') ? 'https://www.youtube.com/embed/lvb5RYvgjL0?rel=0' : (courseName.toLowerCase().includes('analizador') ? 'https://www.youtube.com/embed/h9UIxWA7_Lw?rel=0' : (courseName.toLowerCase().includes('canalizaciones') ? 'https://www.youtube.com/embed/HhwUmtNPrto?rel=0' : (courseName.toLowerCase().includes('empalmes') ? 'https://www.youtube.com/embed/EFwgRMFiN-A?rel=0' : (courseName.toLowerCase().includes('variadores') ? 'https://www.youtube.com/embed/r6lolq0LJhE?rel=0' : 'https://www.youtube.com/embed/7SMbMxs27K0?rel=0'))))))"></iframe>
                </div>
            </div>

            <?php if ($acordeones): ?>
            <!-- Acordeones con el contenido del curso (BD) -->
            <div class="space-y-3" x-data="{ activeAccordion: <?= (int) $primerAcordeon ?> }">
                <?php foreach ($acordeones as $a): ?>
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                    <button type="button" class="flex w-full items-center justify-between gap-3 px-5 py-4 text-left font-display font-bold text-deep hover:bg-mist"
                            :aria-expanded="activeAccordion === <?= $a[0] ?>" @click="activeAccordion = activeAccordion === <?= $a[0] ?> ? null : <?= $a[0] ?>">
                        <span class="flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-mist text-brand"><i class="<?= $a[1] ?>" aria-hidden="true"></i></span> <?= $a[2] ?></span>
                        <i class="fas fa-chevron-down text-sm text-muted transition-transform" :class="activeAccordion === <?= $a[0] ?> && 'rotate-180'" aria-hidden="true"></i>
                    </button>
                    <div class="accordion-content contenido-db border-t border-mist px-5 py-4 text-sm leading-relaxed" x-show="activeAccordion === <?= $a[0] ?>" x-transition <?= $a[0] === $primerAcordeon ? '' : 'style="display: none;"' ?>>
                        <?= $a[3] ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Precio -->
            <div class="rounded-2xl bg-deep px-6 py-7 text-center text-white shadow-xl">
                <p class="text-xs font-bold uppercase tracking-widest text-sky-100">Monto total a pagar</p>
                <p class="mt-2 font-display text-5xl font-extrabold leading-none">
                    <span x-text="currencySymbol" class="align-top text-2xl text-accent"></span><span x-text="coursePrice.toFixed(2)"></span>
                    <span class="text-lg text-sky-100" x-text="currency">PEN</span>
                </p>
                <!-- "Precio regular" solo si hay uno real (precio de la BD o ?regular=) mayor al que se cobra -->
                <p class="mt-3 text-sm text-sky-100" x-show="originalPrice && originalPrice > coursePrice" x-cloak>
                    Precio regular: <span class="line-through" x-text="(currency === 'PEN' ? 'S/ ' : 'US$ ') + (originalPrice || 0).toFixed(2)"></span>
                </p>
            </div>

            <!-- Contacto -->
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                <h2 class="font-display text-lg font-bold text-deep">¿Dudas? Comunícate con nuestros asesores</h2>
                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-line/60 p-3 hover:bg-mist">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#25D366] text-xl text-white"><i class="fab fa-whatsapp" aria-hidden="true"></i></span>
                        <span class="text-sm"><span class="block font-bold text-deep">+51 941 208 020</span><span class="text-muted">WhatsApp</span></span>
                    </a>
                    <a href="mailto:informes@icc.com.pe" class="flex items-center gap-3 rounded-xl border border-line/60 p-3 hover:bg-mist">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand text-white"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                        <span class="text-sm"><span class="block font-bold text-deep">informes@icc.com.pe</span><span class="text-muted">Correo</span></span>
                    </a>
                </div>
                <div class="mt-4 flex items-center justify-center gap-2">
                    <a href="https://www.facebook.com/profile.php?id=61570845450403" target="_blank" rel="noopener" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full bg-mist text-brand hover:bg-brand hover:text-white"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="https://www.tiktok.com/@icc_capacitaciones_int" target="_blank" rel="noopener" aria-label="TikTok" class="flex h-10 w-10 items-center justify-center rounded-full bg-mist text-brand hover:bg-brand hover:text-white"><i class="fab fa-tiktok" aria-hidden="true"></i></a>
                    <a href="<?= BASE_URL ?>" aria-label="Sitio web de ICC" class="flex h-10 w-10 items-center justify-center rounded-full bg-mist text-brand hover:bg-brand hover:text-white"><i class="fas fa-globe" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <!-- Columna derecha: pago -->
        <div id="pago" class="lg:sticky lg:top-6 lg:self-start">
            <div x-show="!paymentSuccess" x-transition class="rounded-2xl bg-white p-6 shadow-xl ring-1 ring-black/5">
                <h2 class="font-display text-2xl font-bold text-brand-dark">Método de pago</h2>

                <!-- Pestañas (si Hotmart es la unica opcion, se muestra directo) -->
                <div class="mt-4 grid auto-cols-fr grid-flow-col gap-1 rounded-xl bg-surface p-1" x-show="!soloHotmart" role="tablist">
                    <button type="button" role="tab" x-show="metodosDisponibles.includes('manual')" :aria-selected="activeTab === 'manual'" :class="activeTab === 'manual' ? 'bg-white text-brand shadow' : 'text-muted hover:text-deep'" class="min-h-[44px] rounded-lg px-2 text-sm font-bold" @click="setTab('manual')">
                        <i class="fas fa-mobile-alt mr-1" aria-hidden="true"></i> Yape / Plin
                    </button>
                    <button type="button" role="tab" x-show="metodosDisponibles.includes('paypal')" :aria-selected="activeTab === 'paypal'" :class="activeTab === 'paypal' ? 'bg-white text-brand shadow' : 'text-muted hover:text-deep'" class="min-h-[44px] rounded-lg px-2 text-sm font-bold" @click="setTab('paypal')">
                        <i class="far fa-credit-card mr-1" aria-hidden="true"></i> PayPal / Tarjeta
                    </button>
                    <button type="button" role="tab" x-show="metodosDisponibles.includes('hotmart') && HOTMART_LINK" :aria-selected="activeTab === 'hotmart'" :class="activeTab === 'hotmart' ? 'bg-white text-brand shadow' : 'text-muted hover:text-deep'" class="min-h-[44px] rounded-lg px-2 text-sm font-bold" @click="setTab('hotmart')">
                        <i class="fas fa-globe-americas mr-1" aria-hidden="true"></i> Otros métodos
                    </button>
                </div>

                <div class="mt-5">
                    <!-- Yape / Plin -->
                    <div x-show="activeTab === 'manual'" x-transition>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="setManualMethod('yape')" :aria-pressed="manualMethod === 'yape'" :class="manualMethod === 'yape' ? 'border-brand ring-2 ring-brand' : 'border-line'" class="flex items-center justify-center gap-2 rounded-xl border bg-white px-3 py-3 font-bold text-deep">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#7400b8] font-bold text-white">Y</span> Yape
                            </button>
                            <button type="button" @click="setManualMethod('plin')" :aria-pressed="manualMethod === 'plin'" :class="manualMethod === 'plin' ? 'border-brand ring-2 ring-brand' : 'border-line'" class="flex items-center justify-center gap-2 rounded-xl border bg-white px-3 py-3 font-bold text-deep">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#00a896] font-bold text-white">P</span> Plin
                            </button>
                        </div>

                        <div x-show="manualMethod" class="mt-5">
                            <div class="text-center">
                                <img :src="manualDetails[manualMethod]?.qrUrl" alt="Código QR para pagar" class="mx-auto max-h-72 w-auto max-w-[14rem] rounded-xl object-contain shadow-md ring-1 ring-black/5">
                            </div>
                            <dl class="mt-4 space-y-2 rounded-xl bg-surface p-4 text-sm">
                                <div class="flex justify-between gap-3"><dt class="text-muted">Titular</dt><dd class="font-semibold text-deep" x-text="manualDetails[manualMethod]?.name">Cargando...</dd></div>
                                <div class="flex justify-between gap-3 border-t border-dashed border-line pt-2"><dt class="text-muted">Monto a transferir</dt><dd class="font-display font-extrabold text-brand" x-text="'S/ ' + amountInSoles.toFixed(2) + ' PEN'"></dd></div>
                                <template x-if="currency === 'USD'">
                                    <p class="text-xs text-muted" x-text="'(Convertido de $' + coursePrice.toFixed(2) + ' USD al cambio ' + tipoCambio.toFixed(2) + ')'"></p>
                                </template>
                            </dl>

                            <fieldset class="mt-5">
                                <legend class="font-display font-bold text-deep">Tus datos (para el certificado)</legend>
                                <div class="mt-3 grid grid-cols-1 gap-3">
                                    <div><label for="m-dni" class="sr-only">DNI o documento de identidad</label><input id="m-dni" type="text" x-model="dni" placeholder="DNI o documento de identidad" class="<?= $campoCk ?>" required></div>
                                    <div><label for="m-nombre" class="sr-only">Nombres completos</label><input id="m-nombre" type="text" x-model="nombre" placeholder="Nombres completos" autocomplete="given-name" class="<?= $campoCk ?>" required></div>
                                    <div><label for="m-apellido" class="sr-only">Apellidos completos</label><input id="m-apellido" type="text" x-model="apellido" placeholder="Apellidos completos" autocomplete="family-name" class="<?= $campoCk ?>" required></div>
                                    <div><label for="m-celular" class="sr-only">Celular o WhatsApp</label><input id="m-celular" type="tel" x-model="celular" placeholder="Número de celular / WhatsApp" autocomplete="tel" class="<?= $campoCk ?>" required></div>
                                </div>
                            </fieldset>

                            <label for="voucher_upload" class="mt-4 flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-line bg-surface px-4 py-5 text-center text-sm font-semibold text-muted hover:border-brand hover:text-brand"
                                   :class="voucherFile && 'border-emerald-500 bg-emerald-50 text-emerald-800'">
                                <i class="fas" :class="voucherFile ? 'fa-check-circle' : 'fa-cloud-upload-alt'" aria-hidden="true"></i>
                                <span id="file_label" x-text="voucherFile ? voucherFile.name : 'Subir captura o foto del voucher'"></span>
                            </label>
                            <input type="file" id="voucher_upload" class="sr-only" @change="voucherFile = $event.target.files[0]" accept="image/*,application/pdf">

                            <button type="button" @click="submitManualPayment()" id="btn_submit_manual" :disabled="!voucherFile"
                                    class="mt-4 flex min-h-[48px] w-full items-center justify-center rounded-xl bg-accent px-6 py-3 font-display text-base font-bold text-deep shadow-md hover:brightness-95 disabled:cursor-not-allowed disabled:opacity-60">
                                Confirmar mi inscripción
                            </button>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div x-show="activeTab === 'paypal'" x-transition>
                        <p class="text-sm text-muted">Inicia sesión en tu cuenta de PayPal o paga de forma segura con tarjeta de crédito o débito en dólares.</p>
                        <template x-if="currency === 'PEN'">
                            <p class="mt-2 text-sm text-muted">(Equivalente para PayPal: <strong class="text-deep" x-text="'$' + amountInUSD.toFixed(2) + ' USD'"></strong> al cambio de <span x-text="tipoCambio"></span>)</p>
                        </template>
                        <fieldset class="mt-5">
                            <legend class="font-display font-bold text-deep">Tus datos (para el certificado)</legend>
                            <div class="mt-3 grid grid-cols-1 gap-3">
                                <div><label for="p-dni" class="sr-only">DNI o documento de identidad</label><input id="p-dni" type="text" x-model="dni" placeholder="DNI o documento de identidad" class="<?= $campoCk ?>" required></div>
                                <div><label for="p-nombre" class="sr-only">Nombres completos</label><input id="p-nombre" type="text" x-model="nombre" placeholder="Nombres completos" autocomplete="given-name" class="<?= $campoCk ?>" required></div>
                                <div><label for="p-apellido" class="sr-only">Apellidos completos</label><input id="p-apellido" type="text" x-model="apellido" placeholder="Apellidos completos" autocomplete="family-name" class="<?= $campoCk ?>" required></div>
                                <div><label for="p-celular" class="sr-only">Celular o WhatsApp</label><input id="p-celular" type="tel" x-model="celular" placeholder="Número de celular / WhatsApp" autocomplete="tel" class="<?= $campoCk ?>" required></div>
                            </div>
                        </fieldset>
                        <!-- Contenedor del boton de PayPal -->
                        <div id="paypal-button-container" class="mt-5"></div>
                    </div>

                    <!-- Hotmart: mas metodos locales segun el pais (iframe; link de respaldo por si un metodo abre su propia ventana) -->
                    <div x-show="activeTab === 'hotmart'" x-transition>
                        <p class="text-sm text-muted">Paga con más métodos según tu país (tarjeta local en cuotas, transferencia bancaria, billeteras digitales y más).</p>
                        <p class="mt-2 text-xs text-muted">El precio final se muestra en tu moneda local dentro del formulario de pago y puede incluir impuestos locales (por ejemplo, IVA), que se suman al precio del curso.</p>
                        <!-- Alto grande a proposito: asi el formulario de Hotmart no muestra su propia barra de scroll -->
                        <iframe :src="HOTMART_LINK" loading="lazy" allow="payment *" @load.once="trackHotmartClick('iframe')" title="Formulario de pago de Hotmart"
                                class="mt-3 h-[1900px] w-full rounded-xl border border-line"></iframe>
                        <p class="mt-3 text-center text-xs text-muted">
                            ¿No carga bien aquí? <a :href="HOTMART_LINK" target="_blank" rel="noopener" class="font-semibold text-brand underline" @click="trackHotmartClick('respaldo')">Ábrelo en una pestaña nueva</a>.
                            Tus accesos al Aula Virtual llegan automáticamente a tu correo tras confirmarse el pago.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 border-t border-mist pt-4 text-xs font-semibold text-muted">
                    <span class="flex items-center gap-1.5"><i class="fas fa-shield-alt text-emerald-600" aria-hidden="true"></i> Pago 100% seguro</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-lock text-emerald-600" aria-hidden="true"></i> Conexión cifrada (SSL)</span>
                </div>
            </div>

            <!-- Exito y estado del tramite -->
            <div x-show="paymentSuccess" x-transition style="display: none;" class="rounded-2xl bg-white p-8 text-center shadow-xl ring-1 ring-black/5" role="status">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-3xl text-emerald-600"><i class="fas fa-check" aria-hidden="true"></i></span>
                <h2 class="mt-4 font-display text-2xl font-bold text-deep" x-text="paymentMethodUsed === 'paypal' ? '¡Pago recibido con éxito!' : '¡Voucher recibido con éxito!'">¡Voucher recibido con éxito!</h2>
                <p class="mt-2 text-sm text-muted">Estamos procesando tu inscripción. Sigue el estado de tu trámite:</p>

                <ol class="relative mx-auto mt-8 grid max-w-sm grid-cols-3 text-xs font-bold">
                    <li class="absolute left-[16%] right-[16%] top-4 h-1 rounded bg-line" aria-hidden="true"><span class="block h-full w-1/2 rounded bg-emerald-500"></span></li>
                    <li class="relative text-emerald-700"><span class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500 text-white ring-4 ring-white"><i class="fas fa-check" aria-hidden="true"></i></span>Pago enviado</li>
                    <li class="relative text-amber-700"><span class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-full border-4 border-amber-400 bg-white text-amber-500 ring-4 ring-white"><i class="fas fa-hourglass-half" aria-hidden="true"></i></span>Validando inscripción</li>
                    <li class="relative text-muted"><span class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-full border-4 border-line bg-white ring-4 ring-white">3</span>Accesos enviados</li>
                </ol>

                <template x-if="paymentMethodUsed === 'manual'">
                    <div class="mt-8 rounded-xl border border-dashed border-line bg-surface p-5">
                        <h3 class="font-display text-lg font-bold text-deep"><i class="fas fa-exclamation-triangle mr-1 text-amber-500" aria-hidden="true"></i> Siguiente paso obligatorio</h3>
                        <p class="mt-2 text-sm text-muted">Para agilizar la validación y enviarte tus accesos de inmediato, haz clic en el botón de abajo y envíanos un mensaje por WhatsApp confirmando tus datos.</p>
                        <a href="https://wa.me/51941208020?text=Hola,%20acabo%20de%20subir%20mi%20voucher%20para%20el%20curso.%20Mis%20nombres%20son:" target="_blank" rel="noopener"
                           class="mt-4 inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-[#25D366] px-6 py-3 font-display font-bold text-white shadow-md hover:brightness-95">
                            <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Escribir a WhatsApp
                        </a>
                    </div>
                </template>

                <template x-if="paymentMethodUsed === 'paypal'">
                    <div class="mt-8 rounded-xl border border-dashed border-line bg-surface p-5">
                        <h3 class="font-display text-lg font-bold text-deep">¡Todo listo!</h3>
                        <p class="mt-2 text-sm text-muted">Tu pago por PayPal ha sido recibido exitosamente. En un momento, recibirás tus credenciales. (Puedes comunicarte con nosotros desde el chat de soporte abajo a la derecha).</p>
                        <button type="button" @click="$crisp.push(['do', 'chat:show']); $crisp.push(['do', 'chat:open']);"
                                class="mt-4 inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-brand px-6 py-3 font-display font-bold text-white shadow-md hover:bg-brand-dark">
                            <i class="fas fa-comments" aria-hidden="true"></i> Abrir chat de soporte
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </main>

    <!-- Celular: precio y acceso directo al pago (el formulario queda debajo de la informacion del curso) -->
    <div x-show="!paymentSuccess" class="fixed inset-x-0 bottom-0 z-40 border-t border-line/60 bg-white p-3 shadow-[0_-4px_16px_rgba(0,0,0,0.12)] lg:hidden">
        <div class="mx-auto flex max-w-md items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="truncate text-xs text-muted" x-text="courseName"></p>
                <p class="font-display text-lg font-extrabold leading-tight text-brand"><span x-text="currencySymbol"></span><span x-text="coursePrice.toFixed(2)"></span></p>
            </div>
            <a href="#pago" class="shrink-0 rounded-xl bg-accent px-5 py-3 font-display text-sm font-bold text-deep shadow-md">Pagar ahora</a>
        </div>
    </div>
</div>

<footer class="bg-deep py-8 text-center text-sm text-sky-100">
    <div class="mx-auto max-w-6xl px-4">
        <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC" class="mx-auto h-10 w-auto">
        <p class="mt-3">Medios de pago: Yape · Plin · PayPal · Tarjeta de crédito o débito</p>
        <p class="mt-1">informes@icc.com.pe · <a href="https://wa.me/51941208020" class="underline" target="_blank" rel="noopener">+51 941 208 020</a></p>
    </div>
</footer>

<!-- Generador de enlaces de pago para administracion (TikTok y ofertas especiales). Solo con ?admin=true -->
<div class="mx-auto mb-10 mt-6 max-w-3xl rounded-2xl border-t-4 border-accent bg-white p-6 shadow-xl ring-1 ring-black/5" x-data="adminPanel()" x-show="visible" x-transition style="display: none;">
    <div class="flex items-center justify-between gap-3">
        <h2 class="font-display text-xl font-bold text-deep">Generador de enlaces de pago</h2>
        <span class="rounded-full bg-deep px-3 py-1 text-xs font-bold text-accent">Admin</span>
    </div>
    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div><label for="admin_curso" class="mb-1 block text-sm font-semibold text-deep">Nombre del curso</label><input type="text" id="admin_curso" class="<?= $campoCk ?>" x-model="courseName" placeholder="Ej: Curso TikTok Premium"></div>
        <div><label for="admin_precio" class="mb-1 block text-sm font-semibold text-deep">Precio especial</label><input type="number" id="admin_precio" class="<?= $campoCk ?>" x-model.number="price" placeholder="Ej: 20"></div>
        <div>
            <label for="admin_moneda" class="mb-1 block text-sm font-semibold text-deep">Moneda</label>
            <select id="admin_moneda" class="<?= $campoCk ?>" x-model="currency">
                <option value="USD">Dólares (USD)</option>
                <option value="PEN">Soles (PEN)</option>
            </select>
        </div>
    </div>
    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
        <button type="button" @click="generateLink()" class="min-h-[44px] rounded-xl bg-brand px-5 font-bold text-white hover:bg-brand-dark">Generar enlace</button>
        <div class="flex flex-1 gap-2" x-show="generatedLink">
            <label for="generated_link_input" class="sr-only">Enlace generado</label>
            <input type="text" readonly :value="generatedLink" id="generated_link_input" class="<?= $campoCk ?> min-w-0 flex-1 font-mono text-xs">
            <button type="button" @click="copyLink()" class="shrink-0 rounded-xl bg-accent px-4 font-bold text-deep hover:brightness-95">Copiar</button>
        </div>
    </div>
</div>


    <!-- Script de Configuración de la Pasarela -->
    <script>
        // Moneda sugerida por el servidor segun el pais detectado por IP (ver CheckoutController::index()
        // y App\Helpers\GeoHelper). Es solo el valor por defecto: ?moneda=PEN|USD en la URL sigue
        // pudiendo forzarlo manualmente (para links promocionales existentes).
        const MONEDA_SUGERIDA = <?= json_encode($data['monedaSugerida'] ?? 'USD') ?>;

        // Link de pago de Hotmart para este curso (App\Helpers\HotmartLinks), si existe.
        const HOTMART_LINK = <?= json_encode($data['hotmartLink'] ?? null) ?>;
        // true si ese link es una oferta promocional de Hotmart: Hotmart convierte su precio
        // a la moneda del comprador, asi que puede diferir en centavos del monto de arriba.
        const HOTMART_OFERTA = <?= json_encode(!empty($data['hotmartOferta'])) ?>;

        // Google Analytics: evento begin_checkout cuando el formulario de pago de Hotmart se
        // muestra (carga del iframe) o el comprador usa el link de respaldo. Junto con los
        // page_view por utm_campaign, permite ver cuantos llegan del anuncio, cuantos ven el
        // pago y cuantos terminan comprando.
        function trackHotmartClick(origen) {
            try {
                var root = document.querySelector('.checkout-container');
                var d = (window.Alpine && root) ? Alpine.$data(root) : null;
                gtag('event', 'begin_checkout', {
                    currency: d ? d.currency : undefined,
                    value: d ? d.coursePrice : undefined,
                    items: [{ item_name: d ? d.courseName : '' }],
                    payment_provider: 'hotmart',
                    origen_boton: origen,
                    transport_type: 'beacon'
                });
            } catch (e) {}
        }

        function checkoutApp() {
            return {
                paymentSuccess: false,
                paymentMethodUsed: null,
                // Estado dinámico cargado desde la URL
                courseName: '',
                coursePrice: 30.00,
                originalPrice: null, // Precio original de la DB (para mostrar como "Precio Regular")
                currency: 'USD',

                // Medios de pago disponibles para este visitante, segun el pais detectado
                // por el servidor (ver App\Helpers\GeoHelper). Ej: ['manual','paypal'] en Peru,
                // ['paypal'] en el resto del mundo. Cuando se sume una pasarela nueva para otro
                // pais, este array es lo que hay que ampliar (y agregar su pestaña/vista abajo).
                metodosDisponibles: <?= json_encode($data['metodosDisponibles'] ?? ['manual', 'paypal']) ?>,
                paisDetectado: <?= json_encode($data['paisDetectado'] ?? 'PE') ?>,

                // Tipo de cambio para conversiones USD <-> PEN
                tipoCambio: 3.80,

                // Pestaña activa ('manual' o 'paypal')
                activeTab: 'manual',

                // Submétodo manual activo ('yape' o 'plin')
                manualMethod: 'yape',
                voucherFile: null,

                // Datos del estudiante
                dni: '',
                nombre: '',
                apellido: '',
                celular: '',

                // Datos de Yape y Plin (Ajusta tus datos reales aquí)
                manualDetails: {
                    yape: {
                        title: 'Pago con Yape',
                        qrUrl: '<?= BASE_URL ?>assets/images/Yape.jpg',
                        color: '#7400b8',
                        name: 'Mariela Ma.'
                    },
                    plin: {
                        title: 'Pago con Plin',
                        qrUrl: '<?= BASE_URL ?>assets/images/plin.jpg',
                        color: '#00c8b0',
                        name: 'Ricardo Cardenas'
                    }
                },

                get currencySymbol() {
                    return this.currency === 'USD' ? '$' : 'S/ ';
                },

                get amountInUSD() {
                    if (this.currency === 'USD') return this.coursePrice;
                    return parseFloat((this.coursePrice / this.tipoCambio).toFixed(2));
                },

                get amountInSoles() {
                    if (this.currency === 'PEN') return this.coursePrice;
                    return parseFloat((this.coursePrice * this.tipoCambio).toFixed(2));
                },

                // Solo Hotmart, sin pestañas: unicamente cuando es el UNICO metodo disponible
                // (hoy, el link de prueba ?hm=). En links internacionales normales se muestran
                // PayPal directo (menos comision que Hotmart) y Hotmart en pestañas.
                get soloHotmart() {
                    return this.metodosDisponibles.includes('hotmart') && !!HOTMART_LINK
                        && !this.metodosDisponibles.includes('paypal')
                        && !this.metodosDisponibles.includes('manual');
                },

                init() {
                    // 1. Cargar parámetros desde la URL
                    const urlParams = new URLSearchParams(window.location.search);
                    this.courseName = urlParams.get('curso') || 'Curso Completo de Marketing y Ventas';
                    this.currency = (urlParams.get('moneda') || MONEDA_SUGERIDA).toUpperCase();

                    <?php if (isset($data['cursoDB']) && $data['cursoDB']): ?>
                        // Si hay un precio explícito en la URL, usarlo (para links promocionales)
                        if (urlParams.get('precio')) {
                            this.coursePrice = parseFloat(urlParams.get('precio'));
                            // Guardar el precio original de la DB para mostrar como "Precio Regular"
                            if (this.currency === 'PEN') {
                                this.originalPrice = <?= $data['cursoDB']['precio'] ?: 'null' ?>;
                            } else {
                                this.originalPrice = <?= $data['cursoDB']['precio_usd'] ?: 'null' ?>;
                            }
                        } else if (this.currency === 'PEN') {
                            this.coursePrice = <?= $data['cursoDB']['precio'] ?: 'parseFloat(urlParams.get("precio")) || 89.90' ?>;
                        } else {
                            this.coursePrice = <?= $data['cursoDB']['precio_usd'] ?: 'parseFloat(urlParams.get("precio")) || 30.00' ?>;
                        }
                    <?php else: ?>
                        this.coursePrice = parseFloat(urlParams.get('precio')) || 30.00;
                    <?php endif; ?>
                    this.currency = (urlParams.get('moneda') || MONEDA_SUGERIDA).toUpperCase();

                    // ?regular=55 fija el "Precio Regular" tachado (si no, sale el de la BD)
                    const regularUrl = parseFloat(urlParams.get('regular'));
                    if (regularUrl > 0) this.originalPrice = regularUrl;

                    // Pestaña inicial: Yape/Plin solo si esta disponible para este visitante
                    // (hoy, solo Peru) y ademas la moneda activa es soles; si Hotmart es la
                    // unica opcion relevante para este pais/curso, vamos directo a esa (ya
                    // incluye PayPal adentro, no hace falta elegir entre pestañas); si no, PayPal.
                    if (this.soloHotmart) {
                        this.activeTab = 'hotmart';
                    } else {
                        this.activeTab = (this.currency === 'PEN' && this.metodosDisponibles.includes('manual'))
                            ? 'manual'
                            : 'paypal';
                    }

                    // Renderizamos los botones si la pestaña inicial es PayPal
                    if (this.activeTab === 'paypal') {
                        setTimeout(() => this.renderPayPalButtons(), 100);
                    }

                    // Sistema de códigos promocionales: ?p=CODIGO
                    // Cada código define: precio, elementos a ocultar, textos a renombrar
                    const promoCodes = {
                        'peru69': {
                            precio: 69.90,
                            moneda: 'PEN',
                            ocultar: ['03/10'],
                            renombrar: [['Equipos y herramientas', 'Herramientas que vamos a ver en el curso']],
                            horas: 20
                        }
                    };

                    const promoCode = urlParams.get('p');
                    if (promoCode && promoCodes[promoCode]) {
                        const promo = promoCodes[promoCode];
                        // Setear moneda ANTES de leer precios de la DB
                        if (promo.moneda) this.currency = promo.moneda.toUpperCase();
                        this.activeTab = (this.currency === 'PEN' && this.metodosDisponibles.includes('manual'))
                            ? 'manual'
                            : 'paypal';

                        if (promo.precio) {
                            // Guardar precio original de la DB para mostrar como "Precio Regular"
                            <?php if (isset($data['cursoDB']) && $data['cursoDB']): ?>
                            if (this.currency === 'PEN') {
                                this.originalPrice = <?= $data['cursoDB']['precio'] ?: 'null' ?>;
                            } else {
                                this.originalPrice = <?= $data['cursoDB']['precio_usd'] ?: 'null' ?>;
                            }
                            <?php endif; ?>
                            this.coursePrice = promo.precio;
                        }

                        setTimeout(() => {
                            if (promo.ocultar) {
                                promo.ocultar.forEach(texto => {
                                    document.querySelectorAll('.accordion-content li').forEach(li => {
                                        if (li.textContent.includes(texto)) li.remove();
                                    });
                                });
                            }
                            if (promo.renombrar) {
                                promo.renombrar.forEach(([viejo, nuevo]) => {
                                    // Buscar encabezados/elementos que contengan el texto y reemplazar TODO su contenido (elimina iconos)
                                    document.querySelectorAll('.accordion-content h3, .accordion-content h4, .accordion-content h5, .accordion-content strong, .accordion-content b, .accordion-content p').forEach(el => {
                                        if (el.textContent.includes(viejo)) {
                                            el.innerHTML = nuevo;
                                        }
                                    });
                                });
                            }
                            if (promo.horas) {
                                // Reemplazar "XX horas académicas" por el nuevo valor
                                document.querySelectorAll('.accordion-content').forEach(el => {
                                    el.innerHTML = el.innerHTML.replace(/\d+\s*horas?\s*acad[ée]micas/gi, promo.horas + ' horas académicas');
                                });
                            }
                        }, 50);
                    } else {
                        // Overrides manuales por URL: ?ocultar=texto&retitular=viejo~nuevo
                        setTimeout(() => {
                            const ocultar = urlParams.get('ocultar');
                            if (ocultar) {
                                document.querySelectorAll('.accordion-content li').forEach(li => {
                                    if (li.textContent.includes(ocultar)) li.remove();
                                });
                            }
                            const retitular = urlParams.get('retitular');
                            if (retitular && retitular.includes('~')) {
                                const [viejo, nuevo] = retitular.split('~');
                                document.querySelectorAll('.accordion-content').forEach(el => {
                                    el.innerHTML = el.innerHTML.replace(viejo, nuevo);
                                });
                            }
                        }, 50);
                    }
                },

                setTab(tab) {
                    this.activeTab = tab;
                    if (tab === 'paypal') {
                        setTimeout(() => this.renderPayPalButtons(), 50);
                    }
                },

                setManualMethod(method) {
                    this.manualMethod = method;
                },

                submitManualPayment() {
                    if (!this.dni || !this.nombre || !this.apellido || !this.celular) {
                        alert('Por favor, ingresa tu DNI, Nombres, Apellidos y Celular.');
                        return;
                    }

                    if (!this.voucherFile) {
                        alert('Por favor, adjunta tu ticket o voucher de pago para continuar.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('voucher', this.voucherFile);
                    formData.append('curso', this.courseName);
                    formData.append('dni', this.dni);
                    formData.append('nombre', this.nombre);
                    formData.append('apellido', this.apellido);
                    formData.append('celular', this.celular);

                    const btn = document.getElementById('btn_submit_manual');
                    btn.disabled = true;
                    btn.innerText = 'Subiendo voucher...';

                    fetch('<?= BASE_URL ?>checkout/voucher', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            this.paymentSuccess = true;
                            this.paymentMethodUsed = 'manual';
                            this.voucherFile = null;
                            
                            // META PIXEL: Rastrear Compra
                            if (typeof fbq === 'function') {
                                fbq('track', 'Purchase', {
                                    value: this.coursePrice,
                                    currency: this.currency,
                                    content_name: this.courseName
                                });
                            }
                            
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            alert('Ocurrió un error: ' + (data.error || 'Error desconocido'));
                            btn.disabled = false;
                            btn.innerText = 'Confirmar mi inscripción';
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('Error de conexión al subir el voucher. Intenta nuevamente.');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerText = 'Confirmar mi inscripción';
                    });
                },

                renderPayPalButtons() {
                    const container = document.getElementById('paypal-button-container');
                    if (!container) return;

                    // No duplicar botones
                    if (container.children.length > 0) return;

                    if (typeof paypal === 'undefined') {
                        console.error('PayPal SDK no disponible.');
                        return;
                    }

                    const self = this;

                    paypal.Buttons({
                        onClick: function (data, actions) {
                            // No dejamos abrir el popup de pago si aun no tenemos los datos del alumno
                            if (!self.dni || !self.nombre || !self.apellido || !self.celular) {
                                alert('Por favor, completa tus datos (DNI, Nombres, Apellidos y Celular) antes de pagar.');
                                return actions.reject();
                            }
                            return actions.resolve();
                        },
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        currency_code: 'USD',
                                        value: self.amountInUSD.toString()
                                    },
                                    description: `Acceso al curso: ${self.courseName}`
                                }]
                            });
                        },
                        onApprove: function (data, actions) {
                            return actions.order.capture().then(function (details) {
                                console.log('PayPal details:', details);

                                // El dinero ya se movio de verdad en PayPal: mostramos éxito de inmediato,
                                // sin hacer esperar (ni arriesgar) al comprador por si el backend falla.
                                self.paymentSuccess = true;
                                self.paymentMethodUsed = 'paypal';

                                // META PIXEL: Rastrear Compra
                                if (typeof fbq === 'function') {
                                    fbq('track', 'Purchase', {
                                        value: self.coursePrice,
                                        currency: self.currency,
                                        content_name: self.courseName
                                    });
                                }

                                if (typeof $crisp !== 'undefined') {
                                    $crisp.push(["do", "chat:show"]);
                                    setTimeout(() => $crisp.push(["do", "chat:open"]), 500);
                                }
                                window.scrollTo({ top: 0, behavior: 'smooth' });

                                // Registrar la venta: le pedimos al backend que vuelva a preguntarle a
                                // PayPal (servidor a servidor) si la orden esta COMPLETED y recien ahi la
                                // guarda y matricula al alumno. Es "best-effort": si esto falla (ej. el
                                // Secret de PayPal aun no esta configurado en el servidor), el comprador
                                // YA vio su pantalla de éxito -- el mensaje de esa pantalla ya le pide
                                // escribirnos por el chat como respaldo, así ninguna venta se pierde.
                                fetch('<?= BASE_URL ?>checkout/paypal_confirm', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        orderID: data.orderID,
                                        curso: self.courseName,
                                        dni: self.dni,
                                        nombre: self.nombre,
                                        apellido: self.apellido,
                                        celular: self.celular
                                    })
                                })
                                .then(res => res.json())
                                .then(resp => {
                                    if (!resp.success) {
                                        console.error('No se pudo registrar la venta de PayPal automaticamente:', resp.error, '- Orden:', data.orderID);
                                    }
                                })
                                .catch(err => {
                                    console.error('Error de conexión confirmando PayPal en backend (orden ' + data.orderID + '):', err);
                                });
                            });
                        },
                        onError: function (err) {
                            console.error('PayPal Error:', err);
                            alert('Hubo un inconveniente con el pago en PayPal. Por favor, intente de nuevo.');
                        }
                    }).render('#paypal-button-container');
                }
            }
        }

        function adminPanel() {
            return {
                visible: false,
                courseName: '',
                price: 30,
                currency: 'USD',
                generatedLink: '',

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    // El panel solo es visible si añadimos ?admin=true en la URL
                    this.visible = urlParams.get('admin') === 'true';

                    // Rellenar valores iniciales
                    this.courseName = urlParams.get('curso') || 'Curso Completo de Marketing y Ventas';
                    this.price = parseFloat(urlParams.get('precio')) || 30.00;
                    this.currency = (urlParams.get('moneda') || 'USD').toUpperCase();
                },

                generateLink() {
                    const baseUrl = window.location.origin + window.location.pathname;
                    const params = new URLSearchParams();
                    params.set('curso', this.courseName);
                    params.set('precio', this.price.toFixed(2));
                    params.set('moneda', this.currency);

                    this.generatedLink = `${baseUrl}?${params.toString()}`;
                },

                copyLink() {
                    const copyText = document.getElementById("generated_link_input");
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); // Para móviles

                    navigator.clipboard.writeText(copyText.value)
                        .then(() => {
                            alert("¡Enlace de pago copiado al portapapeles! Ya puedes enviarlo por WhatsApp o redes sociales.");
                        })
                        .catch(err => {
                            console.error("Error al copiar enlace:", err);
                        });
                }
            }
        }
    </script>
</body>

</html>
