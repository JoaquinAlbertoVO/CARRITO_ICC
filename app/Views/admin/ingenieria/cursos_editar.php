<?php  
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3) { header("location: ./"); }
include '../conexion.php';

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre_curso'])) {
        $alert = '<div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert"><strong>Aviso - </strong> El nombre del curso es obligatorio.</div>';
    } else {
        $id = $_POST['id_curso'];
        $nombre = $_POST['nombre_curso'];
        $desc = $_POST['descripcion'];
        $horas = empty($_POST['horas']) ? 20 : $_POST['horas'];
        $fecha = $_POST['fecha_emision'];
        $categoria = $_POST['categoria'];

        $foto = $_FILES['foto'];
        $nombre_foto = $foto['name'];
        $url_temp = $foto['tmp_name'];
        
        $imgCurso = $_POST['foto_actual'];

        if ($nombre_foto != '') {
            $destino = 'img/cursos/';
            if(!is_dir($destino)) mkdir($destino, 0777, true);
            $img_nombre = 'curso_'.md5(date('d-m-Y H:m:s'));
            $imgCurso = $img_nombre.'.jpg';
            $src = $destino.$imgCurso;
            move_uploaded_file($url_temp, $src);
        }

        $query_update = mysqli_query($conection, "UPDATE cursos SET nombre_curso = '$nombre', descripcion = '$desc', horas_academicas = '$horas', fecha_emision = '$fecha', foto = '$imgCurso', categoria = '$categoria' WHERE id_curso = $id");
        if ($query_update) {
            $alert = '<div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert"><strong>Exitoso - </strong> Curso actualizado correctamente.</div>';
        }else{
            $alert = '<div class="alert alert-dismissible bg-warning border-0 fade show" role="alert"><strong>Advertencia - </strong> Error al actualizar.</div>';
        }
    }
}

if(empty($_REQUEST['id'])) {
    header("location: cursos_lista.php");
}
$id = $_REQUEST['id'];
$query = mysqli_query($conection, "SELECT * FROM cursos WHERE id_curso = $id");
$data = mysqli_fetch_array($query);

include 'includes/head.php';
include 'includes/header.php';
?>
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
                            <input type="hidden" name="foto_actual" value="<?php echo $data['foto']; ?>">
                            
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Nombre del Curso</label>
                                    <input type="text" name="nombre_curso" class="form-control" value="<?php echo $data['nombre_curso']; ?>" required>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Horas Académicas</label>
                                    <input type="number" name="horas" class="form-control" value="<?php echo $data['horas_academicas']; ?>">
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
                                    <textarea name="descripcion" class="form-control" rows="3"><?php echo $data['descripcion']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Foto / Portada del curso</label><br>
                                <input type="file" name="foto" onchange="readURL(this);" accept="image/*"/><br><br>
                                <?php $url_foto = ($data['foto'] == 'default.png') ? 'https://www.file-extension.info/images/resource/formats/img.png' : 'img/cursos/'.$data['foto']; ?>
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
