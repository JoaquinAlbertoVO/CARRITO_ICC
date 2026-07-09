<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <a href="<?= BASE_URL ?>admin/videos?curso=<?= $id_curso ?>" class="btn btn-sm btn-outline-secondary mr-3">
                <i class="material-icons" style="font-size:16px;vertical-align:middle;">arrow_back</i>
            </a>
            <div>
                <h1 class="m-0">Añadir Nuevo Video</h1>
                <p class="text-muted mb-0"><?= htmlspecialchars($nombre_curso) ?></p>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($alert)) echo $alert; ?>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-8 card-form__body">
                    <form method="POST" action="<?= BASE_URL ?>admin/videos_registro?curso=<?= $id_curso ?>">
                        <input type="hidden" name="id_curso" value="<?= $id_curso ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modulo"><strong>Módulo <span class="text-danger">*</span></strong></label>
                                    <input type="text" class="form-control" id="modulo" name="modulo"
                                           placeholder="Ej: Módulo 1, Introducción, etc."
                                           value="<?= htmlspecialchars($_POST['modulo'] ?? 'Módulo 1') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="max-width:150px;">
                                    <label for="orden"><strong>Orden del Video</strong></label>
                                    <input type="number" class="form-control" id="orden" name="orden" min="1"
                                           value="<?= htmlspecialchars($_POST['orden'] ?? $siguiente_orden) ?>">
                                    <small class="form-text text-muted">Posición global.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="titulo"><strong>Título del Video <span class="text-danger">*</span></strong></label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                   placeholder="Ej: Conceptos básicos..."
                                   value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="url_video"><strong>URL del Video <span class="text-danger">*</span></strong></label>
                            <input type="url" class="form-control" id="url_video" name="url_video"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   value="<?= htmlspecialchars($_POST['url_video'] ?? '') ?>" required>
                            <small class="form-text text-muted">Pega el link completo de YouTube o Vimeo.</small>
                        </div>

                        <!-- Vista previa del video -->
                        <div id="video-preview" class="mb-3" style="display:none;">
                            <label><strong>Vista previa:</strong></label>
                            <div class="embed-responsive embed-responsive-16by9" style="max-width:400px;">
                                <iframe id="preview-frame" class="embed-responsive-item" src="" allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="descripcion"><strong>Descripción <span class="text-muted font-weight-normal">(Opcional)</span></strong></label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                              placeholder="Breve descripción..."><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duracion"><strong>Duración</strong></label>
                                    <input type="text" class="form-control" id="duracion" name="duracion"
                                           placeholder="Ej: 4:15"
                                           value="<?= htmlspecialchars($_POST['duracion'] ?? '0:00') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-success mr-2">
                                <i class="material-icons" style="font-size:16px;vertical-align:middle;">save</i> Guardar Video
                            </button>
                            <a href="<?= BASE_URL ?>admin/videos?curso=<?= $id_curso ?>" class="btn btn-light">Cancelar</a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 bg-light border-left p-4">
                    <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size:11px;letter-spacing:1px;">💡 Consejos</h6>
                    <ul class="text-muted" style="font-size:13px;padding-left:18px;">
                        <li class="mb-2">Sube el video a <strong>YouTube</strong> como "No listado" para que solo los alumnos puedan verlo con el link.</li>
                        <li class="mb-2">Pega el link completo de YouTube: <code>https://youtube.com/watch?v=...</code></li>
                        <li class="mb-2">Usa el <strong>Orden</strong> para definir en qué secuencia verán los videos los alumnos.</li>
                        <li>El título debe ser claro, por ejemplo: <em>"Módulo 1 - Instalación básica"</em>.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vista previa automática al pegar URL de YouTube
document.getElementById('url_video').addEventListener('input', function() {
    const url = this.value.trim();
    const preview = document.getElementById('video-preview');
    const frame = document.getElementById('preview-frame');
    const embedUrl = getYouTubeEmbedUrl(url);
    if (embedUrl) {
        frame.src = embedUrl;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
        frame.src = '';
    }
});

function getYouTubeEmbedUrl(url) {
    const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    return match ? 'https://www.youtube.com/embed/' + match[1] : null;
}
</script>
