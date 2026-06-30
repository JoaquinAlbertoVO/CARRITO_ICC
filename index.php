<?php 
include 'index/head.php'; 
include 'index/header.php';
?>
<!--Iniciar popup-->
<!-- Pop-up de promoción--> 
    <div id="promo-popup" class="popup">
        <div class="popup-content">
            <span class="close" id="close-popup">&times;</span>
            <img src="assets/images/promociones/Capacitacion_Manteniemiento_de_Subestacion_Electrica.jpeg" alt="curso de Mantenimiento de Subestación Eléctrica Presencial" class="promo-image">
            <!--<h2>¡Oferta Especial!</h2>
            <p>Obtén un <strong>20% de descuento</strong> en tu primera compra. Usa el código <strong>BIENVENIDO20</strong> al pagar.</p>-->
            <button onclick="window.location.href='https://wa.link/u045or'">¡LO QUIERO!</button>
        </div>
    </div>
    <script>
        // Mostrar el pop-up al cargar la página
        window.onload = function() {
            document.getElementById('promo-popup').style.display = 'block';
        };

        // Cerrar el pop-up al hacer clic en el botón de cerrar
        document.getElementById('close-popup').onclick = function() {
            document.getElementById('promo-popup').style.display = 'none';
        };
    </script>
<!--Finalizar popup-->        
        <section class="main-slider main-slider-two">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true, "effect": "fade", "pagination": {
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
                            style="background-image: url(assets/images/backgrounds/portada5.png);"></div>
                        <div class="image-layer-overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-slider-two__content text-center">
                                        <h2 class="main-slider-two__tagline">Cursos online</h2><br>
                                        <h2 class="main-slider__title">Capacítate y certificate<br> con nosotros</h2><br><br><br><br>
                                    </div>
                                    <div class="main-slider-two__button-box text-center">
                                        <a href="nosotros.php" class="thm-btn">Descubrir más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background-image: url(assets/images/backgrounds/portada2.jpg);"></div>
                        <div class="image-layer-overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-slider-two__content text-left">
                                        <h2 class="main-slider-two__tagline">Cursos online</h2><br>
                                        <h2 class="main-slider__title" style="font-size: 40px;">Análisis de facturas y Evaluación de Tarifas Eléctricas</h2><br>
                                        <h2 class="main-slider__title" style="font-size: 40px;">Costos y Presupuestos (Proyectos - Servicios de Electricidad)</h2><br>
                                        <h2 class="main-slider__title" style="font-size: 40px;">Configuración e Instalación de Analizadores de redes</h2><br><br>
                                    </div>
                                    <div class="main-slider-two__button-box text-left">
                                        <a href="nosotros.php" class="thm-btn">Descubrir más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background-image: url(assets/images/backgrounds/portada4.png);"></div>
                        <div class="image-layer-overlay"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-slider-two__content text-center">
                                        <h2 class="main-slider-two__tagline">Cursos online</h2><br>
                                        <h2 class="main-slider__title">Capacítate y certificate<br> con nosotros</h2><br><br><br><br>
                                    </div>
                                    <div class="main-slider-two__button-box text-center">
                                        <a href="nosotros.php" class="thm-btn">Descubrir más</a>
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

        <!--Features One Start-->
        <section class="features-one">
            <div class="container">
                <div class="row">
                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-empowerment"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4 style="font-family: League Spartan;"><a href="#">Aprende habilidades</a></h4>
                                <p>Nuestros cursos se actualizan constantemente.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-human-resources-1"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4 style="font-family: League Spartan;"><a href="#">Profesores Expertos</a></h4>
                                <p>Te acompañarán docentes con amplia experiencia.</p>
                            </div>
                        </div>
                    </div>
                    <!--End Single Features One-->

                    <!--Start Single Features One-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="features-one__single">
                            <div class="features-one__single-icon">
                                <span class="icon-recruitment"></span>
                            </div>
                            <div class="features-one__single-text">
                                <h4 style="font-family: League Spartan;"><a href="#">Cursos Certificados</a></h4>
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
                                <span class="section-title__tagline" style="font-family: League Spartan;">Presentaciones de la empresa</span>
                                <h2 style="font-family: League Spartan;" class="">APRENDE AHORA <br>CON ICC</h2>
                            </div>
                            <p class="welcome-one__left-text" style="font-family: 'Reem Kufi Fun';">Actualiza tus conocimientos y capacítate con nosotros.<br>Te damos lo mejor en Ingeniería Eléctrica.</p>
                            <ul class="welcome-one__left-features-box list-unstyled">
                                <!--Start Welcome One Left Features Box Single-->
                                <li class="welcome-one__left-features-box-single">
                                    <div class="welcome-one__left-features-box-single-icon">
                                        <span class="icon-professor"></span>
                                    </div>
                                    <div class="welcome-one__left-features-box-single-title">
                                        <h4 style="font-family: League Spartan;">Empieza a aprender de <br>nuestros expertos</h4>
                                    </div>
                                </li>
                                <!--End Welcome One Left Features Box Single-->

                                <!--Start Welcome One Left Features Box Single-->
                                <li class="welcome-one__left-features-box-single">
                                    <div class="welcome-one__left-features-box-single-icon">
                                        <span class="icon-knowledge"></span>
                                    </div>
                                    <div class="welcome-one__left-features-box-single-title">
                                        <h4 style="font-family: League Spartan;">Mejora tus habilidades <br>con nosotros ahora</h4>
                                    </div>
                                </li>
                                <!--End Welcome One Left Features Box Single-->
                            </ul>
                            <div class="welcome-one__left-btn">
                                <a href="cursos.php" class="thm-btn">ver todos los cursos</a>
                            </div>
                        </div>
                    </div>
                    <!--End Welcome One Left-->

                    <!--Start Welcome One Right-->
                    <div class="col-xl-6">
                        <div class="welcome-one__right clearfix">
                            <div class="shape1 rotate-me"><img src="assets/images/shapes/thm-shape1.png" alt="" /></div>
                            <div class="welcome-one__right-img1 wow slideInRight" data-wow-delay="100ms"
                                data-wow-duration="2500ms">
                                <div class="welcome-one__right-img1-inner">
                                    <img src="assets/images/resources/bienvenida.png" alt="" />
                                </div>
                            </div>
                            <div class="welcome-one__right-img2 wow zoomIn" data-wow-delay="100ms"
                                data-wow-duration="3500ms">
                                <img src="assets/images/resources/bienvenido.png" alt="" />
                            </div>
                        </div>
                    </div>
                    <!--End Welcome One Right-->
                </div>
            </div>
        </section>
        <!--End Welcome One-->




<?php
$api_url = "https://carrito-backend-ronl.onrender.com/api/courses";

// Obtener datos del API
$api_response = @file_get_contents($api_url);
$all_courses = $api_response ? json_decode($api_response, true) : [];
$ingenieria_courses = array_slice($all_courses, 0, 4);
$derecho_courses = array_slice($all_courses, 4, 4);
?>
        <!--Courses One Start INGENIERIA-->
        <section class="courses-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Todos los meses encontrarás nuevo contenido en la plataforma</span>
                    <h2 style="font-family: League Spartan;" class="">CURSOS ESPECIALIZADOS EN INGENIERÍA</h2>
                </div>
                <div class="row">
                    <?php foreach($ingenieria_courses as $course): ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                        <div class="tarjeta-dark">
                            <div class="tarjeta-dark-img">
                                <img src="<?= $course['image'] ?>" alt="<?= $course['title'] ?>" />
                            </div>
                            <div class="tarjeta-dark-content">
                                <span class="etiqueta-verde">CURSO</span>
                                <h4 class="tarjeta-dark-title">
                                    <a href="<?= $course['link'] ?>"><?= $course['title'] ?></a>
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
</div>
            </div>
        </section>
        <!--Courses One End INGENIERIA-->

        <!--Video One Start-->
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class=""><br><br><br><br><br>
                            <!--<div class="video-one__box-title">
                                <h2>Watch Video</h2>
                            </div>
                            <div class="icon wow zoomIn" data-wow-delay="300ms" data-wow-duration="1500ms">
                                <a class="video-popup" title="Zilom Video Gallery"
                                    href="https://www.youtube.com/watch?v=p25gICT63ek">
                                    <span class="icon-play"></span>
                                </a>
                                <span class="border-animation border-1"></span>
                                <span class="border-animation border-2"></span>
                                <span class="border-animation border-3"></span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Video One End-->



        <!--Counter One Start-->
        <section class="counter-one jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%"
            style="background-image: url(assets/images/backgrounds/section1.png);">
            <div class="container">
                <div class="row">
                    <!--Start Counter One Left-->
                    <div class="col-xl-5 col-lg-5">
                        <div class="counter-one__left">
                            <div class="section-title">
                                <span class="section-title__tagline">Hechos grandiosos</span>
                                <h2 class="" style="font-size: 50px; color: #FFF; font-family: League Spartan;">La misión de ICC <br>es pulir tu habilidad</h2>
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
                                <li class="counter-one__right-single wow slideInUp animated" data-wow-delay="0.1s"
                                    data-wow-duration="1500ms">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-teacher"></span>
                                    </div>
                                    <!--<h3 class="odometer" data-count="6800">00</h3>-->
                                    <p class="counter-one__right-text" style="font-family: 'Reem Kufi Fun';">Profesores profesionales</p>
                                </li>
                                <!--End Counter One Right Single-->

                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single wow slideInUp animated" data-wow-delay="0.3s"
                                    data-wow-duration="1500ms">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-online-course"></span>
                                    </div>
                                    <!--<h3 class="odometer" data-count="9800">00</h3>-->
                                    <p class="counter-one__right-text" style="font-family: 'Reem Kufi Fun';">Cursos de habilidades</p>
                                </li>
                                <!--End Counter One Right Single-->

                                <!--Start Counter One Right Single-->
                                <li class="counter-one__right-single wow slideInUp animated" data-wow-delay="0.5s"
                                    data-wow-duration="1500ms">
                                    <div class="counter-one__right-single-icon">
                                        <span class="icon-student"></span>
                                    </div>
                                    <!--<h3 class="odometer" data-count="7700">00</h3>-->
                                    <p class="counter-one__right-text" style="font-family: 'Reem Kufi Fun';">Estudiantes Inscritos</p>
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
            <div class="testimonials-two__pattern"><img src="assets/images/pattern/testimonials-two-left-pattern.png"
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
                            <p class="testimonials-two__left-text" style="font-family: 'Reem Kufi Fun';">Tenemos una calificación promedio de 4.7 de 5 estrellas.</p>
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
                                        <h4 class="testimonials-one__single-title" style="font-family: 'League Spartan';">Regulación del Mercado Eléctrico</h4>
                                        <p class="testimonials-one__single-text">Un curso muy recomendado, ayuda ampliar los conocimientos acerca del Sector Energía. Además de conocer el Marco Interinstitucional del Subsector Eléctrico de una forma muy didáctica.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="assets/images/testimonial/testimonio1.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Carlos Hernandez</h5>
                                                <p style="font-family: 'Reem Kufi Fun';">Usuario</p>
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
                                        <h4 class="testimonials-one__single-title" style="font-family: 'League Spartan';">Curso de Especialización de Analizador de Redes</h4>
                                        <p class="testimonials-one__single-text">Este curso fue útil para abarcarme en la especialización de Redes. Los Ponentes son muy concisos y se observa su profesionalismo.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="assets/images/testimonial/testimonio2.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Joel Aguilar</h5>
                                                <p style="font-family: 'Reem Kufi Fun';">Usuario</p>
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
                                        <h4 class="testimonials-one__single-title" style="font-family: 'League Spartan';">Especialización de Motores Eléctricos</h4>
                                        <p class="testimonials-one__single-text">Los materiales educativos son muy buenos y completos, del mismo modo que resulta muy fácil de abordar sin tener conocimientos previos.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="assets/images/testimonial/testimonio3.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Judith Sanchez</h5>
                                                <p style="font-family: 'Reem Kufi Fun';">Usuario</p>
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
                                        <h4 class="testimonials-one__single-title" style="font-family: 'League Spartan';">Banco de Condensadores</h4>
                                        <p class="testimonials-one__single-text">Fue todo un placer realizar este curso. Puesto que el enfoque del ponente fue impecable. Me gustaría realizar otro curso que amplie mis conocimientos relacionado a este campo.</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="assets/images/testimonial/testimonio5.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>Margaret Abarca</h5>
                                                <p style="font-family: 'Reem Kufi Fun';">Usuario</p>
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
                                        <h4 class="testimonials-one__single-title" style="font-family: 'League Spartan';">Sistema de Puesta a Tierra</h4>
                                        <p class="testimonials-one__single-text">El curso dictado fue muy interesante. La estructura y la calidad de los contenidos han sido de lo mejor para el aprendizaje. Me han permitido descubrir acerca de este tema que tardaría en descubrir por mí mismo</p>
                                        <div class="testimonials-one__single-client-info">
                                            <div class="testimonials-one__single-client-info-img">
                                                <!--<img src="assets/images/testimonial/testimonio4.png"
                                                    alt="" />-->
                                            </div>
                                            <div class="testimonials-one__single-client-info-text">
                                                <h5>David Julio Vilca</h5>
                                                <p style="font-family: 'Reem Kufi Fun';">Usuario</p>
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
                            <div class="shape1 zoom-fade"><img src="assets/images/shapes/thm-shape2.png" alt="" /></div>
                            <div class="shape2 wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms"><img
                                    src="assets/images/shapes/thm-shape3.png" alt="" /></div>
                            <div class="registration-two__left">
                                <h2 class="" style="font-size: 50px; color: #FFF;">Comience su carrera educativa <br>con ICC</h2>
                            </div>
                            <div class="registration-two__right">
                                <div class="registration-two__right-btn">
                                    <a href="contacto.php" class="thm-btn">Descubrir más</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--End Registration Two-->
        <!--<a target="blank" href="https://wa.link/zw6o1w" class="btn-whatsapp-pulse"><i class="fab fa-whatsapp"></i></a>-->
        <?php  
        include 'index/footer.php';
        include 'index/mobile.php';
        include 'index/script.php';
        ?>