<?php  
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2) {
    header("location: ./");
}

include '../conexion.php';

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['pass'])) {
        $alert = '<div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Aviso - </strong> Todos los campos son obligatorios</div>';
    }else{
        $id_pla     = $_SESSION['idUser'];
        $nombre     = $_POST['nombre'];
        $correo     = $_POST['correo'];
        $telefono   = $_POST['telefono'];
        $dni        = $_POST['dni'];
        $nopera     = $_POST['nopera'];
        $mpagado    = $_POST['mpagado'];
        $encargado  = $_POST['encargado'];
        $banco      = $_POST['banco'];
        $fecha      = $_POST['fecha'];
        $usuario    = $_POST['usuario'];
        $pass       = $_POST['pass'];

        $foto       = $_FILES['foto'];
        $nombre_foto= $foto['name'];
        $url_temp   = $foto['tmp_name'];
        $imgboucher = 'ejemplo.png';

        if ($nombre_foto != '') {
            $destino    = 'img/uploads/';
            $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
            $imgboucher = $img_nombre.'.jpg';
            $src        = $destino.$imgboucher;
        }

        $query_insert = mysqli_query($conection, "INSERT INTO usuario(id_pla, nombre, correo, telefono, dni, n_operacion, m_pagado, encargado, banco, fecha_deposito, usuario, password, boucher) VALUES ('$id_pla', '$nombre', '$correo', '$telefono', '$dni', '$nopera', '$mpagado', '$encargado', '$banco', '$fecha','$usuario', '$pass', '$imgboucher')");

        if ($query_insert) {
            if ($nombre_foto != '') {
                move_uploaded_file($url_temp, $src);
            }
            $iduser = mysqli_insert_id($conection);
            
            // NUEVO SISTEMA DE MATRICULA DINAMICA
            if(!empty($_POST['cursos_matriculados'])) {
                $cursos = $_POST['cursos_matriculados'];
                foreach($cursos as $id_curso) {
                    mysqli_query($conection, "INSERT INTO usuario_cursos (id_usuario, id_curso) VALUES ($iduser, $id_curso)");
                }
            }

            // También guardamos un registro dummy en "inscrito" para no romper ninguna otra parte de tu sistema antiguo
            mysqli_query($conection, "INSERT INTO inscrito (id_user) VALUES ($iduser)");

            $alert = '<div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Exitoso - </strong> Registro guardado satisfactoriamente</div>';
        }else{
            $alert = '<div class="alert alert-dismissible bg-warning border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Advertencia - </strong> Error al guardar el registro</div>';
        }
    }
}
include 'includes/head.php';
include 'includes/header.php';
?>
<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center justify-content-between">
            <h1 class="m-0">Registrar Alumno</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div><?php echo isset($alert) ? $alert : ''; ?></div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-form__body card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Nombres y Apellidos completos</label>
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
                                        <input id="fname" type="number" name="telefono" class="form-control" placeholder="Ingresar número celular">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">DNI</label>
                                        <input id="fname" type="number" name="dni" class="form-control" placeholder="Ingresar DNI">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Número de Operación</label>
                                        <input id="fname" type="number" name="nopera" class="form-control" placeholder="Ingresar N. de operacion">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Monto Pagado</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" step="any" name="mpagado" class="form-control form-control-prepended" required="" placeholder="Ingresar monto pagar">
                                            <div class="input-group-prepend"><div class="input-group-text"><span class="material-icons">S/</span></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="fname">Encargado de Registro</label>
                                        <?php  
                                        $rolindex = $_SESSION['rol'];
                                        $query_encargado = mysqli_query($conection,"SELECT * FROM plataforma WHERE estatus = 1 AND rol = $rolindex ");
                                        if (mysqli_num_rows($query_encargado) > 0) {
                                            while ($encargado = mysqli_fetch_array($query_encargado)) {
                                                echo '<input type="text" name="encargado" class="form-control" readonly value="'.$encargado["name"].'">';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="fname">Banco registrado</label><br>
                                        <select id="select01" data-toggle="select" name="banco" class="form-control">
                                            <option selected="">Seleccionar...</option>
                                            <option>BCP</option><option>BanBif</option><option>Banco Pichincha</option><option>BBVA</option><option>Interbank</option><option>MiBanco</option><option>Scotiabank Perú</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="flatpickrSample01">Fecha registro</label>
                                        <input id="flatpickrSample01" type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Usuario</label>
                                        <input id="fname" type="text" class="form-control" name="usuario" placeholder="Ingresar usuario">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Contraseña</label>
                                        <input id="fname" type="text" name="pass" class="form-control" placeholder="Ingresar contraseña">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ingresar Baucher</label><br>
                                    <input type="file" name="foto" onchange="readURL(this);" /><br><br>
                                    <img id="blah" src="https://www.file-extension.info/images/resource/formats/img.png" alt="your image" style="max-width:180px;" />
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
                                
                                <hr>
                                <div class="form-group"><br>
                                    <label style="font-size: 20px; font-weight: bold; color: #333;" for="fname">Seleccionar Cursos Matriculados (Dinámico)</label><br>
                                    <p class="text-muted">Marca la casilla de los cursos a los que deseas matricular a este alumno. Estos cursos provienen de la base de datos.</p>
                                    <div class="row">
                                        <?php
                                        // CARGA DINÁMICA DE CURSOS
                                        $query_cursos = mysqli_query($conection, "SELECT * FROM cursos WHERE estado = 1 ORDER BY nombre_curso ASC");
                                        while ($curso = mysqli_fetch_array($query_cursos)) {
                                            ?>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="curso_<?php echo $curso['id_curso']; ?>" name="cursos_matriculados[]" value="<?php echo $curso['id_curso']; ?>">
                                                    <label class="custom-control-label" for="curso_<?php echo $curso['id_curso']; ?>">
                                                        <strong><?php echo $curso['nombre_curso']; ?></strong>
                                                        <br><small class="text-muted">Categoría: <?php echo ucfirst($curso['categoria']); ?> - <?php echo $curso['horas_academicas']; ?> hrs</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-success" style="font-size:18px; padding: 10px 40px;">Guardar Alumno</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include 'includes/barra_lateral_ingenieria.php'; 
include 'includes/script.php';
?>