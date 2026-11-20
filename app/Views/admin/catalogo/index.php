<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$soles = function ($n) { return $n !== null && (float) $n > 0 ? 'S/ ' . number_format((float) $n, 2) : '—'; };
$usd = function ($n) { return $n !== null && (float) $n > 0 ? 'US$ ' . number_format((float) $n, 2) : '—'; };
$estado = function ($item, $esPack = false) {
    if (\App\Models\Catalogo::vendible($item)) {
        return '<span class="badge badge-success">A la venta</span>';
    }
    if (!empty($item['publicado'])) {
        return '<span class="badge badge-warning">Publicado sin precio</span>';
    }
    return '<span class="badge badge-light">Borrador</span>';
};
?>
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-lg-left">
            <div>
                <h1 class="m-0"><i class="material-icons text-primary mr-2" style="font-size:32px;vertical-align:middle;">inventory_2</i>Packs y cursos grabados</h1>
                <p class="text-muted mb-0">Lo que se vende en <a href="<?= BASE_URL ?>tienda" target="_blank" rel="noopener">/tienda</a>. Al pagar, el alumno entra al aula con su certificado de cada curso listo para descargar.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>admin/catalogo_ventas" class="btn btn-primary">Ventas<?= $pendientes ? ' <span class="badge badge-light ml-1">' . (int) $pendientes . ' por aprobar</span>' : '' ?></a>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($msg)): ?>
            <div class="alert alert-<?= $h($msg['tipo']) ?>"><?= $h($msg['texto']) ?></div>
        <?php endif; ?>

        <div class="alert alert-light border">
            <strong>Para vender algo:</strong> entra al curso o pack, pon el precio en soles y en dólares, las horas académicas (salen en el certificado) y marca <em>Publicado</em>.
            Un pack solo se publica si todos sus cursos ya tienen horas.
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Packs y rutas</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Código</th><th>Nombre</th><th class="text-center">Cursos</th><th class="text-center">Horas</th><th class="text-right">Soles</th><th class="text-right">Dólares</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($packs as $p): ?>
                        <tr>
                            <td><strong><?= $h($p['codigo']) ?></strong></td>
                            <td><?= $h($p['nombre']) ?><?php if ($p['incluye']): ?><br><small class="text-muted"><?= $h($p['incluye']) ?></small><?php endif; ?></td>
                            <td class="text-center"><?= count($p['cursos']) ?></td>
                            <td class="text-center"><?= \App\Models\Catalogo::horasPack($p) ?: '—' ?></td>
                            <td class="text-right"><?= $soles($p['precio']) ?></td>
                            <td class="text-right"><?= $usd($p['precio_usd']) ?></td>
                            <td><?= $estado($p, true) ?></td>
                            <td class="text-right"><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>admin/catalogo_pack/<?= (int) $p['id_pack'] ?>">Editar</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$packs): ?><tr><td colspan="8" class="text-muted text-center py-4">Aún no hay packs. Importa el catálogo abajo.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">Cursos grabados (venta suelta)</h4></div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Sigla</th><th>Curso</th><th class="text-center">Clases</th><th class="text-center">Materiales</th><th class="text-center">Horas</th><th class="text-right">Soles</th><th class="text-right">Dólares</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($cursos as $c): ?>
                        <tr>
                            <td><code><?= $h($c['sigla']) ?></code></td>
                            <td><?= $h($c['nombre_curso']) ?></td>
                            <td class="text-center"><?= (int) $c['total_clases'] ?></td>
                            <td class="text-center"><?= (int) $c['total_materiales'] ?></td>
                            <td class="text-center"><?= (int) $c['horas_academicas'] > 0 ? (int) $c['horas_academicas'] : '<span class="text-danger">falta</span>' ?></td>
                            <td class="text-right"><?= $soles($c['precio']) ?></td>
                            <td class="text-right"><?= $usd($c['precio_usd']) ?></td>
                            <td><?= $estado($c) ?></td>
                            <td class="text-right"><a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>admin/catalogo_curso/<?= (int) $c['id_curso'] ?>">Editar</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$cursos): ?><tr><td colspan="9" class="text-muted text-center py-4">Aún no hay cursos grabados.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">Importar desde el Excel</h4></div>
            <div class="card-body">
                <p class="text-muted">Sube el <code>catalogo_asincrono.json</code> generado desde el Excel de cursos. Crea o actualiza cursos, clases, materiales y packs.
                    <strong>No cambia</strong> precios, horas, textos editados ni lo que ya está publicado. Se puede volver a subir sin duplicar nada.</p>
                <form method="post" action="<?= BASE_URL ?>admin/catalogo_importar" enctype="multipart/form-data" class="form-inline">
                    <input type="hidden" name="_token" value="<?= $h($token) ?>">
                    <input type="file" name="archivo" accept=".json,application/json" class="form-control-file mr-3" required>
                    <button class="btn btn-outline-primary" type="submit">Importar</button>
                </form>
            </div>
        </div>
    </div>
</div>
