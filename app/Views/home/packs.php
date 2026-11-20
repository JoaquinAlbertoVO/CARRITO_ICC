<?php
/**
 * Seccion de la landing con los packs de cursos grabados publicados (admin > Packs y cursos grabados).
 * La incluye home/index.php solo si hay packs a la venta. Estilos propios con prefijo .icc-packs
 * (la landing usa el tema zilom + modern_override, no Tailwind).
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
<style>
.icc-packs { background: #061660; color: #fff; padding: 90px 0; position: relative; overflow: hidden; }
.icc-packs::before { content: ""; position: absolute; width: 520px; height: 520px; right: -160px; top: -200px; border-radius: 50%; background: rgba(0, 80, 244, .45); filter: blur(90px); }
.icc-packs .container { position: relative; }
.icc-packs__tag { display: inline-block; background: #cddd32; color: #061660; font-weight: 700; font-size: 13px; letter-spacing: .08em; text-transform: uppercase; padding: 6px 14px; border-radius: 999px; }
.icc-packs h2.icc-packs__title { font-family: 'League Spartan', sans-serif !important; color: #fff; font-size: clamp(30px, 4vw, 46px); line-height: 1.1; margin: 18px 0 12px; }
.icc-packs__sub { color: #c7d6ff; font-size: 18px; line-height: 1.6; max-width: 640px; margin: 0 auto; }
.icc-packs__beneficios { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px 26px; margin: 22px 0 46px; padding: 0; list-style: none; color: #e6edff; font-size: 15px; }
.icc-packs__beneficios i { color: #cddd32; margin-right: 6px; }
.icc-packs__grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
@media (max-width: 991px) { .icc-packs__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .icc-packs { padding: 64px 0; } .icc-packs__grid { grid-template-columns: 1fr; } }
.icc-pack, .icc-pack h3, .icc-pack p, .icc-pack span { text-align: left; }
.icc-pack { display: flex; flex-direction: column; background: #fff; color: #0a1640; border-radius: 20px; padding: 26px; text-decoration: none !important; transition: transform .2s ease, box-shadow .2s ease; box-shadow: 0 10px 30px rgba(0, 0, 0, .18); }
.icc-pack:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(0, 0, 0, .28); color: #0a1640; }
.icc-pack__top { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; }
.icc-pack__icono { width: 46px; height: 46px; border-radius: 14px; background: #e8eefb; color: #0050f4; display: flex; align-items: center; justify-content: center; font-size: 19px; }
.icc-pack__ahorro { background: #cddd32; color: #061660; font-weight: 700; font-size: 12px; padding: 5px 11px; border-radius: 999px; white-space: nowrap; }
.icc-pack h3 { font-family: 'League Spartan', sans-serif !important; font-size: 22px; line-height: 1.2; color: #061660; margin: 18px 0 6px; }
.icc-pack__meta { color: #4b5573; font-size: 14px; margin: 0 0 14px; }
.icc-pack ul { list-style: none; padding: 0; margin: 0 0 18px; }
.icc-pack li { display: flex; gap: 8px; font-size: 15px; line-height: 1.45; padding: 3px 0; color: #0a1640; }
.icc-pack li i { color: #0050f4; font-size: 12px; margin-top: 5px; }
.icc-pack__pie { margin-top: auto; display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; border-top: 1px solid #e8eefb; padding-top: 16px; }
.icc-pack__antes { display: block; color: #4b5573; font-size: 14px; text-decoration: line-through; }
.icc-pack__precio { font-family: 'League Spartan', sans-serif !important; font-size: 30px; font-weight: 800; color: #0050f4; line-height: 1; }
.icc-pack__usd { display: block; color: #4b5573; font-size: 13px; margin-top: 4px; }
.icc-pack__ver { font-weight: 700; color: #0050f4; font-size: 15px; white-space: nowrap; }
.icc-pack--integral { grid-column: 1 / -1; background: linear-gradient(120deg, #0049b7, #0050f4); color: #fff; flex-direction: row; align-items: center; gap: 28px; flex-wrap: wrap; }
.icc-pack--integral:hover { color: #fff; }
.icc-pack--integral h3 { color: #fff; margin-top: 0; font-size: 28px; }
.icc-pack--integral .icc-pack__meta { color: #dbe6ff; margin: 0; }
.icc-pack--integral .icc-pack__precio { color: #cddd32; }
.icc-pack--integral .icc-pack__antes, .icc-pack--integral .icc-pack__usd { color: #c7d6ff; }
.icc-pack--integral .icc-pack__btn { background: #cddd32; color: #061660; font-weight: 700; padding: 14px 22px; border-radius: 12px; white-space: nowrap; }
.icc-packs__cta { text-align: center; margin-top: 44px; }
.icc-packs__cta a { display: inline-flex; align-items: center; gap: 10px; background: #cddd32; color: #061660 !important; font-weight: 700; font-size: 17px; padding: 16px 30px; border-radius: 14px; text-decoration: none; box-shadow: 0 10px 24px rgba(205, 221, 50, .25); }
.icc-packs__cta a:hover { filter: brightness(.95); }
.icc-packs__cta p { color: #c7d6ff; font-size: 14px; margin-top: 12px; }
</style>

<!--Packs de cursos grabados-->
<section class="icc-packs" id="packs" aria-labelledby="icc-packs-titulo">
    <div class="container">
        <div class="text-center">
            <span class="icc-packs__tag">Nuevo · Cursos grabados</span>
            <h2 class="icc-packs__title" id="icc-packs-titulo">Packs de especialización</h2>
            <p class="icc-packs__sub">Elige un pack, entra al aula apenas se confirma tu pago y descarga el certificado de cada curso desde el primer día.</p>
            <ul class="icc-packs__beneficios">
                <li><i class="fas fa-play-circle" aria-hidden="true"></i>Avanzas a tu ritmo</li>
                <li><i class="fas fa-award" aria-hidden="true"></i>Un certificado por curso</li>
                <li><i class="fas fa-qrcode" aria-hidden="true"></i>Verificable con QR</li>
                <li><i class="fas fa-percent" aria-hidden="true"></i>Más barato que por separado</li>
            </ul>
        </div>

        <div class="icc-packs__grid">
            <?php foreach ($tarjetas as $p):
                $suma = \App\Models\Catalogo::sumaSueltos($p, 'precio');
                $ahorro = ($suma && $suma > (float) $p['precio']) ? (int) round(100 - $p['precio'] * 100 / $suma) : 0;
                $n = count($p['cursos']); ?>
            <a class="icc-pack" href="<?= BASE_URL ?>tienda/pack/<?= $hp($p['slug']) ?>">
                <div class="icc-pack__top">
                    <span class="icc-pack__icono"><i class="fas <?= $iconos[$p['codigo']] ?? 'fa-layer-group' ?>" aria-hidden="true"></i></span>
                    <?php if ($ahorro >= 5): ?><span class="icc-pack__ahorro">Ahorras <?= $ahorro ?>%</span><?php endif; ?>
                </div>
                <h3><?= $hp($p['nombre']) ?></h3>
                <p class="icc-pack__meta"><?= $n ?> cursos · <?= $n ?> certificados<?= \App\Models\Catalogo::horasPack($p) ? ' · ' . \App\Models\Catalogo::horasPack($p) . ' h' : '' ?></p>
                <ul>
                    <?php foreach (array_slice($p['cursos'], 0, 4) as $c): ?>
                        <li><i class="fas fa-check" aria-hidden="true"></i><span><?= $hp($c['nombre_curso']) ?></span></li>
                    <?php endforeach; ?>
                    <?php if ($n > 4): ?><li><i class="fas fa-plus" aria-hidden="true"></i><span><?= $n - 4 ?> cursos más</span></li><?php endif; ?>
                </ul>
                <div class="icc-pack__pie">
                    <div>
                        <?php if ($ahorro >= 5): ?><span class="icc-pack__antes">S/ <?= number_format($suma, 2) ?></span><?php endif; ?>
                        <span class="icc-pack__precio">S/ <?= number_format((float) $p['precio'], 2) ?></span>
                        <span class="icc-pack__usd">o US$ <?= number_format((float) $p['precio_usd'], 2) ?></span>
                    </div>
                    <span class="icc-pack__ver">Ver pack <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                </div>
            </a>
            <?php endforeach; ?>

            <?php if ($destacado && !in_array($destacado, $tarjetas, true)):
                $suma = \App\Models\Catalogo::sumaSueltos($destacado, 'precio'); ?>
            <a class="icc-pack icc-pack--integral" href="<?= BASE_URL ?>tienda/pack/<?= $hp($destacado['slug']) ?>">
                <span class="icc-pack__icono" style="background:#cddd32;color:#061660;"><i class="fas fa-crown" aria-hidden="true"></i></span>
                <div style="flex:1;min-width:220px;">
                    <h3><?= $hp($destacado['nombre']) ?></h3>
                    <p class="icc-pack__meta">Todos los cursos grabados (<?= count($destacado['cursos']) ?>) en un solo pago, con un certificado por cada curso.</p>
                </div>
                <div>
                    <?php if ($suma && $suma > (float) $destacado['precio']): ?><span class="icc-pack__antes">S/ <?= number_format($suma, 2) ?></span><?php endif; ?>
                    <span class="icc-pack__precio">S/ <?= number_format((float) $destacado['precio'], 2) ?></span>
                    <span class="icc-pack__usd">o US$ <?= number_format((float) $destacado['precio_usd'], 2) ?></span>
                </div>
                <span class="icc-pack__btn">Lo quiero todo <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
            </a>
            <?php endif; ?>
        </div>

        <div class="icc-packs__cta">
            <a href="<?= BASE_URL ?>tienda">Ver todos los packs y cursos <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            <p>También puedes comprar cada curso por separado<?= $otros > 0 ? ' y ver las rutas de carrera' : '' ?>.</p>
        </div>
    </div>
</section>
<!--Fin packs de cursos grabados-->
