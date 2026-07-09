<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <a href="<?= BASE_URL ?>admin/videos?curso=<?= $id_curso ?>" class="btn btn-sm btn-outline-secondary mr-3">
                <i class="material-icons" style="font-size:16px;vertical-align:middle;">arrow_back</i>
            </a>
            <div>
                <h1 class="m-0">Editar Video</h1>
                <p class="text-muted mb-0"><?= htmlspecialchars($nombre_curso) ?></p>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($alert)) echo $alert; ?>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-8 card-form__body">
                    <form method="POST" action="<?= BASE_URL ?>admin/videos_editar?id=<?= $video['id_video'] ?>">
                        <input type="hidden" name="id_curso" value="<?= $id_curso ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modulo"><strong>Módulo <span class="text-danger">*</span></strong></label>
                                    <input type="text" class="form-control" id="modulo" name="modulo"
                                           value="<?= htmlspecialchars($video['modulo'] ?? 'Módulo 1') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="max-width:150px;">
                                    <label for="orden"><strong>Orden</strong></label>
                                    <input type="number" class="form-control" id="orden" name="orden" min="1"
                                           value="<?= (int)$video['orden'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="titulo"><strong>Título del Video <span class="text-danger">*</span></strong></label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                   value="<?= htmlspecialchars($video['titulo']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="url_video"><strong>URL del Video <span class="text-danger">*</span></strong></label>
                            <input type="url" class="form-control" id="url_video" name="url_video"
                                   value="<?= htmlspecialchars($video['url_video']) ?>" required>
                            <small class="form-text text-muted">Link completo de YouTube o Vimeo.</small>
                        </div>

                        <!-- Vista previa del video -->
                        <div id="video-preview" class="mb-3">
                            <label><strong>Vista previa actual:</strong></label>
                            <div class="embed-responsive embed-responsive-16by9" style="max-width:400px;">
                                <iframe id="preview-frame" class="embed-responsive-item"
                                        src="<?= getYouTubeEmbedFromUrl($video['url_video']) ?>"
                                        allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="descripcion"><strong>Descripción <span class="text-muted font-weight-normal">(Opcional)</span></strong></label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($video['descripcion'] ?? '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duracion"><strong>Duración</strong></label>
                                    <input type="text" class="form-control" id="duracion" name="duracion"
                                           value="<?= htmlspecialchars($video['duracion'] ?? '0:00') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="material-icons" style="font-size:16px;vertical-align:middle;">save</i> Actualizar Video
                            </button>
                            <a href="<?= BASE_URL ?>admin/videos?curso=<?= $id_curso ?>" class="btn btn-light">Cancelar</a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 bg-light border-left p-4">
                    <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size:11px;letter-spacing:1px;">ℹ️ Info del Video</h6>
                    <dl style="font-size:13px;">
                        <dt class="text-muted">ID</dt>
                        <dd>#<?= $video['id_video'] ?></dd>
                        <dt class="text-muted">Creado</dt>
                        <dd><?= date('d/m/Y H:i', strtotime($video['fecha_creado'])) ?></dd>
                    </dl>
                    <hr>
                    <a href="<?= BASE_URL ?>admin/videos_eliminar?id=<?= $video['id_video'] ?>&curso=<?= $id_curso ?>"
                       class="btn btn-sm btn-outline-danger btn-block"
                       onclick="return confirm('¿Seguro que deseas eliminar este video?')">
                        <i class="material-icons" style="font-size:14px;vertical-align:middle;">delete</i> Eliminar este video
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function getYouTubeEmbedFromUrl($url) {
    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
    return !empty($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] : '';
}
?>

<script>
document.getElementById('url_video').addEventListener('input', function() {
    const url = this.value.trim();
    const frame = document.getElementById('preview-frame');
    const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    frame.src = match ? 'https://www.youtube.com/embed/' + match[1] : '';
    document.getElementById('video-preview').style.display = match ? 'block' : 'none';
});
</script>
