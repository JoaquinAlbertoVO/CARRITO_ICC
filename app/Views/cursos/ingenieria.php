

    <!--Page Header Start-->
    <section class="page-header clearfix" style="background-image: url(<?= BASE_URL ?>assets/images/backgrounds/icc_ingenieria_electrica.jpeg);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <!--<h2>Especializaciones en Ingeniería Eléctrica</h2>-->
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
                <span class="section-title__tagline">Todos los meses encontrarás nuevo contenido en la plataforma</span>
                <h2 class="section-title__title" style="color: #1a1e68;">CURSOS ESPECIALIZADOS EN INGENIERÍA</h2>
            </div>

            <div class="row">
                <!--Start case-studies-one Top-->
                <div class="courses-one--courses__top">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="courses-one--courses__menu-box">
                            <ul class="project-filter clearfix post-filter has-dynamic-filters-counter list-unstyled">
                                <li data-filter=".filter-item" class="active"><span class="filter-text">Todos</span></li>
                                <!--<li data-filter=".featured"><span class="filter-text">Featured</span></li>
                                <li data-filter=".business"><span class="filter-text">Business</span></li>
                                <li data-filter=".photography"><span class="filter-text">Photography</span></li>
                                <li data-filter=".development"><span class="filter-text">Development</span></li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End case-studies-one Top-->
            </div>


            <div class="row filter-layout masonary-layout">
                <?php if (!empty($ingenieria_courses)): ?>
                    <?php foreach ($ingenieria_courses as $course): ?>
                    <!--Start Single Courses One-->
                    <div class="col-xl-4 col-lg-4 col-md-6 filter-item development business">
                        <div class="courses-one__single wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                            <div class="courses-one__single-img">
                                <div style="width: 100%; height: 200px; overflow: hidden;"><img src="<?= BASE_URL ?><?= $course['image'] ?>" alt="<?= htmlspecialchars($course['title']) ?>" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
                                <div class="overlay-text">
                                    <p>libre</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content" style="background-color: white;">
                                <div class="courses-one__single-content-overlay-img">
                                    <div style="background-color: var(--mo-surface); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 5px; margin: 0 auto; overflow: hidden;">
                                        <?php if ($course['docente_foto'] && $course['docente_foto'] !== '50x50'): ?>
                                            <img src="<?= BASE_URL ?>assets/images/docentes/<?= $course['docente_foto'] ?>" style="width:100%; height:100%; object-fit:cover; border-radius: 50%;" alt="Docente">
                                        <?php else: ?>
                                            <span style="color: var(--mo-accent); font-family: var(--mo-font-heading); font-size: 9px; line-height: 1;">FOTO<br>50x50</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h6 class="courses-one__single-content-name"><?= htmlspecialchars($course['docente']) ?></h6>
                                <h4 class="courses-one__single-content-title"><a href="<?= BASE_URL ?>cursos/detalle/<?= $course['link'] ?>"><?= htmlspecialchars($course['title']) ?></a></h4>
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
                                <p class="courses-one__single-content-price">S/<?= $course['price'] ?></p>
                                <ul class="courses-one__single-content-courses-info list-unstyled">
                                    <li><?= $course['lecciones'] ?> Lecciones</li>
                                    <li><?= $course['hours'] ?></li>
                                    <li>Experto</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Courses One-->
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p style="color: white; font-size: 18px; margin-top: 30px;">Próximamente tendremos más cursos disponibles.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Courses One End-->

