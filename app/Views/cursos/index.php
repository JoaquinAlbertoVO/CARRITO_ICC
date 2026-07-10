
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
                        <!--Start Single Courses One-->
                        <div class="col-xl-3 col-lg-6 col-md-6 filter-item featured">
                            <div class="courses-one__single" data-aos="fade-up"  >
                                <div class="courses-one__single-img">
                                    <?php if (!empty($curso['foto']) && $curso['foto'] != 'default.png'): ?>
                                        <img src="<?= BASE_URL ?>assets/images/cursos/<?= htmlspecialchars($curso['foto']) ?>" alt="<?= htmlspecialchars($curso['nombre_curso']) ?>" style="width:100%; height:200px; object-fit:cover; border-radius: 12px; margin-bottom: 20px;">
                                    <?php else: ?>
                                        <div style="background-color: var(--mo-surface); border: 2px dashed var(--mo-accent); border-radius: 12px; width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 10px; margin-bottom: 20px;"><h4 style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 14px;">[ ESPACIO PARA IMAGEN ]<br><span style="font-size:11px; font-weight:normal; color:#fff;">(Curso)</span></h4></div>
                                    <?php endif; ?>
                                    <div class="overlay-text">
                                        <p>libre</p>
                                    </div>
                                </div>
                                <div class="courses-one__single-content" >
                                    <div class="courses-one__single-content-overlay-img">
                                        <?php 
                                        $docFoto = $curso['docente_foto'] ?? '';
                                        if (!empty($docFoto) && $docFoto != '50x50') {
                                            $docPath = ($docFoto == '2f7c764e-a95d-4002-b411-fd32c0c174d5.jpg') ? BASE_URL . 'assets/images/' . $docFoto : BASE_URL . 'assets/images/docentes/' . $docFoto;
                                        ?>
                                            <img src="<?= $docPath ?>" alt="<?= htmlspecialchars($curso['docente'] ?? '') ?>" style="width:50px; height:50px; border-radius:50%; object-fit:cover; display:block; margin:0 auto;">
                                        <?php } else { ?>
                                            <div style="background-color: var(--mo-surface); border: 2px dashed var(--mo-accent); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 5px; margin: 0 auto;"><span style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 9px; line-height: 1;">FOTO<br>50x50</span></div>
                                        <?php } ?>
                                    </div>
                                    <h6 class="courses-one__single-content-name"><?= htmlspecialchars($curso['docente'] ?? 'Docente ICC') ?></h6>
                                    <?php
                                        // generate a basic slug for the detail link
                                        $slug = strtolower(str_replace(' ', '_', $curso['nombre_curso']));
                                        $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
                                    ?>
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
                                    <p class="courses-one__single-content-price">S/<?= number_format($curso['precio'] ?? 89.90, 2) ?></p>
                                    <ul class="courses-one__single-content-courses-info list-unstyled">
                                        <li><?= htmlspecialchars($curso['lecciones'] ?? 1) ?> Lecciones</li>
                                        <li><?= htmlspecialchars($curso['horas_academicas'] ?? 20) ?> Horas</li>
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
