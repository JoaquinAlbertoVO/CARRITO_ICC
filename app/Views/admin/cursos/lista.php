<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
            <h1 class="m-lg-0">Gestión de Cursos (Para Certificados)</h1>
            <a href="<?= BASE_URL ?>admin/cursos_registro" class="btn btn-success ml-lg-3">Crear Nuevo Curso <i class="material-icons">add</i></a>
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
                                    <th>Categoría</th>
                                    <th>Nombre del Curso</th>
                                    <th>Horas</th>
                                    <th>Fecha Emisión</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  
                            if(!empty($cursos)) {
                                foreach ($cursos as $data) {
                            ?>
                                <tr>
                                    <td><span class="badge badge-primary text-uppercase"><?php echo $data["categoria"]; ?></span></td>
                                    <td><strong><?php echo $data["nombre_curso"]; ?></strong></td>
                                    <td><?php echo $data["horas_academicas"]; ?> Hrs</td>
                                    <td><?php echo $data["fecha_emision"]; ?></td>
                                    <td>
                                        <div class="dropdown ml-auto">
                                            <a href="<?= BASE_URL ?>admin/gestionar_videos?id=<?php echo $data["id_curso"]; ?>" class="btn btn-info btn-sm" title="Gestionar Videos"><i class="material-icons">play_circle_outline</i></a>
                                            <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="<?= BASE_URL ?>admin/cursos_editar?id=<?php echo $data["id_curso"]; ?>">Editar Curso</a>
                                                <a class="dropdown-item" href="<?= BASE_URL ?>admin/videos?curso=<?php echo $data["id_curso"]; ?>">
                                                    <i class="material-icons" style="font-size:14px;vertical-align:middle;">play_circle_outline</i> Gestionar Videos
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="<?= BASE_URL ?>admin/cursos_delete?id=<?php echo $data["id_curso"]; ?>">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No hay cursos registrados.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
