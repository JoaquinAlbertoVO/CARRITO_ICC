<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="Academia" />
    <meta name="viewport" content="Cursos" />
    <meta name="viewport" content="Aprender" />
    <meta name="viewport" content="Curso Online" />
    <meta name="viewport" content="Clases Grabadas" />
    <meta name="viewport" content="Profesor" />
    <meta name="viewport" content="Estudiante" />
    <meta name="viewport" content="Networking" />
    <meta name="viewport" content="Habilidades" />
    <meta name="viewport" content="Talento" />
    <meta name="viewport" content="Desarrollar" />
    <title><?= $title ?? 'ICC Perú - Instituto de Capacitación Continua' ?></title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>assets/images/favicons/Favicon_Icc.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>assets/images/favicons/Favicon_Icc.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>assets/images/favicons/Favicon_Icc.png" />
    <link rel="manifest" href="<?= BASE_URL ?>assets/images/favicons/site.webmanifest" />
    <meta name="description" content="<?= $meta_description ?? 'ICC - Instituto de Capacitación Continua' ?>" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/animate/animate.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/animate/custom-animate.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/jarallax/jarallax.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/nouislider/nouislider.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/nouislider/nouislider.pips.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/odometer/odometer.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/swiper/swiper.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/icomoon-icons/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/tiny-slider/tiny-slider.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/reey-font/stylesheet.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/owl-carousel/owl.theme.default.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/twentytwenty/twentytwenty.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/zilom.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/zilom-responsive.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/button_whatsapp.css" />
    <!-- styles for popup-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-88Z8HWMT5C"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-88Z8HWMT5C');
    </script>
    <script>function loadScript(a){var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.type="text/javascript",c.src="https://tracker.metricool.com/resources/be.js",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}loadScript(function(){beTracker.t({hash:"7f4d2702c36e51657ae7d91f2c71cf01"})});</script>
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modern_override.css?v=<?php echo filemtime(__DIR__ . '/../assets/css/modern_override.css'); ?>" /></head>

<body>

    <div class="page-wrapper">
<header class="main-header main-header--one  clearfix">
            <div class="main-header--one__top clearfix">
                <div class="container">
                    <div class="main-header--one__top-inner clearfix">
                        <div class="main-header--one__top-left">
                            <div class="main-header--one__top-logo" style="display: flex; align-items: center; gap: 20px;">
        <a href="./"><img width="190" src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/resources/icc-logo1.png" alt="" /></a>
        <button id="btn-tiktok-promo" class="tiktok-btn">TIKTOK</button>
    </div>
                        </div>

                        <div class="main-header--one__top-right clearfix">
                            <ul class="main-header--one__top-social-link list-unstyled clearfix">
                                <li><a href="https://wa.link/myq5iv" target="_black"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://www.facebook.com/icc.com.pe/" target="_black"><i class="fab fa-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/icc.capacitaciones/" target="_black"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://www.linkedin.com/in/empresa-icc-313316253/" target="_black"><i class="fab fa-linkedin"></i></a></li>
                                <!-- Implementación de TikTok-->
                                <li><a href="https://www.tiktok.com/@institutoicc" target="_black"><i class="fab fa-tiktok"></i></a></li>
                            </ul>

                            <div class="main-header--one__top-contact-info clearfix">
                                <ul class="main-header--one__top-contact-info-list list-unstyled">
                                    <li class="main-header--one__top-contact-info-list-item">
                                        <div class="icon">
                                            <span class="icon-phone-call-1"></span>
                                        </div>
                                        <div class="text">
                                            <h6>Agente de mensajes</h6>
                                            <p><a href="tel:+51986884219" target="_black">+51 986 884 219</a></p>
                                        </div>
                                    </li>
                                    <li class="main-header--one__top-contact-info-list-item">
                                        <div class="icon">
                                            <span class="icon-message"></span>
                                        </div>
                                        <div class="text">
                                            <h6>Agente de mensajes</h6>
                                            <p><a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="main-header-one__bottom clearfix">
                <div class="container">
                    <div class="main-header-one__bottom-inner clearfix">
                        <nav class="main-menu main-menu--1">
                            <div class="main-menu__inner">
                                <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>

                                <div class="left">
                                    <ul class="main-menu__list">
                                        <li class="current">
                                            <a class="current" href="./">Inicio</a>
                                            <!--<ul>
                                                <li><a href="index.html">Home One</a></li>
                                                <li><a href="index-2.html">Home Two</a></li>
                                                <li class="dropdown">
                                                    <a href="#">Header Styles</a>
                                                    <ul>
                                                        <li><a href="index.html">Header One</a></li>
                                                        <li><a href="index-2.html">Header Two</a></li>
                                                    </ul>
                                                </li>
                                            </ul>-->
                                        </li>
                                        <li><a href="nosotros.php">Nosotros</a></li>
                                        <li class="dropdown">
    <a href="#">Ingeniería Eléctrica</a>
    <ul class="mo-mega-menu">
        <li class="mo-mega-menu-left">
            <img src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/resources/icc-logo-electrica.png" alt="Ingeniería Eléctrica"/>
            <a href="curso_ingenieria.php" class="ver-especialidades">Ver Especialidades ▾</a>
        </li>
        <li class="mo-mega-menu-right">
            <ul>
                <li><a href="detalle_analisis_facturacion.php">Análisis de facturas y Evaluación de Tarifas E.</a></li>
                <li><a href="detalle_banco_condensadores.php">Banco de Condensadores</a></li>
                <li><a href="detalle_electricidad_basica.php">Electricidad Básica</a></li>
                <li><a href="detalle_gestion_seguridad.php">Gestión y Seguridad en el Trabajo Ley Nº29783</a></li>
                <li><a href="detalle_motores_electricos.php">Motores Eléctricos</a></li>
                <li><a href="detalle_plc.php">Programación Básica de PLC</a></li>
                <li><a href="detalle_puesta_tierra.php">Sistema Puesta a Tierra</a></li>
                <li><a href="detalle_regulacion_mercado.php">Regulación del Mercado de Energía</a></li>
                <li><a href="detalle_configuracion_redes.php">Configuración e Instalación de Analizadores de redes</a></li>
            </ul>
        </li>
    </ul>
