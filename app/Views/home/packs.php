<?php
/**
 * Seccion de la landing con los packs de cursos grabados publicados (admin > Packs y cursos grabados).
 * La incluye home/index.php solo si hay packs a la venta. Tailwind (assets/css/sitio.css).
 */
$hp = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$soloPacks = array_values(array_filter($packs, function ($p) { return $p['tipo'] === 'pack'; }));
$destacado = null;
foreach ($packs as $p) {
    if ($p['tipo'] === 'integral') {
        $destacado = $p;
    }
}
$tarjetas = array_slice($soloPacks ?: $packs, 0, 6);
$otros = count($packs) - count($tarjetas) - ($destacado && !in_array($destacado, $tarjetas, true) ? 1 : 0);
$iconos = ['P1' => 'fa-bolt', 'P2' => 'fa-hard-hat', 'P3' => 'fa-tools', 'P4' => 'fa-cogs', 'P5' => 'fa-leaf', 'P6' => 'fa-chart-line'];
?>
<!--Packs de cursos grabados-->
<section class="relative overflow-hidden bg-deep py-16 text-white sm:py-20" id="packs" aria-labelledby="icc-packs-titulo">
    <div class="pointer-events-none absolute -right-40 -top-52 h-[520px] w-[520px] rounded-full bg-brand/40 blur-3xl" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-6xl px-4">
        <div class="reveal text-center">
            <span class="inline-block rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep">Nuevo · Cursos grabados</span>
            <h2 class="mt-4 font-display text-3xl font-bold sm:text-4xl" id="icc-packs-titulo">Packs de especialización</h2>
            <p class="mx-auto mt-3 max-w-2xl text-lg text-sky-100">Elige un pack, entra al aula apenas se confirma tu pago y descarga el certificado de cada curso desde el primer día.</p>
            <ul class="mt-6 flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-sky-50">
                <li><i class="fas fa-play-circle mr-1.5 text-accent" aria-hidden="true"></i>Avanzas a tu ritmo</li>
                <li><i class="fas fa-award mr-1.5 text-accent" aria-hidden="true"></i>Un certificado por curso</li>
                <li><i class="fas fa-qrcode mr-1.5 text-accent" aria-hidden="true"></i>Verificable con QR</li>
                <li><i class="fas fa-percent mr-1.5 text-accent" aria-hidden="true"></i>Más barato que por separado</li>
            </ul>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($tarjetas as $p):
                $suma = \App\Models\Catalogo::sumaSueltos($p, 'precio');
                $ahorro = ($suma && $suma > (float) $p['precio']) ? (int) round(100 - $p['precio'] * 100 / $suma) : 0;
                $n = count($p['cursos']);
                $horas = \App\Models\Catalogo::horasPack($p); ?>
            <a class="reveal flex flex-col rounded-2xl bg-white p-6 text-ink shadow-xl transition hover:-translate-y-1 hover:shadow-2xl" href="<?= BASE_URL ?>tienda/pack/<?= $hp($p['slug']) ?>">
                <div class="flex items-start justify-between gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-mist text-lg text-brand"><i class="fas <?= $iconos[$p['codigo']] ?? 'fa-layer-group' ?>" aria-hidden="true"></i></span>
                    <?php if ($ahorro >= 5): ?><span class="whitespace-nowrap rounded-full bg-accent px-3 py-1 text-xs font-bold text-deep">Ahorras <?= $ahorro ?>%</span><?php endif; ?>
                </div>
                <h3 class="mt-4 font-display text-xl font-bold leading-snug text-deep"><?= $hp($p['nombre']) ?></h3>
                <p class="mt-1 text-sm text-muted"><?= $n ?> cursos · <?= $n ?> certificados<?= $horas ? ' · ' . $horas . ' h' : '' ?></p>
                <ul class="mb-5 mt-4 space-y-1.5 text-sm">
                    <?php foreach (array_slice($p['cursos'], 0, 4) as $c): ?>
                        <li class="flex gap-2"><i class="fas fa-check mt-1 text-xs text-brand" aria-hidden="true"></i><span><?= $hp($c['nombre_curso']) ?></span></li>
                    <?php endforeach; ?>
                    <?php if ($n > 4): ?><li class="flex gap-2"><i class="fas fa-plus mt-1 text-xs text-brand" aria-hidden="true"></i><span><?= $n - 4 ?> cursos más</span></li><?php endif; ?>
                </ul>
                <div class="mt-auto flex items-end justify-between gap-3 border-t border-mist pt-4">
                    <div>
                        <?php if ($ahorro >= 5): ?><span class="block text-sm text-muted line-through">S/ <?= number_format($suma, 2) ?></span><?php endif; ?>
                        <span class="block font-display text-3xl font-extrabold leading-none text-brand">S/ <?= number_format((float) $p['precio'], 2) ?></span>
                        <span class="mt-1 block text-xs text-muted">o US$ <?= number_format((float) $p['precio_usd'], 2) ?></span>
                    </div>
                    <span class="whitespace-nowrap text-sm font-bold text-brand">Ver pack <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                </div>
            </a>
            <?php endforeach; ?>

            <?php if ($destacado && !in_array($destacado, $tarjetas, true)):
                $suma = \App\Models\Catalogo::sumaSueltos($destacado, 'precio'); ?>
            <a class="reveal flex flex-col gap-6 rounded-2xl bg-gradient-to-r from-brand-dark to-brand p-6 text-white shadow-xl transition hover:-translate-y-1 sm:col-span-2 md:flex-row md:items-center lg:col-span-3" href="<?= BASE_URL ?>tienda/pack/<?= $hp($destacado['slug']) ?>">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent text-lg text-deep"><i class="fas fa-crown" aria-hidden="true"></i></span>
                <div class="min-w-0 flex-1">
                    <h3 class="font-display text-2xl font-bold"><?= $hp($destacado['nombre']) ?></h3>
                    <p class="mt-1 text-sky-100">Todos los cursos grabados (<?= count($destacado['cursos']) ?>) en un solo pago, con un certificado por cada curso.</p>
                </div>
                <div>
                    <?php if ($suma && $suma > (float) $destacado['precio']): ?><span class="block text-sm text-sky-100 line-through">S/ <?= number_format($suma, 2) ?></span><?php endif; ?>
                    <span class="block font-display text-3xl font-extrabold leading-none text-accent">S/ <?= number_format((float) $destacado['precio'], 2) ?></span>
                    <span class="mt-1 block text-xs text-sky-100">o US$ <?= number_format((float) $destacado['precio_usd'], 2) ?></span>
                </div>
                <span class="whitespace-nowrap rounded-xl bg-accent px-5 py-3 text-center font-display font-bold text-deep">Lo quiero todo <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
            </a>
            <?php endif; ?>
        </div>

        <div class="mt-10 text-center">
            <a href="<?= BASE_URL ?>tienda" class="inline-flex min-h-[48px] items-center gap-2 rounded-xl bg-accent px-7 py-3 font-display text-base font-bold text-deep shadow-lg hover:brightness-95">Ver todos los packs y cursos <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <p class="mt-3 text-sm text-sky-100">También puedes comprar cada curso por separado<?= $otros > 0 ? ' y ver las rutas de carrera' : '' ?>.</p>
        </div>
    </div>
</section>
<!--Fin packs de cursos grabados-->
