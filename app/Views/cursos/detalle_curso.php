<?php
/**
 * Detalle de un curso (estilo checkout v2, layouts/sitio.php).
 * Datos: CursosController::detalle ($curso de la BD, $latest_courses = tarjetas).
 * Solo contenido real: sin reseñas ni estrellas inventadas. El precio regular tachado sale de la BD (admin).
 */
$hd = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$nombre = $curso['nombre_curso'] ?? 'Curso en ICC';
$lista = \App\Controllers\CursosController::datosLista($curso);
$precioPEN = (float) ($curso['precio'] ?? 89.90);
$precioUSD = (float) ($curso['precio_usd'] ?? 30.00);
$regularPEN = \App\Models\Catalogo::regularPen($curso);
$urlCheckout = BASE_URL . 'checkout?curso=' . rawurlencode($nombre);
$fotoDoc = $curso['docente_foto'] ?? '';
$tieneFotoDoc = $fotoDoc !== '' && $fotoDoc !== '50x50' && is_file('assets/images/docentes/' . $fotoDoc);
$barra_movil = true; // el layout sube el boton de WhatsApp para no tapar la barra de compra

$cName = mb_strtolower($nombre, 'UTF-8');
$videos = [
    'condensadores' => '8TLJJCuo8Yg',
    'terminaciones' => 'EFj6mLwhkjg',
    'industrial' => 'lvb5RYvgjL0',
    'analizador' => 'h9UIxWA7_Lw',
    'canalizaciones' => 'HhwUmtNPrto',
    'empalmes' => 'EFwgRMFiN-A',
    'variadores' => 'r6lolq0LJhE',
];
$videoId = '7SMbMxs27K0';
foreach ($videos as $clave => $id) {
    if (strpos($cName, $clave) !== false) { $videoId = $id; break; }
}

$bloques = [
    ['resumen', 'Resumen del curso', 'fas fa-bolt'],
    ['temas', 'Temas principales', 'fas fa-list-ul'],
    ['beneficios', 'Beneficios', 'fas fa-award'],
    ['programacion', 'Programación y horarios', 'fas fa-calendar-alt'],
];

ob_start(); ?>
<div class="mt-5 flex flex-wrap gap-2">
    <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-brand-dark"><i class="far fa-clock mr-1" aria-hidden="true"></i><?= (int) $lista['horas'] ?> horas académicas</span>
    <?php if (!empty($curso['fecha_prox'])): ?>
    <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-brand-dark"><i class="far fa-calendar-alt mr-1" aria-hidden="true"></i>Inicio: <?= $hd($curso['fecha_prox']) ?></span>
    <?php endif; ?>
    <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-brand-dark"><i class="fas fa-award mr-1" aria-hidden="true"></i>Certificado incluido</span>
