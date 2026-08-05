        <div class="mdk-header-layout__content page" style="background-color: var(--bg-dark); min-height: 100vh;">
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            
            <style>
                /* Premium UI Enhancements - ICC Brand Colors */
                :root {
                    --bg-dark: #111625;
                    --card-bg: #1a233a;
                    --card-border: rgba(255, 255, 255, 0.08);
                    --accent: #e5c924;
                    --accent-glow: rgba(229, 201, 36, 0.25);
                    --text-main: #f3f4f6;
                    --text-muted: #a4b1cd;
                    --tag-bg: rgba(255, 255, 255, 0.05);
                    --tag-border: rgba(255, 255, 255, 0.1);
                }
                
                .home-banner {
                    background: linear-gradient(135deg, rgba(17, 22, 37, 0.95) 0%, rgba(26, 35, 58, 0.98) 100%);
                    border-bottom: 1px solid var(--card-border);
                    padding: 5rem 0;
                    position: relative;
                    overflow: hidden;
                }
                
                .home-banner::before {
                    content: '';
                    position: absolute;
                    top: -50%;
                    left: -50%;
                    width: 200%;
                    height: 200%;
                    background: radial-gradient(circle, rgba(229, 201, 36, 0.06) 0%, transparent 50%);
                    z-index: 0;
                    pointer-events: none;
                }

                .home-banner .container {
                    position: relative;
                    z-index: 1;
                }

                .display-4.bold {
                    font-weight: 800;
                    background: linear-gradient(to right, #ffffff, #9ca3af);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    letter-spacing: -1px;
                }

                .course-card-premium {
                    background-color: var(--card-bg);
                    border: 1px solid var(--card-border);
                    border-radius: 16px;
                    overflow: hidden;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
                    position: relative;
                }

                .course-card-premium:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.7), 0 0 20px var(--accent-glow);
                    border-color: var(--accent-glow);
                }

                .course-img-wrapper {
                    width: 260px;
                    min-width: 260px;
                    height: 180px;
                    position: relative;
                    overflow: hidden;
                }

                .course-img-wrapper img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: transform 0.6s ease;
                }

                .course-card-premium:hover .course-img-wrapper img {
                    transform: scale(1.05);
                }

                .course-img-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(to right, transparent, var(--card-bg));
                    opacity: 0.8;
                }
                
                .play-overlay {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(17, 22, 37, 0.6);
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    opacity: 0;
                    transition: all 0.3s ease;
                    border: 2px solid var(--accent);
                    z-index: 2;
                }
                
                .course-card-premium:hover .play-overlay {
                    opacity: 1;
                    transform: translate(-50%, -50%) scale(1.1);
                }
                
                .play-overlay i {
                    color: var(--accent);
                    font-size: 30px;
                    margin-left: 3px;
                }

                .progress-container {
                    background-color: rgba(255, 255, 255, 0.1);
                    border-radius: 10px;
                    height: 8px;
                    width: 100%;
                    overflow: hidden;
                    box-shadow: inset 0 1px 3px rgba(0,0,0,0.3);
                }

                .progress-bar-fill {
                    height: 100%;
                    background: linear-gradient(90deg, #e5c924, #fff3a1);
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(229, 201, 36, 0.5);
                }

                .course-title {
                    font-weight: 700;
                    color: var(--text-main);
                    font-size: 1.35rem;
                    transition: color 0.3s ease;
                }

                .course-card-premium:hover .course-title {
                    color: var(--accent);
                }

                .premium-tag {
                    background-color: var(--tag-bg);
                    color: var(--text-muted);
                    font-size: 0.85rem;
                    padding: 8px 16px;
                    border-radius: 30px;
                    display: inline-flex;
                    align-items: center;
                    border: 1px solid var(--tag-border);
                    backdrop-filter: blur(4px);
                    transition: all 0.2s ease;
                }

                .premium-tag:hover {
                    background-color: rgba(255, 255, 255, 0.1);
                    color: var(--text-main);
                }

                .premium-tag i {
                    font-size: 18px;
                    margin-right: 6px;
                    color: var(--accent);
                }
                
                .cert-card {
                    background-color: var(--card-bg);
                    border: 1px solid var(--card-border);
                    border-radius: 16px;
                    overflow: hidden;
                    transition: all 0.3s ease;
                }
                
                .cert-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 30px -10px rgba(0,0,0,0.6);
                    border-color: rgba(255, 255, 255, 0.15);
                }
                
                .btn-premium {
                    background: linear-gradient(135deg, #e5c924, #bfa61c);
                    border: none;
                    color: #111625;
                    border-radius: 30px;
                    padding: 10px 20px;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(229, 201, 36, 0.3);
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .btn-premium:hover {
                    background: linear-gradient(135deg, #bfa61c, #998416);
                    transform: scale(1.02);
                    box-shadow: 0 6px 20px rgba(229, 201, 36, 0.5);
                    color: #111625;
                    text-decoration: none;
                }
            </style>
            
            <div class="home-banner text-white mb-5">
                <div class="container-fluid position-relative text-center w-100 px-3 px-md-5">
                    <h1 class="display-4 bold mb-3" data-aos="fade-up" data-aos-duration="800" style="font-size: 2.8rem; line-height: 1.2;">
                        Bienvenido a ICC <br>
                        <span style="font-size: 2.2rem; color: #e2e8f0; font-weight: 600;">Instituto de Capacitación Continua</span>
                    </h1>
                    <p class="lead mb-4" style="color: #a1a1aa; font-size: 1.25rem;" data-aos="fade-up" data-aos-duration="1000">Cursos en Ingeniería Eléctrica</p>
                    
                    <?php if($resume_curso): ?>
                    <div class="d-inline-flex mt-2 mx-auto" data-aos="fade-up" data-aos-duration="1000">
                        <div style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 50px; border: 1px solid rgba(229, 201, 36, 0.2); box-shadow: 0 10px 20px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; padding: 6px 6px 6px 20px;">
                            <h6 class="text-uppercase mb-0 mr-4 d-flex align-items-center" style="color: var(--accent); letter-spacing: 1px; font-size: 0.8rem; font-weight:700;">
                                <i class="material-icons mr-2" style="font-size: 20px;">play_circle_filled</i> Continuar: <span class="text-white ml-2" style="font-weight: 600; text-transform: none;"><?= htmlspecialchars($resume_curso['nombre_curso']) ?></span>
                            </h6>
                            <a href="<?= BASE_URL ?>aula/curso/<?= $resume_curso['id_curso'] ?>" class="btn-premium" style="padding: 8px 24px; font-size: 0.85rem; border-radius: 30px; margin-bottom: 0;">Retomar</a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="container page__container">
                <div class="mb-5 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;" data-aos="fade-in">
                    <h2 class="bold mb-2 text-center" style="color: #fff; font-size: 2.2rem;">Cursos Activos</h2>
                    <p class="text-center" style="color: var(--accent); font-size: 1.1rem; font-weight: 500; letter-spacing: 1px; text-transform: uppercase;">Nuestros cursos matriculados</p>
                </div>
                <div class="pb-4">
                    <div class="row justify-content-center">

<?php  
if(!empty($cursos)) {
    foreach ($cursos as $curso) {
        $img_curso = ($curso['foto'] == 'default.png') 
            ? 'https://www.file-extension.info/images/resource/formats/img.png' 
            : BASE_URL . 'assets/images/cursos/' . $curso['foto'];
        ?>
        <div class="col-lg-10 col-12 mb-4" data-aos="fade-up">
            <a href="<?= BASE_URL ?>aula/curso/<?= $curso['id_curso'] ?>" class="text-decoration-none">
                <div class="course-card-premium">
                    <div class="course-img-wrapper">
                        <img src="<?= $img_curso ?>" alt="Portada Curso">
                        <div class="play-overlay"><i class="material-icons">play_circle_filled</i></div>
                        <div class="course-img-overlay"></div>
                    </div>
                    <div class="p-4 p-md-5 w-100">
                        <h4 class="course-title mb-4 d-flex align-items-center">
                            <i class="material-icons mr-3" style="color: var(--accent); font-size: 28px;">check_circle</i> 
                            <?= htmlspecialchars($curso['nombre_curso']) ?>
                        </h4>
                        <div class="d-flex flex-wrap align-items-center" style="gap: 12px;">
                            <span class="premium-tag">
                                <i class="material-icons">signal_cellular_alt</i> <?= htmlspecialchars($curso['categoria'] ?? 'Básico') ?>
                            </span>
                            <span class="premium-tag">
                                <i class="material-icons">schedule</i> <?= $curso['horas_academicas'] ?> horas de contenido
                            </span>
                        </div>
                        
                        <?php 
                        // En el futuro calcular progreso real.
                        $progreso_demo = rand(15, 95); 
                        ?>
                        <div class="mt-4 pt-3 border-top" style="border-color: var(--card-border) !important;">
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Progreso del curso</span>
                                <span style="color: var(--accent); font-size: 0.85rem; font-weight: 800;"><?= $progreso_demo ?>%</span>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar-fill" style="width: <?= $progreso_demo ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
    }
} else {
    echo "
    <div class='col-12 text-center py-5' data-aos='fade-up'>
        <div style='background: var(--card-bg); border: 1px dashed rgba(255,255,255,0.1); border-radius: 20px; padding: 60px 20px; max-width: 600px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.2);'>
            <div style='width: 100px; height: 100px; background: rgba(229, 201, 36, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;'>
                <i class='material-icons' style='font-size: 50px; color: var(--accent);'>explore</i>
            </div>
            <h3 class='text-white mb-3' style='font-weight: 700;'>¡Aún no tienes cursos activos!</h3>
            <p style='color: var(--text-muted); font-size: 1.1rem; margin-bottom: 30px;'>Explora nuestro catálogo y empieza a aprender con los mejores expertos de la industria.</p>
            <a href='" . BASE_URL . "cursos' class='btn-premium' style='padding: 12px 30px; font-size: 1.1rem;'><i class='material-icons mr-2'>storefront</i> Ver Catálogo de Cursos</a>
        </div>
    </div>";
}
?>
                    </div>

                    <!-- SECCION CERTIFICADOS -->
                    <div class="col-12 mt-5">
                        <div class="mb-5 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;" data-aos="fade-in">
                            <h2 class="bold mb-2 text-center" style="color: #fff; font-size: 2.2rem;">Tus Certificados</h2>
                        </div>
                    </div>
                    <div class="row">
                    <?php
                    if (!empty($certificados)) {
                        foreach($certificados as $cert) {
                            $img_curso = ($cert['foto'] == 'default.png') ? 'https://www.file-extension.info/images/resource/formats/img.png' : BASE_URL . 'assets/images/cursos/' . $cert['foto'];
                            ?>
                            <div class='col-md-6 col-lg-4 mb-4' data-aos="fade-up">
                                <div class='course-card-premium h-100 d-flex flex-column' style='flex-direction: column !important;'>
                                    <div class='card-img-top text-center' style='height:200px; overflow:hidden; width: 100%;'>
                                        <img src='<?= $img_curso ?>' style='width:100%; height:100%; object-fit: cover;' alt='Curso'>
                                    </div>
                                    <div class='p-4 text-center border-bottom flex-grow-1' style="border-color: rgba(255,255,255,0.05) !important;">
                                        <div class='bold mb-3'>
                                            <h5 class='text-white' style="font-weight: 600; line-height: 1.4;"><?= htmlspecialchars($cert['nombre_curso']) ?></h5>
                                        </div>
                                        <div class='text-muted'>
                                            <small style="font-size: 0.9rem;">Subido el: <?= date('d/m/Y', strtotime($cert['fecha_subida'])) ?></small>
                                        </div>
                                    </div>
                                    <div class='p-4 text-center mt-auto w-100'>
                                        <a target="_blank" href='<?= BASE_URL ?>assets/certificados/<?= $cert['archivo_pdf'] ?>' class='btn-premium w-100' style='display: block;'>
                                            <i class="material-icons mr-2">file_download</i> Descargar
                                        </a>
                                    </div>         
                                </div>
                            </div> 
                            <?php
                        }
                    } else {
                        echo "
                        <div class='col-12 text-center py-5' data-aos='fade-up'>
                            <div style='background: var(--card-bg); border: 1px dashed rgba(255,255,255,0.1); border-radius: 20px; padding: 50px 20px; max-width: 500px; margin: 0 auto;'>
                                <div style='width: 80px; height: 80px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;'>
                                    <i class='material-icons' style='font-size: 40px; color: var(--text-muted);'>workspace_premium</i>
                                </div>
                                <h4 class='text-white mb-2' style='font-weight: 600;'>Sin certificados disponibles</h4>
                                <p style='color: var(--text-muted); font-size: 1rem;'>Tus certificados aparecerán aquí una vez que culmines satisfactoriamente un curso.</p>
                            </div>
                        </div>";
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
