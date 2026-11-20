<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$badge = ['pagado' => 'success', 'pendiente' => 'warning', 'rechazado' => 'secondary'];
?>
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div>
                <h1 class="m-0"><i class="material-icons text-primary mr-2" style="font-size:32px;vertical-align:middle;">shopping_bag</i>Ventas de packs y cursos grabados</h1>
                <p class="text-muted mb-0">PayPal da el acceso solo. Los pagos con Yape, Plin o transferencia esperan aquí hasta que verifiques el comprobante.</p>
            </div>
            <a href="<?= BASE_URL ?>admin/catalogo" class="btn btn-outline-primary mt-3 mt-md-0">Packs y cursos</a>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($msg)): ?><div class="alert alert-<?= $h($msg['tipo']) ?>"><?= $h($msg['texto']) ?></div><?php endif; ?>

        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">Por aprobar (<?= count($pendientes) ?>)</h4></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Fecha</th><th>Alumno</th><th>Compró</th><th>Monto declarado</th><th>Comprobante</th><th class="text-right">Acción</th></tr></thead>
                    <tbody>
                    <?php foreach ($pendientes as $v): ?>
                        <tr>
                            <td class="text-nowrap small"><?= $h(date('d/m/Y H:i', strtotime($v['creado']))) ?></td>
                            <td><strong><?= $h($v['nombre']) ?></strong><br><small class="text-muted"><?= $h($v['correo']) ?> · <?= $h($v['celular']) ?> · Doc. <?= $h($v['documento'] ?: '—') ?></small></td>
                            <td><?= $h($v['item_nombre']) ?> <span class="badge badge-light"><?= $h($v['tipo']) ?></span></td>
                            <td class="text-nowrap"><?= $v['monto'] !== null ? $h($v['moneda'] . ' ' . number_format((float) $v['monto'], 2)) : '—' ?></td>
                            <td><?php if ($v['comprobante']): ?><a href="<?= BASE_URL ?>admin/catalogo_comprobante/<?= (int) $v['id_venta'] ?>" target="_blank" rel="noopener" class="btn btn-sm btn-light">Ver</a><?php endif; ?></td>
                            <td class="text-right text-nowrap">
                                <form method="post" action="<?= BASE_URL ?>admin/catalogo_venta" class="d-inline">
                                    <input type="hidden" name="_token" value="<?= $h($token) ?>">
                                    <input type="hidden" name="id_venta" value="<?= (int) $v['id_venta'] ?>">
                                    <button class="btn btn-sm btn-success" name="accion" value="aprobar" onclick="return confirm('¿Confirmas que el pago llegó? Se le dará acceso y se le enviará el correo.')">Aprobar y dar acceso</button>
                                    <button class="btn btn-sm btn-outline-secondary" name="accion" value="rechazar" onclick="return confirm('¿Marcar como rechazada? No se dará acceso.')">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$pendientes): ?><tr><td colspan="6" class="text-muted text-center py-4">No hay pagos por aprobar.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">Últimas ventas</h4></div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Fecha</th><th>Alumno</th><th>Compró</th><th>Método</th><th>Monto</th><th>Referencia</th><th>Estado</th></tr></thead>
                    <tbody>
                    <?php foreach ($recientes as $v): ?>
                        <tr>
                            <td class="text-nowrap small"><?= $h(date('d/m/Y H:i', strtotime($v['creado']))) ?></td>
                            <td><?= $h($v['nombre']) ?><br><small class="text-muted"><?= $h($v['correo']) ?></small></td>
                            <td><?= $h($v['item_nombre']) ?></td>
                            <td><?= $h($v['metodo']) ?></td>
                            <td class="text-nowrap"><?= $v['monto'] !== null ? $h($v['moneda'] . ' ' . number_format((float) $v['monto'], 2)) : '—' ?></td>
                            <td class="small text-muted"><?= $h($v['referencia']) ?></td>
                            <td><span class="badge badge-<?= $badge[$v['estado']] ?? 'light' ?>"><?= $h($v['estado']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
