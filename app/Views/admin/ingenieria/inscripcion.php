<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center justify-content-between">
        <h1 class="m-0">Inscribir Cursos a: <?= htmlspecialchars($estudiante['nombre'] ?? 'Estudiante') ?></h1>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div><?= isset($alert) ? $alert : ''; ?></div>
                <form action="" method="POST">
                    <div class="card-form__body card-body">
                        <h4 class="card-title mb-4">Selecciona los cursos a los que deseas inscribir a este estudiante:</h4>
                        <div class="form-group">
                            <div class="row">
                                <?php if (!empty($cursos)): ?>
                                    <?php foreach ($cursos as $curso): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" 
                                                       class="custom-control-input" 
                                                       id="curso_<?= $curso['id_curso'] ?>" 
                                                       name="cursos[]" 
                                                       value="<?= $curso['id_curso'] ?>" 
                                                       <?= in_array($curso['id_curso'], $cursos_inscritos) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="curso_<?= $curso['id_curso'] ?>">
                                                    <strong><?= htmlspecialchars($curso['nombre_curso']) ?></strong>
                                                    <span class="text-muted d-block"><small><?= htmlspecialchars($curso['categoria'] ?? '') ?></small></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <p class="text-muted">No hay cursos registrados o activos en el sistema.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center bg-light">
                        <button type="submit" class="btn btn-success">Guardar Inscripciones</button>
                        <a href="<?= BASE_URL ?>admin/ingenieria" class="btn btn-secondary">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SECCION GESTIONAR CERTIFICADOS -->
<div class="container-fluid page__container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Subir Certificados PDF</h4>
            <p class="text-muted mb-0">Solo puedes subir certificados para los cursos en los que el estudiante ya está inscrito.</p>
        </div>
        <div class="card-body">
            <div class="row">
                <?php $tiene_inscritos = false; ?>
                <?php if (!empty($cursos)): ?>
                    <?php foreach ($cursos as $curso): ?>
                        <?php if (in_array($curso['id_curso'], $cursos_inscritos)): $tiene_inscritos = true; ?>
                            <div class="col-md-6 mb-4">
                                <div class="border p-3 rounded">
                                    <h5 class="mb-2 text-primary"><?= htmlspecialchars($curso['nombre_curso']) ?></h5>
                                    
                                    <form action="" method="POST" enctype="multipart/form-data" class="d-flex align-items-center mb-2">
                                        <input type="hidden" name="action" value="upload_cert">
                                        <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">
                                        
                                        <div class="custom-file mr-2" style="flex:1;">
                                            <input type="file" class="custom-file-input" id="cert_<?= $curso['id_curso'] ?>" name="certificado_pdf" accept="application/pdf,image/jpeg,image/png" required>
                                            <label class="custom-file-label" for="cert_<?= $curso['id_curso'] ?>">Elegir archivo...</label>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-info">Subir</button>
                                    </form>
                                    <a href="<?= BASE_URL ?>admin/generar_certificado_auto?id_usuario=<?= $id_usuario ?>&id_curso=<?= $curso['id_curso'] ?>&alumno=<?= urlencode($estudiante['nombre'] ?? '') ?>&curso=<?= urlencode($curso['nombre_curso']) ?>&categoria=<?= urlencode($curso['categoria'] ?? 'Ingeniería') ?>" class="btn btn-sm btn-primary w-100 mt-2" style="border-radius: 20px;">
                                        <i class="material-icons mr-1" style="vertical-align: middle; font-size: 16px;">auto_awesome</i> Generar Automáticamente
                                    </a>
                                    
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <?php if (!$tiene_inscritos): ?>
                    <div class="col-12">
                        <p class="text-warning">Este estudiante aún no está inscrito en ningún curso. Inscríbelo primero arriba para poder subir sus certificados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    // Actualizar nombre del archivo en el input
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });
</script>
