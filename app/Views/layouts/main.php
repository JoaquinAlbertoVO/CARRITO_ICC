<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="Academia, Cursos, Aprender, Curso Online, Clases Grabadas, Profesor, Estudiante, Networking, Habilidades, Talento, Desarrollar" />
    <meta name="description" content="<?= $meta_description ?? 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería.' ?>" />
    
    <!-- Open Graph SEO -->
    <meta property="og:title" content="<?= $title ?? 'ICC Perú - Instituto de Capacitación Continua' ?>" />
    <meta property="og:description" content="<?= $meta_description ?? 'Actualiza tus conocimientos y capacítate con nosotros. Te damos lo mejor en Ingeniería.' ?>" />
    <meta property="og:image" content="<?= $og_image ?? BASE_URL . 'assets/images/resources/logo-icc.png' ?>" />
    <meta property="og:url" content="<?= $og_url ?? BASE_URL ?>" />
    <meta property="og:type" content="website" />
    
    <!-- Structured Data (Schema.org) -->
    <?php if(isset($schema)): ?>
    <script type="application/ld+json">
    <?= $schema ?>
    </script>
    <?php endif; ?>
    
    <title><?= $title ?? 'ICC Perú - Instituto de Capacitación Continua' ?></title>
    <link rel="preload" as="image" href="<?= BASE_URL ?>assets/images/banner_icc.png">
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>assets/images/favicons/Favicon_Icc.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>assets/images/favicons/Favicon_Icc.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>assets/images/favicons/Favicon_Icc.png" />
    <link rel="manifest" href="<?= BASE_URL ?>assets/images/favicons/site.webmanifest" />
    <meta name="description" content="<?= $meta_description ?? 'ICC - Instituto de Capacitación Continua' ?>" />

    <style>
        /* Corrección para que las letras del menú sean blancas cuando se hace scroll (sticky header) */
        .stricky-header.stricky-fixed .main-menu__list > li > a {
            color: #ffffff !important;
        }
        /* Color azul para el ítem activo (opcional, para mantener el contraste si es necesario) */
        .stricky-header.stricky-fixed .main-menu__list > li.current > a {
            color: #3b5998 !important; 
        }
    </style>

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
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JPZGM0RZHW"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-JPZGM0RZHW');
    </script>

    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2480034172420246');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=2480034172420246&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->

    <script>function loadScript(a){var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.type="text/javascript",c.src="https://tracker.metricool.com/resources/be.js",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}loadScript(function(){beTracker.t({hash:"7f4d2702c36e51657ae7d91f2c71cf01"})});</script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modern_override.css?v=2.0.7?v=<?php echo file_exists(__DIR__ . '/../../../assets/css/modern_override.css?v=2.0.7') ? filemtime(__DIR__ . '/../../../assets/css/modern_override.css?v=2.0.7') : '1.0'; ?>" />
    
    <!-- Modern Frameworks CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Modal Ubigeo Styles -->
    <style>
        #ubigeoModal .modal-content {
            border-radius: 12px;
            padding: 10px;
        }
        #ubigeoModal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        #ubigeoModal .modal-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
        }
        #ubigeoModal .modal-body p {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        #ubigeoModal label {
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 5px;
        }
        #ubigeoModal select {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 8px 12px;
            margin-bottom: 15px;
            appearance: none;
            background: url("data:image/svg+xml;utf8,<svg fill='%23f27a1a' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>") no-repeat;
            background-position: right 10px top 50%;
        }
        #ubigeoModal select:focus {
            box-shadow: none;
            border-color: #f27a1a;
        }
        #ubigeoModal .btn-guardar {
            background-color: #172A4E;
            color: white;
            font-weight: bold;
            border-radius: 20px;
            padding: 10px 40px;
            border: none;
            width: 100%;
            max-width: 200px;
            margin: 10px auto;
            display: block;
        }
        #ubigeoModal .btn-guardar:hover {
            background-color: #0d1a33;
        }
        .btn-close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            line-height: 1;
        }
    </style>
</head>


<body>

    <div class="page-wrapper">
