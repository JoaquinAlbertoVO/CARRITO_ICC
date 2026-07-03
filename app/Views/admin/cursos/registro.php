<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center justify-content-between">
            <h1 class="m-0">Registrar Curso</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div><?php echo isset($alert) ? $alert : ''; ?></div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Nombre del Curso</label>
                                    <input type="text" name="nombre_curso" class="form-control" required placeholder="Ej. Electricidad Básica">
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Horas Académicas</label>
                                    <input type="number" name="horas_academicas" class="form-control" value="20">
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Fecha de Emisión</label>
                                    <input type="date" name="fecha_emision" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label>Categoría</label>
                                    <select name="categoria" class="form-control">
                                        <option value="ingenieria">Ingeniería</option>
                                        <option value="derecho">Derecho</option>
                                        <option value="stenergy">Stenergyedu</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-8 mb-3">
                                    <label>Descripción del Curso</label>
                                    <textarea name="descripcion" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Foto / Portada del curso (Opcional)</label><br>
                                <input type="file" name="foto" onchange="readURL(this);" accept="image/*"/><br><br>
                                <img id="blah" src="https://www.file-extension.info/images/resource/formats/img.png" alt="your image" style="max-width:200px;"/>
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
                            <button type="submit" class="btn btn-success">Guardar Curso</button>
                            <a href="<?= BASE_URL ?>admin/cursos" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
