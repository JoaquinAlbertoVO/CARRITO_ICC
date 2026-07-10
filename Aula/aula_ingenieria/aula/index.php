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
$sql = "SELECT c.id_curso, c.nombre_curso, c.foto, c.horas_academicas, c.lecciones 
        FROM usuario_cursos uc 
        INNER JOIN cursos c ON uc.id_curso = c.id_curso 
        WHERE uc.id_usuario = $iduser AND c.estado = 1";

$result = mysqli_query($conection, $sql);

if (!$result) {
    die("Error SQL: " . mysqli_error($conection) . " | iduser: " . $iduser);
}

if(mysqli_num_rows($result) > 0) {
    while ($curso = mysqli_fetch_array($result)) {
        // La foto puede ser la default o estar en administrador
        $img_curso = ($curso['foto'] == 'default.png') 
            ? 'https://www.file-extension.info/images/resource/formats/img.png' 
            : '../../administrador/administrador/img/cursos/'.$curso['foto'];
            
        // Fallback por si la ruta de foto del admin cambia
        // Asumiendo que la ruta real es /administrador/administrador/img/cursos/
        ?>
        <div class='col-md-6 col-lg-4 mb-4'>
            <div class='card card__course card__course__animate'>
                <a href='curso.php?id=<?= $curso['id_curso'] ?>' class='card-img-top text-center bg-light' style='height:200px; overflow:hidden; position: relative;'>
                    <img src='<?= $img_curso ?>' style='width:100%; object-fit: cover;' alt='Portada Curso'>
                    <span class='play-button' style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background: rgba(0,0,0,0.5); border-radius: 50%; padding: 10px;'>
                        <i class="material-icons" style="font-size: 40px;">play_circle_outline</i>
                    </span>
                </a>

                <div class='p-3 text-center border-bottom'>
                    <div class='bold mb-2'>
                        <a href='curso.php?id=<?= $curso['id_curso'] ?>' class='text-body'>
                            <span class='course__title text-primary h5'><?= htmlspecialchars($curso['nombre_curso']) ?></span>
                        </a>
                    </div>
                    <div class='d-flex justify-content-around mt-3'>
                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                            <small class='mr-3 d-flex align-items-center'>
                                <i class="material-icons mr-1" style="font-size:16px;">library_books</i>
                                <span class='ml-1'><?= $curso['lecciones'] ?: 1 ?> Lecciones</span>
                            </small>
                            <small class='d-flex align-items-center'>
                                <i class="material-icons mr-1" style="font-size:16px;">schedule</i>
                                <span class='ml-1'><?= $curso['horas_academicas'] ?> horas</span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class='p-3 text-center'>
                    <a href='curso.php?id=<?= $curso['id_curso'] ?>'><strong class='h4 m-0 text-success'>INGRESAR AL CURSO</strong></a>
                </div>         
            </div>
        </div>
        <?php
    }
} else {
    echo "<div class='col-12 text-center text-white'><p>No tienes cursos inscritos por el momento.</p></div>";
}
?>
<!-- FIN CURSOS DINAMICOS -->

                        
                        <!-- NUEVOS CURSOS DINAMICOS Y CERTIFICADOS -->
                        <div class="col-12 mt-5">
                            <h3 class="text-white text-center mb-4 border-top pt-4">Tus Certificados y Nuevos Cursos</h3>
                        </div>
                        <?php
                        $iduser = $_SESSION['idUser'];
                        $query_dinamicos = mysqli_query($conection, "SELECT c.id_curso, c.nombre_curso, c.foto, c.horas_academicas FROM usuario_cursos uc INNER JOIN cursos c ON uc.id_curso = c.id_curso WHERE uc.id_usuario = $iduser AND c.estado = 1");
                        
                        if(mysqli_num_rows($query_dinamicos) > 0) {
                            while($curso_d = mysqli_fetch_array($query_dinamicos)) {
                                $img_curso = ($curso_d['foto'] == 'default.png') ? 'https://www.file-extension.info/images/resource/formats/img.png' : '../../administrador/administrador/img/cursos/'.$curso_d['foto'];
                                ?>
                                <div class='col-md-6 col-lg-4 mb-4'>
                                    <div class='card card__course'>
                                        <div class='card-img-top text-center bg-light' style='height:200px; overflow:hidden;'>
                                            <img src='<?php echo $img_curso; ?>' style='width:100%; object-fit: cover;' alt='Curso'>
                                        </div>
                                        <div class='p-3 text-center border-bottom'>
                                            <div class='bold mb-2'>
                                                <h5 class='course__title text-primary'><?php echo $curso_d['nombre_curso']; ?></h5>
                                            </div>
                                            <div class='mb-2 text-muted'>
                                                <small><?php echo $curso_d['horas_academicas']; ?> horas lectivas</small>
                                            </div>
                                        </div>
                                        <div class='p-3 text-center'>
                                            <a target="_blank" href='../../administrador/administrador/generar_certificado.php?id_usuario=<?php echo $iduser; ?>&id_curso=<?php echo $curso_d['id_curso']; ?>' class='btn btn-success btn-block' style='border-radius:20px;'>
                                                <i class="material-icons mr-1">file_download</i> Descargar Certificado
                                            </a>
                                        </div>         
                                    </div>
                                </div> 
                                <?php
                            }
                        } else {
                            echo "<div class='col-12 text-center text-white'><p>No tienes certificados o cursos nuevos asignados aún.</p></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>


            <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

            <script>
                AOS.init();
            </script>

<?php  

include 'includes/footer.php';
include 'includes/script.php';

?>