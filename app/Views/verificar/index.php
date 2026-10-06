<?php
$e = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
?>
<style>
    .ver-grid { max-width: 680px; margin: 0 auto; }
    .ver-grid.con-imagen { max-width: 1140px; display: grid; grid-template-columns: minmax(300px, 440px) 1fr; gap: 28px; align-items: start; }
    .ver-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 28px; box-shadow: 0 8px 24px rgba(15, 23, 42, .06); }
    .ver-cert { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 14px; box-shadow: 0 8px 24px rgba(15, 23, 42, .06); }
    .ver-cert img { display: block; width: 100%; height: auto; border-radius: 6px; border: 1px solid #e2e8f0; }
    .ver-cert p { margin: 10px 4px 0; font-size: .82rem; color: #64748b; text-align: center; }
    @media (max-width: 900px) { .ver-grid.con-imagen { grid-template-columns: 1fr; max-width: 680px; } }
    .ver-form { display: flex; gap: 10px; flex-wrap: wrap; }
    .ver-form input[type=text] { flex: 1 1 240px; min-width: 0; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 1rem; text-transform: uppercase; }
    .ver-form button { padding: 12px 22px; border: 0; border-radius: 10px; background: #1d4ed8; color: #fff; font-weight: 700; font-size: 1rem; cursor: pointer; }
    .ver-badge { display: inline-block; padding: 6px 14px; border-radius: 999px; font-weight: 700; font-size: .95rem; }
    .ver-ok { background: #dcfce7; color: #166534; }
    .ver-mal { background: #fee2e2; color: #991b1b; }
    .ver-tabla { width: 100%; border-collapse: collapse; margin-top: 18px; }
    .ver-tabla th { text-align: left; width: 38%; padding: 10px 12px; background: #f1f5f9; border: 1px solid #e2e8f0; font-size: .9rem; color: #334155; vertical-align: top; }
    .ver-tabla td { padding: 10px 12px; border: 1px solid #e2e8f0; font-size: .95rem; color: #0f172a; }
    .ver-inst { margin-top: 22px; padding-top: 16px; border-top: 1px dashed #cbd5e1; font-size: .9rem; color: #475569; line-height: 1.6; }
    @media (max-width: 520px) { .ver-card { padding: 18px; } .ver-tabla th { width: 42%; } }
</style>

<section class="page-header clearfix" style="background-color: var(--mo-surface); padding-top:120px; padding-bottom:50px; border-bottom:1px solid #eaeaea;">
    <div class="container">
        <div class="page-header__inner text-center">
            <h2 style="color: var(--mo-accent); font-family: var(--mo-font-heading);">Verificar certificado</h2>
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                <li class="active">Verificar certificado</li>
            </ul>
        </div>
    </div>
</section>

<section style="padding: 50px 0 70px;">
    <div class="container" style="padding-left: 16px; padding-right: 16px;">
        <div class="ver-grid<?= $estado === 'valido' ? ' con-imagen' : '' ?>">
        <div class="ver-card">
            <p style="margin-top:0; color:#334155;">Escribe el <strong>código</strong> que aparece en tu certificado (junto a "Código:", por ejemplo <em>CERT-MSE-12345678</em>) o escanea el QR del certificado.</p>
            <form class="ver-form" method="get" action="<?= BASE_URL ?>verificar">
                <input type="text" name="c" value="<?= $e($ingresado) ?>" placeholder="CERT-XXXX-XXXXXXXX" maxlength="60" autocomplete="off" aria-label="Código del certificado" required>
                <button type="submit">Verificar</button>
            </form>

            <?php if ($estado === 'valido'): ?>
                <div style="margin-top: 22px;"><span class="ver-badge ver-ok">✔ Certificado válido</span></div>
                <p style="margin: 10px 0 0; color:#334155;">Este certificado fue emitido por <strong>ICC – Instituto de Capacitación Continua</strong>.</p>
                <table class="ver-tabla">
                    <tr><th>Otorgado a</th><td><?= $e($cert['nombre']) ?></td></tr>
                    <?php if ($dni_enmascarado !== ''): ?><tr><th>Documento de identidad</th><td><?= $e($dni_enmascarado) ?></td></tr><?php endif; ?>
                    <tr><th>Curso</th><td><?= $e($cert['curso']) ?></td></tr>
                    <?php if (!empty($cert['horas'])): ?><tr><th>Duración</th><td><?= $e($cert['horas']) ?> horas académicas</td></tr><?php endif; ?>
                    <?php if (!empty($cert['periodo'])): ?><tr><th>Periodo</th><td><?= $e(ucfirst($cert['periodo'])) ?></td></tr><?php endif; ?>
                    <?php if (!empty($cert['fecha_emision'])): ?><tr><th>Fecha de emisión</th><td><?= $e($cert['fecha_emision']) ?></td></tr><?php endif; ?>
                    <tr><th>Código</th><td><?= $e($cert['codigo']) ?></td></tr>
                </table>
            <?php elseif ($estado === 'anulado'): ?>
                <div style="margin-top: 22px;"><span class="ver-badge ver-mal">✖ Certificado anulado</span></div>
                <p style="margin: 10px 0 0; color:#334155;">El código <strong><?= $e($cert['codigo']) ?></strong> existe, pero ese certificado ya no está vigente. Para más información escríbenos a <a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a>.</p>
            <?php elseif ($estado === 'no_encontrado'): ?>
                <div style="margin-top: 22px;"><span class="ver-badge ver-mal">✖ No encontrado</span></div>
                <p style="margin: 10px 0 0; color:#334155;">No encontramos un certificado con el código <strong><?= $e(strtoupper($ingresado)) ?></strong>. Revisa que esté bien escrito. Si el problema continúa, escríbenos a <a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a> o al WhatsApp +51 941 208 020.</p>
            <?php elseif ($estado === 'invalido'): ?>
                <div style="margin-top: 22px;"><span class="ver-badge ver-mal">✖ Código no válido</span></div>
                <p style="margin: 10px 0 0; color:#334155;">El código solo lleva letras, números y guiones (por ejemplo <em>CERT-MSE-12345678</em>).</p>
            <?php elseif ($estado === 'error'): ?>
                <p style="margin: 22px 0 0; color:#991b1b;">No pudimos consultar el registro en este momento. Intenta de nuevo en unos minutos.</p>
            <?php endif; ?>

            <div class="ver-inst">
                <strong><?= $e($razon_social) ?></strong><br>
                RUC <?= $e($ruc) ?><br>
                ¿Dudas sobre un certificado? <a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a> · WhatsApp +51 941 208 020
            </div>
        </div>

        <?php if ($estado === 'valido'): ?>
        <!-- Imagen del certificado al que corresponden los datos (se dibuja a partir del registro, sin el DNI) -->
        <div class="ver-cert">
            <img src="<?= BASE_URL ?>verificar/imagen/<?= $e(rawurlencode($cert['codigo'])) ?>" alt="Certificado emitido a <?= $e($cert['nombre']) ?>: <?= $e($cert['curso']) ?>" width="1123" height="794">
            <p>Certificado emitido a nombre de <?= $e($cert['nombre']) ?>. El documento de identidad no se muestra completo por privacidad.</p>
        </div>
        <?php endif; ?>
        </div>
    </div>
</section>
