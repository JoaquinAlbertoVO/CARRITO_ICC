<?php  
session_start();
if (empty($_SESSION['active']) || empty($_SESSION['idUser'])) {
    header('location: ../../');
    exit;
}
include '../conexion.php';
include 'includes/head.php';
include 'includes/header.php';

$id_curso = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$iduser = $_SESSION['idUser'];

// Verificar si el alumno tiene acceso a este curso
$check_acceso = mysqli_query($conection, "SELECT id FROM usuario_cursos WHERE id_usuario = $iduser AND id_curso = $id_curso");
if(mysqli_num_rows($check_acceso) == 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>No tienes acceso a este curso o no estás inscrito.</div></div>";
    include 'includes/footer.php';
    exit;
}

// Obtener detalles del curso
$query_curso = mysqli_query($conection, "SELECT * FROM cursos WHERE id_curso = $id_curso");
$curso = mysqli_fetch_array($query_curso);

if(!$curso) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>El curso no existe.</div></div>";
    include 'includes/footer.php';
    exit;
}

// Obtener videos ordenados por módulo y orden
$query_videos = mysqli_query($conection, "SELECT * FROM curso_videos WHERE id_curso = $id_curso AND estado = 1 ORDER BY modulo ASC, orden ASC, id_video ASC");
$videos = [];
$modulos = [];
$primer_video = "https://www.youtube.com/embed/"; // default fallback
if(mysqli_num_rows($query_videos) > 0) {
    while($vid = mysqli_fetch_array($query_videos)) {
        $videos[] = $vid;
        $modulos[$vid['modulo']][] = $vid;
    }
    // Setear el primer video para que cargue por defecto
    if(count($videos) > 0) {
        $primer_video = $videos[0]['url_video'];
        // Si es URL de YouTube normal, convertirla a embed
        if (strpos($primer_video, 'watch?v=') !== false) {
            $primer_video = str_replace('watch?v=', 'embed/', $primer_video);
        } elseif (strpos($primer_video, 'youtu.be/') !== false) {
            $primer_video = str_replace('youtu.be/', 'www.youtube.com/embed/', $primer_video);
        }
    }
}
?>
        
<!-- Header Layout Content -->
<div class="mdk-header-layout__content page" >
    <div class="container page__container mt-4 mb-4">
        <div class="row" style="height: auto;">
            <div class="col-md-12">
                <div class="embed-responsive embed-responsive-16by9 mb-4" style="max-height:auto; background: #000;">
                    <iframe id="player1" class="embed-responsive-item" src="<?= $primer_video ?>" allowfullscreen=""></iframe>
                </div>
            </div>
            
            <div class="col-md-12">
                <div data-perfect-scrollbar style="position: relative; height:auto;">
                    <div class="card clear-shadow border">
                        <div class="card-body ">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong><?= htmlspecialchars($curso['nombre_curso']) ?></strong>
                                <small class="text-muted"><?= htmlspecialchars($curso['horas_academicas']) ?> hrs</small>
                            </div>
                            <div class="mt-2 text-muted">
                                <?= nl2br(htmlspecialchars($curso['descripcion'] ?? '')) ?>
                            </div>
                        </div>
                    </div>
                    
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <style type="text/css">
                        input { position: absolute; opacity: 0; z-index: -1; }
                        .row { display: flex; }
                        .row .col { flex: 1; }
                        .row .col:last-child { margin-left: 1em; }
                        .tabs { border-radius: 8px; overflow: hidden; box-shadow: 0 4px 4px -2px rgba(0, 0, 0, 0.5); margin-bottom: 15px;}
                        .tab { width: 100%; color: white; overflow: hidden; }
                        .tab-label {
                            display: flex; justify-content: space-between; padding: 1em;
                            background: #fff; font-weight: bold; cursor: pointer; color: #353535;
                        }
                        .tab-label:hover { background: #1377c9; color: #fff; }
                        .tab-label::after {
                            content: "\276F"; width: 1em; height: 1em; text-align: center; transition: all 0.35s;
                        }
                        .tab-content1 {
                            max-height: 0; padding: 0 1em; color: #3687e4; background: white; transition: all 0.35s;
                        }
                        input:checked + .tab-label { background: #1377c9; color: #fff; }
                        input:checked + .tab-label::after { transform: rotate(90deg); }
                        input:checked ~ .tab-content1 { max-height: 100vh; padding: 1em; overflow-y: auto;}
                        .media-body a { cursor: pointer; }
                    </style>
                    
                    <div class="list-group list-group-fit">
                        <div class="">
                            <div class="">
                                <?php if(empty($modulos)): ?>
                                    <div class="alert alert-info">Aún no hay videos para este curso.</div>
                                <?php else: ?>
                                    <?php 
                                    $mod_index = 1; 
                                    $vid_index = 1;
                                    $js_video_urls = [];
                                    foreach ($modulos as $nombre_modulo => $lista_videos): ?>
                                    <div class="tabs">
                                        <div class="tab">
                                            <input type="checkbox" id="chck_mod_<?= $mod_index ?>" <?= ($mod_index == 1) ? 'checked' : '' ?>>
                                            <label class="tab-label" style="width: 100%; margin-bottom: 1px;" for="chck_mod_<?= $mod_index ?>"><?= htmlspecialchars($nombre_modulo) ?></label>
                                            <div class="tab-content1">
                                                <?php foreach ($lista_videos as $v): 
                                                    // Convertir a embed
                                                    $url = $v['url_video'];
                                                    if (strpos($url, 'watch?v=') !== false) {
                                                        $url = str_replace('watch?v=', 'embed/', $url);
                                                    } elseif (strpos($url, 'youtu.be/') !== false) {
                                                        $url = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
                                                    }
                                                    $js_video_urls["vid".$vid_index] = $url;
                                                ?>
                                                <div class="media mb-2 mt-2">
                                                    <div class="media-left mr-2">
                                                        <div class="text-muted"><?= $vid_index ?>.</div>
                                                    </div>
                                                    <div class="media-body">
                                                        <a type="button" id="vid<?= $vid_index ?>" onclick="changeVid(this.id)" class="text-primary font-weight-bold">
                                                            <?= htmlspecialchars($v['titulo']) ?>
                                                        </a>
                                                    </div>
                                                    <div class="media-right">
                                                        <small class="text-muted"><?= htmlspecialchars($v['duracion']) ?></small>
                                                    </div>
                                                </div>
                                                <hr style="margin: 5px 0;">
                                                <?php 
                                                    $vid_index++;
                                                endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $mod_index++;
                                    endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        // Diccionario generado en PHP con los URLs de cada ID
        var videosUrls = <?= json_encode($js_video_urls ?? []) ?>;

        function changeVid(clicked_id) {   
            if (videosUrls[clicked_id]) {
                document.getElementById('player1').src = videosUrls[clicked_id];
                window.scrollTo({ top: 0, behavior: 'smooth' }); // Subir al reproductor al hacer clic
            }
        }
    </script>
</div>
<?php  
include 'includes/footer.php';
include 'includes/script.php';
?>
