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
                            <div class="form-group">
                                <label>Foto / Portada del curso</label><br>
                                <input type="file" name="foto" onchange="readURL(this);" accept="image/*"/><br><br>
                                <?php $url_foto = (!isset($data['foto']) || $data['foto'] == 'default.png') ? 'https://www.file-extension.info/images/resource/formats/img.png' : BASE_URL . 'public/assets/img/cursos/'.$data['foto']; ?>
                                <img id="blah" src="<?php echo $url_foto; ?>" alt="your image" style="max-width:200px;"/>
                            </div>
                            <script type="text/javascript">
                                function readURL(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) { $('#blah').attr('src', e.target.result); };
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
