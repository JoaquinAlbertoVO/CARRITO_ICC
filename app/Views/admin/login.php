<?php // Login logic moved to AdminAuthController ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>assets/admin/images/favicons/icc_favicon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>assets/admin/images/favicons/icc_favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>assets/admin/images/favicons/icc_favicon.png" />

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/vendor/perfect-scrollbar.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/app.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/app.rtl.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-material-icons.rtl.css" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">

    <!-- ion Range Slider -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-ion-rangeslider.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-ion-rangeslider.rtl.css" rel="stylesheet">

</head>

<body class="layout-login-centered-boxed" style="background: url(<?= BASE_URL ?>assets/admin/images/favicons/fondo.jpg);">


    <div class="layout-login-centered-boxed__form">
        <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-4 navbar-light">
            <a href="./" class="text-center text-light-gray mb-4">

                <!-- LOGO -->
                <img width="250" src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC Ingeniería">

            </a>
        </div>

        <div class="card card-body">

            <form action="" novalidate method="POST">
                <div><?= $alert ?></div>
                <div class="form-group">
                    <label class="text-label" for="select01">Rol:</label>
                    <select id="select01" name="rol" data-toggle="select" class="form-control">
                        <option selected="">Seleccionar rol ...</option>
                        <option value="1">Administrador</option>
                        <option value="2">Ingeniería Eléctrica</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-label" for="email_2">Usuario:</label>
                    <div class="input-group input-group-merge">
                        <input id="email_2" type="text" name="usuario" required="" class="form-control form-control-prepended" placeholder="Ingresa tu usuario">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-user"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-label" for="password_2">Contraseña:</label>
                    <div class="input-group input-group-merge">
                        <input id="password_2" type="password" name="clave" required="" class="form-control form-control-prepended" placeholder="Ingresa tu contraseña">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-key"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-1">
                    <button class="btn btn-block btn-primary" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>


    <!-- jQuery -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/material-design-kit.js"></script>

    <!-- Range Slider -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/ion.rangeSlider.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/ion-rangeslider.js"></script>

    <!-- App -->
    <script src="<?= BASE_URL ?>assets/admin/js/toggle-check-all.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/check-selected-row.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/dropdown.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/sidebar-mini.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="<?= BASE_URL ?>assets/admin/js/app-settings.js"></script>




</body>

</html>


