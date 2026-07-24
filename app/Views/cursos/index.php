
    <!--Page Header Start-->
    <section class="page-header clearfix" style="background-image: url(<?= BASE_URL ?>assets/images/backgrounds/icc_capacitacion.png);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2>Cursos</h2>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                                <li class="active">Cursos</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--Page Header End-->



    <!--Courses One Start-->
    <section class="courses-one courses-one--courses">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Revisar nueva lista</span>
                <h2 class="section-title__title">Explorar Cursos</h2>
            </div>

            <div class="row">
                <!--Start case-studies-one Top-->
                <div class="courses-one--courses__top">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="courses-one--courses__menu-box">
                            <ul class="project-filter clearfix post-filter has-dynamic-filters-counter list-unstyled">
                                <li data-filter=".filter-item" class="active"><span class="filter-text">Todos</span></li>
                                <li data-filter=".featured"><span class="filter-text">Ingeniería Eléctrica</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End case-studies-one Top-->
            </div>


            <div class="row filter-layout masonary-layout">
                <?php if (!empty($cursos)): ?>
                    <?php foreach ($cursos as $curso): ?>
                        <?php 
                            $slug = strtolower(str_replace(' ', '_', $curso['nombre_curso']));
                            $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                            $slug = str_replace('_', '-', $slug);
                            $foto = !empty($curso['foto']) ? $curso['foto'] : 'default.png';
                            $docFoto = !empty($curso['docente_foto']) ? $curso['docente_foto'] : '50x50';
                        ?>
                        <!--Start Single Courses One-->
                        <div class="col-xl-4 col-lg-4 col-md-6 filter-item featured">
                            <div class="courses-one__single" data-aos="fade-up">
                                <div class="courses-one__single-img">
                                    <div style="width: 100%; height: 200px; overflow: hidden;"><img src="<?= BASE_URL ?>assets/images/cursos/<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($curso['nombre_curso']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius: 12px; margin-bottom: 20px;"></div>
                                    <div class="overlay-text">
                                        <p>libre</p>
                                    </div>
                                </div>
                                <div class="courses-one__single-content" style="background-color: white;">
                                    <div class="courses-one__single-content-overlay-img">
                                        <div style="background-color: var(--mo-surface); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 5px; margin: 0 auto; overflow: hidden;">
                                            <?php if ($docFoto !== '50x50'): ?>
                                                <img src="<?= BASE_URL ?>assets/images/docentes/<?= htmlspecialchars($docFoto) ?>" style="width:100%; height:100%; object-fit:cover; border-radius: 50%;" alt="Docente">
                                            <?php else: ?>
                                                <span style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 9px; line-height: 1;">FOTO<br>50x50</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <h6 class="courses-one__single-content-name"><?= htmlspecialchars($curso['docente'] ?? 'Docente ICC') ?></h6>
                                    <h4 class="courses-one__single-content-title"><a href="<?= BASE_URL ?>cursos/detalle/<?= $slug ?>"><?= htmlspecialchars($curso['nombre_curso']) ?></a></h4>
                                    <div class="courses-one__single-content-review-box">
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                        <div class="rateing-box">
                                            <span>(5)</span>
                                        </div>
                                    </div>
                                    <?php
                                    $precioPreventa = 89.90;
                                    $horas = ($curso['horas_academicas'] ?? 20);
                                    $nombreCursoSafe = strtolower($curso['nombre_curso'] ?? '');
                                    
                                    if (strpos($nombreCursoSafe, 'subestaciones') !== false) {
                                        $precioPreventa = 99.00;
                                        $horas = 25;
                                    } elseif (strpos($nombreCursoSafe, 'condensadores') !== false) {
                                        $precioPreventa = 99.00;
                                        $horas = 25;
                                    } elseif (strpos($nombreCursoSafe, 'analizador') !== false) {
                                        $precioPreventa = 99.00;
                                        $horas = 25;
                                    } elseif (strpos($nombreCursoSafe, 'canalizacion') !== false) {
                                        $precioPreventa = 100.00;
                                        $horas = 16;
                                    } elseif (strpos($nombreCursoSafe, 'terminaciones') !== false) {
                                        $precioPreventa = 99.00;
                                        $horas = 15;
                                    } elseif (strpos($nombreCursoSafe, 'empalmes') !== false) {
                                        $precioPreventa = 99.00;
                                        $horas = 15;
                                    } elseif (strpos($nombreCursoSafe, 'variadores') !== false) {
                                        $precioPreventa = 99.00;
                                        $horas = 30;
                                    } elseif (strpos($nombreCursoSafe, 'electricidad industrial') !== false) {
                                        $precioPreventa = 100.00;
                                        $horas = 40;
                                    } else {
                                        $precioPreventa = $curso['precio'] ?? 89.90;
                                    }
                                    ?>
                                    <p class="courses-one__single-content-price">S/<?= number_format($precioPreventa, 2) ?></p>
                                    <ul class="courses-one__single-content-courses-info list-unstyled">
                                        <li><?= htmlspecialchars($curso['lecciones'] ?? 10) ?> Lecciones</li>
                                        <li><?= htmlspecialchars($horas) ?> Horas</li>
                                        <li>Experto</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--End Single Courses One-->
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center" style="margin-bottom: 50px;">
                        <p>No hay cursos disponibles por el momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Courses One End-->