</li>
                                        <!--<li class="dropdown">
                                            <a href="#"> Teachers</a>
                                            <ul>
                                                <li><a href="teachers-1.html"> Teachers</a></li>
                                                <li><a href="teachers-2.html">Become Teacher</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#">News</a>
                                            <ul>
                                                <li><a href="news.html">News</a></li>
                                                <li><a href="news-details.html">News Details</a></li>
                                            </ul>
                                        </li>-->
                                        <li><a href="contacto.php">Contáctanos</a></li>
                                    </ul>
                                </div>

                                <div class="right">
                                    <div class="main-menu__right">
                                        <!--<div class="main-menu__right-login-register">
                                            <ul class="list-unstyled">
                                                <li><a href="#">Login</a></li>
                                                <li><a href="#">Register</a></li>
                                            </ul>
                                        </div>-->
                                        <div class="main-menu__right-cart-search">
                                            <!--<div class="main-menu__right-cart-box">
                                                <a href="#"><span class="icon-shopping-cart"></span></a>
                                            </div>-->
                                            <div class="main-menu__right-search-box">
                                                <a href="https://icc.com.pe/Aula/" target="_black" class="thm-btn comment-form__btn">Aula Virtual</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </nav>

                    </div>
                </div>
            </div>
        </header>


        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content">

            </div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->

