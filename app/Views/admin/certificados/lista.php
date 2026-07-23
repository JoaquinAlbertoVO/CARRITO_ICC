<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-lg-left">
            <div>
                <h1 class="m-0"><i class="material-icons text-primary mr-2" style="font-size: 32px; vertical-align: middle;">card_membership</i>Gestión de Certificados</h1>
                <p class="text-muted mb-0">Administra todos los certificados emitidos y atiende solicitudes pendientes.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNuevoCertificado">
                    <i class="material-icons mr-1">add_circle</i> Generar Nuevo Certificado
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <!-- Tarjetas de Resumen -->
        <div class="row card-group-row mb-4">
            <div class="col-lg-6 col-md-6 card-group-row__col">
                <div class="card card-group-row__card card-body flex-row align-items-center">
                    <div class="avatar avatar-lg mr-3">
                        <span class="avatar-title rounded-circle bg-success text-white">
                            <i class="material-icons">verified</i>
                        </span>
                    </div>
                    <div class="flex">
                        <div class="text-amount"><?= count($certificados_emitidos ?? []) ?></div>
                        <div class="text-muted text-uppercase font-weight-bold small">Certificados Emitidos</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 card-group-row__col">
                <div class="card card-group-row__card card-body flex-row align-items-center">
                    <div class="avatar avatar-lg mr-3">
                        <span class="avatar-title rounded-circle bg-warning text-white">
                            <i class="material-icons">pending_actions</i>
                        </span>
                    </div>
                    <div class="flex">
                        <div class="text-amount"><?= count($solicitudes_pendientes ?? []) ?></div>
                        <div class="text-muted text-uppercase font-weight-bold small">Solicitudes Pendientes</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?= BASE_URL ?>admin/certificados" class="form-inline d-flex justify-content-between">
                    <div class="search-form form-control-rounded search-form--light flex-grow-1 mr-3" style="max-width: 500px;">
                        <input type="text" class="form-control" name="busqueda" placeholder="Buscar por alumno, DNI o curso..." value="<?= htmlspecialchars($busqueda ?? '') ?>">
                        <button class="btn" type="submit"><i class="material-icons">search</i></button>
                    </div>
                    <?php if (!empty($busqueda)): ?>
                        <a href="<?= BASE_URL ?>admin/certificados" class="btn btn-secondary btn-sm">Limpiar búsqueda</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Pestañas (Tabs) -->
        <ul class="nav nav-pills mb-3" id="cert-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="emitidos-tab" data-toggle="pill" href="#emitidos" role="tab">
                    <i class="material-icons mr-1" style="font-size: 18px; vertical-align: text-bottom;">check_circle</i>
                    Certificados Emitidos (<?= count($certificados_emitidos ?? []) ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pendientes-tab" data-toggle="pill" href="#pendientes" role="tab">
                    <i class="material-icons mr-1" style="font-size: 18px; vertical-align: text-bottom;">hourglass_empty</i>
                    Solicitudes Pendientes (<?= count($solicitudes_pendientes ?? []) ?>)
                </a>
            </li>
        </ul>

        <div class="tab-content" id="cert-tabs-content">
            <!-- TAB 1: CERTIFICADOS EMITIDOS -->
            <div class="tab-pane fade show active" id="emitidos" role="tabpanel">
                <div class="card">
                    <div class="table-responsive" data-toggle="lists">
                        <table class="table mb-0 thead-border-top-0 table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Curso</th>
                                    <th>Categoría</th>
                                    <th>Fecha Emisión</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($certificados_emitidos)): ?>
                                <?php foreach ($certificados_emitidos as $cert): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($cert['alumno'] ?? '') ?></strong>
                                            <div class="text-muted small"><i class="material-icons" style="font-size: 13px; vertical-align: middle;">badge</i> DNI/User: <?= htmlspecialchars($cert['usuario_dni'] ?? '') ?></div>
                                        </td>
                                        <td>
                                            <strong class="text-primary"><?= htmlspecialchars($cert['nombre_curso'] ?? '') ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info text-uppercase"><?= htmlspecialchars($cert['categoria'] ?? 'General') ?></span>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= date('d/m/Y h:i A', strtotime($cert['fecha_subida'])) ?></small>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?= BASE_URL ?>assets/certificados/<?= htmlspecialchars($cert['archivo_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Ver / Descargar Certificado">
                                                <i class="material-icons mr-1">picture_as_pdf</i> Ver PDF
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/ingenieria_inscripcion?id=<?= $cert['id_usuario'] ?>" class="btn btn-sm btn-outline-secondary" title="Gestionar Estudiante">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/certificado_delete?id=<?= $cert['id_certificado'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este certificado?');" title="Eliminar Certificado">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="material-icons d-block mb-2" style="font-size: 40px; color: #ccc;">verified</i>
                                        No se encontraron certificados emitidos.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 2: SOLICITUDES PENDIENTES -->
            <div class="tab-pane fade" id="pendientes" role="tabpanel">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table mb-0 thead-border-top-0 table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Curso Solicitado</th>
                                    <th>Categoría</th>
                                    <th class="text-right">Acción Requerida</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($solicitudes_pendientes)): ?>
                                <?php foreach ($solicitudes_pendientes as $sol): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($sol['alumno'] ?? '') ?></strong>
                                            <div class="text-muted small"><i class="material-icons" style="font-size: 13px; vertical-align: middle;">badge</i> DNI/User: <?= htmlspecialchars($sol['usuario_dni'] ?? '') ?></div>
                                        </td>
                                        <td>
                                            <strong class="text-warning"><?= htmlspecialchars($sol['nombre_curso'] ?? '') ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-warning text-uppercase"><?= htmlspecialchars($sol['categoria'] ?? 'General') ?></span>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?= BASE_URL ?>admin/generar_certificado_auto?id_usuario=<?= $sol['id_usuario'] ?>&id_curso=<?= $sol['id_curso'] ?>&alumno=<?= urlencode($sol['alumno'] ?? '') ?>&curso=<?= urlencode($sol['nombre_curso'] ?? '') ?>&categoria=<?= urlencode($sol['categoria'] ?? 'Ingeniería') ?>" class="btn btn-sm btn-success mr-1">
                                                <i class="material-icons mr-1" style="font-size: 16px;">auto_awesome</i> Auto-Generar PDF
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/ingenieria_inscripcion?id=<?= $sol['id_usuario'] ?>" class="btn btn-sm btn-primary">
                                                <i class="material-icons mr-1" style="font-size: 16px;">file_upload</i> Subir PDF
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="material-icons d-block mb-2" style="font-size: 40px; color: #28a745;">task_alt</i>
                                        ¡Excelente! No hay solicitudes de certificados pendientes.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Generar Nuevo Certificado -->
