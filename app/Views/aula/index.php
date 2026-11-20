<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$nombre = trim((string) ($alumno['nombre'] ?? ''));
$primer = $nombre !== '' ? mb_convert_case(explode(' ', $nombre)[0], MB_CASE_TITLE, 'UTF-8') : '';
$datosOk = !empty($alumno['datos_cert_ok']);
$totalVistos = array_sum(array_column($cursos, 'vistos'));
$listos = count($certificadosAuto) + count($certificadosSubidos);
$urlCert = function ($idCurso) use ($datosOk) {
    return BASE_URL . ($datosOk ? 'aula/certificado/' . (int) $idCurso : 'aula/mis_datos?certificado=' . (int) $idCurso);
};
?>
<!-- Saludo y resumen -->
<section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-deep via-deep to-brand-dark p-6 text-white shadow-xl sm:p-8">
    <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-brand/40 blur-3xl"></div>
    <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold text-accent">Aula virtual ICC</p>
            <h1 class="mt-1 font-display text-3xl font-extrabold sm:text-4xl">Hola<?= $primer ? ', ' . $h($primer) : '' ?> 👋</h1>
            <p class="mt-2 max-w-xl text-sky-100"><?= $continuar ? 'Sigue donde te quedaste.' : ($cursos ? 'Elige un curso para empezar.' : 'Aquí verás tus cursos apenas se active tu matrícula.') ?></p>
            <?php if ($continuar): ?>
            <a href="<?= BASE_URL ?>aula/curso/<?= (int) $continuar['id_curso'] ?>" class="mt-5 inline-flex min-h-[48px] items-center gap-3 rounded-xl bg-accent px-5 font-bold text-deep shadow-lg hover:brightness-95">
                <i class="fas fa-play" aria-hidden="true"></i> Continuar: <span class="max-w-[14rem] truncate sm:max-w-xs"><?= $h($continuar['nombre_curso']) ?></span>
            </a>
            <?php endif; ?>
        </div>
        <dl class="grid grid-cols-3 gap-3 text-center sm:gap-4">
            <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur"><dt class="text-xs text-sky-100">Cursos</dt><dd class="font-display text-2xl font-extrabold"><?= count($cursos) ?></dd></div>
            <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur"><dt class="text-xs text-sky-100">Clases vistas</dt><dd class="font-display text-2xl font-extrabold"><?= (int) $totalVistos ?></dd></div>
            <div class="rounded-2xl bg-white/10 px-4 py-3 backdrop-blur"><dt class="text-xs text-sky-100">Certificados</dt><dd class="font-display text-2xl font-extrabold text-accent"><?= (int) $listos ?></dd></div>
        </dl>
    </div>
</section>

<?php if ($certificadosAuto && !$datosOk): ?>
<a href="<?= BASE_URL ?>aula/mis_datos" class="mt-6 flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-2 ring-accent hover:shadow-md sm:p-5">
    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent text-xl text-deep"><i class="fas fa-award"></i></span>
    <span class="flex-1">
        <span class="block font-display font-bold text-deep">Tus certificados ya están listos</span>
        <span class="block text-sm text-muted">Confirma cómo debe salir tu nombre y descárgalos.</span>
    </span>
    <i class="fas fa-chevron-right text-brand" aria-hidden="true"></i>
</a>
<?php endif; ?>

