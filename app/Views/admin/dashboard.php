<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
        <h1 class="m-lg-0">Administrador Dashboard</h1>
    </div>
</div>

<div class="container-fluid page__container">
    <h3 class="m-lg-0"><strong>ICC - Ingenieria</strong></h3><br>
    <div class="row card-group-row">
        <!-- Mes Actual -->
        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Mes actual</div>
                    <div class="text-amount">S/ <?= number_format($total_mes_ingenieria, 2) ?></div>
                </div>
                <div class="avatar">
                    <span class="bg-soft-success avatar-title rounded-circle text-center text-success">
                        <i class="material-icons icon-40pt">gps_fixed</i>
                    </span>
                </div>
            </div>
        </div>
        <!-- Total General -->
        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Total</div>
                    <div class="text-amount">S/ <?= number_format($total_general_ingenieria, 2) ?></div>
                </div>
                <div class="avatar">
                    <span class="bg-soft-primary avatar-title rounded-circle text-center text-primary">
                        <i class="material-icons icon-40pt">attach_money</i>
                    </span>
                </div>
            </div>
        </div>
        <!-- Estudiantes -->
        <div class="col-lg-4 col-md-12 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Estudiantes</div>
                    <div class="text-amount"><?= $estudiantes_ingenieria ?></div>
                </div>
                <div class="avatar">
                    <span class="bg-soft-warning avatar-title rounded-circle text-center text-warning">
                        <i class="material-icons text-warning icon-40pt">perm_identity</i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4 class="card-title mb-0"><i class="material-icons mr-1" style="vertical-align: middle;">notifications_active</i> Solicitudes de Certificados Pendientes</h4>
                </div>
                <div class="card-body p-0">
                    <?php if(!empty($solicitudes_certificados)): ?>
                    <div class="table-responsive">
                        <table class="table mb-0 thead-border-top-0 table-nowrap">
                            <thead>
                                <tr>
                                    <th>Alumno</th>
                                    <th>Curso</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php foreach($solicitudes_certificados as $solicitud): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($solicitud['alumno']) ?></strong></td>
                                    <td><?= htmlspecialchars($solicitud['nombre_curso']) ?></td>
                                    <td class="text-center">
                                        <a href="<?= BASE_URL ?>admin/ingenieria_inscripcion?id=<?= $solicitud['id_usuario'] ?>" class="btn btn-sm btn-success">Subir Certificado</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="p-4 text-center text-muted">
                        No hay solicitudes pendientes en este momento.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>