<!--Page Header Start-->
    <!--<section class="page-header clearfix" style="background-image: url(<?= BASE_URL ?>assets/images/backgrounds/page-header-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2>Course Details</h2>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="index.html">Home</a></li>
                                <li class="active">Course Details</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>-->
    <!--Page Header End-->

    <!--Start Course Details-->
    <section class="course-details">
        <div class="container">
            <div class="row">
                <!--Start Course Details Content-->
                <div class="col-xl-8 col-lg-8">
                    <div class="course-details__content">
                        <!--Start Single Courses One-->
                        <div class="courses-one__single style2 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                            <?php
                            $cName = strtolower($curso['nombre_curso'] ?? '');
                            if (strpos($cName, 'condensadores') !== false) {
                                $video_url = 'https://www.youtube.com/embed/8TLJJCuo8Yg?rel=0';
                            } elseif (strpos($cName, 'terminaciones') !== false) {
                                $video_url = 'https://www.youtube.com/embed/EFj6mLwhkjg?rel=0';
                            } elseif (strpos($cName, 'industrial') !== false) {
                                $video_url = 'https://www.youtube.com/embed/lvb5RYvgjL0?rel=0';
                            } elseif (strpos($cName, 'analizador') !== false) {
                                $video_url = 'https://www.youtube.com/embed/h9UIxWA7_Lw?rel=0';
                            } else {
                                $video_url = 'https://www.youtube.com/embed/7SMbMxs27K0?rel=0';
                            }
                            ?>
                            <div class="course-video-container" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 20px;">
                                <iframe width="100%" height="450" src="<?= $video_url ?>" title="Video de introducción" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display: block;"></iframe>
                            </div>
                            <div class="courses-one__single-content" style="padding-top: 0; border: none; box-shadow: none;">
                                <div class="course-details__content-list">
                                    <h3 class="course-details__curriculum-single-title">Requisitos</h3>
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>No se necesita conocimiento previo.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Una laptop o cualquier dispositivo con conexión a internet.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>
                                <div class="course-details__content-list">
                                    <h3 class="course-details__curriculum-single-title">Inversión</h3>
                                    <h5 class="" style="color: #4D5FE3;">➤ 90 Soles ó 23 dólares</h5><br>
                                    <span style="color: black;">Incluye:</span>
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Acceso ilimitado a los videos grabados del curso.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Acceso ilimitado a los manuales y plataforma virtual del curso.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Certificado virtual y físico a nombre de ICC con duración de 120 horas.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Asesoría virtual en caso de cualquier duda del curso.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="icon-confirmation"></span>
                                            </div>
                                            <div class="text">
                                                <p>Docentes altamente calificados a nivel Nacional e Internacional.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--End Single Courses One-->

                        <!--Start Course TEMARIO-->
                        <div class="">
                            <div class="">
                                <div class="accordion">
                                    <h1 style="background-color: #F1F2F6; border-radius: 8px; font-family: League Spartan;">Temario</h1>
                                    <dl>
                                                                                <?php if(!empty($data['modulos'])): ?>
                                            <?php foreach($data['modulos'] as $nombre_modulo => $videos): ?>
                                                <dt><a class="accordionTitle courses-one__single-content" href="#" style="font-family: League Spartan;"><?= htmlspecialchars($nombre_modulo) ?></a></dt>
                                                <dd class="accordionItem accordionItemCollapsed" style="margin-bottom: 0;">
                                                    <div class="course-details__content-list"><br>
                                                        <ul class="list-unstyled" style="padding-left: 35px;">
                                                            <?php foreach($videos as $video): ?>
                                                                <li>
                                                                    <div class="icon">
                                                                        <span class="icon-confirmation"></span>
                                                                    </div>
                                                                    <div class="text">
                                                                        <p><?= htmlspecialchars($video['titulo']) ?></p>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul><br>
                                                    </div>
                                                </dd>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <dt><a class="accordionTitle courses-one__single-content" href="#" style="font-family: League Spartan;">Próximamente Temario</a></dt>
                                        <?php endif; ?>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <!--End Course TEMARIO--><br>

                        <!--Start Course Details Curriculum-->
                        <div class="course-details__curriculum">
                            <h2 class="course-details__curriculum-title">Inicio</h2>
                            <!--Start Single Course Details Curriculum-->
                            <div class="course-details__curriculum-single">
                                <p class="course-details__curriculum-single-text">Ingreso al aula virtual 24/7 avance de acuerdo su ritmo, inician en el momento que se efectúe la compra de este. Clases asincrónicas no tiene un horario fijo, podrás verlo a tu propio ritmo y podrás repetir las clases cuantas veces quieras ya que tienes acceso ilimitado.</p><br>
                                <h3 class="course-details__curriculum-single-title">Pasos para realizar inscripción:</h3>
                                <ol class="">
                                    <li>
                                        <div class="icon">
                                            <span class=""></span>
                                        </div>
                                        <div class="text">
                                            <p>Realizar el depósito en cualquiera de nuestras cuentas.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class=""></span>
                                        </div>
                                        <div class="text">
                                            <p>Luego enviar la foto del voucher por este medio, en conjunto con su N° de DNI, correo electrónico y los cursos a elegir.</p>
                                        </div>
                                    </li>
                                </ol>
                                <span>⚠️ NOTA IMPORTANTE Si desea Boleta o Factura, solicitarlo por este medio y abonar únicamente a la Cuenta Corriente, caso contrario solo abonar a las cuentas.</span>
                            </div>
                            <!--End Single Course Details Curriculum-->

                        </div>
                        <!--End Course Details Curriculum-->

                        <!--Start Course Details Reviews-->
                        <div class="course-details__reviews">
                            <h3 class="course-details__reviews-title">Reseñas</h3>
                            <div class="course-details__progress-review">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-7 col-md-7">
                                        <div class="course-details__progress clearfix">
                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Excelente</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 90%;"></span>
                                                </div>
                                                <p class="course-details__progress-count">2</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Muy bueno</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 80%;"></span>
                                                </div>
                                                <p class="course-details__progress-count">1</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Promedio</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 70%;"></span>
                                                </div>
                                                <p class="course-details__progress-count">1</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Pobre</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 0%;" class="no-bubble"></span>
                                                </div>
                                                <p class="course-details__progress-count">0</p>
                                            </div>

                                            <div class="course-details__progress-item">
                                                <p class="course-details__progress-text">Horrible</p>
                                                <div class="course-details__progress-bar">
                                                    <span style="width: 0%;" class="no-bubble"></span>
                                                </div>
                                                <p class="course-details__progress-count">0</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                        <div class="course-details__review-box">
                                            <h2 class="course-details__review-count">4.6</h2>
                                            <div class="course-details__review-stars">
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                                <i class="fas fa-star"></i><!-- /.fas fa-star -->
                                            </div>
                                            <p class="course-details__review-text">30 RESEÑAS</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="course-details__add-review">
                                <div class="course-details__add-review-form">
                                    <form action="assets/inc/sendemail.php" class="comment-one__form contact-form-validated" novalidate="novalidate">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <a href="https://wa.link/zkj9jo" target="_black" class="thm-btn comment-form__btn">Inscríbete Aquí</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--End Course Details Reviews-->
                    </div>
                </div>
                <!--End Course Details Content-->

                <!--Start Course Details Sidebar-->
                <div class="col-xl-4 col-lg-4">
                    <div class="course-details__sidebar">
                        <div class="courses-one__single style2 wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 30px; box-shadow: 0px 10px 30px 0px rgba(0, 0, 0, 0.07); border-radius: 8px; overflow: hidden; background-color: #ffffff;">
                            <div class="courses-one__single-img">
                                <img src="<?= BASE_URL ?>assets/images/cursos/<?= htmlspecialchars($curso['foto'] ?? 'default.png') ?>" alt="<?= htmlspecialchars($curso['nombre_curso'] ?? 'Curso') ?>" style="width: 100%; height: 220px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                <div class="overlay-text">
                                    <p>libre</p>
                                </div>
                            </div>
                            <div class="courses-one__single-content" style="padding: 20px 20px 10px 20px;">
                                <div class="courses-one__single-content-overlay-img">
                                    <img src="https://ui-avatars.com/api/?name=Ricardo+Cardenas&background=random&color=fff&size=50" alt="Profesor" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;">
                                </div>
                                <h6 class="courses-one__single-content-name">Ricardo Cardenas <span>Actualizado recientemente</span></h6>
                                <h4 class="courses-one__single-content-title" style="font-size: 18px; line-height: 1.3; margin-bottom: 10px;"><?= htmlspecialchars($curso['nombre_curso'] ?? 'Curso en ICC') ?></h4>
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
                            </div>
                        </div>

                        <div class="course-details__price wow fadeInUp animated" data-wow-delay="0.1s">
                            <h2 class="course-details__price-amount">S/89.90<span><del>S/99.90</del></span></h2>
                            <div class="course-details__price-btn">
                                <a href="https://wa.link/zkj9jo" target="_black" class="thm-btn">compra este curso</a>
                            </div>
                        </div>

                        <div class="course-details__sidebar-meta wow fadeInUp animated" data-wow-delay="0.3s">
                            <ul class="course-details__sidebar-meta-list list-unstyled">
                                <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href=""><i class="far fa-clock"></i></a>
                                    </div>
                                    <div class="text">
                                        <p><a href="#">Duración:<span> 10 horas</span></a></p>
                                    </div>
                                </li>

                                <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href=""><i class="far fa-folder-open"></i></a>
                                    </div>
                                    <div class="text">
                                        <p><a href="#">Conferencias:<span> 6</span></a></p>
                                    </div>
                                </li>

                                <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href=""><i class="far fa-user-circle"></i></a>
                                    </div>
                                    <div class="text">
                                        <p><a href="#">Estudiantes:<span> Máximo 6</span></a></p>
                                    </div>
                                </li>

                                <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href=""><i class="fas fa-play"></i></a>
                                    </div>
                                    <div class="text">
                                        <p><a href="#">Video:<span> 8 horas</span></a></p>
                                    </div>
                                </li>

                                <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href=""><i class="far fa-flag"></i></a>
                                    </div>
                                    <div class="text">
                                        <p><a href="#">Nivel de habilidad::<span> Avanzado</span></a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="course-details__new-courses wow fadeInUp animated" data-wow-delay="0.5s">
                            <h3 class="course-details__new-courses-title">Nuevos cursos</h3>
                            <ul class="course-details__new-courses-list list-unstyled">
                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/Portada_ANA.png" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title"><a href="<?= BASE_URL ?>cursos/detalle/analisis-facturacion">Análisis de facturación y tarifas eléctricas</a></h4>
                                        <div class="course-details__new-courses-rateing-box">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="course-details__new-courses-rateing-count">
                                                <span>(5)</span>
                                            </div>
                                        </div>
                                        <p class="course-details__new-courses-price">S/89.90</p>
                                    </div>
                                </li>

                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/Portada_EMPTER.png" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title"><a href="<?= BASE_URL ?>cursos/detalle/puesta-tierra">Sistema puesta a tierra</a></h4>
                                        <div class="course-details__new-courses-rateing-box">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="course-details__new-courses-rateing-count">
                                                <span>(5)</span>
                                            </div>
                                        </div>
                                        <p class="course-details__new-courses-price">S/89.90</p>
                                    </div>
                                </li>

                                <li class="course-details__new-courses-list-item">
                                    <div class="course-details__new-courses-list-item-img">
                                        <img src="<?= BASE_URL ?>assets/images/cursos/Portada_BDC.png" alt="Curso" style="width: 65px; height: 65px; object-fit: cover; border-radius: 5px;">
                                    </div>
                                    <div class="course-details__new-courses-list-item-content">
                                        <h4 class="course-details__new-courses-list-item-content-title"><a href="<?= BASE_URL ?>cursos/detalle/banco-condensadores">Banco de condensadores</a></h4>
                                        <div class="course-details__new-courses-rateing-box">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="course-details__new-courses-rateing-count">
                                                <span>(5)</span>
                                            </div>
                                        </div>
                                        <p class="course-details__new-courses-price">S/89.90</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End Course Details Sidebar-->
            </div>
        </div>
    </section>
    <!--End Course Details-->



