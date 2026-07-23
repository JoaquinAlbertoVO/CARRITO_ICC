
        
        <section class="main-slider main-slider-two">
            <div class="swiper-container thmáswiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true, "effect": "fade", "pagination": {
            "el": "#main-slider-pagination",
            "type": "bullets",
            "clickable": true
            },
            "navigation": {
            "nextEl": "#main-slider__swiper-button-next",
            "prevEl": "#main-slider__swiper-button-prev"
            },
            "autoplay": {
            "delay": 5000
            }}'>

                <div class="swiper-wrapper">
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc.png') center/cover no-repeat;"></div>

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12" style="min-height: 400px;">
                                    <!-- El texto y botón ya están incluidos en el diseño de la imagen banner_icc.png -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc.png') center/cover no-repeat;"></div>

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12" style="min-height: 400px;">
                                    <!-- El texto y botón ya están incluidos en el diseño de la imagen banner_icc.png -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc.png') center/cover no-repeat;"></div>

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12" style="min-height: 400px;">
                                    <!-- El texto y botón ya están incluidos en el diseño de la imagen banner_icc.png -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->


                </div>
                <!-- If we need navigation buttons -->
                <div class="swiper-pagination" id="main-slider-pagination"></div>
            </div>
        </section>

<?php
$ingenieria_courses = $ingenieria_courses ?? [];
?>
        <!--Courses One Start INGENIERÍA-->
        <section class="courses-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Todos los meses encontrarás nuevo contenido en la plataforma</h2>
                    <h2 class="" style="color: #1a1e68;">CURSOS ESPECIALIZADOS EN INGENIERÍA</h2>
                </div>
                <div class="row">
                    <?php foreach($ingenieria_courses as $course): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="tarjeta-dark">
                            <div class="tarjeta-dark-img">
                                <div style="width: 100%; height: 200px; overflow: hidden;"><img src="<?= BASE_URL ?><?= $course['image'] ?>" alt="Curso" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
                            </div>
                            <div class="tarjeta-dark-content">
                                <span class="etiqueta-verde">CURSO</h2>
                                <h3 class="tarjeta-dark-title">
                                    <a href="<?= BASE_URL . 'cursos/detalle/' . str_replace(['detalle_', '.php', '_'], ['', '', '-'], $course['link']) ?>"><?= $course['title'] ?></a>
                                </h3>
                                <div class="tarjeta-dark-meta">
                                    <div class="meta-item">
                                        <i class="far fa-calendar-alt"></i> PROX.
                                    </div>
                                    <div class="meta-item">
                                        <i class="far fa-money-bill-alt"></i> <?= $course['price'] ?>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-graduation-cap"></i> <?= $course['hours'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
