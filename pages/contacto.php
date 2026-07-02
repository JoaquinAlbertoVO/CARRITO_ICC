<?php $base_path = "../";  
include '../contacto/head.php'; 
include '../contacto/header.php';
?>
    <!--Page Header Start-->
    <section class="page-header clearfix" style="background-image: url(assets/images/backgrounds/page-header-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2>Contactános</h2>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="./">Inicio</a></li>
                                <li class="active">Contactános</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--Page Header End-->

    <!--Start Contact Details One-->
    <section class="contact-details-one">
        <div class="container">
            <div class="row">
                <!--Start Single Contact Details One-->
                <div class="col-xl-4 col-lg-4">
                    <div class="contact-details-one__single">
                        <div class="contact-details-one__single-icon">
                            <span class="icon-phone-call-1"></span>
                            <!-- <span class="icon-chat"></span> -->
                        </div>
                        <div class="contact-details-one__single-text">
                            <h4><a href="tel:+51986884219" target="_black">+51 986 884 219</a></h4>
                            <p>Llame en cualquier momento</p>
                        </div>
                    </div>
                </div>
                <!--End Single Contact Details One-->

                <!--Start Single Contact Details One-->
                <div class="col-xl-4 col-lg-4">
                    <div class="contact-details-one__single">
                        <div class="contact-details-one__single-icon">
                            <span class="icon-message-1"></span>
                        </div>
                        <div class="contact-details-one__single-text">
                            <h4><a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a></h4>
                            <p>Envíenos un correo electrónico</p>
                        </div>
                    </div>
                </div>
                <!--End Single Contact Details One-->

                <!--Start Single Contact Details One-->
                <!--<div class="col-xl-4 col-lg-4">
                    <div class="contact-details-one__single">
                        <div class="contact-details-one__single-icon">
                            <span class="icon-address"></span>
                        </div>
                        <div class="contact-details-one__single-text">
                            <h4>Av. República de Polonia</h4>
                            <p>Visite en cualquier momento</p>
                        </div>
                    </div>
                </div>-->
                <!--End Single Contact Details One-->
            </div>
        </div>
    </section>
    <!--End Contact Details One-->

    <!--Contact Page Start-->
    <section class="contact-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4">
                    <div class="contact-page__left">
                        <div class="section-title">
                            <span class="section-title__tagline" style="font-family: League Spartan;">Enviar un mensaje</span>
                            <h2 class="section-title__title" style="font-family: League Spartan;">Siempre Estamos <br> Listos Para Saber <br>De Usted</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="contact-page__right">
                        <form action="assets/inc/sendemail.php" class="comment-one__form contact-form-validated" novalidate="novalidate">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="comment-form__input-box">
                                        <input type="text" placeholder="Su nombre" name="name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="comment-form__input-box">
                                        <input type="email" placeholder="dirección de correo electronico" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="comment-form__input-box">
                                        <input type="text" placeholder="número de teléfono" name="phone">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="comment-form__input-box">
                                        <input type="email" placeholder="tema" name="Subject">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="comment-form__input-box">
                                        <textarea name="message" placeholder="escribe un mensaje"></textarea>
                                    </div>
                                    <button type="submit" class="thm-btn comment-form__btn">enviar comentario</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Contact Page End-->

    <!--Contact Page Google Map Start-->
    <!--<section class="contact-page-google-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3903.133582992453!2d-76.99797338449544!3d-11.965251943648903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c544610d46f1%3A0x3d4689d17d920020!2sAv.%20Rep%C3%BAblica%20de%20Polonia%201147%2C%20San%20Juan%20de%20Lurigancho%2015423!5e0!3m2!1ses-419!2spe!4v1664043242415!5m2!1ses-419!2spe"
            class="contact-page-google-map__one" allowfullscreen></iframe>
            
    </section>-->
    <!--Contact Page Google Map End-->
<?php  
include '../nosotros/footer.php';
include '../nosotros/mobile.php';
include '../contacto/script.php';
?>