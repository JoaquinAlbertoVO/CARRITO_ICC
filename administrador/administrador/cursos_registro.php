<?php  
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3) { header("location: ./"); }
include '../conexion.php';

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre_curso'])) {
        $alert = '<div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert"><strong>Aviso - </strong> El nombre del curso es obligatorio.</div>';
    } else {
        $nombre = $_POST['nombre_curso'];
        $desc = $_POST['descripcion'];
        $horas = empty($_POST['horas']) ? 20 : $_POST['horas'];
        $fecha = $_POST['fecha_emision'];
        $categoria = $_POST['categoria'];

        $foto = $_FILES['foto'];
        $nombre_foto = $foto['name'];
        $url_temp = $foto['tmp_name'];
        $imgCurso = 'default.png';

        if ($nombre_foto != '') {
            $destino = 'img/cursos/';
            if(!is_dir($destino)) mkdir($destino, 0777, true);
            $img_nombre = 'curso_'.md5(date('d-m-Y H:m:s'));
            $imgCurso = $img_nombre.'.jpg';
            $src = $destino.$imgCurso;
            move_uploaded_file($url_temp, $src);
        }

        $query_insert = mysqli_query($conection, "INSERT INTO cursos(nombre_curso, descripcion, horas_academicas, fecha_emision, foto, categoria) VALUES ('$nombre', '$desc', '$horas', '$fecha', '$imgCurso', '$categoria')");
        if ($query_insert) {
            $alert = '<div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert"><strong>Exitoso - </strong> Curso creado correctamente.</div>';
        }else{
            $alert = '<div class="alert alert-dismissible bg-warning border-0 fade show" role="alert"><strong>Advertencia - </strong> Error al guardar.</div>';
        }
    }
}
include 'includes/head.php';
include 'includes/header.php';
?>
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
                                    <input type="number" name="horas" class="form-control" value="20">
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
                            <a href="cursos_lista.php" class="btn btn-secondary">Volver</a>
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
