<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-lg-left">
            <div>
                <h1 class="m-0"><i class="material-icons text-primary mr-2" style="font-size: 32px; vertical-align: middle;">library_add</i>Certificados en lote</h1>
                <p class="text-muted mb-0">Pega o sube la lista de alumnos de un curso: se generan todos los PDF con QR, se registran en la verificación y descargas un ZIP.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= BASE_URL ?>admin/certificado_suelto" class="btn btn-outline-primary mr-2">Certificado suelto</a>
                <a href="<?= BASE_URL ?>admin/certificados" class="btn btn-outline-primary">Volver a certificados</a>
            </div>
        </div>
    </div>

    <div class="container-fluid page__container">
        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">1. Datos del curso <span class="text-muted font-weight-normal">(iguales para todos los alumnos)</span></h4></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Curso <span class="text-muted">(elige uno de la lista o escribe otro)</span></label>
                    <input type="text" id="mCurso" class="form-control" list="listaCursos" maxlength="200" autocomplete="off" placeholder="Operación y Mantenimiento de Subestaciones Eléctricas">
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
                    <div class="form-group col-md-3">
                        <label>Horas académicas</label>
                        <input type="number" min="1" id="mHoras" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Modalidad</label>
                        <select id="mModalidad" class="form-control">
                            <option value="">(no mencionar)</option>
                            <option selected>Virtual</option>
                            <option>Presencial</option>
                            <option>Semipresencial</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Realizado del <span class="text-muted">(opcional)</span></label>
                        <input type="date" id="mInicio" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>al</label>
                        <input type="date" id="mFin" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Fecha de emisión</label>
                        <input type="date" id="mEmision" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Código de cada certificado</label>
                        <select id="mTipoCodigo" class="form-control">
                            <option value="aleatorio">Aleatorio, no deducible del DNI (recomendado)</option>
                            <option value="dni">CERT-&lt;SIGLA&gt;-&lt;DNI&gt;, como los lotes antiguos</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3" id="mSiglaBox" style="display:none;">
                        <label>Sigla del curso</label>
                        <input type="text" id="mSigla" class="form-control" maxlength="12" placeholder="MSE">
                    </div>
                </div>
                <small class="text-muted">Sin fechas "realizado del…", el certificado sale sin esa frase. Quien ya tenga certificado de este curso y fecha de emisión conserva su código (repetir un lote no crea códigos nuevos).</small>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h4 class="card-title mb-0">2. Lista de alumnos</h4></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Pega las celdas desde Excel <span class="text-muted">(columnas: Nombre y DNI; el DNI es opcional)</span></label>
                    <textarea id="mLista" class="form-control" rows="6" placeholder="Juan Pérez García&#9;12345678&#10;María López Ríos&#9;87654321"></textarea>
                </div>
                <div class="form-group">
                    <label>…o sube un archivo .csv <span class="text-muted">(en Excel: Guardar como → CSV)</span></label>
                    <input type="file" id="mArchivo" accept=".csv,.txt" class="form-control-file">
                </div>
                <p class="text-muted small mb-2">Se reconocen los encabezados <code>Nombre</code>/<code>Nombres</code>/<code>Apellidos</code>, <code>DNI</code> y <code>Codigo</code> (este último para reemitir con el mismo código). Sin encabezado, el número de 6 a 12 dígitos es el DNI y el texto es el nombre. Máximo <?= (int) $max_filas ?> por lote.</p>
                <button type="button" class="btn btn-primary" id="mRevisar">Revisar lista</button>
            </div>
        </div>

        <div class="card mb-4" id="mPaso3" style="display:none;">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="card-title mb-0">3. Revisión y generación</h4>
                <span id="mResumenFiltro" class="text-muted small"></span>
            </div>
            <div class="table-responsive" style="max-height: 460px; overflow-y: auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th style="width:36px;"><input type="checkbox" id="mTodos" checked></th><th style="width:44px;">#</th><th>Nombre</th><th style="width:150px;">DNI</th><th>Estado</th></tr></thead>
                    <tbody id="mCuerpo"></tbody>
                </table>
            </div>
            <div class="card-body border-top">
                <div class="progress mb-2" style="height: 18px; display:none;" id="mProgresoBox">
                    <div class="progress-bar bg-success" id="mProgreso" role="progressbar" style="width:0%">0%</div>
                </div>
                <div id="mMensaje" class="mb-2"></div>
                <button type="button" class="btn btn-success" id="mGenerar"><i class="material-icons mr-1" style="vertical-align: middle;">picture_as_pdf</i> <span>Generar certificados</span></button>
                <a href="#" class="btn btn-outline-primary ml-2" id="mZip" style="display:none;"><i class="material-icons mr-1" style="vertical-align: middle;">archive</i> Descargar ZIP</a>
                <button type="button" class="btn btn-link ml-2" id="mNuevo" style="display:none;">Nuevo lote</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var URL_FILA = '<?= BASE_URL ?>admin/certificado_masivo_fila';
    var URL_ZIP = '<?= BASE_URL ?>admin/certificado_masivo_zip?lote=<?= htmlspecialchars($lote) ?>';
    var LOTE = '<?= htmlspecialchars($lote) ?>';
    var MAX = <?= (int) $max_filas ?>;

    var $ = function (id) { return document.getElementById(id); };
    var curso = $('mCurso'), horas = $('mHoras'), inicio = $('mInicio'), fin = $('mFin'), sigla = $('mSigla');
    var tipo = $('mTipoCodigo'), cuerpo = $('mCuerpo');
    var filas = [];          // {nombre, dni, codigo, incluir, estado, ...}
    var siglaTocada = false;
    var ocupado = false;

    // ---------- Datos del curso ----------
    function siglaSugerida(nombre) {
        return nombre.split(/\s+/).filter(function (w) { return w.length > 3; })
            .map(function (w) { return w.charAt(0); }).join('').toUpperCase()
            .normalize('NFD').replace(/[^A-Z0-9]/g, '').substr(0, 8);
    }
    curso.addEventListener('change', function () {
        var op = document.querySelectorAll('#listaCursos option');
        for (var i = 0; i < op.length; i++) {
            if (op[i].value === curso.value) {
                if (op[i].dataset.horas) horas.value = op[i].dataset.horas;
                var a = op[i].dataset.inicio || '', b = op[i].dataset.fin || '';
                if (/^\d{4}-\d{2}-\d{2}/.test(a)) inicio.value = a.substr(0, 10);
                if (/^\d{4}-\d{2}-\d{2}/.test(b)) fin.value = b.substr(0, 10);
                break;
            }
        }
        if (!siglaTocada) sigla.value = siglaSugerida(curso.value);
    });
    sigla.addEventListener('input', function () { siglaTocada = true; });
    tipo.addEventListener('change', function () { $('mSiglaBox').style.display = tipo.value === 'dni' ? '' : 'none'; });

    // ---------- Lectura de la lista ----------
    function sinTildes(s) { return s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase().trim(); }

    function partirLinea(linea, sep) {   // CSV con comillas
        var out = [], cur = '', q = false;
        for (var i = 0; i < linea.length; i++) {
            var ch = linea.charAt(i);
            if (q) {
                if (ch === '"') { if (linea.charAt(i + 1) === '"') { cur += '"'; i++; } else { q = false; } } else { cur += ch; }
            } else if (ch === '"') { q = true; }
            else if (ch === sep) { out.push(cur); cur = ''; }
            else { cur += ch; }
        }
        out.push(cur);
        return out.map(function (s) { return s.trim(); });
    }

    function leerLista(texto) {
        texto = texto.replace(/^﻿/, '');
        var lineas = texto.split(/\r\n|\r|\n/).filter(function (l) { return l.trim() !== ''; });
        if (!lineas.length) return [];
        var p = lineas[0];
        var tabs = (p.match(/\t/g) || []).length, pv = (p.match(/;/g) || []).length, cm = (p.match(/,/g) || []).length;
        var sep = tabs > 0 ? '\t' : (pv > 0 && pv >= cm ? ';' : ',');
        var celdas = lineas.map(function (l) { return partirLinea(l, sep); });

        // Encabezado: alguna celda de la primera fila es "nombre(s)", "apellidos", "alumno"...
        var iN = -1, iA = -1, iD = -1, iC = -1;
        celdas[0].forEach(function (c, i) {
            var k = sinTildes(c);
            if (/^(nombres?|alumno|alumna|estudiante|participante|nombre completo|nombres y apellidos|apellidos y nombres)$/.test(k) && iN < 0) iN = i;
            else if (/^apellidos?$/.test(k) && iA < 0) iA = i;
            else if (/^(dni|documento|doc|n° ?dni|nro\.? ?dni|dni\/ce|n° documento|numero de documento|nro\.? documento)$/.test(k) && iD < 0) iD = i;
            else if (/^codigo$/.test(k) && iC < 0) iC = i;
        });
        var conEncabezado = iN >= 0 || iA >= 0;
        var datos = conEncabezado ? celdas.slice(1) : celdas;
        var out = [];
        datos.forEach(function (c) {
            var nombre = '', dni = '', codigo = '';
            if (conEncabezado) {
                var n = iN >= 0 ? (c[iN] || '') : '', a = iA >= 0 ? (c[iA] || '') : '';
                dni = iD >= 0 ? (c[iD] || '') : '';
                // Un número en la columna de nombre/apellidos es el DNI mal ubicado
                [n, a] = [n, a].map(function (v) {
                    if (/^[0-9][0-9.\s]{5,13}$/.test(v)) { if (!dni) dni = v; return ''; }
                    return v;
                });
                nombre = (iN >= 0 && iA >= 0 && iN !== iA) ? (n + ' ' + a) : (n || a);
                codigo = iC >= 0 ? (c[iC] || '') : '';
            } else {
                var textos = [];
                c.forEach(function (v) {
                    if (v === '') return;
                    if (!dni && /^[0-9][0-9.\s]{5,13}$/.test(v)) dni = v;
                    else if (!codigo && /^CERT-/i.test(v)) codigo = v;
                    else textos.push(v);
                });
                nombre = textos.join(' ');
            }
            nombre = nombre.replace(/\s+/g, ' ').trim();
            if (nombre === '' && dni.trim() === '') return;
            out.push({ nombre: nombre, dni: dni.trim(), codigo: codigo.trim().toUpperCase() });
        });
        return out;
    }

    // ---------- Filtros / validacion ----------
    function normalizarDni(v) {
        var s = String(v).trim().replace(/\.0+$/, '').replace(/[\s.]/g, '');
        var nota = '';
        if (/^\d{7}$/.test(s)) { s = '0' + s; nota = 'DNI completado con un 0 inicial (Excel lo suele quitar)'; }
        return { valor: s, nota: nota };
    }

    function evaluar() {
        var vistos = {};
        filas.forEach(function (f) {
            var d = normalizarDni(f.dni);
            f.dni = d.valor;
            f.err = ''; f.aviso = d.nota; f.dup = false;
            if (!/[A-Za-zÁÉÍÓÚÑáéíóúñ]/.test(f.nombre) || f.nombre.length < 3) f.err = 'Falta el nombre';
            else if (f.dni !== '' && !/^[A-Za-z0-9-]{1,20}$/.test(f.dni)) f.err = 'DNI no válido (solo letras, números y guiones)';
            else if (f.codigo !== '' && !/^[A-Z0-9-]{6,60}$/.test(f.codigo)) f.err = 'Código no válido';
            if (!f.err) {
                if (f.dni !== '' && /^\d+$/.test(f.dni) && f.dni.length !== 8 && f.dni.length !== 9) {
                    f.aviso += (f.aviso ? ' · ' : '') + 'DNI de ' + f.dni.length + ' dígitos: revísalo';
                }
                if (f.nombre.split(' ').length < 2) f.aviso += (f.aviso ? ' · ' : '') + 'Solo una palabra en el nombre';
                var clave = f.dni !== '' ? 'd:' + f.dni.toUpperCase() : 'n:' + sinTildes(f.nombre);
                if (vistos[clave]) { f.dup = true; } else { vistos[clave] = true; }
            }
        });
    }

    function textoEstado(f) {
        if (f.estado === 'generando') return ['Generando…', 'text-info'];
        if (f.estado === 'ok') return ['✔ ' + f.cod + (f.previo ? ' (código existente actualizado)' : ''), 'text-success'];
        if (f.estado === 'error') return ['✖ ' + f.msg, 'text-danger'];
        if (f.err) return [f.err, 'text-danger'];
        if (f.dup) return ['Repetido en la lista (se omite)', 'text-warning'];
        if (f.aviso) return [f.aviso, 'text-warning'];
        return ['Listo', 'text-muted'];
    }

    function actualizarEstados() {
        var inc = 0, errs = 0, dups = 0, avisos = 0;
        filas.forEach(function (f) {
            var t = textoEstado(f);
            f.celdaEstado.className = t[1];
            f.celdaEstado.textContent = '';
            if (f.estado === 'ok') {
                var a = document.createElement('a');
                a.href = f.pdf; a.target = '_blank'; a.rel = 'noopener'; a.textContent = t[0];
                a.className = t[1];
                f.celdaEstado.appendChild(a);
            } else {
                f.celdaEstado.textContent = t[0];
            }
            f.check.disabled = !!f.err || ocupado || f.estado === 'ok';
            if (f.err) f.check.checked = false;
            f.incluir = f.check.checked;
            if (f.incluir) inc++;
            if (f.err) errs++; else if (f.dup) dups++; else if (f.aviso) avisos++;
        });
        $('mResumenFiltro').textContent = filas.length + ' filas · ' + inc + ' a generar' +
            (errs ? ' · ' + errs + ' con error' : '') + (dups ? ' · ' + dups + ' repetidas' : '') + (avisos ? ' · ' + avisos + ' con aviso' : '');
        $('mGenerar').disabled = ocupado || inc === 0;
        $('mGenerar').querySelector('span').textContent = 'Generar ' + (inc || '') + ' certificado' + (inc === 1 ? '' : 's');
    }

    function dibujarTabla() {
        cuerpo.innerHTML = '';
        filas.forEach(function (f, i) {
            var tr = document.createElement('tr');
            var c1 = document.createElement('td'), chk = document.createElement('input');
            chk.type = 'checkbox'; chk.addEventListener('change', actualizarEstados);
            c1.appendChild(chk);
            var c2 = document.createElement('td'); c2.textContent = i + 1; c2.className = 'text-muted';
            var c3 = document.createElement('td'), inN = document.createElement('input');
            inN.type = 'text'; inN.className = 'form-control form-control-sm'; inN.value = f.nombre; inN.maxLength = 200;
            c3.appendChild(inN);
            var c4 = document.createElement('td'), inD = document.createElement('input');
            inD.type = 'text'; inD.className = 'form-control form-control-sm'; inD.value = f.dni; inD.maxLength = 20;
            c4.appendChild(inD);
            var c5 = document.createElement('td');
            [c1, c2, c3, c4, c5].forEach(function (c) { tr.appendChild(c); });
            cuerpo.appendChild(tr);
            f.check = chk; f.celdaEstado = c5; f.estado = 'pendiente';
            var alEditar = function () {
                f.nombre = inN.value.replace(/\s+/g, ' ').trim(); f.dni = inD.value;
                evaluar();
                if (!f.err && !chk.checked && !f.dup) chk.checked = true;   // corregida: se vuelve a incluir
                filas.forEach(function (g) { if (g.dup) g.check.checked = false; });
                actualizarEstados();
            };
            inN.addEventListener('input', alEditar);
            inD.addEventListener('input', alEditar);
            inD.addEventListener('blur', function () { inD.value = f.dni; });
            f.inN = inN; f.inD = inD;
        });
        evaluar();
        filas.forEach(function (f) { f.inD.value = f.dni; f.check.checked = !f.err && !f.dup; });   // el DNI ya corregido se ve en la casilla
        actualizarEstados();
    }

    // ---------- Revisar ----------
    function revisar(texto) {
        var lista = leerLista(texto);
        if (!lista.length) { alert('No se encontró ningún alumno en la lista.'); return; }
        if (lista.length > MAX) {
            alert('La lista tiene ' + lista.length + ' filas y el máximo por lote es ' + MAX + '. Divídela en partes.');
            return;
        }
        filas = lista;
        $('mPaso3').style.display = '';
        $('mMensaje').innerHTML = '';
        $('mZip').style.display = 'none';
        dibujarTabla();
        $('mPaso3').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    $('mRevisar').addEventListener('click', function () { revisar($('mLista').value); });

    $('mArchivo').addEventListener('change', function () {
        var f = this.files[0];
        if (!f) return;
        if (/\.xlsx?$/i.test(f.name)) {
            alert('Los archivos de Excel (.xlsx) no se leen directo: en Excel usa Guardar como → CSV, o copia las celdas y pégalas en el cuadro de arriba.');
            this.value = '';
            return;
        }
        var lector = new FileReader();
        lector.onload = function () {
            var buf = lector.result, txt;
            try { txt = new TextDecoder('utf-8', { fatal: true }).decode(buf); }
            catch (e) { txt = new TextDecoder('windows-1252').decode(buf); }   // CSV de Excel en Windows
            $('mLista').value = txt;
            revisar(txt);
        };
        lector.readAsArrayBuffer(f);
    });

    $('mTodos').addEventListener('change', function () {
        var v = this.checked;
        filas.forEach(function (f) { if (!f.err && !f.dup && f.estado !== 'ok') f.check.checked = v; });
        actualizarEstados();
    });

    // ---------- Generacion (una fila por peticion, con progreso) ----------
    function bloquearCurso(b) {
        ['mCurso', 'mHoras', 'mModalidad', 'mInicio', 'mFin', 'mEmision', 'mTipoCodigo', 'mSigla', 'mLista', 'mArchivo', 'mRevisar'].forEach(function (id) { $(id).disabled = b; });
        filas.forEach(function (f) { f.inN.disabled = b || f.estado === 'ok'; f.inD.disabled = b || f.estado === 'ok'; });
    }

    function avanceTotal() {
        var total = filas.filter(function (f) { return f.incluir || f.estado === 'ok'; }).length;
        var hechas = filas.filter(function (f) { return f.estado === 'ok' || f.estado === 'error'; }).length;
        var pct = total ? Math.round(hechas * 100 / total) : 0;
        $('mProgreso').style.width = pct + '%';
        $('mProgreso').textContent = hechas + ' / ' + total + ' (' + pct + '%)';
    }

    $('mGenerar').addEventListener('click', async function () {
        if (ocupado) return;
        if (curso.value.trim() === '' || horas.value.trim() === '' || !$('mEmision').value) {
            alert('Completa el curso, las horas y la fecha de emisión.');
            return;
        }
        if (tipo.value === 'dni' && sigla.value.trim() === '') {
            alert('Escribe la sigla del curso para armar los códigos CERT-<SIGLA>-<DNI>.');
            return;
        }
        var pendientes = filas.filter(function (f) { return f.incluir && f.estado !== 'ok'; });
        if (!pendientes.length) return;
        if (!confirm('Se generarán ' + pendientes.length + ' certificados de "' + curso.value.trim() + '" y se registrarán en la verificación pública. ¿Continuar?')) return;

        ocupado = true;
        bloquearCurso(true);
        $('mProgresoBox').style.display = '';
        $('mMensaje').textContent = '';
        $('mGenerar').disabled = true;
        var avisar = function (e) { e.preventDefault(); e.returnValue = ''; };
        window.addEventListener('beforeunload', avisar);

        var sesionVencida = false;
        for (var i = 0; i < pendientes.length && !sesionVencida; i++) {
            var f = pendientes[i];
            f.estado = 'generando'; actualizarEstados();
            var fd = new FormData();
            fd.append('lote', LOTE);
            fd.append('alumno', f.nombre); fd.append('dni', f.dni); fd.append('codigo', f.codigo);
            fd.append('curso', curso.value.trim()); fd.append('horas', horas.value.trim());
            fd.append('modalidad', $('mModalidad').value);
            fd.append('inicio', inicio.value); fd.append('fin', fin.value); fd.append('emision', $('mEmision').value);
            fd.append('tipo_codigo', tipo.value); fd.append('sigla', sigla.value.trim());
            try {
                var res = await fetch(URL_FILA, { method: 'POST', body: fd, credentials: 'same-origin' });
                if (res.status === 403) { sesionVencida = true; throw new Error('Sesión vencida: vuelve a entrar al panel y reintenta.'); }
                var j = await res.json();
                if (j.ok) { f.estado = 'ok'; f.cod = j.codigo; f.pdf = j.pdf; f.previo = j.previo; }
                else { f.estado = 'error'; f.msg = j.error || 'Error desconocido'; }
            } catch (e) {
                f.estado = 'error'; f.msg = e.message || 'Error de conexión';
            }
            avanceTotal();
            actualizarEstados();
        }

        window.removeEventListener('beforeunload', avisar);
        ocupado = false;
        var ok = filas.filter(function (f) { return f.estado === 'ok'; }).length;
        var mal = filas.filter(function (f) { return f.estado === 'error'; }).length;
        // Las filas con error vuelven a quedar pendientes para reintentar (el curso sigue bloqueado: es el mismo lote)
        filas.forEach(function (f) { if (f.estado === 'error') { f.check.checked = true; } });
        bloquearCurso(true);
        filas.forEach(function (f) { if (f.estado === 'error') { f.inN.disabled = false; f.inD.disabled = false; } });
        actualizarEstados();
        var m = $('mMensaje');
        m.className = 'alert alert-' + (mal ? 'warning' : 'success') + ' mb-2';
        m.textContent = ok + ' certificado' + (ok === 1 ? '' : 's') + ' generado' + (ok === 1 ? '' : 's') + ' y registrado' + (ok === 1 ? '' : 's') + ' en la verificación.' +
            (mal ? ' ' + mal + ' con error: corrígelos y pulsa de nuevo "Generar" para reintentar solo esos.' : '');
        if (ok > 0) { $('mZip').href = URL_ZIP; $('mZip').style.display = ''; $('mNuevo').style.display = ''; }
        if (mal) $('mGenerar').disabled = false;
    });

    $('mNuevo').addEventListener('click', function () { location.reload(); });
    tipo.dispatchEvent(new Event('change'));
})();
</script>
