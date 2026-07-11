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
$check_acceso = mysqli_query($conection, "SELECT id_curso FROM usuario_cursos WHERE id_usuario = $iduser AND id_curso = $id_curso");
if(!$check_acceso || mysqli_num_rows($check_acceso) == 0) {
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

if(!$query_videos) {
    // Si la tabla no existe o hay error, no hacemos nada y dejamos modulos vacios
} elseif(mysqli_num_rows($query_videos) > 0) {
    while($vid = mysqli_fetch_array($query_videos)) {
        $videos[] = $vid;
        $modulos[$vid['modulo']][] = $vid;
    }
    // Setear el primer video para que cargue por defecto
    if(count($videos) > 0) {
        $primer_video = $videos[0]['url_video'];
        if (strpos($primer_video, 'watch?v=') !== false) {
            $primer_video = str_replace('watch?v=', 'embed/', $primer_video);
        } elseif (strpos($primer_video, 'youtu.be/') !== false) {
            $primer_video = str_replace('youtu.be/', 'www.youtube.com/embed/', $primer_video);
        }
    }
}

// Generar iniciales del docente
$docente_nombre = $curso['docente'] ?: 'Instructor ICC';
$iniciales = strtoupper(substr($docente_nombre, 0, 1) . substr(strrchr($docente_nombre, " "), 1, 1));
if (strlen($iniciales) < 2) $iniciales = substr($docente_nombre, 0, 2);

// Progreso de Videos
$query_progreso = mysqli_query($conection, "SELECT id_video FROM progreso_videos WHERE id_usuario = $iduser AND id_curso = $id_curso");
$videos_completados = [];
if($query_progreso) {
    while($prog = mysqli_fetch_array($query_progreso)) {
        $videos_completados[] = $prog['id_video'];
    }
}
$total_videos = count($videos);
$completados_count = count($videos_completados);
$porcentaje_progreso = $total_videos > 0 ? round(($completados_count / $total_videos) * 100) : 0;

$query_estado = mysqli_query($conection, "SELECT estado_certificado FROM usuario_cursos WHERE id_usuario = $iduser AND id_curso = $id_curso");
$estado_certificado = ($query_estado && $row_estado = mysqli_fetch_array($query_estado)) ? $row_estado['estado_certificado'] : 0;

?>
<style>
    body {
        background-color: #1a1a1a !important; /* Dark background */
        color: #e0e0e0;
    }
    .page {
        background-color: #1a1a1a !important;
    }
    .video-container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        margin-bottom: 30px;
        background: #000;
    }
    
    /* Tabs customizadas al estilo de la imagen */
    .custom-tabs {
        display: flex;
        background: #9d9d9d;
        border-radius: 4px;
        margin-bottom: 30px;
    }
    .custom-tab {
        padding: 12px 25px;
        color: #444;
        font-weight: 600;
        cursor: pointer;
    }
    .custom-tab.active {
        color: #f6c039; /* Color oro/amarillo */
        border-bottom: 3px solid #f6c039;
    }

    /* Título de sección */
    .section-title {
        color: #fff;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Accordion Custom */
    .accordion-module {
        background: #f4f5f7;
        border-radius: 6px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    .accordion-header {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        background: #f4f5f7;
        color: #f6c039; /* Oro */
        font-weight: bold;
        font-size: 16px;
    }
    .accordion-header i {
        color: #f6c039;
        transition: transform 0.3s;
    }
    .accordion-header.active i {
        transform: rotate(180deg);
    }
    .accordion-body {
        background: #ffffff;
        display: none;
    }
    .accordion-body.show {
        display: block;
    }
    .video-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-top: 1px solid #eee;
        cursor: pointer;
        transition: background 0.2s;
    }
    .video-item:hover {
        background: #f9f9f9;
    }
    .video-item .title {
        color: #555;
        font-weight: 500;
        display: flex;
        align-items: center;
    }
    .video-item .title i {
        margin-right: 10px;
        color: #aaa;
    }
    .video-item .meta {
        color: #888;
        font-size: 14px;
        display: flex;
        align-items: center;
    }
    .video-item .meta i {
        margin-left: 10px;
        font-size: 14px;
    }

    /* Cajas Derecha (Sidebar) */
    .sidebar-box {
        background: #222222;
        border: 1px solid #444;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
    }
    .sidebar-box.gold-border {
        border-color: #f6c039;
    }
    .btn-gold {
        background: transparent;
        color: #f6c039;
        border: 1px solid #f6c039;
        width: 100%;
        padding: 12px;
        border-radius: 4px;
        font-weight: bold;
        text-align: center;
        display: block;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    .btn-gold:hover {
        background: #f6c039;
        color: #000;
        text-decoration: none;
    }
    .sidebar-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .sidebar-list li {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        color: #ccc;
        font-size: 14px;
    }
    .sidebar-list li i {
        width: 25px;
        color: #888;
    }
    
    .instructor-box {
        display: flex;
        align-items: center;
    }
    .instructor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f6c039;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        margin-right: 15px;
    }
    .instructor-info h5 {
        color: #fff;
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }
    .instructor-info span {
        color: #aaa;
        font-size: 13px;
    }
</style>

<div class="mdk-header-layout__content page" style="min-height: 100vh;">
    <div class="container page__container mt-5 mb-5">
        <div class="row">
            
            <!-- CONTENIDO PRINCIPAL (IZQUIERDA) -->
            <div class="col-lg-8">
                
                <!-- Reproductor de Video -->
                <div class="video-container mb-2">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="player1" class="embed-responsive-item" src="<?= $primer_video ?>" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="text-right mb-4">
                    <button id="btnMarcarCompletado" class="btn btn-success" style="border-radius: 20px; font-weight: bold; display: none;" onclick="marcarCompletado()">
                        <i class="material-icons mr-1" style="vertical-align: middle;">check_circle</i> Marcar Lección Completada
                    </button>
                    <span id="txtCompletado" class="text-success" style="font-weight: bold; display: none;">
                        <i class="material-icons mr-1" style="vertical-align: middle;">check_circle</i> Lección Completada
                    </span>
                </div>

                <!-- Tabs -->
                <div class="custom-tabs">
                    <div class="custom-tab active">Información del curso</div>
                    <!-- <div class="custom-tab">Reseñas</div> -->
                </div>

                <!-- Acordeón de Módulos -->
                <h3 class="section-title">Contenido del curso</h3>
                
                <div class="modules-container">
                    <?php if(empty($modulos)): ?>
                        <div class="alert alert-dark" style="background: #222; border-color: #333; color: #ccc;">Aún no hay videos para este curso.</div>
                    <?php else: ?>
                        <?php 
                        $mod_index = 1; 
                        $vid_index = 1;
                        $js_video_urls = [];
                        foreach ($modulos as $nombre_modulo => $lista_videos): ?>
                            
                            <div class="accordion-module">
                                <div class="accordion-header <?= ($mod_index == 1) ? 'active' : '' ?>" onclick="toggleAccordion(this)">
                                    <span class="text-uppercase"><?= htmlspecialchars($nombre_modulo) ?></span>
                                    <i class="material-icons">expand_more</i>
                                </div>
                                <div class="accordion-body <?= ($mod_index == 1) ? 'show' : '' ?>">
                                    <?php foreach ($lista_videos as $v): 
                                        $url = $v['url_video'];
                                        if (strpos($url, 'watch?v=') !== false) {
                                            $url = str_replace('watch?v=', 'embed/', $url);
                                        } elseif (strpos($url, 'youtu.be/') !== false) {
                                            $url = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
                                        }
                                        $js_video_urls["vid".$vid_index] = $url;
                                    ?>
                                        <div class="video-item" id="vid<?= $vid_index ?>" onclick="changeVid(this.id, <?= $v['id_video'] ?>)">
                                            <div class="title d-flex align-items-center">
                                                <i class="material-icons status-icon mr-2" style="font-size: 20px; color: <?= in_array($v['id_video'], $videos_completados) ? '#28a745' : 'inherit' ?>;">
                                                    <?= in_array($v['id_video'], $videos_completados) ? 'check_circle' : 'play_circle_outline' ?>
                                                </i>
                                                <?= htmlspecialchars($v['titulo']) ?>
                                            </div>
                                            <div class="meta">
                                                <?= htmlspecialchars($v['duracion']) ?>
                                                <i class="material-icons">lock_open</i>
                                            </div>
                                        </div>
                                    <?php 
                                        $vid_index++;
                                    endforeach; ?>
                                </div>
                            </div>

                        <?php 
                        $mod_index++;
                        endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>

            <!-- BARRA LATERAL (DERECHA) -->
            <div class="col-lg-4">
                
                <!-- Caja Detalles -->
                <div class="sidebar-box gold-border">
                    <div class="mb-3 text-center">
                        <strong style="color: #fff; font-size: 16px;">Progreso: <?= $porcentaje_progreso ?>%</strong>
                    </div>
                    <div class="progress mb-4" style="height: 10px; border-radius: 5px; background: #333;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $porcentaje_progreso ?>%;" aria-valuenow="<?= $porcentaje_progreso ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    
                    <ul class="sidebar-list">
                        <li>
                            <i class="material-icons">equalizer</i>
                            <?= htmlspecialchars($curso['categoria'] ?: 'Intermedio') ?>
                        </li>
                        <li>
                            <i class="material-icons">school</i>
                            <?= htmlspecialchars($curso['lecciones'] ?: 0) ?> Lecciones
                        </li>
                        <li>
                            <i class="material-icons">update</i>
                            <?= htmlspecialchars($curso['fecha_emision'] ?: date('F j, Y')) ?> Última actualización
                        </li>
                        <li class="mt-4 text-center pb-2 border-0">
                            <?php if($porcentaje_progreso == 100): ?>
                                <?php if($estado_certificado == 0): ?>
                                    <button id="btnSolicitarCertificado" class="btn btn-success btn-block" style="border-radius: 20px; font-weight: bold;" onclick="solicitarCertificado(<?= $id_curso ?>)">
                                        <i class="material-icons mr-1" style="vertical-align: middle;">military_tech</i> Solicitar Certificado
                                    </button>
                                <?php elseif($estado_certificado == 1): ?>
                                    <span class="badge badge-info w-100 p-2" style="font-size: 14px; border-radius: 20px;"><i class="material-icons mr-1" style="vertical-align: middle;">hourglass_empty</i> Certificado Solicitado (Pendiente)</span>
                                <?php else: ?>
                                    <span class="badge badge-success w-100 p-2" style="font-size: 14px; border-radius: 20px;"><i class="material-icons mr-1" style="vertical-align: middle;">done_all</i> Certificado Emitido</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted"><i class="material-icons mr-1" style="vertical-align: middle;">lock</i> Finaliza para solicitar certificado</span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>

                <!-- Caja Instructor -->
                <div class="sidebar-box">
                    <div style="color: #ccc; font-size: 14px; margin-bottom: 15px;">Un curso de</div>
                    <div class="instructor-box">
                        <div class="instructor-avatar">
                            <?= $iniciales ?>
                        </div>
                        <div class="instructor-info">
                            <h5><?= htmlspecialchars($docente_nombre) ?></h5>
                            <span>Instructor Experto</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var videosUrls = <?= json_encode($js_video_urls ?? []) ?>;
    var videosCompletados = <?= json_encode($videos_completados) ?>;
    var idCurso = <?= $id_curso ?>;
    var currentVideoId = <?= count($videos) > 0 ? $videos[0]['id_video'] : 0 ?>;
    var currentDivId = "vid1";

    function updateCompletadoUI(videoId) {
        if(videosCompletados.includes(String(videoId)) || videosCompletados.includes(Number(videoId))) {
            document.getElementById('btnMarcarCompletado').style.display = 'none';
            document.getElementById('txtCompletado').style.display = 'inline-block';
        } else {
            document.getElementById('btnMarcarCompletado').style.display = 'inline-block';
            document.getElementById('txtCompletado').style.display = 'none';
        }
    }

    // Al cargar la página
    if(currentVideoId > 0) updateCompletadoUI(currentVideoId);

    function changeVid(clicked_id, video_id) {   
        currentVideoId = video_id;
        currentDivId = clicked_id;
        updateCompletadoUI(video_id);

        if (videosUrls[clicked_id]) {
            document.getElementById('player1').src = videosUrls[clicked_id];
            
            // Resaltar el video activo
            var items = document.querySelectorAll('.video-item');
            items.forEach(function(item) {
                item.style.background = 'transparent';
                item.querySelector('.title').style.color = '#555';
            });
            
            var activeItem = document.getElementById(clicked_id);
            activeItem.style.background = '#f9f9f9';
            activeItem.querySelector('.title').style.color = '#f6c039';

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function marcarCompletado() {
        if(currentVideoId === 0) return;
        fetch('marcar_progreso.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id_curso=' + idCurso + '&id_video=' + currentVideoId
        }).then(r => r.json()).then(data => {
            if(data.success) {
                // Recargar página para actualizar la barra de progreso desde PHP
                window.location.reload();
            }
        });
    }

    function solicitarCertificado(id_curso) {
        var btn = document.getElementById('btnSolicitarCertificado');
        btn.disabled = true;
        btn.innerHTML = '<i class="material-icons mr-1" style="vertical-align: middle;">autorenew</i> Solicitando...';
        fetch('solicitar_certificado.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id_curso=' + id_curso
        }).then(r => r.json()).then(data => {
            if(data.success) {
                window.location.reload();
            } else {
                alert('Error al solicitar certificado');
                btn.disabled = false;
                btn.innerHTML = '<i class="material-icons mr-1" style="vertical-align: middle;">military_tech</i> Solicitar Certificado';
            }
        });
    }

    function toggleAccordion(element) {
        element.classList.toggle("active");
        var body = element.nextElementSibling;
        if (body.classList.contains("show")) {
            body.classList.remove("show");
        } else {
            body.classList.add("show");
        }
    }
</script>

<?php  
include 'includes/footer.php';
include 'includes/script.php';
?>