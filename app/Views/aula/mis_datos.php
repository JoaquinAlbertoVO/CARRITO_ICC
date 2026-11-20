<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$nombre = (string) ($alumno['nombre'] ?? '');
?>
<div class="mx-auto max-w-xl" x-data="{ nombre: <?= $h(json_encode($nombre, JSON_UNESCAPED_UNICODE)) ?> }">
    <a href="<?= BASE_URL ?>aula" class="text-sm font-semibold text-brand hover:underline"><i class="fas fa-arrow-left mr-1 text-xs"></i> Mis cursos</a>
    <div class="mt-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-line sm:p-8">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent text-xl text-deep"><i class="fas fa-id-card"></i></span>
        <h1 class="mt-4 font-display text-2xl font-extrabold text-deep">Datos de tu certificado</h1>

        <?php if ($bloqueado): ?>
            <p class="mt-2 text-muted">Tus certificados ya se emitieron con estos datos:</p>
            <dl class="mt-5 space-y-3 rounded-2xl bg-surface p-4 text-sm">
                <div><dt class="text-muted">Nombre</dt><dd class="font-semibold"><?= $h($nombre) ?></dd></div>
                <div><dt class="text-muted">Documento</dt><dd class="font-semibold"><?= $h($alumno['dni'] ?: '—') ?></dd></div>
            </dl>
            <p class="mt-5 text-sm text-muted">¿Hay un error? Escríbenos y lo corregimos.</p>
            <a href="https://wa.me/51941208020?text=<?= rawurlencode('Hola ICC, necesito corregir el nombre de mi certificado. Mi usuario es ' . ($alumno['usuario'] ?? '')) ?>" target="_blank" rel="noopener" class="mt-3 inline-flex min-h-[44px] items-center gap-2 rounded-xl bg-brand px-5 font-bold text-white"><i class="fab fa-whatsapp"></i> Pedir corrección</a>
        <?php else: ?>
            <p class="mt-2 text-muted">Revisa que tu nombre esté completo y bien escrito: <strong>así saldrá en todos tus certificados</strong> y en la página de verificación.</p>
            <form method="post" action="<?= BASE_URL ?>aula/mis_datos" class="mt-6 space-y-4">
                <input type="hidden" name="_token" value="<?= $h($token) ?>">
                <input type="hidden" name="certificado" value="<?= (int) $idCert ?>">
                <label class="block text-sm font-semibold">Nombres y apellidos completos
                    <input name="nombre" x-model="nombre" required minlength="5" maxlength="200" autocomplete="name" class="mt-1 w-full rounded-xl border border-line px-3 py-3 text-base focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">
                </label>
                <?php $docFijo = trim((string) ($alumno['dni'] ?? '')) !== '' && trim((string) $alumno['dni'], '0') !== ''; ?>
                <label class="block text-sm font-semibold">DNI o documento <span class="font-normal text-muted">(sale en el certificado)</span>
                    <?php if ($docFijo): ?>
                        <input value="<?= $h($alumno['dni']) ?>" readonly aria-describedby="doc-ayuda" class="mt-1 w-full cursor-not-allowed rounded-xl border border-line bg-surface px-3 py-3 text-base text-muted">
                        <span id="doc-ayuda" class="mt-1 block text-xs font-normal text-muted">¿Está mal? <a href="https://wa.me/51941208020" target="_blank" rel="noopener" class="font-semibold text-brand hover:underline">Escríbenos</a> y lo corregimos.</span>
                    <?php else: ?>
                        <input name="dni" maxlength="20" inputmode="numeric" class="mt-1 w-full rounded-xl border border-line px-3 py-3 text-base focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">
                    <?php endif; ?>
                </label>
                <div class="rounded-2xl bg-mist p-4 text-center">
                    <p class="text-xs font-semibold uppercase tracking-wide text-muted">Así se verá</p>
                    <p class="mt-1 font-display text-xl font-bold text-deep" x-text="nombre.trim().toLowerCase().replace(/(^|\s)(\S)/g, (m, a, b) => a + b.toUpperCase()).replace(/\s(De|Del|La|Las|Los|Y)(?=\s)/g, m => m.toLowerCase()) || '—'"></p>
                </div>
                <label class="flex items-start gap-3 text-sm">
                    <input type="checkbox" required class="mt-1 h-4 w-4 rounded border-line text-brand focus:ring-brand">
                    <span>Confirmo que mi nombre y documento son correctos. Después de descargar el primer certificado, los cambios se piden a soporte.</span>
                </label>
                <button class="flex min-h-[52px] w-full items-center justify-center gap-2 rounded-xl bg-brand font-display font-bold text-white hover:bg-brand-dark">
                    <?= $idCert ? 'Guardar y descargar certificado' : 'Guardar mis datos' ?> <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
