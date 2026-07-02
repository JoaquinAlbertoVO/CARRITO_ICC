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
                    <form action="<?= BASE_URL ?>admin/derecho_registro" method="POST" enctype="multipart/form-data">
                        <div class="card-form__body card-body">

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <input type="hidden" name="idusuario">
                                        <label for="fname">Nombres y Apellifos completos</label>
                                        <input id="fname" type="text" name="nombre" class="form-control" placeholder="Ingresar nombres y apellidos">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Correo Electronico</label>
                                        <input id="fname" type="text" name="correo" class="form-control" placeholder="Ingresar correo electronico">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Telefono</label>
                                        <input id="fname" type="number" name="telefono" class="form-control" placeholder="Ingresar nÃºmero celular">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">DNI</label>
                                        <input id="fname" type="number" name="dni" class="form-control" placeholder="Ingresar DNI">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">NÃºmero de OperaciÃ³n</label>
                                        <input id="fname" type="number" name="nopera" class="form-control" placeholder="Ingresar N. de operacion">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Monto Pagado</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" step="any" name="mpagado" class="form-control form-control-prepended" required="" placeholder="Ingresar monto pagar">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <span class="material-icons">S/</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="fname">Encargado de Registro</label>
                                        <input id="fname" type="text" name="encargado" class="form-control" readonly value="<?= $_SESSION['nombre'] ?? 'Admin' ?>">
                                        
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="fname">Banco registrado</label><br>
                                        <select id="select01" data-toggle="select" name="banco" class="form-control">
                                            <option selected="">Seleccionar...</option>
                                            <option>BCP</option>
                                            <option>BanBif</option>
                                            <option>Banco Pichincha</option>
                                            <option>BBVA</option>
                                            <option>Interbank</option>
                                            <option>MiBanco</option>
                                            <option>Scotiabank PerÃº</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="flatpickrSample01">Fecha registro</label>
                                        <input id="flatpickrSample01" type="text" name="fecha" class="form-control" placeholder="Flatpickr example" data-toggle="flatpickr" value="today">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Usuario</label>
                                        <input id="fname" type="text" class="form-control" name="usuario" placeholder="Ingresar usuario">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">ContraseÃ±a</label>
                                        <input id="fname" type="text" name="pass" class="form-control" placeholder="Ingresar contraseÃ±a">
                                    </div>
                                </div>
                                <style type="text/css">
                                    img{
                                      max-width:180px;
                                    }
                                    input[type=file]{
                                    padding:10px;
                                    background:#efefef;}
                                </style>
                                <div class="form-group">
                                    <label>Ingresar Baucher</label><br><br>
                                    <input type="file" name="foto" onchange="readURL(this);" /><br><br>
                                    <img id="blah" src="https://www.file-extension.info/images/resource/formats/img.png" alt="your image" />
                                </div>
                                <script type="text/javascript">
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function (e) {
                                                $('#blah')
                                                    .attr('src', e.target.result);
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                                <div class="form-group"><br>
                                    <label style="font-size: 20px;" for="fname">Seleccionar Cursos Matriculados</label><br><br>
                                    <div class="form-row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="fname">PROCESO DE DESALOJO EN LA CORTE SUPREMA</label>
                                            <select id="select01" data-toggle="select" name="2" class="form-control">
                                                <option value="1" selected="">No</option>
                                                <option value="2">Si</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="fname">MODIFICACION AL REGLAMENTO DE LA LEY DE C. CON EL ESTADO</label>
                                            <select id="select01" data-toggle="select" name="3" class="form-control">
                                                <option value="1" selected="">No</option>
                                                <option value="3">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="fname">DERECHO PENAL</label>
                                            <select id="select01" data-toggle="select" name="4" class="form-control">
                                                <option value="1" selected="">No</option>
                                                <option value="4">Si</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="fname">DERECHO AMBIENTAL</label>
                                            <select id="select01" data-toggle="select" name="5" class="form-control">
                                                <option value="1" selected="">No</option>
                                                <option value="5">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="fname">ESPECIALIZACION NUEVO CODIGO PROCESAL PENAL</label>
                                            <select id="select01" data-toggle="select" name="6" class="form-control">
                                                <option value="1" selected="">No</option>
                                                <option value="6">Si</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="fname">LITIGACION ORAL EN EL NUEVO CODIGO PROCESAL PENAL</label>
                                            <select id="select01" data-toggle="select" name="7" class="form-control">
                                                <option value="1" selected="">No</option>
                                                <option value="7">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="card-body text-center">

                            <button type="submit" class="btn btn-success">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


