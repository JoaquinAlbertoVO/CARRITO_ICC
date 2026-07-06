
        
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
                        <div class="image-layer-overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-slider-two__content text-center">
                                        <h2 class="main-slider-two__tagline">Cursos online</h2><br>
                                        <h1 class="main-slider__title" style="font-size:inherit; font-weight:inherit;">Capacítate y certificate<br> con nosotros</h1><br><br><br><br>
                                    </div>
                                    <div class="main-slider-two__button-box text-center">
                                        <a href="<?= BASE_URL ?>nosotros" class="thm-btn">Descubrir más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc.png') center/cover no-repeat;"></div>
                        <div class="image-layer-overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-slider-two__content text-center">
                                        <h2 class="main-slider-two__tagline">Cursos online</h2><br>
                                        <h1 class="main-slider__title" style="font-size:inherit; font-weight:inherit;">Especialízate en Ingeniería<br> Eléctrica con nosotros</h1><br><br><br><br>
                                    </div>
                                    <div class="main-slider-two__button-box text-center">
                                        <a href="<?= BASE_URL ?>nosotros" class="thm-btn">Descubrir más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc.png') center/cover no-repeat;"></div>
                        <div class="image-layer-overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-slider-two__content text-center">
                                        <h2 class="main-slider-two__tagline">Cursos online</h2><br>
                                        <h1 class="main-slider__title" style="font-size:inherit; font-weight:inherit;">Capacítate y certificate<br> con nosotros</h1><br><br><br><br>
                                    </div>
                                    <div class="main-slider-two__button-box text-center">
                                        <a href="<?= BASE_URL ?>nosotros" class="thm-btn">Descubrir más</a>
                                    </div>
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
        <!--Courses One Start INGENIERIA-->
        <section class="courses-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Todos los máses encontrarás nuevo contenido en la plataforma</span>
                    <h2  class="">CURSOS ESPECIALIZADOS EN INGENIERÍA</h2>
                </div>
                <div class="row">
                    <?php foreach($ingenieria_courses as $course): ?>
                    <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up">
                        <div class="tarjeta-dark">
                            <div class="tarjeta-dark-img">
                                <div style="background-color: var(--mo-surface); border: 2px dashed var(--mo-accent); border-radius: 12px; width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 10px; margin-bottom: 20px;"><img src="<?= BASE_URL ?><?= $course['image'] ?>" alt="Curso" style="width:100%; height:100%; object-fit:cover; border-radius:10px;"></div>
                            </div>
                            <div class="tarjeta-dark-content">
                                <span class="etiqueta-verde">CURSO</span>
                                <h4 class="tarjeta-dark-title">
                                    <a href="<?= BASE_URL . 'cursos/detalle/' . str_replace(['detalle_', '.php', '_'], ['', '', '-'], $course['link']) ?>"><?= $course['title'] ?></a>
                                </h4>
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
        <!--Courses One End INGENIERIA-->

        <!--Features One Start-->
        <section class="features-one">
            <div class="container">
                <div class="row">
                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-empowerment"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4 ><a href="#">Aprende habilidades</a></h4>
                                <p>Nuestros cursos se actualizan constantemente.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-human-resources-1"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4 ><a href="#">Profesores Expertos</a></h4>
                                <p>Te acompañarán docentes con amplia experiencia.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-recruitment"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4 ><a href="#">Cursos Certificados</a></h4>
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
        <section class="welcome-one">
            <div class="container">
                <div class="row">
                    <!--Start Welcome One Left-->
                    <div class="col-xl-6">
                        <div class="welcome-one__left">
                            <div class="section-title">
                                <span class="section-title__tagline" >Presentaciones de la empresa</span>
                                <h2  class="">APRENDE AHORA <br>CON ICC</h2>
                            </div>
                            <p class="welcome-one__left-text" >Actualiza tus conocimientos y capacítate con nosotros.<br>Te damás lo mejor en Ingeniería Eléctrica.</p>
                            <ul class="welcome-one__left-features-box list-unstyled">
                                <!--Start Welcome One Left Features Box Single-->
                                <li class="welcome-one__left-features-box-single">
                                    <div class="welcome-one__left-features-box-single-icon">
                                        <span class="icon-professor"></span>
                                    </div>
                                    <div class="welcome-one__left-features-box-single-title">
                                        <h4 >Empieza a aprender de <br>nuestros expertos</h4>
                                    </div>
                                </li>
                                <!--End Welcome One Left Features Box Single-->

                                <!--Start Welcome One Left Features Box Single-->
                                <li class="welcome-one__left-features-box-single">
                                    <div class="welcome-one__left-features-box-single-icon">
                                        <span class="icon-knowledge"></span>
                                    </div>
                                    <div class="welcome-one__left-features-box-single-title">
                                        <h4 >Mejora tus habilidades <br>con nosotros ahora</h4>
                                    </div>
                                </li>
                                <!--End Welcome One Left Features Box Single-->
                            </ul>
                        </div>
                    </div>
                    <!--End Welcome One Left-->

                    <!--Start Welcome One Right-->
                    <div class="col-xl-6">
                        <div class="welcome-one__right clearfix">
                            <div class="shape1 rotate-me"><img src="<?= BASE_URL ?>assets/images/shapes/thmáshape1.png" alt="" /></div>
                            <div class="welcome-one__right-img1" data-aos="fade-left">
                                <div class="welcome-one__right-img1-inner">
                                    <div style="background-color: var(--mo-surface); border: 2px dashed var(--mo-accent); border-radius: 16px; width: 300px; height: 350px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 20px;">
                                        <h4 style="color: var(--mo-accent); font-family: var(--mo-font-heading);">[ ESPACIO PARA IMAGEN 1 ]<br><span style="font-size:14px; font-weight:normal; color:#fff;">(Recomendado: Estudiantes / Profesores)</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="welcome-one__right-img2" data-aos="zoom-in" style="margin-top: 30px; margin-left: -50px;">
                                <div style="background-color: var(--mo-primary); border: 2px dashed #ffffff; border-radius: 16px; width: 250px; height: 250px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                                        <h4 style="color: #ffffff; font-family: var(--mo-font-heading);">[ ESPACIO PARA IMAGEN 2 ]<br><span style="font-size:14px; font-weight:normal; color:#aaa;">(Recomendado: Clase en Zoom)</span></h4>
                                </div>
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
                                <span class="section-title__tagline">Hechos grandiosos</span>
                                <h2 class="">La másión de ICC <br>es pulir tu habilidad</h2>
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
                                        <span class="icon-teacher"></span>
                                    </div>
                                    <!--<h3 class="odometer" data-count="6800">00</h3>-->
                                    <p class="counter-one__right-text" >Profesores profesionales</p>
                                </li>
                                <!--End Counter One Right Single-->

                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single" data-aos="fade-left">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-online-course"></span>
                                    </div>
                                    <!--<h3 class="odometer" data-count="9800">00</h3>-->
                                    <p class="counter-one__right-text" >Cursos de habilidades</p>
                                </li>
                                <!--End Counter One Right Single-->

                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single" data-aos="fade-left">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-student"></span>
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
                                <span class="section-title__tagline">Qué opinan nuestros Usuarios</span>
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
                                        <h4 class="testimonials-one__single-title" >Regulación del Mercado Eléctrico</h4>
                                        <p class="testimonials-one__single-text">Un curso muy recomendado, ayuda ampliar los conocimientos acerca del Sector Energía. Además de conocer el Marco Interinstitucional del Subsector Eléctrico de una forma muy didáctica.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio1.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Carlos Hernandez</h5>
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
                                        <h4 class="testimonials-one__single-title" >Curso de Especialización de Analizador de Redes</h4>
                                        <p class="testimonials-one__single-text">Este curso fue útil para abarcarme en la especialización de Redes. Los Ponentes son muy concisos y se observa su profesionalismo.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio2.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Joel Aguilar</h5>
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
                                        <h4 class="testimonials-one__single-title" >Especialización de Motores Eléctricos</h4>
                                        <p class="testimonials-one__single-text">Los materiales educativos son muy buenos y completos, del másmo modo que resulta muy fácil de abordar sin tener conocimientos previos.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio3.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Judith Sanchez</h5>
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
                                        <h4 class="testimonials-one__single-title" >Banco de Condensadores</h4>
                                        <p class="testimonials-one__single-text">Fue todo un placer realizar este curso. Puesto que el enfoque del ponente fue impecable. Me gustaría realizar otro curso que amplie más conocimientos relacionado a este campo.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio5.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Margaret Abarca</h5>
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
                                        <h4 class="testimonials-one__single-title" >Sistema de Puesta a Tierra</h4>
                                        <p class="testimonials-one__single-text">El curso dictado fue muy interesante. La estructura y la calidad de los contenidos han sido de lo mejor para el aprendizaje. Me han permitido descubrir acerca de este tema que tardaría en descubrir por mí másmo</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="<?= BASE_URL ?>assets/images/testimonial/testimonio4.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>David Julio Vilca</h5>
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








