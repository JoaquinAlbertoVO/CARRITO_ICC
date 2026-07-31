<!--Start Page Header-->
<section class="page-header clearfix" style="background-color: var(--mo-surface); padding-top:120px; padding-bottom:60px; border-bottom:1px solid #eaeaea;">
    <div class="container">
        <div class="page-header__inner text-center">
            <h2 style="color: var(--mo-accent); font-family: var(--mo-font-heading);">Libro de Reclamaciones</h2>
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                <li class="active">Libro de Reclamaciones</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Header-->

<section class="contact-one" style="padding: 60px 0;">
    <div class="container" style="max-width: 800px; color: var(--mo-text-primary);">
        <?php if(isset($_SESSION['reclamo_exito'])): ?>
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin-bottom: 30px;">
                <h4 style="margin-top:0;">¡Reclamo Registrado Correctamente!</h4>
                <p>Su solicitud ha sido registrada bajo el código: <strong><?= $_SESSION['reclamo_exito']['codigo'] ?></strong></p>
                <p>Una copia de este reclamo ha sido enviada a su correo electrónico. Le contactaremos en el plazo legal establecido por Indecopi.</p>
            </div>
            <?php unset($_SESSION['reclamo_exito']); ?>
        <?php else: ?>
        <p style="margin-bottom: 30px; font-size: 16px;">Conforme a lo establecido en el Código de Protección y Defensa del Consumidor, esta institución cuenta con un Libro de Reclamaciones Virtual a tu disposición. Llena el siguiente formulario para registrar tu queja o reclamo.</p>
        
        <?php if(isset($_SESSION['reclamo_error'])): ?>
            <div class="alert alert-danger" style="color: red; margin-bottom: 20px;"><?= $_SESSION['reclamo_error'] ?></div>
            <?php unset($_SESSION['reclamo_error']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>legal/procesar_reclamo" method="POST" class="contact-one__form">
            <!-- HONEYPOT ANTI-SPAM -->
            <div style="display:none;">
                <label>Si eres humano, deja este campo en blanco:</label>
                <input type="text" name="telefono_falso" value="" tabindex="-1" autocomplete="off">
            </div>

            <h4 style="color: var(--mo-accent); margin-bottom:15px;">1. Datos del Consumidor</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" name="nombres" placeholder="Nombres completos *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="apellidos" placeholder="Apellidos completos *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
                <div class="col-md-4 mb-3">
                    <select name="tipo_documento" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                        <option value="">Tipo Doc. *</option>
                        <option value="DNI">DNI</option>
                        <option value="CE">Carnet de Extranjería</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>
                <div class="col-md-8 mb-3">
                    <input type="text" name="numero_documento" placeholder="Número de Documento *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
                <div class="col-md-12 mb-3">
                    <input type="text" name="direccion" placeholder="Dirección / Domicilio *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="telefono" placeholder="Teléfono / Celular *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="email" name="email" placeholder="Correo Electrónico *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
            </div>

            <h4 style="color: var(--mo-accent); margin-top:30px; margin-bottom:15px;">2. Detalle del Bien Contratado</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select name="tipo_bien" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                        <option value="">Identificación *</option>
                        <option value="Producto">Producto (Certificado Físico, etc)</option>
                        <option value="Servicio">Servicio (Curso Virtual)</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="number" step="0.01" name="monto_reclamado" placeholder="Monto Reclamado (Opcional)" class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
                <div class="col-md-12 mb-3">
                    <input type="text" name="descripcion_bien" placeholder="Descripción del Producto o Curso *" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                </div>
            </div>

            <h4 style="color: var(--mo-accent); margin-top:30px; margin-bottom:15px;">3. Detalle del Reclamo y Pedido</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select name="tipo_reclamo" required class="form-control" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;">
                        <option value="">Tipo *</option>
                        <option value="Reclamo">Reclamo (Disconformidad con el bien o servicio)</option>
                        <option value="Queja">Queja (Disconformidad ajena al bien o servicio)</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <textarea name="detalle_reclamo" placeholder="Detalle exactamente qué ocurrió *" required class="form-control" rows="4" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <textarea name="pedido" placeholder="Especifique lo que solicita (Ej. devolución, cambio) *" required class="form-control" rows="3" style="background:var(--mo-surface); color:#fff; border:1px solid #333; padding:15px; width:100%;"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <p style="font-size: 13px; color: #999;">Al enviar este formulario, usted declara que los datos consignados son verdaderos. La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.</p>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="thm-btn" style="padding: 15px 40px; cursor:pointer;">ENVIAR RECLAMO</button>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>
</section>
