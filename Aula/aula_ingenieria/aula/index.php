<?php  

session_start();
if (empty($_SESSION['active']) || empty($_SESSION['idUser'])) {
    header('location: ../../');
    exit;
}
include '../conexion.php';
include 'includes/head.php';
include 'includes/header.php';

?>


        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content page">
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            
            <div class="home-banner text-white mb-4">
                <div class="container page__container">
                    <h1 class="display-4 bold" data-aos="fade-up" data-aos-duration="800">Bienvenido a ICC - Instituto de Capacitación Continua</h1>
                    <p class="lead mb-5" data-aos="fade-up" data-aos-duration="1000">Cursos en Ingeniería Eléctrica</p>
                </div>
            </div>

            <div class="container page__container">
                <div class="m-4 p-4">
                    <h2 class="bold mb-1 text-center" style="color: #fff;">Cursos Activos</h2>
                    <p class="lead text-muted text-center" style="color: #fad705;">Nuestros cursos matriculados</p>
                </div>
                <div class="d-flex justify-content-around pb-4">

                    <div class="row">

                        
                        <!-- INICIO CURSOS DINAMICOS -->
<?php  
$iduser = $_SESSION['idUser'];
mysqli_set_charset($conection,"utf8");

// Consulta dinámica a la tabla usuario_cursos unida con cursos
$sql = "SELECT c.id_curso, c.nombre_curso, c.foto, c.horas_academicas, c.lecciones, c.categoria 
        FROM usuario_cursos uc 
        INNER JOIN cursos c ON uc.id_curso = c.id_curso 
        WHERE uc.id_usuario = $iduser AND c.estado = 1";

$result = mysqli_query($conection, $sql);

if (!$result) {
    die("Error SQL: " . mysqli_error($conection) . " | iduser: " . $iduser);
}

if(mysqli_num_rows($result) > 0) {
    while ($curso = mysqli_fetch_array($result)) {
        $img_curso = ($curso['foto'] == 'default.png') 
            ? 'https://www.file-extension.info/images/resource/formats/img.png' 
            : '../../administrador/administrador/img/cursos/'.$curso['foto'];
        ?>
        <div class="col-12 mb-3">
            <a href="curso.php?id=<?= $curso['id_curso'] ?>" class="text-decoration-none">
                <div class="card shadow-sm border-0 d-flex flex-row align-items-center" style="border-radius:12px; overflow:hidden; background-color: #2d3139; transition: transform 0.2s;">
                    <div style="width: 220px; min-width: 220px; height: 160px; position: relative;">
                        <img src="<?= $img_curso ?>" style="width:100%; height:100%; object-fit: cover;" alt="Portada Curso">
                    </div>
                    <div class="p-4 w-100">
                        <h4 class="text-white mb-3 d-flex align-items-center" style="font-weight: 600;">
                            <i class="material-icons text-success mr-2">check_circle</i> 
                            <?= htmlspecialchars($curso['nombre_curso']) ?>
                        </h4>
                        <div class="d-flex align-items-center">
                            <span class="mr-3" style="background-color: #3b3f46; color: #a1a6b0; font-size: 0.9rem; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; border: 1px solid #4a505c;">
                                <i class="material-icons mr-1" style="font-size:16px;">signal_cellular_alt</i> <?= htmlspecialchars($curso['categoria'] ?? 'Básico') ?>
                            </span>
                            <span style="background-color: #3b3f46; color: #a1a6b0; font-size: 0.9rem; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; border: 1px solid #4a505c;">
                                <i class="material-icons mr-1" style="font-size:16px;">schedule</i> <?= $curso['horas_academicas'] ?> horas de contenido
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
    }
} else {
    echo "<div class='col-12 text-center text-white'><p>No tienes cursos inscritos por el momento.</p></div>";
}
?>
<!-- FIN CURSOS DINAMICOS -->

<!-- SECCION CERTIFICADOS -->
<div class="col-12 mt-5">
    <h3 class="text-white text-center mb-4 border-top pt-4" style="border-color: #4a505c !important;">Tus Certificados</h3>
</div>
<?php
$iduser = $_SESSION['idUser'];
$query_cert = mysqli_query($conection, "SELECT uc.archivo_pdf, c.nombre_curso, c.foto, uc.fecha_subida 
                                        FROM usuario_certificados uc 
                                        INNER JOIN cursos c ON uc.id_curso = c.id_curso 
                                        WHERE uc.id_usuario = $iduser");

if($query_cert && mysqli_num_rows($query_cert) > 0) {
    while($cert = mysqli_fetch_array($query_cert)) {
        $img_curso = ($cert['foto'] == 'default.png') ? 'https://www.file-extension.info/images/resource/formats/img.png' : '../../administrador/administrador/img/cursos/'.$cert['foto'];
        ?>
        <div class='col-md-6 col-lg-4 mb-4'>
            <div class='card' style="background-color: #2d3139; border-radius: 12px; border: 1px solid #4a505c; overflow: hidden;">
                <div class='card-img-top text-center' style='height:200px; overflow:hidden;'>
                    <img src='<?php echo $img_curso; ?>' style='width:100%; height:100%; object-fit: cover;' alt='Curso'>
                </div>
                <div class='p-3 text-center border-bottom' style="border-color: #4a505c !important;">
                    <div class='bold mb-2'>
                        <h5 class='text-white'><?php echo $cert['nombre_curso']; ?></h5>
                    </div>
                    <div class='mb-2 text-muted'>
                        <small>Subido el: <?= date('d/m/Y', strtotime($cert['fecha_subida'])) ?></small>
                    </div>
                </div>
                <div class='p-3 text-center'>
                    <a target="_blank" href='../../assets/certificados/<?= $cert['archivo_pdf'] ?>' class='btn btn-success btn-block' style='border-radius:20px; font-weight: bold;'>
                        <i class="material-icons mr-1">file_download</i> Descargar PDF
                    </a>
                </div>         
            </div>
        </div> 
        <?php
    }
} else {
    echo "<div class='col-12 text-center text-muted'><p>No tienes certificados disponibles aún.</p></div>";
}
?>
                    </div> <!-- row -->
                </div> <!-- d-flex -->
            </div> <!-- container -->
        </div> <!-- page__content -->

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

<?php  
include 'includes/footer.php';
include 'includes/script.php';
?>