<?php
/**
 * Lista de todos los cursos (estilo checkout v2, layouts/sitio.php).
 * $cursos = tarjetas de CursosController::tarjeta().
 */
$cab = [
    'titulo' => 'Cursos',
    'sub' => 'Capacítate en Ingeniería Eléctrica con docentes especializados y recibe tu certificado de ICC.',
    'etiqueta' => 'Explora los cursos',
    'migas' => [['Inicio', ''], ['Cursos', null]],
];
require __DIR__ . '/../partials/cabecera_pagina.php';
?>
<section class="bg-surface pb-16 pt-4" x-data="{ moneda: 'PEN' }">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <p class="text-sm text-muted"><?= count($cursos) + count($grabados ?? []) ?> cursos especializados</p>
            <?php require __DIR__ . '/_moneda.php'; ?>
        </div>

        <?php $todos = array_merge($cursos, $grabados ?? []); ?>
        <?php if (!empty($todos)): ?>
        <h2 class="mt-8 font-display text-2xl font-extrabold text-deep">Cursos especializados</h2>
        <p class="mt-1 text-muted">En vivo por Zoom o grabados para avanzar a tu ritmo, con certificado de cada curso.</p>
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($todos as $course) { include __DIR__ . '/_tarjeta.php'; } ?>
        </div>
        <?php else: ?>
        <p class="mt-10 rounded-2xl bg-white p-8 text-center text-muted shadow-sm">No hay cursos disponibles por el momento.</p>
        <?php endif; ?>

        <div class="reveal mt-12 flex flex-col items-center justify-between gap-4 rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-black/5 sm:flex-row sm:text-left">
            <div>
                <h2 class="font-display text-lg font-bold text-deep">¿Prefieres avanzar a tu ritmo?</h2>
                <p class="mt-1 text-sm text-muted">También tenemos cursos grabados y packs con un certificado por cada curso.</p>
            </div>
            <a href="<?= BASE_URL ?>tienda" class="inline-flex min-h-[48px] shrink-0 items-center gap-2 rounded-xl bg-brand px-6 py-3 font-display font-bold text-white hover:bg-brand-dark">Ver packs grabados <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>
