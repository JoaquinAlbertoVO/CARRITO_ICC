<?php
$h = function ($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); };
$val = function ($n) { return $n !== null && (float) $n > 0 ? number_format((float) $n, 2, '.', '') : ''; };
$enPack = array_map(function ($c) { return (int) $c['id_curso']; }, $pack['cursos']);
$sumaPen = \App\Models\Catalogo::sumaSueltos($pack, 'precio');
$sumaUsd = \App\Models\Catalogo::sumaSueltos($pack, 'precio_usd');
?>
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div>
                <h1 class="m-0"><?= $h($pack['codigo']) ?> · <?= $h($pack['nombre']) ?></h1>
                <p class="text-muted mb-0"><?= count($pack['cursos']) ?> cursos · <?= \App\Models\Catalogo::horasPack($pack) ?> horas · un certificado por curso</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>tienda/pack/<?= $h($pack['slug']) ?>" target="_blank" rel="noopener" class="btn btn-outline-secondary mr-2">Ver en la tienda</a>
                <a href="<?= BASE_URL ?>admin/catalogo" class="btn btn-outline-primary">Volver</a>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($msg)): ?><div class="alert alert-<?= $h($msg['tipo']) ?>"><?= $h($msg['texto']) ?></div><?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>admin/catalogo_pack/<?= (int) $pack['id_pack'] ?>">
            <input type="hidden" name="_token" value="<?= $h($token) ?>">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header"><h4 class="card-title mb-0">Datos del pack</h4></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" required maxlength="200" value="<?= $h($pack['nombre']) ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label>Precio S/</label>
                                    <input type="number" step="0.01" min="0" name="precio" class="form-control" value="<?= $val($pack['precio']) ?>">
                                    <?php if ($sumaPen): ?><small class="text-muted">Sueltos suman S/ <?= number_format($sumaPen, 2) ?></small><?php endif; ?>
                                </div>
                                <div class="form-group col-4">
                                    <label>Precio US$</label>
                                    <input type="number" step="0.01" min="0" name="precio_usd" class="form-control" value="<?= $val($pack['precio_usd']) ?>">
                                    <?php if ($sumaUsd): ?><small class="text-muted">Sueltos suman US$ <?= number_format($sumaUsd, 2) ?></small><?php endif; ?>
                                </div>
                                <div class="form-group col-4">
                                    <label>Orden en la tienda</label>
                                    <input type="number" name="orden" class="form-control" value="<?= (int) $pack['orden'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Para quién es</label>
                                <input type="text" name="publico" class="form-control" maxlength="255" value="<?= $h($pack['publico']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Descripción para la tienda <small class="text-muted">(opcional)</small></label>
                                <textarea name="descripcion" rows="3" class="form-control" maxlength="1500"><?= $h($pack['descripcion']) ?></textarea>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="pub" name="publicado" value="1" <?= !empty($pack['publicado']) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="pub">Publicado en la tienda</label>
                            </div>
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header"><h4 class="card-title mb-0">Cursos incluidos</h4></div>
                        <div class="list-group list-group-flush" style="max-height:520px;overflow:auto;">
                            <?php foreach ($todos as $c): ?>
                                <label class="list-group-item py-2 d-flex align-items-center mb-0">
                                    <input type="checkbox" name="cursos[]" value="<?= (int) $c['id_curso'] ?>" class="mr-2" <?= in_array((int) $c['id_curso'], $enPack, true) ? 'checked' : '' ?>>
                                    <span class="flex-grow-1"><?= $h($c['nombre_curso']) ?></span>
                                    <small class="<?= (int) $c['horas_academicas'] > 0 ? 'text-muted' : 'text-danger' ?>"><?= (int) $c['horas_academicas'] > 0 ? (int) $c['horas_academicas'] . ' h' : 'sin horas' ?></small>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