<!-- Modal Cupón TikTok -->
<div id="tiktok-modal" class="tiktok-modal" style="display: none;">
    <div class="tiktok-modal-content">
        <span class="tiktok-modal-close" id="btn-close-tiktok">&times;</span>
        <h3 class="tiktok-modal-title">INGRESAR CUPÓN</h3>
        <input type="text" id="tiktok-coupon-input" class="tiktok-modal-input" placeholder="Escribe tu código aquí">
        <button id="btn-submit-tiktok" class="tiktok-modal-submit">ENVIAR</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("tiktok-modal");
    var btnOpen = document.getElementById("btn-tiktok-promo");
    var btnClose = document.getElementById("btn-close-tiktok");
    var btnSubmit = document.getElementById("btn-submit-tiktok");
    var inputCoupon = document.getElementById("tiktok-coupon-input");

    if(btnOpen) {
        btnOpen.onclick = function() {
            modal.style.display = "flex";
            inputCoupon.value = ""; 
            setTimeout(function() { inputCoupon.focus(); }, 100);
        }
    }
    
    if(btnClose) {
        btnClose.onclick = function() {
            modal.style.display = "none";
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

        var cuponesValidos = {
        // INGENIERÍA ELÉCTRICA
        'TIKTOK-FACTURAS': { curso: 'Análisis de facturas y Evaluación de Tarifas E.', precio: 50, moneda: 'PEN' },
        'TIKTOK-BANCO': { curso: 'Banco de Condensadores', precio: 50, moneda: 'PEN' },
        'TIKTOK-ELECTRICIDAD': { curso: 'Electricidad Básica', precio: 50, moneda: 'PEN' },
        'TIKTOK-GESTION': { curso: 'Gestión y Seguridad en el Trabajo Ley Nº29783', precio: 50, moneda: 'PEN' },
        'TIKTOK-MOTORES': { curso: 'Motores Eléctricos', precio: 50, moneda: 'PEN' },
        'TIKTOK-PLC': { curso: 'Programación Básica de PLC', precio: 50, moneda: 'PEN' },
        'TIKTOK-TIERRA': { curso: 'Sistema Puesta a Tierra', precio: 50, moneda: 'PEN' },
        'TIKTOK-REGULACION': { curso: 'Regulación del Mercado de Energía', precio: 50, moneda: 'PEN' },
        'TIKTOK-REDES': { curso: 'Configuración e Instalación de Analizadores de redes', precio: 50, moneda: 'PEN' },
    };

    if(btnSubmit) {
        btnSubmit.onclick = function() {
            var codigo = inputCoupon.value.trim().toUpperCase();
            if(codigo === "") return;

            if(cuponesValidos[codigo]) {
                var datos = cuponesValidos[codigo];
                var urlDestino = "CARRITO_PRE/index.html?curso=" + encodeURIComponent(datos.curso) + "&precio=" + datos.precio + "&moneda=" + datos.moneda;
                window.location.href = urlDestino;
            } else {
                alert("Cupón no válido o expirado.");
            }
        }
    }
});
</script>


        <!-- CONTENIDO PRINCIPAL -->
        <?= $content ?>
        <!-- FIN CONTENIDO PRINCIPAL -->

        <!--Start Footer One-->
        <footer class="footer-one">
            <div class="footer-one__bg" style="background-image: url(assets/images/backgrounds/section2.png);">
            </div><!-- /.footer-one__bg -->
            <div class="footer-one__top">
                <div class="container">
                    <div class="row">
                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.1s">
                            <div class="footer-widget__column footer-widget__about">
                                <div class="footer-widget__about-logo">
                                    <a href="./"><img width="160" height="60" src="<?= BASE_URL ?>assets/images/resources/icc-logo1.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.3s">
                            <div class="footer-widget__column footer-widget__courses">
                                <h3 class="footer-widget__title">Cursos</h3>
                                <ul class="footer-widget__courses-list list-unstyled">
                                    <li><a href="curso_ingenieria.php">Ingeniería Eléctrica</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.5s">
                            <div class="footer-widget__column footer-widget__links">
                                <h3 class="footer-widget__title">Enlaces</h3>
                                <ul class="footer-widget__links-list list-unstyled">
                                    <li><a href="./">Inicio</a></li>
                                    <li><a href="nosotros.php">Nosotros</a></li>
                                    <li><a href="curso_ingenieria.php">Ingeniería</a></li>
                                    <li><a href="contacto.php">Contáctanos</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-3 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.7s">
                            <div class="footer-widget__column footer-widget__contact">
                                <h3 class="footer-widget__title">Contáctanos</h3>
                                <!--<p class="text">Av. República de Polonia Mz. A1 Lt.17 -S.J.L - Lima</p>-->
                                <p><a href="mailto:informes@icc.com.pe" target="_black">informes@icc.com.pe</a></p>
                                <p class="phone"><a href="tel:+51986884219" target="_black">+51 986 884 219</a></p>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-3 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.9s">
                            <div class="footer-widget__column footer-widget__social-links">
                                <ul class="footer-widget__social-links-list list-unstyled clearfix">
                                    <li><a href="https://www.facebook.com/icc.com.pe/" target="_black"><i class="fab fa-facebook"></i></a></li>
                                    <!--<li><a href="https://wa.link/myq5iv" target="_black"><i class="fab fa-whatsapp"></i></a></li>-->
                                    <li><a href="https://www.instagram.com/icc.capacitaciones/" target="_black"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/empresa-icc-313316253//" target="_black"><i class="fab fa-linkedin"></i></a></li>
                                    <!--Implementación de TikTok-->
                                    <li><a href="https://www.tiktok.com/@institutoicc" target="_black"><i class="fab fa-tiktok"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                    </div>
                </div>
            </div>

            <!--Start Footer One Bottom-->
            <div class="footer-one__bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="footer-one__bottom-inner">
                                <div class="footer-one__bottom-text text-center">
                                    <p>&copy; Copyright 2024 by informes@icc.com.pe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer One Bottom-->
        </footer>
        <!--End Footer One-->        </div><!-- /.page-wrapper -->

        <div class="mobile-nav__wrapper">
            <div class="mobile-nav__overlay mobile-nav__toggler"></div>
            <!-- /.mobile-nav__overlay -->
            <div class="mobile-nav__content">
                <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

                <div class="logo-box">
                    <a href="./" aria-label="logo image"><img src="<?= BASE_URL ?>assets/images/resources/icc-logo1.png" width="230" alt="" /></a>
                </div>
                <!-- /.logo-box -->
                <div class="mobile-nav__container"></div>
                <!-- /.mobile-nav__container -->

                <ul class="mobile-nav__contact list-unstyled">
                    <li>
                        <i class="icon-letter"></i>
                        <a href="mailto:informes@icc.com.pe" target="_black">informes@icc.com.pe</a>
                    </li>
                    <li>
                        <i class="icon-phone-call-1"></i>
                        <a href="+51986884219" target="_black">+51 986 884 219</a>
                    </li>
                </ul><!-- /.mobile-nav__contact -->
                <div class="mobile-nav__top">
                    <div class="mobile-nav__social">
                        <a href="https://wa.link/myq5iv" target="_black" class="fab fa-whatsapp"></a>
                        <a href="https://www.facebook.com/icc.com.pe/" target="_black" class="fab fa-facebook-square"></a>
                        <a href="https://www.instagram.com/icc.capacitaciones/" target="_black" class="fab fa-instagram"></a>
                        <a href="https://www.linkedin.com/in/empresa-icc-313316253/" target="_black" class="fab fa-linkedin"></a>
                        <!--Implementación de TikTok -->
                        <a href="https://www.tiktok.com/@institutoicc" target="_black"><i class="fab fa-tiktok"></i></a>
                    </div><!-- /.mobile-nav__social -->
                </div><!-- /.mobile-nav__top -->
                <div class="">
                    <a href="https://icc.com.pe/aula/login.php" target="_black" class="thm-btn comment-form__btn">Aula Virtual</a>
                </div>
            </div>
            <!-- /.mobile-nav__content -->
        </div>
        <!-- /.mobile-nav__wrapper -->



        <div class="search-popup">
            <div class="search-popup__overlay search-toggler"></div>
            <!-- /.search-popup__overlay -->
            <div class="search-popup__content">
                <form action="#">
                    <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                    <input type="text" id="search" placeholder="Search Here..." />
                    <button type="submit" aria-label="search submit" class="thm-btn2">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
            <!-- /.search-popup__content -->
        </div>
        <!-- /.search-popup -->    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <a target="blank" href="https://wa.link/myq5iv" class="scroll-to-target scroll-to-top btn-whatsapp-pulse"><i style="font-size: 40px;" class="fab fa-whatsapp"></i></a>
    <script src="<?= BASE_URL ?>assets/vendors/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/jarallax/jarallax.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/jquery-appear/jquery.appear.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/jquery-validate/jquery.validate.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/nouislider/nouislider.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/odometer/odometer.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/swiper/swiper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/tiny-slider/tiny-slider.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/wnumb/wNumb.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/wow/wow.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/isotope/isotope.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/countdown/countdown.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/twentytwenty/twentytwenty.js"></script>
    <script src="<?= BASE_URL ?>assets/vendors/twentytwenty/jquery.event.move.js"></script>


    <script src="http://maps.google.com/maps/api/js?key=AIzaSyATY4Rxc8jNvDpsK8ZetC7JyN4PFVYGCGM"></script>

    <!-- template js -->
    <script src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/js/zilom.js"></script>
</body>

</html>