<!-- Cursos -->
<section class="mt-10" aria-labelledby="t-cursos">
    <div class="flex items-end justify-between gap-4">
        <h2 id="t-cursos" class="font-display text-2xl font-extrabold text-deep">Mis cursos</h2>
        <a href="<?= BASE_URL ?>tienda" class="text-sm font-bold text-brand hover:underline">Ver más cursos <i class="fas fa-arrow-right text-xs"></i></a>
    </div>

    <?php if (!$cursos): ?>
        <div class="mt-6 rounded-2xl bg-white p-10 text-center shadow-sm ring-1 ring-line">
            <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mist text-2xl text-brand"><i class="fas fa-graduation-cap"></i></span>
            <p class="mt-4 font-display text-xl font-bold text-deep">Todavía no tienes cursos activos</p>
            <p class="mx-auto mt-2 max-w-md text-muted">Si ya pagaste con Yape o Plin, lo activamos apenas verifiquemos tu pago. ¿Dudas? Escríbenos.</p>
            <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="<?= BASE_URL ?>tienda" class="inline-flex min-h-[44px] items-center justify-center rounded-xl bg-brand px-5 font-bold text-white hover:bg-brand-dark">Ver cursos y packs</a>
                <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl border border-line px-5 font-bold text-ink hover:bg-surface"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>
    <?php else: ?>
    <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($cursos as $c): $grabado = $c['modalidad'] === 'asincrono'; ?>
        <article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-line transition hover:-translate-y-0.5 hover:shadow-lg">
            <a href="<?= BASE_URL ?>aula/curso/<?= (int) $c['id_curso'] ?>" class="relative block aspect-video overflow-hidden bg-deep">
                <?php if ($c['miniatura']): ?>
                    <img src="<?= $h($c['miniatura']) ?>" alt="" loading="lazy" class="h-full w-full object-cover opacity-90 transition group-hover:scale-105 group-hover:opacity-100">
                <?php else: ?>
                    <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-deep to-brand-dark"><i class="fas fa-bolt text-4xl text-accent"></i></span>
                <?php endif; ?>
                <span class="absolute inset-0 bg-gradient-to-t from-deep/80 via-transparent"></span>
                <span class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-xs font-bold <?= $grabado ? 'bg-accent text-deep' : 'bg-white text-brand-dark' ?>"><?= $grabado ? 'Grabado' : 'En vivo' ?></span>
                <span class="absolute bottom-3 right-3 flex h-11 w-11 items-center justify-center rounded-full bg-white/95 text-brand shadow-lg transition group-hover:scale-110"><i class="fas fa-play ml-0.5"></i></span>
            </a>
            <div class="flex flex-1 flex-col p-5">
                <h3 class="font-display text-lg font-bold leading-snug text-deep"><a href="<?= BASE_URL ?>aula/curso/<?= (int) $c['id_curso'] ?>" class="hover:text-brand"><?= $h($c['nombre_curso']) ?></a></h3>
                <p class="mt-1 text-xs text-muted"><?= (int) $c['total'] ?> clases<?= (int) $c['horas_academicas'] > 0 ? ' · ' . (int) $c['horas_academicas'] . ' horas' : '' ?></p>
                <div class="mt-4">
                    <div class="flex justify-between text-xs font-semibold"><span class="text-muted"><?= (int) $c['vistos'] ?> de <?= (int) $c['total'] ?> vistas</span><span class="text-brand"><?= (int) $c['progreso'] ?>%</span></div>
                    <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-mist" role="progressbar" aria-valuenow="<?= (int) $c['progreso'] ?>" aria-valuemin="0" aria-valuemax="100" aria-label="Avance del curso">
                        <div class="h-full rounded-full <?= $c['progreso'] >= 100 ? 'bg-emerald-500' : 'bg-brand' ?>" style="width: <?= (int) $c['progreso'] ?>%"></div>
                    </div>
                </div>
                <div class="mt-auto flex gap-2 pt-5">
                    <a href="<?= BASE_URL ?>aula/curso/<?= (int) $c['id_curso'] ?>" class="inline-flex min-h-[42px] flex-1 items-center justify-center rounded-xl bg-brand text-sm font-bold text-white hover:bg-brand-dark"><?= $c['vistos'] ? ($c['progreso'] >= 100 ? 'Repasar' : 'Continuar') : 'Empezar' ?></a>
                    <?php if ($c['certificado']): ?>
                    <a href="<?= $urlCert($c['id_curso']) ?>" class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl border border-line px-3 text-sm font-bold text-deep hover:border-brand hover:text-brand" title="Descargar certificado"><i class="fas fa-award text-brand"></i><span class="sr-only sm:not-sr-only">Certificado</span></a>
                    <?php endif; ?>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Certificados -->
