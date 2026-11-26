<?php
/**
 * Cabecera azul de las paginas internas (estilo checkout v2). Usa:
 *   $cab = ['titulo' => '...', 'sub' => '...', 'etiqueta' => '...', 'migas' => [['Inicio', ''], ['Cursos', null]]];
 * Una miga con url null es la pagina actual.
 */
$hc = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
?>
<section class="relative overflow-hidden bg-brand-dark bg-cover bg-center text-white" style="background-image: url('<?= BASE_URL ?>assets/images/fondo_icc_hero.jpg');">
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-deep/60 via-deep/20 to-deep/30"></div>
    <div class="relative mx-auto max-w-6xl px-4 pb-16 pt-8 sm:pb-20 sm:pt-10">
        <?php if (!empty($cab['migas'])): ?>
        <nav aria-label="Ruta" class="text-sm text-sky-100">
            <ol class="flex flex-wrap items-center gap-1.5">
                <?php foreach ($cab['migas'] as $i => $m): ?>
                    <?php if ($i > 0): ?><li aria-hidden="true"><i class="fas fa-chevron-right text-[10px] opacity-60"></i></li><?php endif; ?>
                    <?php if ($m[1] === null): ?>
                    <li aria-current="page" class="font-semibold text-white"><?= $hc($m[0]) ?></li>
                    <?php else: ?>
                    <li><a href="<?= BASE_URL . $hc($m[1]) ?>" class="hover:text-accent hover:underline"><?= $hc($m[0]) ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </nav>
        <?php endif; ?>
        <?php if (!empty($cab['etiqueta'])): ?>
        <span class="mt-5 inline-block rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-deep"><?= $hc($cab['etiqueta']) ?></span>
        <?php endif; ?>
        <h1 class="mt-3 max-w-3xl font-display text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl"><?= $hc($cab['titulo']) ?></h1>
        <?php if (!empty($cab['sub'])): ?>
        <p class="mt-3 max-w-2xl text-base text-sky-50 sm:text-lg"><?= $hc($cab['sub']) ?></p>
        <?php endif; ?>
        <?php if (!empty($cab['extra'])) echo $cab['extra']; ?>
    </div>
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="absolute bottom-0 left-0 block h-8 w-full sm:h-12" aria-hidden="true"><path d="M0,40 C240,80 480,0 720,30 C960,60 1200,80 1440,20 L1440,80 L0,80 Z" fill="<?= $hc($cab['onda'] ?? '#f5f7fb') ?>"></path></svg>
</section>
