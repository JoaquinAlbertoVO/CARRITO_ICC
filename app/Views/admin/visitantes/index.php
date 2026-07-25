<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
            <h1 class="m-lg-0">Visitantes / Ubicaciones Registradas</h1>
        </div>
    </div>

    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-12 card-form__body">
                    <div class="table-responsive border-bottom" data-toggle="lists">
                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                                <tr>
                                    <th>IP</th>
                                    <th>Pas</th>
                                    <th>Departamento / Regin</th>
                                    <th>Provincia / Ciudad</th>
                                    <th>Distrito</th>
                                    <th>Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  
                            if(!empty($visitantes)) {
                                foreach ($visitantes as $data) {
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($data['ip_address']); ?></td>
                                    <td><strong><?= htmlspecialchars($data['pais'] ?? 'Per'); ?></strong></td>
                                    <td><?= htmlspecialchars($data['departamento']); ?></td>
                                    <td><?= htmlspecialchars($data['provincia']); ?></td>
                                    <td><?= htmlspecialchars($data['distrito']); ?></td>
                                    <td><?= date('d/m/Y h:i A', strtotime($data['created_at'])); ?></td>
                                </tr>
                            <?php 
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay registros todava.</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
