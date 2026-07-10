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
