<div class="mdk-header-layout__content page">

    <div class="page__header page__header-nav mb-0">
        <div class="container page__container">
            <div class="navbar navbar-secondary navbar-light navbar-expand-sm p-0 d-none d-md-flex" id="secondaryNavbar">
                <ul class="nav navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="<?= BASE_URL ?>admin/cursos" class="nav-link dropdown-toggle" data-toggle="dropdown">Regresar a Cursos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container page__container">
        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <h1 class="h2 mb-0">Gestionar Videos: <?= htmlspecialchars($data['curso']['nombre_curso']) ?></h1>
            </div>
        </div>

        <div class="row">
            <!-- Formulario para agregar video -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Agregar Nuevo Video</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>admin/gestionar_videos?id=<?= $data['curso']['id_curso'] ?>" method="POST">
                            <input type="hidden" name="action" value="add_video">
                            
                            <div class="form-group">
                                <label for="modulo">Nombre del Módulo (ej. Módulo 1)</label>
                                <input type="text" class="form-control" name="modulo" required value="Módulo 1">
                            </div>
                            
                            <div class="form-group">
                                <label for="titulo">Título del Video</label>
                                <input type="text" class="form-control" name="titulo" required placeholder="Ej. Introducción">
                            </div>
                            
                            <div class="form-group">
                                <label for="url_video">URL del Video (YouTube)</label>
                                <input type="text" class="form-control" name="url_video" required placeholder="Ej. https://www.youtube.com/watch?v=...">
                            </div>

                            <div class="form-group">
                                <label for="duracion">Duración (Ej. 05:30)</label>
                                <input type="text" class="form-control" name="duracion" required placeholder="00:00">
                            </div>

                            <div class="form-group">
                                <label for="orden">Orden Numérico</label>
                                <input type="number" class="form-control" name="orden" value="1" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-block">Guardar Video</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de videos existentes -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Videos Actuales</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Orden</th>
                                    <th>Título</th>
                                    <th>Duración</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($data['videos'])): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay videos agregados.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($data['videos'] as $video): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($video['modulo']) ?></td>
                                            <td><?= htmlspecialchars($video['orden']) ?></td>
                                            <td><?= htmlspecialchars($video['titulo']) ?></td>
                                            <td><?= htmlspecialchars($video['duracion']) ?></td>
                                            <td class="text-center">
                                                <a href="<?= BASE_URL ?>admin/gestionar_videos?id=<?= $data['curso']['id_curso'] ?>&delete_video=<?= $video['id_video'] ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('¿Estás seguro de eliminar este video?')">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
