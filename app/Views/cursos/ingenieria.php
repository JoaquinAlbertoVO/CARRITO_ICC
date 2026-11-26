<?php
/**
 * Cursos de Ingenieria Electrica (estilo checkout v2, layouts/sitio.php).
 * $ingenieria_courses = tarjetas de CursosController::tarjeta().
 */
$cab = [
    'titulo' => 'Cursos especializados en Ingeniería Eléctrica',
    'sub' => 'Todos los meses encontrarás nuevo contenido en la plataforma.',
    'etiqueta' => 'Ingeniería Eléctrica',
    'migas' => [['Inicio', ''], ['Cursos', 'cursos'], ['Ingeniería Eléctrica', null]],
];
require __DIR__ . '/../partials/cabecera_pagina.php';
?>
<section class="bg-surface pb-16 pt-4" x-data="{ moneda: 'PEN' }">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <p class="text-sm text-muted"><?= count($ingenieria_courses) ?> especialidades</p>
            <?php require __DIR__ . '/_moneda.php'; ?>
        </div>

        <?php if (!empty($ingenieria_courses)): ?>
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($ingenieria_courses as $course) { include __DIR__ . '/_tarjeta.php'; } ?>
        </div>
        <?php else: ?>
        <p class="mt-10 rounded-2xl bg-white p-8 text-center text-muted shadow-sm">Próximamente tendremos más cursos disponibles.</p>
        <?php endif; ?>
    </div>
</section>
