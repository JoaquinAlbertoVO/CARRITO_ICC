<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$usd = $pago['moneda'] === 'USD';
$precio = function ($item) use ($usd) {
    $v = (float) ($usd ? $item['precio_usd'] : $item['precio']);
    return $v > 0 ? ($usd ? 'US$ ' : 'S/ ') . number_format($v, 2) : 'Precio por definir';
};
$iconoPack = ['P1' => 'fa-bolt', 'P2' => 'fa-hard-hat', 'P3' => 'fa-tools', 'P4' => 'fa-cogs', 'P5' => 'fa-leaf', 'P6' => 'fa-chart-line', 'PI' => 'fa-crown', 'R1' => 'fa-route', 'R2' => 'fa-route'];
$grupos = [
    'pack' => ['titulo' => 'Packs por especialidad', 'sub' => 'Varios cursos de un mismo tema, con un certificado por cada curso.'],
    'ruta' => ['titulo' => 'Rutas de carrera', 'sub' => 'Combinan packs pensando en un puesto de trabajo.'],
    'integral' => ['titulo' => 'Todo el catálogo', 'sub' => 'Todos los cursos grabados en un solo pago, al mejor precio.'],
];
?>
<section class="relative overflow-hidden bg-brand-dark bg-cover bg-center text-white" style="background-image:url('<?= BASE_URL ?>assets/images/fondo_icc_hero.jpg')">
    <div class="absolute inset-0 bg-gradient-to-r from-deep/90 via-deep/70 to-transparent"></div>
    <div class="relative mx-auto max-w-6xl px-4 py-14 sm:py-20">
        <span class="inline-block rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep">Cursos grabados</span>
        <h1 class="mt-4 max-w-2xl font-display text-3xl font-extrabold leading-tight sm:text-5xl">Aprende electricidad industrial a tu ritmo</h1>
        <p class="mt-4 max-w-xl text-base text-sky-50 sm:text-lg">Compra un curso o un pack completo. Entras al aula apenas se confirma tu pago y <strong class="text-accent">tu certificado de cada curso ya está listo para descargar.</strong></p>
        <ul class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-sm text-sky-50">
            <li><i class="fas fa-play-circle mr-1 text-accent" aria-hidden="true"></i> Clases grabadas</li>
            <li><i class="fas fa-folder-open mr-1 text-accent" aria-hidden="true"></i> Material en PDF</li>
            <li><i class="fas fa-award mr-1 text-accent" aria-hidden="true"></i> Certificado con QR verificable</li>
        </ul>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4">
    <?php if ($vistaPrevia): ?>
        <p class="mt-6 rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900"><i class="fas fa-eye mr-1"></i> <strong>Vista previa del admin:</strong> nada está publicado todavía. Los visitantes ven esta página vacía hasta que pongas precios y publiques en admin &gt; Packs y cursos grabados.</p>
    <?php endif; ?>

    <?php foreach ($grupos as $tipo => $g):
        $lista = array_values(array_filter($packs, function ($p) use ($tipo) { return $p['tipo'] === $tipo; }));
        if (!$lista) continue; ?>
    <section class="mt-12">
        <h2 class="font-display text-2xl font-extrabold text-deep"><?= $h($g['titulo']) ?></h2>
        <p class="mt-1 text-muted"><?= $h($g['sub']) ?></p>
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($lista as $p):
                $horas = \App\Models\Catalogo::horasPack($p);
                $suma = \App\Models\Catalogo::sumaSueltos($p, $usd ? 'precio_usd' : 'precio');
                $propio = (float) ($usd ? $p['precio_usd'] : $p['precio']);
                $ahorro = ($suma && $propio > 0 && $suma > $propio) ? round(100 - $propio * 100 / $suma) : 0; ?>
            <a href="<?= BASE_URL ?>tienda/pack/<?= $h($p['slug']) ?>" class="group flex flex-col rounded-2xl bg-white p-6 shadow-sm ring-1 ring-line transition hover:-translate-y-0.5 hover:shadow-lg hover:ring-brand <?= $tipo === 'integral' ? 'lg:col-span-3 sm:col-span-2 bg-gradient-to-br from-deep to-brand-dark text-white ring-0' : '' ?>">
                <div class="flex items-start justify-between gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl <?= $tipo === 'integral' ? 'bg-accent text-deep' : 'bg-mist text-brand' ?>"><i class="fas <?= $iconoPack[$p['codigo']] ?? 'fa-layer-group' ?>" aria-hidden="true"></i></span>
                    <?php if ($ahorro >= 5): ?><span class="rounded-full bg-accent px-3 py-1 text-xs font-bold text-deep">Ahorras <?= (int) $ahorro ?>%</span><?php endif; ?>
                </div>
                <h3 class="mt-4 font-display text-lg font-bold <?= $tipo === 'integral' ? 'text-white text-2xl' : 'text-deep' ?>"><?= $h($p['nombre']) ?></h3>
                <?php if ($p['publico']): ?><p class="mt-1 text-sm <?= $tipo === 'integral' ? 'text-sky-100' : 'text-muted' ?>"><?= $h($p['publico']) ?></p><?php endif; ?>
                <ul class="mt-4 space-y-1 text-sm <?= $tipo === 'integral' ? 'text-sky-50 sm:columns-2 lg:columns-3' : 'text-ink' ?>">
                    <?php foreach ($p['cursos'] as $c): ?>
                        <li class="flex gap-2"><i class="fas fa-check mt-1 text-xs <?= $tipo === 'integral' ? 'text-accent' : 'text-brand' ?>" aria-hidden="true"></i><span><?= $h($c['nombre_curso']) ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <div class="mt-auto pt-5">
                    <p class="text-xs <?= $tipo === 'integral' ? 'text-sky-100' : 'text-muted' ?>"><?= count($p['cursos']) ?> cursos · <?= count($p['cursos']) ?> certificados<?= $horas ? ' · ' . $horas . ' h' : '' ?></p>
                    <div class="mt-2 flex items-end justify-between gap-3">
                        <p>
                            <?php if ($ahorro >= 5): ?><span class="block text-sm line-through <?= $tipo === 'integral' ? 'text-sky-200' : 'text-muted' ?>"><?= ($usd ? 'US$ ' : 'S/ ') . number_format($suma, 2) ?></span><?php endif; ?>
                            <span class="font-display text-2xl font-extrabold <?= $tipo === 'integral' ? 'text-accent' : 'text-brand' ?>"><?= $precio($p) ?></span>
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-bold <?= $tipo === 'integral' ? 'text-white' : 'text-brand' ?>">Ver pack <i class="fas fa-arrow-right transition group-hover:translate-x-1" aria-hidden="true"></i></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endforeach; ?>

    <?php if ($cursos): ?>
    <section class="mt-14">
        <h2 class="font-display text-2xl font-extrabold text-deep">Cursos sueltos</h2>
        <p class="mt-1 text-muted">¿Solo necesitas un tema? Compra el curso por separado.</p>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($cursos as $c): ?>
            <a href="<?= BASE_URL ?>tienda/curso/<?= $h($c['slug']) ?>" class="group flex items-center justify-between gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-line transition hover:ring-brand">
                <div class="min-w-0">
                    <h3 class="font-semibold text-deep group-hover:text-brand"><?= $h($c['nombre_curso']) ?></h3>
                    <p class="mt-1 text-xs text-muted"><?= (int) $c['total_clases'] ?> clases<?= (int) $c['horas_academicas'] > 0 ? ' · ' . (int) $c['horas_academicas'] . ' h' : '' ?><?= (int) $c['total_materiales'] > 0 ? ' · material PDF' : '' ?></p>
                </div>
                <span class="shrink-0 font-display text-lg font-extrabold text-brand"><?= $precio($c) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!$packs && !$cursos): ?>
        <div class="mt-12 rounded-2xl bg-white p-10 text-center shadow-sm ring-1 ring-line">
            <p class="font-display text-xl font-bold text-deep">Muy pronto</p>
            <p class="mt-2 text-muted">Estamos preparando los packs. Escríbenos y te avisamos.</p>
            <a href="https://wa.me/51941208020" class="mt-5 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-brand px-5 font-bold text-white" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> Escribir por WhatsApp</a>
        </div>
    <?php endif; ?>

    <section class="mt-16 grid gap-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-line sm:grid-cols-3 sm:p-8">
        <div><p class="font-display text-lg font-bold text-deep"><span class="mr-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand text-sm text-white">1</span>Elige y paga</p><p class="mt-2 text-sm text-muted">Con tarjeta o PayPal el acceso es inmediato. Con Yape o Plin lo activamos apenas verificamos tu pago.</p></div>
        <div><p class="font-display text-lg font-bold text-deep"><span class="mr-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand text-sm text-white">2</span>Entra al aula</p><p class="mt-2 text-sm text-muted">Te llegan tus accesos por correo. Ves las clases cuando quieras y descargas el material.</p></div>
        <div><p class="font-display text-lg font-bold text-deep"><span class="mr-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand text-sm text-white">3</span>Descarga tu certificado</p><p class="mt-2 text-sm text-muted">Uno por cada curso, con código y QR que cualquiera puede verificar en icc.com.pe/verificar.</p></div>
    </section>
</div>
