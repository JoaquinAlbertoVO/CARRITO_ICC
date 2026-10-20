<?php
$v = function ($k, $def = '') use ($viejo) { return htmlspecialchars($viejo[$k] ?? $def); };
$mod = $viejo['modalidad'] ?? 'Virtual';
?>
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-lg-left">
            <div>
                <h1 class="m-0"><i class="material-icons text-primary mr-2" style="font-size: 32px; vertical-align: middle;">note_add</i>Certificado suelto</h1>
                <p class="text-muted mb-0">Genera un certificado ICC con QR de verificación para un alumno que no está en el sistema (reemplazos, pedidos puntuales).</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>admin/certificado_masivo" class="btn btn-outline-primary mr-2">Certificados en lote</a>
                <a href="<?= BASE_URL ?>admin/certificados" class="btn btn-outline-primary">Volver a certificados</a>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?>">
                <?= htmlspecialchars($mensaje['texto']) ?>
                <?php if (!empty($mensaje['pdf'])): ?>
                    <div class="mt-2">
                        <a href="<?= htmlspecialchars($mensaje['pdf']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success mr-2" download>Descargar PDF</a>
                        <a href="<?= BASE_URL ?>verificar/<?= htmlspecialchars(rawurlencode($mensaje['codigo'])) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">Ver en la verificación</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">Datos del certificado</h4></div>
                    <div class="card-body">
                        <form method="post" action="<?= BASE_URL ?>admin/certificado_suelto_generar" id="formSuelto" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Nombre completo del alumno</label>
                                    <input type="text" name="alumno" class="form-control" required maxlength="200" value="<?= $v('alumno') ?>" placeholder="Juan Pérez García">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>DNI <span class="text-muted">(opcional)</span></label>
                                    <input type="text" name="dni" class="form-control" maxlength="20" value="<?= $v('dni') ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Curso <span class="text-muted">(elige uno de la lista o escribe otro)</span></label>
                                <input type="text" name="curso" id="sueltoCurso" class="form-control" list="listaCursos" required maxlength="200" value="<?= $v('curso') ?>" placeholder="Operación y Mantenimiento de Subestaciones Eléctricas">
                                <datalist id="listaCursos">
                                    <?php foreach ($cursos as $c): ?>
                                        <option value="<?= htmlspecialchars($c['nombre_curso']) ?>"
                                                data-horas="<?= htmlspecialchars(preg_replace('/\D/', '', (string) $c['horas_academicas'])) ?>"
                                                data-inicio="<?= htmlspecialchars((string) ($c['fecha_inicio'] ?? '')) ?>"
                                                data-fin="<?= htmlspecialchars((string) ($c['fecha_fin'] ?? '')) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Horas académicas</label>
                                    <input type="number" min="1" name="horas" id="sueltoHoras" class="form-control" required value="<?= $v('horas') ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Modalidad</label>
                                    <select name="modalidad" class="form-control">
                                        <option value="">(no mencionar)</option>
                                        <?php foreach (['Virtual', 'Presencial', 'Semipresencial'] as $m): ?>
                                            <option <?= $mod === $m ? 'selected' : '' ?>><?= $m ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Fecha de emisión</label>
                                    <input type="date" name="emision" class="form-control" required value="<?= $v('emision', date('Y-m-d')) ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Curso realizado del <span class="text-muted">(opcional)</span></label>
                                    <input type="date" name="inicio" id="sueltoInicio" class="form-control" value="<?= $v('inicio') ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>al <span class="text-muted">(vacío si fue un solo día)</span></label>
                                    <input type="date" name="fin" id="sueltoFin" class="form-control" value="<?= $v('fin') ?>">
                                </div>
                            </div>
                            <p class="text-muted small mt-n2">Sin fechas, el certificado sale sin la frase "realizado del ...".</p>

                            <div class="form-group">
                                <label>Código <span class="text-muted">(déjalo vacío para crear uno nuevo)</span></label>
                                <input type="text" name="codigo" id="sueltoCodigo" class="form-control" maxlength="60" value="<?= $v('codigo') ?>" placeholder="CERT-MSE-12345678">
                                <small class="form-text text-muted">Solo para <b>reemitir</b> un certificado que ya existe (mismo código, mismo QR). Si el código ya está en el registro, se actualizan sus datos.</small>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="material-icons mr-1" style="vertical-align: middle;">picture_as_pdf</i> Generar certificado</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-header"><h4 class="card-title mb-0">Últimos certificados sueltos</h4></div>
                    <?php if (empty($recientes)): ?>
                        <div class="card-body text-muted">Todavía no se generó ninguno desde esta pantalla.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead><tr><th>Alumno</th><th>Código</th><th></th></tr></thead>
                                <tbody>
                                <?php foreach ($recientes as $r): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($r['nombre']) ?><br><small class="text-muted"><?= htmlspecialchars($r['curso']) ?></small></td>
                                        <td><a href="<?= BASE_URL ?>verificar/<?= htmlspecialchars(rawurlencode($r['codigo'])) ?>" target="_blank" rel="noopener"><code><?= htmlspecialchars($r['codigo']) ?></code></a><?= $r['estado'] !== 'vigente' ? ' <span class="badge badge-danger">Anulado</span>' : '' ?></td>
                                        <td class="text-right"><a class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener" download href="<?= BASE_URL ?>assets/certificados/<?= htmlspecialchars(implode('/', array_map('rawurlencode', explode('/', $r['archivo_pdf'])))) ?>">PDF</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var curso = document.getElementById('sueltoCurso');
    var horas = document.getElementById('sueltoHoras');
    var inicio = document.getElementById('sueltoInicio');
    var fin = document.getElementById('sueltoFin');
    var codigo = document.getElementById('sueltoCodigo');

    // Al elegir un curso de la lista se completan horas y fechas (se pueden corregir a mano)
    curso.addEventListener('change', function () {
        var opciones = document.querySelectorAll('#listaCursos option');
        for (var i = 0; i < opciones.length; i++) {
            if (opciones[i].value === curso.value) {
                if (opciones[i].dataset.horas) horas.value = opciones[i].dataset.horas;
                var ini = opciones[i].dataset.inicio, f = opciones[i].dataset.fin;
                if (/^\d{4}-\d{2}-\d{2}/.test(ini || '')) inicio.value = ini.substr(0, 10);
                if (/^\d{4}-\d{2}-\d{2}/.test(f || '')) fin.value = f.substr(0, 10);
                break;
            }
        }
    });

    document.getElementById('formSuelto').addEventListener('submit', function (e) {
        if (codigo.value.trim() !== '' &&
            !confirm('Vas a reemitir con el código ' + codigo.value.trim().toUpperCase() + '. Si ya existe en el registro, sus datos se reemplazarán por los de este formulario. ¿Continuar?')) {
            e.preventDefault();
        }
    });
})();
</script>
