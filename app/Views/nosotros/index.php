

    <!--Page Header Start-->
    <section class="page-header clearfix" style="background-image: url(<?= BASE_URL ?>assets/images/APARTADO_NOSOTROS.png);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2 style="color: #4D5FE3; font-family: League Spartan;">Nosotros</h2>
                            <p style="color: #fff;">ICC-Instituto de Capacitación Continua</p>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                                <li class="active">Nosotros</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="why-choose-one">
        <div class="container">
            <div class="row">
                <!--Start Why Choose One Left-->
                <div class="col-xl-6 col-lg-6">
                    <div class="why-choose-one__left">
                        <div class="section-title">
                            <span class="section-title__tagline" >Acerca de la compañía</span>
                            <h2 class="section-title__title" >ICC-Instituto de Capacitación Continua</h2>
                        </div>
                        <p class="why-choose-one__left-text">ICC brinda servicios de consultoría y capacitación a estudiantes, profesionales y organizaciones del sector público y privado. Nuestro equipo de profesionales, están comprometidos con tu futuro.</p>
                        <div class="why-choose-one__left-learning-box">
                            <div class="icon">
                                <span class="icon-professor"></span>
                            </div>
                            <div class="text">
                                <h4>Comienza a aprender de nuestros expertos <br>y mejora tus habilidades</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Why Choose One Left-->

                <!--Start Why Choose One Right-->
                <div class="col-xl-6 col-lg-6">
                    <div class="why-choose-one__right  clearfix animated"   style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: slideInRight;">
                        <div class="why-choose-one__right-img clearfix">
                            <img src="<?= BASE_URL ?>assets/images/NOSOTROS_471X400.png" alt="Nosotros" style="width: 100%; border-radius: 16px; box-shadow: 0 15px 30px rgba(0,0,0,0.1); display: block;">
                            <!--<div class="why-choose-one__right-img-overlay">
                                <p>SOMOS LA MEJOR INSTITUCIÓN</p>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!--End Why Choose One Right-->

            </div>
        </div>
    </section>

    <!--Start Features Two-->
    <section class="features-two">
        <div class="container">
            <style>
                .hover-flip-z .features-two__single-img {
                    transform-style: preserve-3d;
                    perspective: 1000px;
                }
                .hover-flip-z .features-two__single-img-inner {
                    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
                    transform: translateZ(0px);
                }
                .hover-flip-z .features-two__single-overlay {
                    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.8s ease;
                    transform: translateZ(50px);
                }
                .hover-flip-z:hover .features-two__single-img-inner {
                    transform: translateZ(60px) scale(1.05);
                }
                .hover-flip-z:hover .features-two__single-overlay {
                    transform: translateZ(-20px);
                    opacity: 0;
                }
            </style>
            <div class="row">
                <!--Start Single Features Two-->
                <div class="col-xl-6 "  >
                    <div class="features-two__single hover-flip-z">
                        <div class="features-two__single-img">
                            <div class="features-two__single-img-inner">
                                <img src="<?= BASE_URL ?>assets/images/MISION.png" alt="Misión" style="width: 100%; border-radius: 16px; box-shadow: 0 15px 30px rgba(0,0,0,0.1); display: block;">
                            </div>
                            <div class="features-two__single-overlay">
                                <h3 class="features-two__single-overlay-title"><a href="#">Misión</a>
                                </h3>
                                <p class="features-two__single-overlay-text">Brindar un servicio de calidad en capacitaciones para las empresas y personas que lo requieran.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Single Features Two-->

                <!--Start Single Features Two-->
                <div class="col-xl-6 "  >
                    <div class="features-two__single hover-flip-z">
                        <div class="features-two__single-img">
                            <div class="features-two__single-img-inner">
                                <img src="<?= BASE_URL ?>assets/images/VISION.png" alt="Visión" style="width: 100%; border-radius: 16px; box-shadow: 0 15px 30px rgba(0,0,0,0.1); display: block;">
                            </div>
                            <div class="features-two__single-overlay">
                                <h3 class="features-two__single-overlay-title"><a href="#">Visión</a>
                                </h3>
                                <p class="features-two__single-overlay-text">Ser reconocidos a nivel Nacional como un centro líder en formación profesional y capacitación.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Single Features Two-->
            </div>
        </div>
    </section>
    <!--End Features Two-->

    <!--Features One Start-->
    <section class="features-one">
        <div class="section-title text-center">
            <span class="section-title__tagline" >ICC-Instituto de Capacitación Continua</span>
            <h2 class="section-title__title" >Valores</h2>
        </div>
        <div class="container">
            <div class="row">
                <!--Start Single Features One-->
                <div class="col-xl-4 col-lg-4 "  >
                    <div class="features-one__single">
                        <!--<div class="features-one__single-icon">
                            <span class="icon-empowerment"></span>
                        </div>-->
                        <div class="features-one__single-text">
                            <h4 ><a href="#">Innovación</a></h4>
                            <p>Promovemos de manera continua y sistemática las condiciones necesarias para crear y mejorar los procesos de trabajo en el Centro.</p>
                        </div>
                    </div>
                </div>
                <!--End Single Features One-->

                <!--Start Single Features One-->
                <div class="col-xl-4 col-lg-4 "  >
                    <div class="features-one__single">
                        <!--<div class="features-one__single-icon">
                            <span class="icon-human-resources-1"></span>
                        </div>-->
                        <div class="features-one__single-text">
                            <h4 ><a href="#">Liderazgo</a></h4>
                            <p>Actuamos con iniciativa y responsabilidad en el desarrollo de todas nuestras actividades y en la solución de los problemas.</p>
                        </div>
                    </div>
                </div>
                <!--End Single Features One-->

                <!--Start Single Features One-->
                <div class="col-xl-4 col-lg-4 "  >
                    <div class="features-one__single">
                        <!--<div class="features-one__single-icon">
                            <span class="icon-recruitment"></span>
                        </div>-->
                        <div class="features-one__single-text">
                            <h4 ><a href="#">Compromiso</a></h4>
                            <p>Somos conscientes de la importancia que tiene cumplir con el desarrollo del trabajo dentro del tiempo estipulado para ello, ponemos al máximo nuestras capacidades para sacar adelante la tarea encomendada.</p>
                        </div>
                    </div>
                </div>
                <!--End Single Features One-->
            </div>
        </div>
    </section>
    <!--Features One End-->

    <!--Testimonials One Start-->
    <!--<section class="testimonials-one clearfix">
        <div class="auto-container">
            <div class="section-title text-center">
                <span class="section-title__tagline" >ICC-Instituto de Capacitación Continua</span>
                <h2 class="section-title__title" >Valores</h2>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="testimonials-one__wrapper">
                        <div class="testimonials-one__pattern"><img
                                src="<?= BASE_URL ?>assets/images/pattern/testimonials-one-left-pattern.png" alt="" /></div>
                        <div class="shape1"><img src="<?= BASE_URL ?>assets/images/shapes/thm-shape3.png" alt="" /></div>
                        <div class="row">
                            <div class="col-xl-12">-->
                                <!--<div class="testimonials-one__carousel owl-carousel owl-theme owl-dot-type1">-->
                                    <!--Start Single Testimonials One -->
                                    <!--<div class="testimonials-one__single " 
                                        >
                                        <div class="testimonials-one__single-inner">
                                            <h4 class="testimonials-one__single-title" >Innovación</h4>-->
                                            <!--<p class="testimonials-one__single-text">Promovemos de manera continua y sistemática las condiciones necesarias para crear y mejorar los procesos de trabajo en el Centro.</p>-->
                                            <!--<div class="testimonials-one__single-client-info">
                                                <div class="testimonials-one__single-client-info-img">
                                                    <img src="<?= BASE_URL ?>assets/images/testimonial/testimonials-v1-client-info-img1.png"
                                                        alt="" />
                                                </div>
                                                <div class="testimonials-one__single-client-info-text">
                                                    <h5>Kevin Martin</h5>
                                                    <p>Developer</p>
                                                </div>
                                            </div>-->
                                        <!--</div>
                                    </div>-->
                                    <!--End Single Testimonials One -->

                                    <!--Start Single Testimonials One -->
                                    <!--<div class="testimonials-one__single " 
                                        >
                                        <div class="testimonials-one__single-inner">
                                            <h4 class="testimonials-one__single-title" >Liderazgo</h4>-->
                                            <!--<p class="testimonials-one__single-text">Actuamos con iniciativa y responsabilidad en el desarrollo de todas nuestras actividades y en la solución de los problemas.</p>-->
                                            <!--<div class="testimonials-one__single-client-info">
                                                <div class="testimonials-one__single-client-info-img">
                                                    <img src="<?= BASE_URL ?>assets/images/testimonial/testimonials-v1-client-info-img2.png"
                                                        alt="" />
                                                </div>
                                                <div class="testimonials-one__single-client-info-text">
                                                    <h5>Christine Eve</h5>
                                                    <p>Developer</p>
                                                </div>
                                            </div>-->
                                        <!--</div>
                                    </div>-->
                                    <!--End Single Testimonials One -->

                                    <!--Start Single Testimonials One -->
                                    <!--<div class="testimonials-one__single " 
                                        >
                                        <div class="testimonials-one__single-inner">
                                            <h4 class="testimonials-one__single-title" >Compromiso</h4>
                                            <p class="testimonials-one__single-text">Somos conscientes de la importancia que tiene cumplir con el desarrollo del trabajo dentro del tiempo estipulado para ello, ponemos al máximo nuestras capacidades para sacar adelante la tarea encomendada.</p>-->
                                            <!--<div class="testimonials-one__single-client-info">
                                                <div class="testimonials-one__single-client-info-img">
                                                    <img src="<?= BASE_URL ?>assets/images/testimonial/testimonials-v1-client-info-img3.png"
                                                        alt="" />
                                                </div>
                                                <div class="testimonials-one__single-client-info-text">
                                                    <h5>David Cooper</h5>
                                                    <p>Developer</p>
                                                </div>
                                            </div>-->
                                        <!--</div>
                                    </div>-->
                                    <!--End Single Testimonials One -->
                                <!--</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!--Testimonials One End-->



