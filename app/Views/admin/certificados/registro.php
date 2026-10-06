<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-lg-left">
            <div>
                <h1 class="m-0"><i class="material-icons text-primary mr-2" style="font-size: 32px; vertical-align: middle;">verified_user</i>Registro público de certificados</h1>
                <p class="text-muted mb-0">Lo que muestra la página <a href="<?= BASE_URL ?>verificar" target="_blank" rel="noopener"><?= BASE_URL ?>verificar</a> al escribir o escanear el código de un certificado.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>admin/certificados" class="btn btn-outline-primary">Volver a certificados</a>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?>"><?= htmlspecialchars($mensaje['texto']) ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">Certificados registrados</h4></div>
                    <div class="card-body">
                        <?php if (empty($resumen)): ?>
                            <p class="text-muted mb-0">Todavía no hay certificados en el registro. Los que se generen desde el panel se agregan solos; los de lotes anteriores se importan con el formulario.</p>
                        <?php else: ?>
                            <table class="table table-sm mb-0">
                                <thead><tr><th>Marca</th><th>Curso</th><th class="text-right">Certificados</th></tr></thead>
                                <tbody>
                                <?php foreach ($resumen as $fila): ?>
                                    <tr><td><?= $fila['marca'] === 'ST' ? 'ST Energy' : 'ICC' ?></td><td><?= htmlspecialchars($fila['curso']) ?></td><td class="text-right"><?= (int) $fila['total'] ?></td></tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">Importar un lote ya emitido</h4></div>
                    <div class="card-body">
                        <p class="text-muted small">Sube el archivo <code>_resumen.csv</code> que dejó el script de certificados (columnas Nombre, DNI, Codigo, Archivo, URL_QR). Si un código ya existe, se actualiza (no se duplica).</p>
                        <form method="post" enctype="multipart/form-data" action="<?= BASE_URL ?>admin/registro_certificados_importar">
                            <div class="form-group">
                                <label>Marca que emitió el certificado</label>
                                <select name="marca" class="form-control">
                                    <option value="ICC">ICC (verifica en icc.com.pe/verificar)</option>
                                    <option value="ST">ST Energy (verifica en verifica.stenergyedu.com)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nombre del curso (como figura en el certificado)</label>
                                <input type="text" name="curso" class="form-control" required placeholder="Operación y Mantenimiento de Subestaciones Eléctricas">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Horas académicas</label>
                                    <input type="text" name="horas" class="form-control" placeholder="16">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Fecha de emisión</label>
                                    <input type="text" name="emision" class="form-control" placeholder="4 de Octubre del 2026">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Periodo en que se dictó</label>
                                <input type="text" name="periodo" class="form-control" placeholder="Realizado del 28 de septiembre al 2 de octubre del 2026">
                            </div>
                            <div class="form-group">
                                <label>Modalidad <span class="text-muted">(solo si el certificado dice "en modalidad virtual")</span></label>
                                <input type="text" name="modalidad" class="form-control" placeholder="Virtual">
                            </div>
                            <div class="form-group">
                                <label>Archivo _resumen.csv</label>
                                <input type="file" name="csv" accept=".csv" class="form-control-file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Importar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="card-title mb-0"><?= $q !== '' ? 'Resultados de la búsqueda' : 'Últimos certificados registrados' ?></h4>
                <form method="get" action="<?= BASE_URL ?>admin/registro_certificados" class="form-inline mt-2 mt-md-0">
                    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" class="form-control form-control-sm mr-2" placeholder="Código, nombre, DNI o curso" style="min-width: 260px;">
                    <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                    <?php if ($q !== ''): ?><a href="<?= BASE_URL ?>admin/registro_certificados" class="btn btn-sm btn-link">Quitar filtro</a><?php endif; ?>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr><th>Código</th><th>Marca</th><th>Alumno</th><th>Curso</th><th>Emisión</th><th>Estado</th><th class="text-right">Acción</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($filas)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">No hay certificados<?= $q !== '' ? ' que coincidan con la búsqueda' : ' registrados todavía' ?>.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($filas as $f): $anulado = $f['estado'] !== 'vigente'; ?>
                        <tr>
                            <td><a href="<?= BASE_URL ?>verificar/<?= htmlspecialchars(rawurlencode($f['codigo'])) ?>" target="_blank" rel="noopener"><code><?= htmlspecialchars($f['codigo']) ?></code></a></td>
                            <td><?= $f['marca'] === 'ST' ? 'ST Energy' : 'ICC' ?></td>
                            <td><?= htmlspecialchars($f['nombre']) ?><?= !empty($f['dni']) ? '<br><small class="text-muted">DNI ' . htmlspecialchars($f['dni']) . '</small>' : '' ?></td>
                            <td><?= htmlspecialchars($f['curso']) ?></td>
                            <td><?= htmlspecialchars((string) $f['fecha_emision']) ?></td>
                            <td><span class="badge badge-<?= $anulado ? 'danger' : 'success' ?>"><?= $anulado ? 'Anulado' : 'Vigente' ?></span></td>
                            <td class="text-right">
                                <form method="post" action="<?= BASE_URL ?>admin/registro_certificados_estado" class="d-inline"
                                      onsubmit="return confirm('<?= $anulado ? '¿Reactivar este certificado? Volverá a mostrarse como válido.' : '¿Anular este certificado? La página pública pasará a mostrarlo como anulado.' ?>');">
                                    <input type="hidden" name="id" value="<?= (int) $f['id'] ?>">
                                    <input type="hidden" name="accion" value="<?= $anulado ? 'reactivar' : 'anular' ?>">
                                    <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
                                    <button type="submit" class="btn btn-sm <?= $anulado ? 'btn-outline-success' : 'btn-outline-danger' ?>"><?= $anulado ? 'Reactivar' : 'Anular' ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted small">Se muestran hasta 50 resultados; usa el buscador para encontrar uno concreto.</div>
        </div>
    </div>
</div>