</div>                <div class="row" style="margin-top: 40px;"><div class="col-12 text-center"><a href="<?= BASE_URL ?>cursos" class="thm-btn">Ver todos los cursos</a></div></div>
            </div>
        </section>
        <!--Courses One End INGENIERÍA-->

        <!--Features One Start-->
        <section class="features-one">
            <div class="container">
                <div class="row">
                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-empowerment"></h2>
                            </div>
                            <div class="features-one__single-text">
                                <h3 ><a href="#">Aprende habilidades</a></h3>
                                <p>Nuestros cursos se actualizan constantemente.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-human-resources-1"></h2>
                            </div>
                            <div class="features-one__single-text">
                                <h3 ><a href="#">Profesores Expertos</a></h3>
                                <p>Te acompañarán docentes con amplia experiencia.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-recruitment"></h2>
                            </div>
                            <div class="features-one__single-text">
                                <h3 ><a href="#">Cursos Certificados</a></h3>
                                <p>Al culminar las horas lectivas recibirán un certificado otorgado por ICC.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->
                </div>
            </div>
        </section>
        <!--Features One End-->

        <!--Start Welcome One-->
        <section class="welcome-one" style="margin-top: 80px;">
            <div class="container">
                <div class="row">
                    <!--Start Welcome One Left-->
                    <div class="col-xl-6">
                        <div class="welcome-one__left">
                            <div class="section-title">
                                <span class="section-title__tagline" >Presentaciones de la empresa</h2>
                                <h2  class="">APRENDE AHORA <br>CON ICC</h2>
                            </div>
                            <p class="welcome-one__left-text" >Actualiza tus conocimientos y capacítate con nosotros.<br>Te damos lo mejor en INGENIERÍA Eléctrica.</p>
                            <ul class="welcome-one__left-features-box list-unstyled">
                                <!--Start Welcome One Left Features Box Single-->
                                <li class="welcome-one__left-features-box-single">
                                    <div class="welcome-one__left-features-box-single-icon">
                                        <span class="icon-professor"></h2>
                                    </div>
                                    <div class="welcome-one__left-features-box-single-title">
                                        <h3 >Empieza a aprender de <br>nuestros expertos</h3>
                                    </div>
                                </li>
                                <!--End Welcome One Left Features Box Single-->

                                <!--Start Welcome One Left Features Box Single-->
                                <li class="welcome-one__left-features-box-single">
                                    <div class="welcome-one__left-features-box-single-icon">
                                        <span class="icon-knowledge"></h2>
                                    </div>
                                    <div class="welcome-one__left-features-box-single-title">
                                        <h3 >Mejora tus habilidades <br>con nosotros ahora</h3>
                                    </div>
                                </li>
                                <!--End Welcome One Left Features Box Single-->
                            </ul>
                        </div>
                    </div>
                    <!--End Welcome One Left-->

                    <!--Start Welcome One Right-->
                    <div class="col-xl-6">
                            <style>
                                .hover-swap {
                                    position: relative;
                                    height: 380px;
                                    width: 100%;
                                    transform-style: preserve-3d;
                                    perspective: 1000px;
                                    margin-top: 30px;
                                }
                                .img-zoom {
                                    position: absolute;
                                    right: 10px;
                                    top: 0;
                                    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
                                    transform: translateZ(0px);
                                }
                                .img-material {
                                    position: absolute;
                                    left: -20px;
                                    bottom: -20px;
                                    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
                                    transform: translateZ(40px);
                                }
                                .hover-swap:hover .img-zoom {
                                    /* La imagen del fondo pasa al frente y se mueve a la izquierda para dejarse ver */
                                    transform: translateZ(80px) translateX(-50px) scale(1.05);
                                }
                                .hover-swap:hover .img-material {
                                    /* El cuadro de texto pasa al fondo y se aparta a la derecha */
                                    transform: translateZ(-30px) translateX(50px) scale(0.95);
                                }
                            </style>
                            <div class="welcome-one__right clearfix hover-swap">
                                <div class="shape1 rotate-me"><img src="<?= BASE_URL ?>assets/images/shapes/thmáshape1.png" alt="" /></div>
                                
                                <div class="img-zoom" data-aos="fade-left">
                                    <img src="<?= BASE_URL ?>assets/images/CUADRO_300X350.png" alt="Zoom" style="width: 100%; max-width: 300px; border-radius: 16px; box-shadow: 0 15px 30px rgba(0,0,0,0.1); display: block;">
                                </div>
                                
                                <div class="img-material" data-aos="zoom-in">
                                    <img src="<?= BASE_URL ?>assets/images/CUADRO_230X250.png" alt="Material" style="width: 100%; max-width: 230px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); display: block;">
                                </div>
                            </div>
                    </div>
                    <!--End Welcome One Right-->
                </div>
            </div>
        </section>
        <!--End Welcome One-->

        <!--Counter One Start-->
        <section class="counter-one" style="background: transparent; margin-top: 0; padding-top: 100px;">
            <div class="container">
                <div class="row">
                    <!--Start Counter One Left-->
                    <div class="col-xl-5 col-lg-5">
                        <div class="counter-one__left">
                            <div class="section-title">
                                <span class="section-title__tagline">Hechos grandiosos</h2>
                                <h2 class="">La misión de ICC <br>es pulir tu habilidad</h2>
                            </div>
                            <!--<p class="counter-one__left-text">There are many variations of passages of lore ipsum
                                available but the majority have suffered.</p>-->
                        </div>
                    </div>
                    <!--End Counter One Left-->

                    <!--Start Counter One Right-->
                    <div class="col-xl-7 col-lg-7">
                        <div class="counter-one__right">
                            <ul class="counter-one__right-box list-unstyled">
                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single" data-aos="fade-left">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-teacher"></h2>
                                    </div>
                                    <!--<h3 class="odometer" data-count="6800">00</h3>-->
                                    <p class="counter-one__right-text" >Profesores profesionales</p>
                                </li>
                                <!--End Counter One Right Single-->

                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single" data-aos="fade-left">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-online-course"></h2>
                                    </div>
                                    <!--<h3 class="odometer" data-count="9800">00</h3>-->
                                    <p class="counter-one__right-text" >Cursos de habilidades</p>
                                </li>
                                <!--End Counter One Right Single-->

                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single" data-aos="fade-left">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-student"></h2>
                                    </div>
                                    <!--<h3 class="odometer" data-count="7700">00</h3>-->
                                    <p class="counter-one__right-text" >Estudiantes Inscritos</p>
                                </li>
                                <!--End Counter One Right Single-->
                            </ul>
                        </div>
                    </div>
                    <!--End Counter One Right-->
                </div>
            </div>
        </section>
        <!--Counter One End-->

        <!--Start Testimonials Two-->
        <section class="testimonials-two">
            <div class="testimonials-two__pattern"><img src="<?= BASE_URL ?>assets/images/pattern/testimonials-two-left-pattern.png"
                    alt="" /></div>
            <div class="container">
                <div class="row">
                    <!--Start Testimonials Two Left-->
                    <div class="col-xl-4">
                        <div class="testimonials-two__left">
                            <div class="section-title">
                                <span class="section-title__tagline">Qué opinan nuestros Usuarios</h2>
                                <h2 class="" style="font-size: 50px; font-family: League Spartan;">¿Qué están <br>diciendo?</h2>
                            </div>
                            <p class="testimonials-two__left-text" >Tenemás una calificación promedio de 4.7 de 5 estrellas.</p>
                        </div>
                    </div>
                    <!--End Testimonials Two Left-->

                    <!--Start Testimonials Two Right-->
                    <div class="testimonials-two__right">
                        <div class="testimonials-two__carousel owl-carousel owl-theme owl-dot-type1 style2">
                            <div class="item">

                                <!--Start Single Testimonials One -->
                                <div class="testimonials-one__single">
                                    <div class="testimonials-one__single-inner">
                                        <h3 class="testimonials-one__single-title" >Regulación del Mercado Eléctrico</h3>
                                        <p class="testimonials-one__single-text">Un curso muy recomendado, ayuda ampliar los conocimientos acerca del Sector Energía. Además de conocer el Marco Interinstitucional del Subsector Eléctrico de una forma muy didáctica.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio1.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h4></h4>
                                                <p >Usuario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Testimonials One -->

                            </div><!-- /.item -->

                            <div class="item">
                                <!--Start Single Testimonials One -->
                                <div class="testimonials-one__single">
                                    <div class="testimonials-one__single-inner">
                                        <h3 class="testimonials-one__single-title" >Curso de Especialización de Analizador de Redes</h3>
                                        <p class="testimonials-one__single-text">Este curso fue útil para abarcarme en la especialización de Redes. Los Ponentes son muy concisos y se observa su profesionalismo.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio2.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h4></h4>
                                                <p >Usuario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Testimonials One -->

                            </div><!-- /.item -->

                            <div class="item">
                                <!--Start Single Testimonials One -->
                                <div class="testimonials-one__single">
                                    <div class="testimonials-one__single-inner">
                                        <h3 class="testimonials-one__single-title" >Especialización de Motores Eléctricos</h3>
                                        <p class="testimonials-one__single-text">Los materiales educativos son muy buenos y completos, del másmo modo que resulta muy fácil de abordar sin tener conocimientos previos.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio3.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h4></h4>
                                                <p >Usuario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Testimonials One -->

                            </div><!-- /.item -->

                            <div class="item">
                                <!--Start Single Testimonials One -->
                                <div class="testimonials-one__single">
                                    <div class="testimonials-one__single-inner">
                                        <h3 class="testimonials-one__single-title" >Banco de Condensadores</h3>
                                        <p class="testimonials-one__single-text">Fue todo un placer realizar este curso. Puesto que el enfoque del ponente fue impecable. Me gustaría realizar otro curso que amplie más conocimientos relacionado a este campo.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio5.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h4></h4>
                                                <p >Usuario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Testimonials One -->

                            </div><!-- /.item -->
                            <div class="item">
                                <!--Start Single Testimonials One -->
                                <div class="testimonials-one__single">
                                    <div class="testimonials-one__single-inner">
                                        <h3 class="testimonials-one__single-title" >Sistema de Puesta a Tierra</h3>
                                        <p class="testimonials-one__single-text">El curso dictado fue muy interesante. La estructura y la calidad de los contenidos han sido de lo mejor para el aprendizaje. Me han permitido descubrir acerca de este tema que tardaría en descubrir por mí másmo</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio4.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h4></h4>
                                                <p >Usuario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Single Testimonials One -->

                            </div><!-- /.item -->
                        </div>
                    </div>
                    <!--End Testimonials Two Right-->
                </div>
            </div>
        </section>
        <!--End Testimonials Two-->

        <!--Start Registration Two-->
        <section class="registration-two">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="registration-two__wrapper">
                            <div class="shape1 zoom-fade"><img src="<?= BASE_URL ?>assets/images/shapes/thmáshape2.png" alt="" /></div>
                            <div class="shape2 "  ><img
                                    src="<?= BASE_URL ?>assets/images/shapes/thmáshape3.png" alt="" /></div>
                            <div class="registration-two__left">
                                <h2 class="" style="font-size: 50px; color: #FFF;">Comience su carrera educativa <br>con ICC</h2>
                            </div>
                            <div class="registration-two__right">
                                <div class="registration-two__right-btn">
                                    <a href="<?= BASE_URL ?>contacto" class="thm-btn">Descubrir más</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--End Registration Two-->
        <!--<a target="blank" href="https://wa.link/zw6o1w" class="btn-whatsapp-pulse"><i class="fab fa-whatsapp"></i></a>-->









