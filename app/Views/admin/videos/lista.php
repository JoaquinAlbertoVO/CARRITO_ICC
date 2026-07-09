<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div>
                <a href="<?= BASE_URL ?>admin/cursos" class="btn btn-sm btn-outline-secondary mb-2">
                    <i class="material-icons" style="font-size:16px;vertical-align:middle;">arrow_back</i> Volver a Cursos
                </a>
                <h1 class="m-0">Videos del Curso</h1>
                <p class="text-muted mb-0"><strong><?= htmlspecialchars($nombre_curso) ?></strong> &mdash; <?= count($videos) ?> video(s)</p>
            </div>
            <a href="<?= BASE_URL ?>admin/videos_registro?curso=<?= $id_curso ?>" class="btn btn-success mt-2 mt-md-0">
                <i class="material-icons" style="font-size:16px;vertical-align:middle;">add</i> Añadir Video
            </a>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($alert)) echo $alert; ?>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0 thead-border-top-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">Orden</th>
                            <th>Módulo</th>
                            <th>Título</th>
                            <th>URL / Link del Video</th>
                            <th style="width:150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($videos)): ?>
                        <?php foreach ($videos as $v): ?>
                        <tr>
                            <td class="text-center">
                                <span class="badge badge-secondary"><?= (int)$v['orden'] ?></span>
                            </td>
                            <td>
                                <span class="badge badge-info"><?= htmlspecialchars($v['modulo'] ?? 'Módulo 1') ?></span>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($v['titulo']) ?></strong><br>
                                <small class="text-muted"><i class="material-icons" style="font-size:11px;vertical-align:middle;">schedule</i> <?= htmlspecialchars($v['duracion'] ?? '0:00') ?></small>
                            </td>
                            <td>
                                <a href="<?= htmlspecialchars($v['url_video']) ?>" target="_blank" class="text-primary text-truncate d-block" style="max-width:260px;" title="<?= htmlspecialchars($v['url_video']) ?>">
                                    <i class="material-icons" style="font-size:14px;vertical-align:middle;">play_circle_outline</i>
                                    <?= htmlspecialchars($v['url_video']) ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>admin/videos_editar?id=<?= $v['id_video'] ?>" class="btn btn-sm btn-primary mr-1" title="Editar">
                                    <i class="material-icons" style="font-size:14px;">edit</i>
                                </a>
                                <a href="<?= BASE_URL ?>admin/videos_eliminar?id=<?= $v['id_video'] ?>&curso=<?= $id_curso ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Seguro que deseas eliminar este video?')"
                                   title="Eliminar">
                                    <i class="material-icons" style="font-size:14px;">delete</i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="material-icons" style="font-size:48px;display:block;opacity:0.3;">videocam_off</i>
                                Este curso aún no tiene videos registrados.<br>
                                <a href="<?= BASE_URL ?>admin/videos_registro?curso=<?= $id_curso ?>" class="btn btn-success btn-sm mt-3">
                                    <i class="material-icons" style="font-size:14px;vertical-align:middle;">add</i> Añadir primer video
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
