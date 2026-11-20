<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$val = function ($n) { return $n !== null && (float) $n > 0 ? number_format((float) $n, 2, '.', '') : ''; };
$tipos = ['pdf' => 'PDF', 'pptx' => 'Presentación', 'xlsx' => 'Excel', 'docx' => 'Word', 'carpeta' => 'Carpeta de Drive', 'enlace' => 'Enlace'];
?>
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div>
                <h1 class="m-0"><?= $h($curso['nombre_curso']) ?></h1>
                <p class="text-muted mb-0">Curso grabado · <?= count($clases) ?> clases · <?= count($materiales) ?> materiales</p>
            </div>
            <div class="mt-3 mt-md-0">
                <?php if (!empty($curso['slug'])): ?><a href="<?= BASE_URL ?>tienda/curso/<?= $h($curso['slug']) ?>" target="_blank" rel="noopener" class="btn btn-outline-secondary mr-2">Ver en la tienda</a><?php endif; ?>
                <a href="<?= BASE_URL ?>admin/catalogo" class="btn btn-outline-primary">Volver</a>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($msg)): ?><div class="alert alert-<?= $h($msg['tipo']) ?>"><?= $h($msg['texto']) ?></div><?php endif; ?>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">Venta y certificado</h4></div>
                    <div class="card-body">
                        <form method="post" action="<?= BASE_URL ?>admin/catalogo_curso/<?= (int) $curso['id_curso'] ?>">
                            <input type="hidden" name="_token" value="<?= $h($token) ?>">
                            <div class="form-group">
                                <label>Nombre del curso <small class="text-muted">(así sale en el certificado)</small></label>
                                <input type="text" name="nombre" class="form-control" required maxlength="150" value="<?= $h($curso['nombre_curso']) ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label>Precio S/</label>
                                    <input type="number" step="0.01" min="0" name="precio" class="form-control" value="<?= $val($curso['precio']) ?>">
                                </div>
                                <div class="form-group col-4">
                                    <label>Precio US$</label>
                                    <input type="number" step="0.01" min="0" name="precio_usd" class="form-control" value="<?= $val($curso['precio_usd']) ?>">
                                </div>
                                <div class="form-group col-4">
                                    <label>Horas académicas</label>
                                    <input type="number" min="0" name="horas" class="form-control" value="<?= (int) $curso['horas_academicas'] ?: '' ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label>Sigla <small class="text-muted">(código del certificado)</small></label>
                                    <input type="text" name="sigla" class="form-control" maxlength="10" value="<?= $h($curso['sigla']) ?>">
                                </div>
                                <div class="form-group col-8 d-flex align-items-end">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" id="pub" name="publicado" value="1" <?= !empty($curso['publicado']) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="pub">Publicado (se vende suelto en la tienda)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Resumen para la tienda <small class="text-muted">(opcional)</small></label>
                                <textarea name="resumen" rows="3" class="form-control" maxlength="1000"><?= $h($curso['resumen']) ?></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Clases</h4>
                        <a href="<?= BASE_URL ?>admin/gestionar_videos?id=<?= (int) $curso['id_curso'] ?>" class="btn btn-sm btn-outline-primary">Editar clases</a>
                    </div>
                    <ol class="list-group list-group-flush" style="max-height:360px;overflow:auto;">
                        <?php foreach ($clases as $v): ?>
                            <li class="list-group-item py-2 small d-flex justify-content-between">
                                <span><?= (int) $v['orden'] ?>. <?= $h($v['titulo']) ?><?php if (preg_match('/^Clase \d+$/', $v['titulo'])): ?> <span class="badge badge-warning">sin título</span><?php endif; ?></span>
                                <span class="text-muted"><?= $h($v['modulo']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">Materiales (PDF y Drive)</h4></div>
            <div class="card-body pb-0">
                <p class="text-muted small mb-3">Los enlaces de Drive deben estar compartidos como <em>"Cualquier persona con el enlace"</em>, si no el alumno verá "Solicitar acceso".</p>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>#</th><th>Título</th><th>Tipo</th><th>Enlace</th><th>Visible</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($materiales as $m): $f = 'm' . (int) $m['id_material']; ?>
                        <tr>
                            <form method="post" action="<?= BASE_URL ?>admin/catalogo_material" id="<?= $f ?>"></form>
                            <td style="width:70px"><input form="<?= $f ?>" type="number" name="orden" class="form-control form-control-sm" value="<?= (int) $m['orden'] ?>"></td>
                            <td><input form="<?= $f ?>" type="text" name="titulo" class="form-control form-control-sm" value="<?= $h($m['titulo']) ?>">
                                <?php if ($m['nota_interna'] && $m['nota_interna'] !== 'import: '): ?><small class="text-muted"><?= $h(preg_replace('/^import:\s*/', '', $m['nota_interna'])) ?></small><?php endif; ?></td>
                            <td style="width:150px"><select form="<?= $f ?>" name="tipo" class="form-control form-control-sm">
                                <?php foreach ($tipos as $k => $t): ?><option value="<?= $k ?>" <?= $m['tipo'] === $k ? 'selected' : '' ?>><?= $t ?></option><?php endforeach; ?>
                            </select></td>
                            <td><input form="<?= $f ?>" type="url" name="url" class="form-control form-control-sm" value="<?= $h($m['url']) ?>"></td>
                            <td class="text-center" style="width:70px"><input form="<?= $f ?>" type="hidden" name="estado" value="0"><input form="<?= $f ?>" type="checkbox" name="estado" value="1" <?= $m['estado'] ? 'checked' : '' ?>></td>
                            <td class="text-right text-nowrap">
                                <input form="<?= $f ?>" type="hidden" name="_token" value="<?= $h($token) ?>">
                                <input form="<?= $f ?>" type="hidden" name="id_curso" value="<?= (int) $curso['id_curso'] ?>">
                                <input form="<?= $f ?>" type="hidden" name="id_material" value="<?= (int) $m['id_material'] ?>">
                                <a href="<?= $h($m['url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-light">Abrir</a>
                                <button form="<?= $f ?>" class="btn btn-sm btn-outline-primary" type="submit">Guardar</button>
                                <button form="<?= $f ?>" class="btn btn-sm btn-outline-danger" type="submit" name="eliminar" value="<?= (int) $m['id_material'] ?>" onclick="return confirm('¿Eliminar este material?')">×</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-light">
                        <form method="post" action="<?= BASE_URL ?>admin/catalogo_material" id="mNuevo"></form>
                        <td><input form="mNuevo" type="number" name="orden" class="form-control form-control-sm" value="<?= count($materiales) + 1 ?>"></td>
                        <td><input form="mNuevo" type="text" name="titulo" class="form-control form-control-sm" placeholder="Nuevo material" required></td>
                        <td><select form="mNuevo" name="tipo" class="form-control form-control-sm"><?php foreach ($tipos as $k => $t): ?><option value="<?= $k ?>"><?= $t ?></option><?php endforeach; ?></select></td>
                        <td><input form="mNuevo" type="url" name="url" class="form-control form-control-sm" placeholder="https://drive.google.com/..." required></td>
                        <td></td>
                        <td class="text-right">
                            <input form="mNuevo" type="hidden" name="_token" value="<?= $h($token) ?>">
                            <input form="mNuevo" type="hidden" name="id_curso" value="<?= (int) $curso['id_curso'] ?>">
                            <button form="mNuevo" class="btn btn-sm btn-primary" type="submit">Agregar</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