<div class="modal fade" id="modalNuevoCertificado" tabindex="-1" role="dialog" aria-labelledby="modalNuevoCertificadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalNuevoCertificadoLabel">Generar Nuevo Certificado</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASE_URL ?>admin/generar_certificado_auto" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_usuario">Seleccionar Alumno</label>
                        <select name="id_usuario" id="id_usuario" class="form-control" required>
                            <option value="">-- Buscar y seleccionar alumno --</option>
                            <?php foreach ($todos_usuarios as $usr): ?>
                                <option value="<?= $usr['iduser'] ?>">
                                    <?= htmlspecialchars($usr['nombre']) ?> (DNI: <?= htmlspecialchars($usr['dni'] ?: $usr['usuario']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="id_curso">Seleccionar Curso</label>
                        <select name="id_curso" id="id_curso" class="form-control" required>
                            <option value="">-- Buscar y seleccionar curso --</option>
                            <?php foreach ($todos_cursos as $cur): ?>
                                <option value="<?= $cur['id_curso'] ?>">
                                    <?= htmlspecialchars($cur['nombre_curso']) ?> [<?= htmlspecialchars($cur['categoria'] ?: 'General') ?>]
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="material-icons mr-1" style="font-size: 16px;">auto_awesome</i> Generar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mover el modal al final del body para evitar conflictos de z-index
    document.body.appendChild(document.getElementById('modalNuevoCertificado'));
    
    // Inicializar Select2 con el parent del modal para asegurar que el input de búsqueda funcione
    $('#id_usuario, #id_curso').select2({
        dropdownParent: $('#modalNuevoCertificado'),
        width: '100%'
    });
});
</script>
