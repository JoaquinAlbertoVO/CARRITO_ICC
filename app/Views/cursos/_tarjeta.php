<?php
/**
 * Tarjeta de un curso (lista de cursos, ingenieria y "otros cursos" del detalle).
 * Espera $course = CursosController::tarjeta() y un x-data con "moneda" ('PEN' | 'USD') en un contenedor.
 */
$ht = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$fotoDoc = $course['docente_foto'] ?? '';
$tieneFotoDoc = $fotoDoc !== '' && $fotoDoc !== '50x50' && is_file('assets/images/docentes/' . $fotoDoc);
?>
<article class="reveal group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-lg">
    <div class="aspect-video overflow-hidden bg-deep">
        <img src="<?= BASE_URL . $ht($course['image']) ?>" alt="" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
    </div>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center justify-between gap-2">
            <span class="rounded-full bg-accent px-3 py-0.5 text-xs font-bold uppercase tracking-wide text-deep">Curso</span>
            <span class="flex items-center gap-1.5 text-xs font-semibold text-muted"><i class="fas fa-award text-brand" aria-hidden="true"></i> Certificado incluido</span>
        </div>
        <h3 class="mt-3 font-display text-lg font-bold leading-snug text-deep">
            <a href="<?= BASE_URL ?>cursos/detalle/<?= $ht($course['link']) ?>" class="after:absolute after:inset-0 focus:outline-none"><?= $ht($course['title']) ?></a>
        </h3>
        <?php if (!empty($course['docente'])): ?>
        <p class="mt-2 flex items-center gap-2 text-sm text-muted">
            <?php if ($tieneFotoDoc): ?>
            <img src="<?= BASE_URL ?>assets/images/docentes/<?= $ht($fotoDoc) ?>" alt="" loading="lazy" class="h-7 w-7 rounded-full object-cover">
            <?php else: ?>
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-mist text-xs text-brand"><i class="fas fa-user-tie" aria-hidden="true"></i></span>
            <?php endif; ?>
            <?= $ht($course['docente']) ?>
        </p>
        <?php endif; ?>
        <div class="mt-auto flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-mist pt-4 text-sm text-muted">
            <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt text-brand" aria-hidden="true"></i><?= $ht($course['date']) ?></span>
            <span class="flex items-center gap-1.5"><i class="far fa-clock text-brand" aria-hidden="true"></i><?= $ht($course['hours']) ?></span>
            <span class="ml-auto font-display text-lg font-extrabold text-brand">
                <span x-show="moneda === 'PEN'">S/ <?= $ht($course['price']) ?></span>
                <span x-show="moneda === 'USD'" x-cloak>US$ <?= $ht($course['price_usd']) ?></span>
            </span>
        </div>
    </div>
</article>
