<?php
/**
 * Verificacion de certificados de ICC (estilo checkout v2, layouts/sitio.php).
 * La de ST Energy es verificar/stenergy.php. Datos: VerificarController::index.
 */
$e = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$conImagen = $estado === 'valido' && !empty($marca['imagen']);
$ejemplo = 'CERT-MSE-12345678';
$cab = [
    'titulo' => 'Verificar certificado',
    'sub' => 'Comprueba que un certificado fue emitido por ICC escribiendo su código o escaneando el QR.',
    'etiqueta' => 'Certificados ICC',
    'migas' => [['Inicio', ''], ['Verificar certificado', null]],
];
require __DIR__ . '/../partials/cabecera_pagina.php';
$aviso = function ($icono, $clases, $titulo) {
    return '<p class="mt-6 inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-bold ' . $clases . '"><i class="' . $icono . '" aria-hidden="true"></i> ' . $titulo . '</p>';
};
?>
<section class="bg-surface pb-16 pt-4">
    <div class="mx-auto px-4 <?= $conImagen ? 'grid max-w-6xl grid-cols-1 items-start gap-6 lg:grid-cols-[minmax(0,26rem)_1fr]' : 'max-w-2xl' ?>">
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5 sm:p-8">
            <p class="text-ink">Escribe el <strong>código</strong> que aparece en tu certificado (junto a "Código:", por ejemplo <em class="font-mono text-sm"><?= $e($ejemplo) ?></em>) o escanea el QR del certificado.</p>
            <form class="mt-5 flex flex-col gap-3 sm:flex-row" method="get" action="<?= BASE_URL ?>verificar">
                <label for="codigo-cert" class="sr-only">Código del certificado</label>
                <input id="codigo-cert" type="text" name="c" value="<?= $e($ingresado) ?>" placeholder="CERT-XXXX-XXXXXXXX" maxlength="60" autocomplete="off" required
                       class="min-w-0 flex-1 rounded-xl border border-line px-4 py-3 font-mono uppercase tracking-wide text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand">
                <?php if (!empty($marca_forzada)): ?><input type="hidden" name="marca" value="<?= $e($marca_forzada) ?>"><?php endif; ?>
                <button type="submit" class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-brand px-6 py-3 font-display font-bold text-white hover:bg-brand-dark"><i class="fas fa-search" aria-hidden="true"></i> Verificar</button>
            </form>

            <?php if ($estado === 'valido'): ?>
                <?= $aviso('fas fa-check-circle', 'bg-emerald-50 text-emerald-800', 'Certificado válido') ?>
                <p class="mt-3 text-ink">Este certificado fue emitido por <strong><?= $e($marca['nombre']) ?></strong>.</p>
                <dl class="mt-5 divide-y divide-mist overflow-hidden rounded-xl ring-1 ring-line/60">
                    <?php
                    $filas = [['Otorgado a', $cert['nombre']]];
                    if ($dni_enmascarado !== '') $filas[] = ['Documento de identidad', $dni_enmascarado];
                    $filas[] = ['Curso', $cert['curso']];
                    if (!empty($cert['horas'])) $filas[] = ['Duración', $cert['horas'] . ' horas académicas'];
                    if (!empty($cert['periodo'])) $filas[] = ['Periodo', ucfirst($cert['periodo'])];
                    if (!empty($cert['fecha_emision'])) $filas[] = ['Fecha de emisión', $cert['fecha_emision']];
                    $filas[] = ['Código', $cert['codigo']];
                    foreach ($filas as $f): ?>
                    <div class="grid grid-cols-[38%_1fr] text-sm">
                        <dt class="bg-surface px-4 py-3 font-semibold text-muted"><?= $e($f[0]) ?></dt>
                        <dd class="px-4 py-3 font-medium text-deep <?= $f[0] === 'Código' ? 'font-mono' : '' ?>"><?= $e($f[1]) ?></dd>
                    </div>
                    <?php endforeach; ?>
                </dl>
                <?php if (!empty($descargable)): ?>
                <a href="<?= BASE_URL ?>verificar/descargar/<?= $e(rawurlencode($cert['codigo'])) ?>" rel="nofollow"
                   class="mt-5 inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-brand px-6 py-3 font-display font-bold text-white hover:bg-brand-dark"><i class="fas fa-download" aria-hidden="true"></i> Descargar certificado (PDF)</a>
                <?php endif; ?>
            <?php elseif ($estado === 'anulado'): ?>
                <?= $aviso('fas fa-times-circle', 'bg-red-50 text-red-800', 'Certificado anulado') ?>
                <p class="mt-3 text-ink">El código <strong><?= $e($cert['codigo']) ?></strong> existe, pero ese certificado ya no está vigente. Para más información escríbenos a <a class="font-semibold text-brand underline" href="mailto:<?= $e($marca['email']) ?>"><?= $e($marca['email']) ?></a>.</p>
            <?php elseif ($estado === 'no_encontrado'): ?>
                <?= $aviso('fas fa-times-circle', 'bg-red-50 text-red-800', 'No encontrado') ?>
                <p class="mt-3 text-ink">No encontramos un certificado con el código <strong><?= $e(strtoupper($ingresado)) ?></strong>. Revisa que esté bien escrito. Si el problema continúa, escríbenos a <a class="font-semibold text-brand underline" href="mailto:<?= $e($marca['email']) ?>"><?= $e($marca['email']) ?></a> o al WhatsApp <?= $e($marca['telefono']) ?>.</p>
            <?php elseif ($estado === 'invalido'): ?>
                <?= $aviso('fas fa-exclamation-circle', 'bg-red-50 text-red-800', 'Código no válido') ?>
                <p class="mt-3 text-ink">El código solo lleva letras, números y guiones (por ejemplo <em class="font-mono text-sm"><?= $e($ejemplo) ?></em>).</p>
            <?php elseif ($estado === 'error'): ?>
                <p class="mt-6 rounded-xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">No pudimos consultar el registro en este momento. Intenta de nuevo en unos minutos.</p>
            <?php endif; ?>

            <div class="mt-6 border-t border-dashed border-line pt-4 text-sm leading-relaxed text-muted">
                <strong class="text-deep"><?= $e($marca['razon_social'] !== '' ? $marca['razon_social'] : $marca['nombre']) ?></strong><br>
                <?php if ($marca['ruc'] !== ''): ?>RUC <?= $e($marca['ruc']) ?><br><?php endif; ?>
                ¿Dudas sobre un certificado? <a class="font-semibold text-brand underline" href="mailto:<?= $e($marca['email']) ?>"><?= $e($marca['email']) ?></a> · WhatsApp <?= $e($marca['telefono']) ?>
            </div>
        </div>

        <?php if ($conImagen): ?>
        <!-- Imagen del certificado al que corresponden los datos (se dibuja a partir del registro, sin el DNI) -->
        <figure class="rounded-2xl bg-white p-3 shadow-sm ring-1 ring-black/5">
            <img src="<?= BASE_URL ?>verificar/imagen/<?= $e(rawurlencode($cert['codigo'])) ?>" alt="Certificado emitido a <?= $e($cert['nombre']) ?>: <?= $e($cert['curso']) ?>" width="1123" height="794" class="w-full rounded-lg ring-1 ring-line/60">
            <figcaption class="mt-3 text-center text-xs text-muted">Certificado emitido a nombre de <?= $e($cert['nombre']) ?>. El documento de identidad no se muestra completo por privacidad.</figcaption>
        </figure>
        <?php endif; ?>
    </div>
</section>
