<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
        <h1 class="m-lg-0"><?= $titulo ?> - Estudiantes</h1>
        <a href="<?= BASE_URL . $ruta_editar ?>" class="btn btn-success ml-lg-3">Nuevo Estudiante <i class="material-icons">add</i></a>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="card card-form">
        <div class="row no-gutters">
            <div class="col-lg-12 card-form__body">
                <div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
                    <form action="<?= BASE_URL . $ruta_lista ?>" method="GET">
                        <div class="search-form search-form--light m-3">
                            <input type="text" class="form-control search" name="busqueda" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar estudiante...">
                            <button class="btn" type="submit" role="button"><i class="material-icons">search</i></button>
                        </div>
                    </form>

                    <table class="table mb-0 thead-border-top-0">
                        <thead>
                            <tr>
                                <th>Nombres Completos</th>
                                <th style="width: 37px;">Usuario</th>
                                <th style="width: 120px;">ContraseÃ±a</th>
                                <th style="width: 120px;">Monto Pagado</th>
                                <th style="width: 24px;"></th>
                            </tr>
                        </thead>
                        <?php if (count($estudiantes) > 0): ?>
                            <?php foreach ($estudiantes as $data): ?>
                                <tbody class="list" id="staff02">
                                    <tr class="<?= $data['iduser'] ?>">
                                        <td>
                                            <span class="js-lists-values-employee-name"><?= htmlspecialchars($data["nombre"]) ?></span>
                                        </td>
                                        <td><span><?= htmlspecialchars($data["usuario"]) ?></span></td>
                                        <td><small class="text-muted"><?= htmlspecialchars($data["password"]) ?></small></td>
                                        <td>S/ <?= htmlspecialchars($data["m_pagado"]) ?></td>
                                        <td>
                                            <div class="dropdown ml-auto">
                                                <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?= BASE_URL . $ruta_editar ?>?id=<?= $data["iduser"] ?>">Editar</a>
                                                    <?php if (($_SESSION['rol'] ?? 1) == 1): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger lista__delete" href="<?= BASE_URL . $ruta_eliminar ?>?id=<?= $data["iduser"] ?>">Eliminar</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tbody><tr><td colspan="5" class="text-center">No hay registros</td></tr></tbody>
                        <?php endif; ?>
                    </table>

                    <div class="card">
                        <div class="card-body">
                            <div class="pagination-rounded">
                                <ul class="pagination">
                                    <?php if ($pagina != 1): ?>
                                        <li class="page-item"><a class="page-link" href="?pagina=1&busqueda=<?= urlencode($busqueda) ?>" aria-label="First"><i class="material-icons">first_page</i></a></li>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina - 1 ?>&busqueda=<?= urlencode($busqueda) ?>" aria-label="Previous"><i class="material-icons">chevron_left</i></a></li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                        <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                                            <a class="page-link" href="?pagina=<?= $i ?>&busqueda=<?= urlencode($busqueda) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($pagina != $total_paginas && $total_paginas > 0): ?>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina + 1 ?>&busqueda=<?= urlencode($busqueda) ?>" aria-label="Next"><i class="material-icons">chevron_right</i></a></li>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?= $total_paginas ?>&busqueda=<?= urlencode($busqueda) ?>" aria-label="Last"><i class="material-icons">last_page</i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>