</div>
<?php
$cab = [
    'titulo' => $nombre,
    'sub' => $curso['descripcion'] ?? '',
    'etiqueta' => 'Curso · ' . (($curso['categoria'] ?? '') !== '' ? $curso['categoria'] : 'Ingeniería'),
    'migas' => [['Inicio', ''], ['Cursos', 'cursos'], [$nombre, null]],
    'extra' => ob_get_clean(),
];
require __DIR__ . '/../partials/cabecera_pagina.php';
?>
<section class="bg-surface pb-16 pt-4" x-data="{ moneda: 'PEN' }">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 px-4 lg:grid-cols-3">

        <!-- Tarjeta de compra -->
        <aside class="lg:order-2" aria-label="Precio e inscripción">
            <div id="comprar" class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5 lg:sticky lg:top-24">
                <img src="<?= BASE_URL ?>assets/images/cursos/<?= $hd($curso['foto'] ?: 'default.png') ?>" alt="" class="aspect-video w-full bg-deep object-cover">
                <div class="p-6">
                    <?php if (false): // el nombre del docente no se muestra en la web ?>
                    <div class="flex items-center gap-3">
                        <?php if ($tieneFotoDoc): ?>
                        <img src="<?= BASE_URL ?>assets/images/docentes/<?= $hd($fotoDoc) ?>" alt="" class="h-11 w-11 rounded-full object-cover ring-2 ring-mist">
                        <?php else: ?>
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-mist text-brand"><i class="fas fa-user-tie" aria-hidden="true"></i></span>
                        <?php endif; ?>
                        <div class="text-sm">
                            <p class="text-muted">Docente</p>
                            <p class="font-bold text-deep"><?= $hd($curso['docente']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mt-5 text-center">
                        <?php require __DIR__ . '/_moneda.php'; ?>
                    </div>
                    <div class="mt-5 rounded-2xl bg-deep px-5 py-6 text-center text-white">
                        <p class="text-xs font-bold uppercase tracking-widest text-sky-100">Monto total a pagar</p>
                        <p class="mt-2 font-display text-4xl font-extrabold leading-none">
                            <span x-show="moneda === 'PEN'">S/ <?= number_format($precioPEN, 2) ?></span>
                            <span x-show="moneda === 'USD'" x-cloak>US$ <?= number_format($precioUSD, 2) ?></span>
                        </p>
                        <?php if ($regularPEN): ?><p class="mt-2 text-sm text-sky-100" x-show="moneda === 'PEN'">Precio regular: <span class="line-through">S/ <?= number_format($regularPEN, 2) ?></span></p><?php endif; ?>
                        <p class="mt-2 text-xs text-sky-100">Pago único · certificado incluido</p>
                    </div>

                    <a :href="moneda === 'PEN' ? '<?= $hd($urlCheckout) ?>&precio=<?= $precioPEN ?>&moneda=PEN' : '<?= $hd($urlCheckout) ?>&precio=<?= $precioUSD ?>&moneda=USD'"
                       href="<?= $hd($urlCheckout) ?>&precio=<?= $precioPEN ?>&moneda=PEN"
                       class="mt-5 flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3 font-display text-base font-bold text-deep shadow-md hover:brightness-95">
                        Comprar este curso <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="https://wa.link/zkj9jo" target="_blank" rel="noopener"
                       class="mt-3 flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl border border-brand px-6 py-3 font-display font-semibold text-brand hover:bg-mist">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i> Consultar por WhatsApp
                    </a>
                    <p class="mt-4 text-center text-xs text-muted">Yape · Plin · PayPal · Tarjeta de crédito o débito</p>
                </div>
            </div>
        </aside>

        <!-- Contenido -->
        <div class="space-y-6 lg:order-1 lg:col-span-2">
            <div class="reveal overflow-hidden rounded-2xl bg-deep shadow-xl ring-1 ring-black/5">
                <div class="aspect-video">
                    <iframe class="h-full w-full" src="https://www.youtube-nocookie.com/embed/<?= $hd($videoId) ?>?rel=0" title="Video de presentación: <?= $hd($nombre) ?>"
                            loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>

            <div class="reveal rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                <h2 class="flex items-center gap-3 font-display text-xl font-bold text-deep">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand text-white"><i class="fas fa-clipboard-check" aria-hidden="true"></i></span>
                    Requisitos
                </h2>
                <ul class="mt-4 space-y-2 text-ink">
                    <li class="flex gap-3"><i class="fas fa-check-circle mt-1 text-brand" aria-hidden="true"></i>No se necesita conocimiento previo.</li>
                    <li class="flex gap-3"><i class="fas fa-check-circle mt-1 text-brand" aria-hidden="true"></i>Una laptop o cualquier dispositivo con conexión a internet.</li>
                </ul>
            </div>

            <?php
            $hayBloques = false;
            foreach ($bloques as $b) { if (!empty($curso[$b[0]])) { $hayBloques = true; } }
            ?>
            <?php if ($hayBloques): ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <?php foreach ($bloques as $b): if (empty($curso[$b[0]])) continue; ?>
                <div class="reveal rounded-2xl border-t-4 border-brand bg-white p-6 shadow-sm">
                    <h2 class="flex items-center gap-3 font-display text-lg font-bold text-deep">
                        <i class="<?= $b[2] ?> text-brand" aria-hidden="true"></i> <?= $b[1] ?>
                    </h2>
                    <div class="contenido-db mt-4 text-sm leading-relaxed text-ink"><?= $curso[$b[0]] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="reveal rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-black/5">
                <p class="text-muted">Pronto publicaremos el temario completo. Escríbenos por WhatsApp y te lo enviamos.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($latest_courses)): ?>
    <div class="mx-auto mt-16 max-w-6xl px-4">
        <h2 class="reveal font-display text-2xl font-bold text-brand-dark">Otros cursos que te pueden interesar</h2>
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($latest_courses as $course) { include __DIR__ . '/_tarjeta.php'; } ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Barra fija de compra en celular -->
    <div class="fixed inset-x-0 bottom-0 z-30 border-t border-line/60 bg-white p-3 shadow-[0_-4px_16px_rgba(0,0,0,0.12)] lg:hidden">
        <div class="mx-auto flex max-w-md items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="truncate text-xs text-muted"><?= $hd($nombre) ?></p>
                <p class="font-display text-lg font-extrabold leading-tight text-brand">
                    <span x-show="moneda === 'PEN'"><?php if ($regularPEN): ?><span class="mr-1 text-sm font-semibold text-muted line-through">S/ <?= number_format($regularPEN, 2) ?></span><?php endif; ?>S/ <?= number_format($precioPEN, 2) ?></span>
                    <span x-show="moneda === 'USD'" x-cloak>US$ <?= number_format($precioUSD, 2) ?></span>
                </p>
            </div>
            <a href="#comprar" class="shrink-0 rounded-xl bg-accent px-5 py-3 font-display text-sm font-bold text-deep shadow-md">Comprar</a>
        </div>
    </div>
</section>
