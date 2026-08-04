<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center justify-content-between">
            <h1 class="m-0">Actualizar Curso</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div><?php echo isset($alert) ? $alert : ''; ?></div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <input type="hidden" name="id_curso" value="<?php echo $data['id_curso']; ?>">
                            <input type="hidden" name="foto_actual" value="<?php echo $data['foto'] ?? 'default.png'; ?>">
                            
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Nombre del Curso</label>
                                    <input type="text" name="nombre_curso" class="form-control" value="<?php echo $data['nombre_curso']; ?>" required>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Horas Académicas</label>
                                    <input type="number" name="horas_academicas" class="form-control" value="<?php echo $data['horas_academicas']; ?>">
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Fecha de Emisión</label>
                                    <input type="date" name="fecha_emision" class="form-control" value="<?php echo $data['fecha_emision']; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label>Categoría</label>
                                    <select name="categoria" class="form-control">
                                        <option value="ingenieria" <?php if($data['categoria'] == 'ingenieria') echo 'selected'; ?>>Ingeniería</option>
                                        <option value="derecho" <?php if($data['categoria'] == 'derecho') echo 'selected'; ?>>Derecho</option>
                                        <option value="stenergy" <?php if($data['categoria'] == 'stenergy') echo 'selected'; ?>>Stenergyedu</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-8 mb-3">
                                    <label>Descripción del Curso</label>
                                    <textarea name="descripcion" class="form-control" rows="3"><?php echo $data['descripcion'] ?? ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label>Requisitos del Curso</label>
                                    <textarea name="requisitos" class="form-control" rows="3"><?php echo $data['requisitos'] ?? ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-2 mb-3">
                                    <label>Precio (S/)</label>
                                    <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $data['precio'] ?? '89.90'; ?>">
                                </div>
                                <div class="col-12 col-md-2 mb-3">
                                    <label>Precio (USD)</label>
                                    <input type="number" step="0.01" name="precio_usd" class="form-control" value="<?php echo $data['precio_usd'] ?? '30.00'; ?>">
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Fecha Prox. (ej. PRÓXIMAMENTE)</label>
                                    <input type="text" name="fecha_prox" class="form-control" value="<?php echo $data['fecha_prox'] ?? 'PRÓXIMAMENTE'; ?>">
                                </div>
                                <div class="col-12 col-md-2 mb-3">
                                    <label>Lecciones</label>
                                    <input type="number" name="lecciones" class="form-control" value="<?php echo $data['lecciones'] ?? '1'; ?>">
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Nombre del Docente</label>
                                    <input type="text" name="docente" class="form-control" value="<?php echo $data['docente'] ?? ''; ?>" placeholder="Ej. Ricardo Cárdenas">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Resumen del Curso (HTML permitido)</label>
                                    <textarea name="resumen" class="form-control" rows="4"><?php echo $data['resumen'] ?? ''; ?></textarea>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Temas Principales (HTML permitido)</label>
                                    <textarea name="temas" class="form-control" rows="4"><?php echo $data['temas'] ?? ''; ?></textarea>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Beneficios (HTML permitido)</label>
                                    <textarea name="beneficios" class="form-control" rows="4"><?php echo $data['beneficios'] ?? ''; ?></textarea>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Programación y Horarios (HTML permitido)</label>
                                    <textarea name="programacion" class="form-control" rows="4"><?php echo $data['programacion'] ?? ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Foto / Portada del curso</label><br>
                                    <input type="file" name="foto" onchange="readURL(this);" accept="image/*"/><br><br>
                                    <?php $url_foto = (!isset($data['foto']) || $data['foto'] == 'default.png' || $data['foto'] == '') ? 'https://www.file-extension.info/images/resource/formats/img.png' : BASE_URL . 'assets/images/cursos/'.$data['foto']; ?>
                                    <img id="blah" src="<?php echo $url_foto; ?>" alt="your image" style="max-width:200px;"/>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Foto del Docente</label><br>
                                    <input type="file" name="docente_foto" onchange="readURLDoc(this);" accept="image/*"/><br><br>
                                    <?php $url_docente = (!isset($data['docente_foto']) || $data['docente_foto'] == '50x50' || $data['docente_foto'] == '') ? 'https://www.file-extension.info/images/resource/formats/img.png' : BASE_URL . 'assets/images/docentes/'.$data['docente_foto']; ?>
                                    <img id="blahDoc" src="<?php echo $url_docente; ?>" alt="your image" style="max-width:100px; border-radius:50%;"/>
                                </div>
                            </div>
                            <script type="text/javascript">
                                function readURL(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) { $('#blah').attr('src', e.target.result); };
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                                function readURLDoc(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) { $('#blahDoc').attr('src', e.target.result); };
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                            </script>
                        </div>
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-success">Actualizar Curso</button>
                            <a href="<?= BASE_URL ?>admin/cursos" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
