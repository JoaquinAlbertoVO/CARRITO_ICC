<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center justify-content-between">
        <h1 class="m-0">Registrar Alumno</h1>
        <a href="<?= BASE_URL ?>admin/ingenieria" class="btn btn-outline-secondary btn-sm">
            <i class="material-icons mr-1" style="font-size: 1rem; vertical-align: middle;">arrow_back</i> Volver a lista
        </a>
    </div>
</div>

<div class="container-fluid page__container">
    <!-- Alertas -->
    <div><?php echo isset($alert) ? $alert : ''; ?></div>

    <form action="<?= BASE_URL ?>admin/ingenieria_registro" method="POST" enctype="multipart/form-data">
        
        <!-- SECCIÓN 1: Datos Personales -->
        <div class="card" style="border-radius: 10px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div class="card-header bg-white" style="border-bottom: 2px solid #5567FF;">
                <h5 class="m-0" style="color: #5567FF; font-weight: 600;">
                    <i class="material-icons mr-2" style="vertical-align: middle; font-size: 1.3rem;">person</i>
                    Datos Personales
                </h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="reg_nombre"><strong>Nombres y Apellidos completos</strong></label>
                        <input id="reg_nombre" type="text" name="nombre" class="form-control" placeholder="Ej: Juan Carlos Pérez García" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="reg_correo"><strong>Correo Electrónico</strong></label>
                        <input id="reg_correo" type="email" name="correo" class="form-control" placeholder="Ej: correo@ejemplo.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="reg_telefono"><strong>Teléfono</strong></label>
                        <input id="reg_telefono" type="text" name="telefono" class="form-control" placeholder="Ej: 987 654 321">
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="reg_dni"><strong>DNI</strong></label>
                        <input id="reg_dni" type="text" name="dni" class="form-control" placeholder="Ej: 12345678" maxlength="8">
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="reg_encargado"><strong>Encargado de Registro</strong></label>
                        <input id="reg_encargado" type="text" name="encargado" class="form-control" readonly value="<?= $_SESSION['nombre'] ?? 'Admin' ?>" style="background-color: #f8f9fa;">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 2: Información de Pago -->
        <div class="card" style="border-radius: 10px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div class="card-header bg-white" style="border-bottom: 2px solid #28a745;">
                <h5 class="m-0" style="color: #28a745; font-weight: 600;">
                    <i class="material-icons mr-2" style="vertical-align: middle; font-size: 1.3rem;">payment</i>
                    Información de Pago
                </h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-md-3 mb-3">
                        <label for="reg_nopera"><strong>Número de Operación</strong></label>
                        <input id="reg_nopera" type="text" name="nopera" class="form-control" placeholder="Ej: 00123456">
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="reg_mpagado"><strong>Monto Pagado</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="font-weight: 600;">S/</span>
                            </div>
                            <input id="reg_mpagado" type="number" step="0.01" name="mpagado" class="form-control" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="reg_banco"><strong>Banco</strong></label>
                        <select id="reg_banco" name="banco" class="form-control">
                            <option value="" selected>Seleccionar...</option>
                            <option>BCP</option>
                            <option>BanBif</option>
                            <option>Banco Pichincha</option>
                            <option>BBVA</option>
                            <option>Interbank</option>
                            <option>MiBanco</option>
                            <option>Scotiabank Perú</option>
                            <option>Yape</option>
                            <option>Plin</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="reg_fecha"><strong>Fecha de Depósito</strong></label>
                        <input id="reg_fecha" type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <!-- Subir Boucher -->
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label><strong>Comprobante de Pago (Boucher)</strong></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="reg_foto" name="foto" accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="reg_foto" id="file_label">Seleccionar archivo...</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3 text-center">
                        <img id="img_preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='100'%3E%3Crect width='120' height='100' fill='%23f0f0f0' rx='8'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='%23aaa' font-size='12'%3EVista previa%3C/text%3E%3C/svg%3E" 
                             alt="Vista previa" style="max-width: 180px; max-height: 140px; border-radius: 8px; border: 2px dashed #dee2e6; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3: Credenciales de Acceso -->
        <div class="card" style="border-radius: 10px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div class="card-header bg-white" style="border-bottom: 2px solid #fd7e14;">
                <h5 class="m-0" style="color: #fd7e14; font-weight: 600;">
                    <i class="material-icons mr-2" style="vertical-align: middle; font-size: 1.3rem;">vpn_key</i>
                    Credenciales de Acceso al Aula Virtual
                </h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="reg_usuario"><strong>Usuario</strong></label>
                        <input id="reg_usuario" type="text" name="usuario" class="form-control" placeholder="Ej: jperez" required>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="reg_pass"><strong>Contraseña</strong></label>
                        <div class="input-group">
                            <input id="reg_pass" type="text" name="pass" class="form-control" placeholder="Ej: 123456" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()" title="Generar contraseña aleatoria">
                                    <i class="material-icons" style="font-size: 1.1rem; vertical-align: middle;">autorenew</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 4: Cursos a Matricular -->
        <div class="card" style="border-radius: 10px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div class="card-header bg-white" style="border-bottom: 2px solid #6f42c1;">
                <h5 class="m-0" style="color: #6f42c1; font-weight: 600;">
                    <i class="material-icons mr-2" style="vertical-align: middle; font-size: 1.3rem;">school</i>
                    Seleccionar Cursos a Matricular
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Marca la casilla de los cursos en los que deseas matricular a este alumno.</p>
                <div class="row">
                    <?php if (!empty($cursos)): ?>
                        <?php foreach ($cursos as $curso): ?>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="custom-control custom-checkbox" style="padding: 12px 12px 12px 40px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef; transition: all 0.2s;">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="curso_<?= $curso['id_curso'] ?>" 
                                           name="cursos_matriculados[]" 
                                           value="<?= $curso['id_curso'] ?>">
                                    <label class="custom-control-label" for="curso_<?= $curso['id_curso'] ?>" style="cursor: pointer; width: 100%;">
                                        <strong><?= htmlspecialchars($curso['nombre_curso']) ?></strong>
                                        <br><small class="text-muted">
                                            Categoría: <?= ucfirst(htmlspecialchars($curso['categoria'])) ?> 
                                            &bull; <?= $curso['horas_academicas'] ?> hrs académicas
                                        </small>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-4">
                            <i class="material-icons text-muted" style="font-size: 2.5rem;">info_outline</i>
                            <p class="text-muted mt-2">No hay cursos registrados aún. <a href="<?= BASE_URL ?>admin/cursos_registro">Crear un curso</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- BOTÓN GUARDAR -->
        <div class="text-center mb-5">
            <button type="submit" class="btn btn-success btn-lg" style="font-size: 18px; padding: 12px 60px; border-radius: 8px; box-shadow: 0 4px 12px rgba(40,167,69,0.3);">
                <i class="material-icons mr-2" style="vertical-align: middle;">save</i> Guardar Alumno
            </button>
        </div>

    </form>
</div>

<script>
    // Vista previa de imagen del boucher
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('img_preview').src = e.target.result;
                document.getElementById('img_preview').style.border = '2px solid #28a745';
            };
            reader.readAsDataURL(input.files[0]);
            document.getElementById('file_label').textContent = input.files[0].name;
        }
    }

    // Generador de contraseña aleatoria
    function generatePassword() {
        var chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        var password = '';
        for (var i = 0; i < 8; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('reg_pass').value = password;
    }
</script>