<header class="main-header main-header--one  clearfix">
            <div class="main-header--one__top clearfix">
                <div class="container">
                    <div class="main-header--one__top-inner clearfix">
                        <div class="main-header--one__top-left">
                            <div class="main-header--one__top-logo" style="display: flex; align-items: center; gap: 20px;">
        <a href="./" aria-label="Inicio"><img width="190" alt="Logo de ICC" src="<?= BASE_URL ?>assets/images/logo_icc.png" /></a>
        <button id="btn-tiktok-promo" class="tiktok-btn">TIKTOK</button>
    </div>
                        </div>

                        <div class="main-header--one__top-right clearfix">
                            <ul class="main-header--one__top-social-link list-unstyled clearfix">
                                <li><a href="https://wa.me/51941208020" target="_blank" aria-label="WhatsApp" style="background-color: #25D366; color: white; opacity: 1;"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://www.facebook.com/profile.php?id=61570845450403" target="_blank" aria-label="Facebook" style="background-color: #1877F2; color: white; opacity: 1;"><i class="fab fa-facebook"></i></a></li>
                                <!-- Implementación de TikTok-->
                                <li><a href="https://www.tiktok.com/@icc_capacitaciones_int" target="_blank" aria-label="TikTok" style="background-color: #000000; color: white; opacity: 1;"><i class="fab fa-tiktok"></i></a></li>
                            </ul>

                            <div class="main-header--one__top-contact-info clearfix">
                                <ul class="main-header--one__top-contact-info-list list-unstyled">
                                    <li class="main-header--one__top-contact-info-list-item">
                                        <div class="icon">
                                            <span class="icon-phone-call-1"></span>
                                        </div>
                                        <div class="text">
                                            <h6>Agente de mensajes</h6>
                                            <p><a href="tel:+51941208020" target="_black">+51 941 208 020</a></p>
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
                                <a href="#" class="mobile-nav__toggler" style="color: #ffffff !important;" aria-label="Abrir menú de navegación"><i class="fa fa-bars"></i></a>

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
                                        <li><a href="<?= BASE_URL ?>nosotros">Nosotros</a></li>
                                        <li class="dropdown">
    <a href="#">Ingeniería Eléctrica</a>
    <ul>
        <li class="dropdown">
            <a href="<?= BASE_URL ?>cursos/ingenieria" class="ver-especialidades">Ver Especialidades</a>
            <ul>
                <li><a href="<?= BASE_URL ?>cursos/detalle/analizador-de-redes">Analizador de Redes</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/banco-de-condensadores">Banco de Condensadores</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/canalizacion-de-tuberias-conduit">Canalización de Tuberías Conduit</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/especializacion-en-electricidad-industrial">Especialización en Electricidad Industrial</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/empalmes-termocontraibles-en-mt">Empalmes Termocontraíbles en MT</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/mantenimiento-de-subestaciones-electricas">Mantenimiento de Subestaciones Eléctricas</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/terminaciones-termocontraibles-en-mt">Terminaciones Termocontraíbles en MT</a></li>
                <li><a href="<?= BASE_URL ?>cursos/detalle/variadores-de-frecuencia">Variadores de Frecuencia</a></li>
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
                                        <li><a href="<?= BASE_URL ?>contacto">Contáctanos</a></li>
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
                                                <a href="#" aria-label="Carrito de compras"><span class="icon-shopping-cart"></span></a>
                                            </div>-->
                                            <div class="main-menu__right-search-box" style="margin-right: 15px; display: flex; align-items: center; position: relative;">
                                                <a href="#" id="btnOpenUbigeo" aria-label="Ubicación" style="color: white; display: flex; align-items: center; gap: 8px; text-decoration: none; margin-right: 15px;" title="Cambiar mi ubicación">
                                                    <i class="fas fa-map-marker-alt" style="font-size: 22px;"></i>
                                                    <div style="display: flex; flex-direction: column; font-size: 13px; line-height: 1.2; text-align: left;">
                                                        <span style="font-weight: 400; color: #ffffff;">Ubicación</span>
                                                        <span id="headerLocationText" style="font-weight: bold; color: #4a90e2;">Lima, Lima</span>
                                                    </div>
                                                </a>
                                                <!-- Popover de Ubicación -->
                                                <div id="locationPopover" style="display: none; position: absolute; top: calc(100% + 10px); left: 0; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); z-index: 1000; width: 280px; text-align: left; cursor: default;">
                                                    <div style="font-weight: 700; color: #172A4E; font-size: 15px; margin-bottom: 8px;">Estás navegando en:</div>
                                                    <div id="popoverLocationText" style="color: #666; font-size: 14px; margin-bottom: 20px; line-height: 1.4;">Lima, Lima</div>
                                                    <div style="display: flex; gap: 10px;">
                                                        <button id="btnConfirmLocation" style="flex: 1; background: #172A4E; color: white; border: none; border-radius: 20px; padding: 8px 10px; font-size: 13px; font-weight: bold; transition: background 0.3s;">Confirmar</button>
                                                        <button id="btnChangeLocation" style="flex: 1; background: transparent; color: #172A4E; border: 1px solid #172A4E; border-radius: 20px; padding: 8px 10px; font-size: 13px; font-weight: bold; transition: background 0.3s;">Cambiar</button>
                                                    </div>
                                                    <!-- Flecha -->
                                                    <div style="position: absolute; top: -6px; left: 25px; width: 14px; height: 14px; background: white; transform: rotate(45deg); border-left: 1px solid rgba(0,0,0,0.05); border-top: 1px solid rgba(0,0,0,0.05);"></div>
                                                    <!-- Cerrar -->
                                                    <button id="btnClosePopover" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 18px; color: #999; line-height: 1;">&times;</button>
                                                </div>
                                            </div>
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
<style>
.tiktok-modal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
}
.tiktok-modal-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    position: relative;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.tiktok-modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}
.tiktok-modal-title {
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
}
.tiktok-modal-input {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 2px solid #ddd;
    border-radius: 6px;
    outline: none;
    font-size: 16px;
}
.tiktok-modal-input:focus {
    border-color: #ff3b30;
}
.tiktok-modal-submit {
    background-color: #ff3b30;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    width: 100%;
    transition: background 0.3s;
}
.tiktok-modal-submit:hover {
    background-color: #e62e24;
}
</style>
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
        // INGENIERÃA ELÉCTRICA (Antiguos)
        'TIKTOK-FACTURAS': { curso: 'Análisis de facturas y Evaluación de Tarifas E.', precio: 50, moneda: 'PEN' },
        'TIKTOK-BANCO': { curso: 'Banco de Condensadores', precio: 50, moneda: 'PEN' },
        'TIKTOK-ELECTRICIDAD': { curso: 'Electricidad Básica', precio: 50, moneda: 'PEN' },
        'TIKTOK-GESTION': { curso: 'Gestión y Seguridad en el Trabajo Ley Nº29783', precio: 50, moneda: 'PEN' },
        'TIKTOK-MOTORES': { curso: 'Motores Eléctricos', precio: 50, moneda: 'PEN' },
        'TIKTOK-PLC': { curso: 'Programación Básica de PLC', precio: 50, moneda: 'PEN' },
        'TIKTOK-TIERRA': { curso: 'Sistema Puesta a Tierra', precio: 50, moneda: 'PEN' },
        'TIKTOK-REGULACION': { curso: 'Regulación del Mercado de Energía', precio: 50, moneda: 'PEN' },
        'TIKTOK-REDES': { curso: 'Configuración e Instalación de Analizadores de redes', precio: 50, moneda: 'PEN' },
        
        // CUPONES NUEVOS (Google Sheet)
        'CUPON-TERMOCONTRAIBLES-VIRTUAL': { curso: 'Terminaciones Termocontraibles MT (Virtual)', precio: 99, moneda: 'PEN' },
        'CUPON-TERMOCONTRAIBLES-SEMI': { curso: 'Terminaciones Termocontraibles MT (Semipresencial)', precio: 350, moneda: 'PEN' },
        'CUPON-REDES-VIRTUAL': { curso: 'Analizador de Redes BT (Virtual)', precio: 99, moneda: 'PEN' },
        'CUPON-REDES-SEMI': { curso: 'Analizador de Redes BT (Semipresencial)', precio: 250, moneda: 'PEN' },
        'CUPON-CONDUIT-VIRTUAL': { curso: 'Canalizaciones Tubería Conduit (Virtual)', precio: 99, moneda: 'PEN' },
        'CUPON-CONDUIT-SEMI': { curso: 'Canalizaciones Tubería Conduit (Semipresencial)', precio: 350, moneda: 'PEN' },
        'CUPON-VARIADORES-VIRTUAL': { curso: 'Variadores en Velocidad (Virtual)', precio: 99, moneda: 'PEN' },
        'CUPON-VARIADORES-SEMI': { curso: 'Variadores en Velocidad (Semipresencial)', precio: 450, moneda: 'PEN' },
        'CUPON-EMPALME-SEMI': { curso: 'Empalme Autocontraible 3 M (Semipresencial)', precio: 750, moneda: 'PEN' },
        'CUPON-BANCO-VIRTUAL': { curso: 'Banco de Condensadores (Virtual)', precio: 99, moneda: 'PEN' },
        'CUPON-BANCO-SEMI': { curso: 'Banco de Condensadores (Semipresencial)', precio: 450, moneda: 'PEN' }
    };

    if(btnSubmit) {
        btnSubmit.onclick = function() {
            var codigo = inputCoupon.value.trim().toUpperCase();
            if(codigo === "") return;

            if(cuponesValidos[codigo]) {
                var datos = cuponesValidos[codigo];
                var urlPago = "<?= BASE_URL ?>checkout?curso=" + encodeURIComponent(datos.curso) + 
                              "&precio=" + encodeURIComponent(datos.precio) + 
                              "&moneda=" + encodeURIComponent(datos.moneda);
                window.location.href = urlPago;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups!',
                    text: 'Cupón no válido o expirado.',
                    confirmButtonColor: 'var(--thm-base)',
                    confirmButtonText: 'Intentar de nuevo'
                });
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
                                    <a href="./" aria-label="Inicio"><img width="160" height="60" src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="Imagen decorativa"></a>
                                </div>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-2 col-lg-4 col-md-4 wow animated fadeInUp" data-wow-delay="0.3s">
                            <div class="footer-widget__column footer-widget__courses">
                                <h3 class="footer-widget__title">Cursos</h3>
                                <ul class="footer-widget__courses-list list-unstyled">
                                    <li><a href="<?= BASE_URL ?>cursos/ingenieria">Ingeniería Eléctrica</a></li>
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
                                    <li><a href="<?= BASE_URL ?>nosotros">Nosotros</a></li>
                                    <li><a href="<?= BASE_URL ?>cursos/ingenieria">Ingeniería</a></li>
                                    <li><a href="<?= BASE_URL ?>contacto">Contáctanos</a></li>
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
                                <p class="phone"><a href="tel:+51941208020" target="_black">+51 941 208 020</a></p>
                            </div>
                        </div>
                        <!--End Footer Widget Column-->

                        <!--Start Footer Widget Column-->
                        <div class="col-xl-3 col-lg-6 col-md-6 wow animated fadeInUp" data-wow-delay="0.9s">
                            <div class="footer-widget__column footer-widget__social-links">
                                <ul class="footer-widget__social-links-list list-unstyled clearfix">
                                    <li><a href="https://wa.me/51941208020" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a></li>
                                    <li><a href="https://www.facebook.com/profile.php?id=61570845450403" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a></li>
                                    <!--Implementación de TikTok-->
                                    <li><a href="https://www.tiktok.com/@icc_capacitaciones_int" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a></li>
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
                <span class="mobile-nav__close mobile-nav__toggler" style="color: #ffffff !important;"><i class="fa fa-times"></i></span>

                <div class="logo-box">
                    <a href="./" aria-label="logo image"><img src="<?= BASE_URL ?>assets/images/logo_icc.png" width="230" alt="Imagen decorativa" /></a>
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
                        <a href="tel:+51941208020" target="_black">+51 941 208 020</a>
                    </li>
                </ul><!-- /.mobile-nav__contact -->
                <div class="mobile-nav__top">
                    <div class="mobile-nav__social">
                        <a href="https://wa.me/51941208020" target="_blank" class="fab fa-whatsapp" aria-label="WhatsApp"></a>
                        <a href="https://www.facebook.com/profile.php?id=61570845450403" target="_blank" class="fab fa-facebook-square" aria-label="Facebook"></a>
                        <!--Implementación de TikTok -->
                        <a href="https://www.tiktok.com/@icc_capacitaciones_int" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
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
        <!-- /.search-popup -->    <a href="#" data-target="html" class="scroll-to-target scroll-to-top" aria-label="Volver arriba"><i class="fa fa-angle-up"></i></a>

    <a target="_blank" href="https://wa.link/myq5iv" class="scroll-to-target scroll-to-top btn-whatsapp-pulse" aria-label="Contactar por WhatsApp"><i style="font-size: 40px;" class="fab fa-whatsapp"></i></a>
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


    <script src="https://maps.google.com/maps/api/js?key=AIzaSyATY4Rxc8jNvDpsK8ZetC7JyN4PFVYGCGM"></script>

    <!-- template js -->
    <script src="<?= BASE_URL ?>assets/js/zilom.js"></script>

    <!-- Modern Frameworks JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        // Configuración por defecto de Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "4000"
        };
    </script>

    <!-- Modal Ubigeo -->
    <div class="modal fade" id="ubigeoModal" tabindex="-1" aria-labelledby="ubigeoModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ubigeoModalLabel" style="color: #172A4E; font-size: 1.25rem;">Elige tu ubicación</h5>
            <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close" id="btnCloseModalUbigeo">&times;</button>
          </div>
          <div class="modal-body">
            <p>Conocer tu ubicación nos ayuda a ofrecerte cursos más relevantes para tu zona.</p>
            
            <form id="ubigeoForm">
                <label>País</label>
                <select id="selPais" class="form-control" required>
                    <option value="Perú">Perú</option>
                    <option value="Colombia">Colombia</option>
                    <option value="México">México</option>
                    <option value="Chile">Chile</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="España">España</option>
                    <option value="Otro">Otro</option>
                </select>

                <div id="container-peru">
                    <label>Departamento</label>
                    <select id="selDepartamento" class="form-control">
                        <option value="">Selecciona</option>
                    </select>
                    
                    <label>Provincia</label>
                    <select id="selProvincia" class="form-control" disabled>
                        <option value="">Selecciona</option>
                    </select>
                    
                    <label>Distrito</label>
                    <select id="selDistrito" class="form-control" disabled>
                        <option value="">Selecciona</option>
                    </select>
                </div>

                <div id="container-extranjero" style="display: none;">
                    <label>Ciudad / Región</label>
                    <input type="text" id="txtCiudadExtranjera" class="form-control" placeholder="Ej. Bogotá" style="border-radius: 8px; border: 1px solid #ccc; padding: 8px 12px; margin-bottom: 15px;">
                </div>
                
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-guardar">Guardar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Script Ubigeo -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Verificar cookie
        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            if (match) return match[2];
            return null;
        }
        
        function setCookie(name, value, days) {
            let d = new Date();
            d.setTime(d.getTime() + (days*24*60*60*1000));
            document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
        }

        var myModal = new bootstrap.Modal(document.getElementById('ubigeoModal'));
        
        // Abrir modal manualmente
        let btnOpen = document.getElementById('btnOpenUbigeo');
        if(btnOpen) {
            btnOpen.addEventListener('click', function(e) {
                e.preventDefault();
                myModal.show();
            });
        }

        let isDataLoaded = false;
        
        function initUbigeo() {
            if (isDataLoaded) return;
            // Cargar datos de ubigeo local
            fetch('<?= BASE_URL ?>assets/js/ubigeo.json')
            .then(res => res.json())
            .then(data => {
                isDataLoaded = true;
                let ubigeoData = data;
                
                // Extraer departamentos unicos
                let departamentos = {};
                ubigeoData.forEach(item => {
                    departamentos[item.departamento] = item.departamento;
                });
                
                let depSelect = document.getElementById('selDepartamento');
                let provSelect = document.getElementById('selProvincia');
                let distSelect = document.getElementById('selDistrito');
                let paisSelect = document.getElementById('selPais');
                let contPeru = document.getElementById('container-peru');
                let contExt = document.getElementById('container-extranjero');
                let txtCiudad = document.getElementById('txtCiudadExtranjera');
                
                Object.keys(departamentos).sort().forEach(dep => {
                    depSelect.innerHTML += `<option value="${dep}">${dep}</option>`;
                });
                
                paisSelect.addEventListener('change', function() {
                    if(this.value === 'Perú') {
                        contPeru.style.display = 'block';
                        contExt.style.display = 'none';
                        depSelect.required = true;
                        provSelect.required = true;
                        distSelect.required = true;
                        txtCiudad.required = false;
                    } else {
                        contPeru.style.display = 'none';
                        contExt.style.display = 'block';
                        depSelect.required = false;
                        provSelect.required = false;
                        distSelect.required = false;
                        txtCiudad.required = true;
                    }
                });

                // Inicializar requireds
                paisSelect.dispatchEvent(new Event('change'));

                depSelect.addEventListener('change', function() {
                    provSelect.innerHTML = '<option value="">Selecciona</option>';
                    distSelect.innerHTML = '<option value="">Selecciona</option>';
                    distSelect.disabled = true;
                    
                    if(this.value) {
                        provSelect.disabled = false;
                        let provincias = {};
                        ubigeoData.forEach(item => {
                            if(item.departamento === this.value) {
                                provincias[item.provincia] = item.provincia;
                            }
                        });
                        Object.keys(provincias).sort().forEach(prov => {
                            provSelect.innerHTML += `<option value="${prov}">${prov}</option>`;
                        });
                    } else {
                        provSelect.disabled = true;
                    }
                });
                
                provSelect.addEventListener('change', function() {
                    distSelect.innerHTML = '<option value="">Selecciona</option>';
                    
                    if(this.value) {
                        distSelect.disabled = false;
                        let distritos = {};
                        ubigeoData.forEach(item => {
                            if(item.departamento === depSelect.value && item.provincia === this.value) {
                                distritos[item.distrito] = item.distrito;
                            }
                        });
                        Object.keys(distritos).sort().forEach(dist => {
                            distSelect.innerHTML += `<option value="${dist}">${dist}</option>`;
                        });
                    } else {
                        distSelect.disabled = true;
                    }
                });
                
                // Enviar datos
                document.getElementById('ubigeoForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    let pais = paisSelect.value;
                    let payload = { pais: pais };

                    if (pais === 'Perú') {
                        payload.departamento = depSelect.value;
                        payload.provincia = provSelect.value;
                        payload.distrito = distSelect.value;
                    } else {
                        payload.ciudad = txtCiudad.value;
                    }
                    
                    fetch('<?= BASE_URL ?>visitor/saveLocation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    }).then(r => r.json()).then(res => {
                        // Guardar cookie
                        setCookie('visitor_location_saved', '1', 30);
                        let locText = "";
                        if (pais === 'Perú') {
                            locText = payload.departamento;
                            if (payload.provincia && payload.provincia !== payload.departamento) locText += ", " + payload.provincia;
                            if (payload.distrito && payload.distrito !== payload.provincia) locText += ", " + payload.distrito;
                        } else {
                            locText = payload.ciudad;
                        }
                        if (!locText) locText = pais;
                        localStorage.setItem('visitor_location_text', locText);
                        let ht = document.getElementById('headerLocationText');
                        if (ht) ht.innerText = locText;
                        myModal.hide();
                        if(res.success && typeof gtag === 'function') {
                            gtag('event', 'location_selected', {
                                'event_category': 'Visitor Location',
                                'event_label': pais === 'Perú' ? (payload.departamento + '-' + payload.provincia + '-' + payload.distrito) : (pais + '-' + payload.ciudad)
                            });
                        }
                    }).catch(e => {
                        console.error(e);
                        setCookie('visitor_location_saved', '1', 30);
                        myModal.hide();
                    });
                });
                
                // Si lo cierran sin guardar
                document.getElementById('btnCloseModalUbigeo').addEventListener('click', function() {
                    setCookie('visitor_location_saved', '1', 1); // No molestar por 1 dia
                });
            }).catch(e => console.error('Error loading ubigeo', e));
        }

        let savedLocText = localStorage.getItem('visitor_location_text');
        if (savedLocText) {
            let ht = document.getElementById('headerLocationText');
            if (ht) ht.innerText = savedLocText;
        }

        if (!getCookie('visitor_location_saved')) {
            initUbigeo();
            // Show popover instead of modal
            let popover = document.getElementById('locationPopover');
            if (popover) {
                popover.style.display = 'block';
                document.getElementById('popoverLocationText').innerText = savedLocText || 'Lima, Lima';
                
                document.getElementById('btnConfirmLocation').addEventListener('click', function(e) {
                    e.preventDefault();
                    setCookie('visitor_location_saved', '1', 30);
                    popover.style.display = 'none';
                    // Save default as Lima if nothing else
                    if (!localStorage.getItem('visitor_location_text')) {
                        localStorage.setItem('visitor_location_text', 'Lima, Lima');
                    }
                });
                
                document.getElementById('btnChangeLocation').addEventListener('click', function(e) {
                    e.preventDefault();
                    popover.style.display = 'none';
                    myModal.show();
                });
                
                document.getElementById('btnClosePopover').addEventListener('click', function(e) {
                    e.preventDefault();
                    setCookie('visitor_location_saved', '1', 1);
                    popover.style.display = 'none';
                });
            }
        } else {
            // Si hacen click manual y los datos an no se cargaron, se cargan
            let btnOpen = document.getElementById('btnOpenUbigeo');
            if(btnOpen) {
                btnOpen.addEventListener('click', function(e) {
                    initUbigeo();
                });
            }
        }
    });
    </script>
</body>


</html>