<section id="certificados" class="mt-12 scroll-mt-24" aria-labelledby="t-cert">
    <h2 id="t-cert" class="font-display text-2xl font-extrabold text-deep">Mis certificados</h2>
    <p class="mt-1 text-sm text-muted">Cada certificado lleva un código y un QR que se puede comprobar en <a href="<?= BASE_URL ?>verificar" class="font-semibold text-brand hover:underline">icc.com.pe/verificar</a>.</p>

    <?php if (!$certificadosAuto && !$certificadosSubidos && !$certificadosRegistrados): ?>
        <p class="mt-6 rounded-2xl bg-white p-6 text-center text-muted ring-1 ring-line">Aún no tienes certificados. En los cursos en vivo aparecen aquí cuando el equipo los emite.</p>
    <?php else: ?>
    <ul class="mt-6 grid gap-4 md:grid-cols-2">
        <?php foreach ($certificadosAuto as $c): $preparando = (int) $c['horas_academicas'] <= 0; ?>
        <li class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-line">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-mist text-xl text-brand"><i class="fas fa-award"></i></span>
            <div class="min-w-0 flex-1">
                <p class="truncate font-semibold text-deep"><?= $h($c['nombre_curso']) ?></p>
                <p class="text-xs text-muted"><code class="text-[11px]"><?= $h($c['codigo']) ?></code><?= $preparando ? '' : ' · ' . (int) $c['horas_academicas'] . ' horas' ?></p>
            </div>
            <?php if ($preparando): ?>
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-800">En preparación</span>
            <?php else: ?>
                <a href="<?= $urlCert($c['id_curso']) ?>" class="inline-flex min-h-[40px] shrink-0 items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep hover:brightness-95"><i class="fas fa-download"></i><span class="hidden sm:inline">Descargar</span></a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <?php foreach ($certificadosRegistrados as $c): ?>
        <li class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-line">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-mist text-xl text-brand"><i class="fas fa-certificate"></i></span>
            <div class="min-w-0 flex-1">
                <p class="truncate font-semibold text-deep"><?= $h($c['curso']) ?></p>
                <p class="text-xs text-muted"><code class="text-[11px]"><?= $h($c['codigo']) ?></code><?= $c['fecha_emision'] ? ' · ' . $h($c['fecha_emision']) : '' ?></p>
            </div>
            <a href="<?= $c['pdf'] ? $h($c['pdf']) : BASE_URL . 'verificar/' . rawurlencode($c['codigo']) ?>" target="_blank" rel="noopener" class="inline-flex min-h-[40px] shrink-0 items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep hover:brightness-95"><i class="fas <?= $c['pdf'] ? 'fa-download' : 'fa-eye' ?>"></i><span class="hidden sm:inline"><?= $c['pdf'] ? 'Descargar' : 'Ver' ?></span></a>
        </li>
        <?php endforeach; ?>
        <?php foreach ($certificadosSubidos as $c): ?>
        <li class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-line">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-mist text-xl text-brand"><i class="fas fa-certificate"></i></span>
            <div class="min-w-0 flex-1">
                <p class="truncate font-semibold text-deep"><?= $h($c['nombre_curso']) ?></p>
                <p class="text-xs text-muted">Curso en vivo<?= !empty($c['fecha_subida']) ? ' · ' . $h(date('d/m/Y', strtotime($c['fecha_subida']))) : '' ?></p>
            </div>
            <a href="<?= BASE_URL ?>assets/certificados/<?= implode('/', array_map('rawurlencode', explode('/', (string) $c['archivo_pdf']))) ?>" target="_blank" rel="noopener" class="inline-flex min-h-[40px] shrink-0 items-center gap-2 rounded-xl bg-accent px-4 text-sm font-bold text-deep hover:brightness-95"><i class="fas fa-download"></i><span class="hidden sm:inline">Descargar</span></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</section>
