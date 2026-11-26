<?php
/** Nosotros (estilo checkout v2, layouts/sitio.php). */
$img = BASE_URL . 'assets/images/nosotros/';
$cab = [
    'titulo' => 'Nosotros',
    'sub' => 'ICC - Instituto de Capacitación Continua',
    'etiqueta' => 'Acerca de la compañía',
    'migas' => [['Inicio', ''], ['Nosotros', null]],
    'onda' => '#ffffff',
];
require __DIR__ . '/../partials/cabecera_pagina.php';
?>
<!-- Quienes somos -->
<section class="bg-white pb-16 pt-6">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 md:grid-cols-2">
        <div class="reveal">
            <p class="text-sm font-bold uppercase tracking-widest text-brand">Acerca de la compañía</p>
            <h2 class="mt-2 font-display text-3xl font-bold leading-tight text-brand-dark sm:text-4xl">ICC - Instituto de Capacitación Continua</h2>
            <p class="mt-4 text-lg text-muted">ICC brinda servicios de consultoría y capacitación a estudiantes, profesionales y organizaciones del sector público y privado. Nuestro equipo de profesionales está comprometido con tu futuro.</p>
            <div class="mt-8 flex items-center gap-4 rounded-2xl bg-surface p-5 ring-1 ring-line/60">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand text-xl text-white"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
                <p class="font-display text-lg font-bold text-deep">Comienza a aprender de nuestros expertos y mejora tus habilidades</p>
            </div>
            <a href="<?= BASE_URL ?>cursos" class="mt-8 inline-flex min-h-[48px] items-center gap-2 rounded-xl bg-accent px-7 py-3 font-display font-bold text-deep shadow-md hover:brightness-95">Ver cursos <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="reveal">
            <img src="<?= $img ?>icc-10-anios-700.webp" width="700" height="595" alt="ICC: 10 años brindando educación de calidad en ingeniería eléctrica"
                 class="mx-auto w-full max-w-md rounded-3xl shadow-xl ring-1 ring-black/5">
        </div>
    </div>
</section>

<!-- Mision y vision -->
<section class="bg-surface py-16">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-6 px-4 md:grid-cols-2">
        <?php foreach ([
            ['Misión', 'Brindar un servicio de calidad en capacitaciones para las empresas y personas que lo requieran.', 'mision-900.webp', 'fas fa-bullseye', 'Alumno de ICC en una clase en vivo sobre protecciones eléctricas'],
            ['Visión', 'Ser reconocidos a nivel Nacional como un centro líder en formación profesional y capacitación.', 'vision-900.webp', 'fas fa-eye', 'Profesional frente a un mapa del mundo: visión de ICC'],
        ] as $mv): ?>
        <article class="reveal overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
            <img src="<?= $img . $mv[2] ?>" width="900" height="540" loading="lazy" alt="<?= $mv[4] ?>" class="aspect-[5/3] w-full object-cover">
            <div class="p-6">
                <h2 class="flex items-center gap-3 font-display text-2xl font-bold text-deep">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand text-base text-white"><i class="<?= $mv[3] ?>" aria-hidden="true"></i></span>
                    <?= $mv[0] ?>
                </h2>
                <p class="mt-3 text-muted"><?= $mv[1] ?></p>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<!-- Valores -->
<section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-4">
        <div class="reveal text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand">ICC - Instituto de Capacitación Continua</p>
            <h2 class="mt-2 font-display text-2xl font-bold text-brand-dark sm:text-3xl">Valores</h2>
        </div>
        <div class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
            <?php foreach ([
                ['fas fa-lightbulb', 'Innovación', 'Promovemos de manera continua y sistemática las condiciones necesarias para crear y mejorar los procesos de trabajo en el Centro.'],
                ['fas fa-flag', 'Liderazgo', 'Actuamos con iniciativa y responsabilidad en el desarrollo de todas nuestras actividades y en la solución de los problemas.'],
                ['fas fa-handshake', 'Compromiso', 'Somos conscientes de la importancia que tiene cumplir con el desarrollo del trabajo dentro del tiempo estipulado para ello, ponemos al máximo nuestras capacidades para sacar adelante la tarea encomendada.'],
            ] as $v): ?>
            <div class="reveal rounded-2xl border-t-4 border-brand bg-surface p-6">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-mist text-xl text-brand"><i class="<?= $v[0] ?>" aria-hidden="true"></i></span>
                <h3 class="mt-4 font-display text-xl font-bold text-deep"><?= $v[1] ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-muted"><?= $v[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
