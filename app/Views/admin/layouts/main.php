<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Instructor Dashboard</title>

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

    <!-- Flatpickr -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-flatpickr.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-flatpickr.rtl.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-flatpickr-airbnb.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-flatpickr-airbnb.rtl.css" rel="stylesheet">

    <!-- Quill Theme -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-quill.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-quill.rtl.css" rel="stylesheet">

    <!-- Dropzone -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-dropzone.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-dropzone.rtl.css" rel="stylesheet">

    <!-- Select2 -->
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-select2.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/css/vendor-select2.rtl.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/admin/vendor/select2/select2.min.css" rel="stylesheet">

</head>

<body class="layout-default">

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

<?php  

if (empty($_SESSION['active'])) {
    header('location: ../');
}

?>
<!-- Header -->

        <div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-primary pl-md-0 pr-0" id="navbar" data-primary>
                    <div class="container-fluid pr-0 ">

                        <!-- Navbar toggler -->
                        <button class="navbar-toggler navbar-toggler-custom d-lg-none d-flex mr-navbar" type="button" data-toggle="sidebar">
                            <span class="material-icons">short_text</span>
                        </button>


                        <div class="d-flex sidebar-account flex-shrink-0 mr-auto mr-lg-0">
                            <a href="./" class="flex d-flex align-items-center text-underline-0">
                                <span class="mr-1  text-white">
                                    <!-- LOGO -->
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="30" height="30">
                                        <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                            <img width="170" src="<?= BASE_URL ?>assets/admin/images/favicons/icc-logo1.png" alt="ICC">
                                        </g>
                                    </svg>
                                </span>
                                <span class="flex d-flex flex-column text-white">
                                    <strong class="sidebar-brand"></strong>
                                </span>
                            </a>
                        </div>

                        <ul class="nav navbar-nav d-none d-lg-flex pl-2">
                            <li class="nav-item dropdown">
                                <a href="./" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
                                    <span class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="22" height="22">
                                            <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                                <?php  
                                                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                                                    ?>
                                                    <img width="150" src="<?= BASE_URL ?>assets/admin/images/favicons/icc-logo-electrica.png" alt="ICC-electrica">
                                                    <?php 
                                                }
                                                ?>
                                                <?php  
                                                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
                                                    ?>
                                                    <img width="150" src="<?= BASE_URL ?>assets/admin/images/favicons/icc-logo-derecho.png" alt="ICC-electrica">
                                                    <?php 
                                                }
                                                ?>
                                            </g>
                                        </svg></span>
                                </a>
                            </li>
                        </ul>

                        <ul class="ml-auto nav navbar-nav mr-2 d-none d-lg-flex">
                            <li class="nav-item"><a href="#" class="nav-link"></a></li>
                        </ul>

                        <div class="dropdown">
                            <a href="#account_menu" class="dropdown-toggle navbar-toggler navbar-toggler-dashboard border-left d-flex align-items-center ml-navbar" data-toggle="dropdown">
                                <img src="data:image/jpeg;base64,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" class="rounded-circle" width="32" alt="Frontted">
                                <span class="ml-1 d-flex-inline">
                                    <span class="text-light"><?php echo $_SESSION['nombre']; ?></span>
                                </span>
                            </a>
                            <div id="company_menu" class="dropdown-menu dropdown-menu-right navbar-company-menu">
                                <!--<div class="dropdown-item d-flex align-items-center py-2 navbar-company-info py-3">

                                    <span class="mr-3">
                                        <img src="<?= BASE_URL ?>assets/admin/images/frontted-logo-blue.svg" width="43" height="43" alt="avatar">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong class="h5 m-0">Adrian D.</strong>
                                        <small class="text-muted text-uppercase">STUDENT</small>
                                    </span>

                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item d-flex align-items-center py-2" href="student-edit-account.html">
                                    <span class="material-icons mr-2">account_circle</span> Edit Account
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <span class="material-icons mr-2">settings</span> Settings
                                </a>-->
                                <a class="dropdown-item d-flex align-items-center py-2" href="salir.php">
                                    <span class="material-icons mr-2">exit_to_app</span> Cerrar Sesion
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
<!-- VISTA DINAMICA DEL DASHBOARD -->
<div class="mdk-drawer-layout__content page">
    <?= $content ?>
</div>
<!-- FIN VISTA DINAMICA -->
                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left bg-white" data-perfect-scrollbar>

                            <div class="sidebar-block p-0 m-0">
                                <div class="d-flex align-items-center sidebar-p-a border-bottom bg-light">
                                    <a href="#" class="flex d-flex align-items-center text-body text-underline-0">
                                        <span class="flex d-flex flex-column">
                                            <strong style="font-size: 15px"><?= $_SESSION['nombre'] ?? 'Admin' ?></strong>
                                            
                                            
                                            
                                        </span>
                                    </a>
                                    <div class="dropdown ml-auto">
                                        <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!--<a class="dropdown-item" href="student-dashboard.html">Dashboard</a>
                                            <a class="dropdown-item" href="student-profile.html">My profile</a>
                                            <a class="dropdown-item" href="student-edit-account.html">Edit account</a>
                                            <div class="dropdown-divider"></div>-->
                                            <a class="dropdown-item" rel="nofollow" data-method="delete" href="salir.php">Cerrar Sesion</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-block p-0">
    
                                <div class="sidebar-heading">Administrador</div>


                                <ul class="sidebar-menu mt-0">


                                    <li class="sidebar-menu-item active">
                                        <a class="sidebar-menu-button" href="./">
                                            <span class="sidebar-menu-icon sidebar-menu-icon--left">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="22" height="22">
                                                    <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                                        <path d="M7.652,14.05v-0.6C7.65,12.373,6.777,11.501,5.7,11.5H4.5c-0.414,0-0.75,0.336-0.75,0.75v6C3.75,18.664,4.086,19,4.5,19 h1.2c1.077-0.001,1.949-0.873,1.951-1.95v-0.6C7.65,16.117,7.564,15.79,7.4,15.5c-0.089-0.155-0.089-0.345,0-0.5 C7.564,14.71,7.651,14.383,7.652,14.05z M6.152,17.05c-0.017,0.249-0.231,0.437-0.48,0.42c-0.225-0.015-0.405-0.195-0.42-0.42v-0.6 c0.017-0.249,0.231-0.437,0.48-0.42c0.225,0.015,0.405,0.195,0.42,0.42V17.05z M6.152,14.05c-0.017,0.249-0.231,0.437-0.48,0.42 c-0.225-0.015-0.405-0.195-0.42-0.42v-0.6c0.017-0.249,0.231-0.437,0.48-0.42c0.225,0.015,0.405,0.195,0.42,0.42V14.05z M7.652,4.95C7.618,3.873,6.716,3.028,5.64,3.062C4.611,3.095,3.785,3.921,3.752,4.95v4.8c0,0.414,0.336,0.75,0.75,0.75 s0.75-0.336,0.75-0.75v-1.2c-0.017-0.249,0.171-0.463,0.42-0.48c0.249-0.017,0.463,0.171,0.48,0.42c0.001,0.02,0.001,0.04,0,0.06 v1.2c0,0.414,0.336,0.75,0.75,0.75s0.75-0.336,0.75-0.75V4.95z M6.152,6.15c-0.017,0.249-0.231,0.437-0.48,0.42 c-0.225-0.015-0.405-0.195-0.42-0.42v-1.2c0.017-0.249,0.231-0.437,0.48-0.42c0.225,0.015,0.405,0.195,0.42,0.42V6.15z M11.2,4H9.7 C9.286,4,8.95,4.336,8.95,4.75S9.286,5.5,9.7,5.5h1.5c0.414,0,0.75-0.336,0.75-0.75S11.614,4,11.2,4z M11.951,12.75 c0-0.414-0.336-0.75-0.75-0.75c0,0-0.001,0-0.001,0H9.7c-0.414,0-0.75,0.336-0.75,0.75S9.286,13.5,9.7,13.5h1.5 c0.414,0.001,0.75-0.335,0.751-0.749C11.951,12.751,11.951,12.75,11.951,12.75z M8.5,20h-6C2.224,20,2,19.776,2,19.5v-17 C2,2.224,2.224,2,2.5,2h8.672c0.265,0,0.52,0.105,0.707,0.293l2.828,2.828C14.895,5.308,15,5.563,15,5.828V12c0,0.552,0.448,1,1,1 c0.552,0,1-0.448,1-1V5.414c0.001-0.531-0.21-1.04-0.586-1.414L13,0.586C12.624,0.212,12.116,0.001,11.586,0H2C0.895,0,0,0.895,0,2 v18c0,1.105,0.895,2,2,2h6.5c0.552,0,1-0.448,1-1S9.052,20,8.5,20z M23.685,16.61l-6-2.382c-0.119-0.047-0.251-0.047-0.37,0 l-6,2.382c-0.194,0.077-0.319,0.266-0.315,0.475v3.13c0,0.276,0.224,0.5,0.5,0.5s0.5-0.224,0.5-0.5v-2.08 c0-0.138,0.111-0.249,0.248-0.25c0.029,0,0.057,0.005,0.085,0.015l5,1.765c0.108,0.037,0.224,0.037,0.332,0l6-2.118 c0.261-0.091,0.398-0.376,0.307-0.637C23.924,16.773,23.819,16.663,23.685,16.61L23.685,16.61z M20.763,19.829l-2.93,1.034 c-0.215,0.076-0.451,0.076-0.666,0l-2.93-1.034c-0.26-0.092-0.546,0.045-0.638,0.306c-0.019,0.053-0.028,0.11-0.028,0.166v2.145 c0,0.212,0.134,0.401,0.334,0.471l2.574,0.909c0.661,0.232,1.382,0.232,2.043,0l2.573-0.909c0.2-0.07,0.334-0.259,0.334-0.471V20.3 c0-0.276-0.223-0.5-0.5-0.5c-0.057,0-0.113,0.01-0.166,0.028L20.763,19.829z" stroke="none" fill="currentColor" stroke-width="0" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="sidebar-menu-text">Dashboard</span>
                                        </a>
                                    </li>
                                </ul>

                                <?php  
                                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                                ?>
                                <div class="sidebar-heading">Ingenieria Electrica</div>

                                <ul class="sidebar-menu mt-0">
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="<?= BASE_URL ?>admin/ingenieria">
                                            <span class="sidebar-menu-icon sidebar-menu-icon--left">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="22" height="22">
                                                    <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                                        <path d="M24,1.5C24,0.672,23.328,0,22.5,0h-21C0.672,0,0,0.672,0,1.5v21C0,23.328,0.672,24,1.5,24h21c0.828,0,1.5-0.672,1.5-1.5 V1.5z M10,21.5c0,0.276-0.224,0.5-0.5,0.5h-3C6.224,22,6,21.776,6,21.5v-6C6,15.224,6.224,15,6.5,15h3c0.276,0,0.5,0.224,0.5,0.5 V21.5z M15.5,21.5c0,0.276-0.224,0.5-0.5,0.5h-2c-0.276,0-0.5-0.224-0.5-0.5v-5c0-0.276,0.224-0.5,0.5-0.5h2 c0.276,0,0.5,0.224,0.5,0.5V21.5z M20.5,21.5c0,0.276-0.224,0.5-0.5,0.5h-2c-0.276,0-0.5-0.224-0.5-0.5v-6 c0-0.276,0.224-0.5,0.5-0.5h2c0.276,0,0.5,0.224,0.5,0.5V21.5z M23,11.75c0,0.414-0.336,0.75-0.75,0.75H1.75 C1.336,12.5,1,12.164,1,11.75S1.336,11,1.75,11H3c0.276,0,0.5-0.224,0.5-0.5V3.487C3.487,3.232,3.683,3.014,3.938,3h2.624 C6.817,3.014,7.013,3.232,7,3.487V10.5C7,10.776,7.224,11,7.5,11h1C8.776,11,9,10.776,9,10.5V6c0.012-0.288,0.254-0.511,0.542-0.5 h2.166c0.288-0.011,0.53,0.212,0.542,0.5v4.5c0,0.276,0.224,0.5,0.5,0.5h3.106c0.138,0,0.25-0.112,0.25-0.25 c0-0.029-0.005-0.059-0.015-0.086l-2.565-7c-0.079-0.229,0.043-0.479,0.272-0.558c0.007-0.003,0.015-0.005,0.023-0.007l1.8-0.577 c0.242-0.082,0.505,0.039,0.6,0.276l2.886,7.871c0.072,0.197,0.259,0.328,0.469,0.328h2.674c0.414,0,0.75,0.336,0.75,0.75 c0,0.001,0,0.003,0,0.004V11.75z" stroke="none" fill="currentColor" stroke-width="0" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="sidebar-menu-text">Ingenieria Electrica</span>
                                        </a>
                                    </li>
                                </ul>
                                <?php
                                }
                                ?>
                            </div>

                            <?php  
                            if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
                            ?>
                            <div class="sidebar-heading">Derecho gestion publica</div>
                            <div class="sidebar-block p-0">
                                <ul class="sidebar-menu" id="components_menu">
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="<?= BASE_URL ?>admin/derecho">
                                            <span class="sidebar-menu-icon sidebar-menu-icon--left">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="22" height="22">
                                                    <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                                        <path d="M24,1.5C24,0.672,23.328,0,22.5,0h-21C0.672,0,0,0.672,0,1.5v21C0,23.328,0.672,24,1.5,24h21c0.828,0,1.5-0.672,1.5-1.5 V1.5z M10,21.5c0,0.276-0.224,0.5-0.5,0.5h-3C6.224,22,6,21.776,6,21.5v-6C6,15.224,6.224,15,6.5,15h3c0.276,0,0.5,0.224,0.5,0.5 V21.5z M15.5,21.5c0,0.276-0.224,0.5-0.5,0.5h-2c-0.276,0-0.5-0.224-0.5-0.5v-5c0-0.276,0.224-0.5,0.5-0.5h2 c0.276,0,0.5,0.224,0.5,0.5V21.5z M20.5,21.5c0,0.276-0.224,0.5-0.5,0.5h-2c-0.276,0-0.5-0.224-0.5-0.5v-6 c0-0.276,0.224-0.5,0.5-0.5h2c0.276,0,0.5,0.224,0.5,0.5V21.5z M23,11.75c0,0.414-0.336,0.75-0.75,0.75H1.75 C1.336,12.5,1,12.164,1,11.75S1.336,11,1.75,11H3c0.276,0,0.5-0.224,0.5-0.5V3.487C3.487,3.232,3.683,3.014,3.938,3h2.624 C6.817,3.014,7.013,3.232,7,3.487V10.5C7,10.776,7.224,11,7.5,11h1C8.776,11,9,10.776,9,10.5V6c0.012-0.288,0.254-0.511,0.542-0.5 h2.166c0.288-0.011,0.53,0.212,0.542,0.5v4.5c0,0.276,0.224,0.5,0.5,0.5h3.106c0.138,0,0.25-0.112,0.25-0.25 c0-0.029-0.005-0.059-0.015-0.086l-2.565-7c-0.079-0.229,0.043-0.479,0.272-0.558c0.007-0.003,0.015-0.005,0.023-0.007l1.8-0.577 c0.242-0.082,0.505,0.039,0.6,0.276l2.886,7.871c0.072,0.197,0.259,0.328,0.469,0.328h2.674c0.414,0,0.75,0.336,0.75,0.75 c0,0.001,0,0.003,0,0.004V11.75z" stroke="none" fill="currentColor" stroke-width="0" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="sidebar-menu-text">Derecho y Gestion P.</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            }
                            ?>
                            
                            <div class="sidebar-p-a sidebar-b-y bg-light">
                                <div class="d-flex align-items-top mb-2">
                                    <div class="sidebar-heading m-0 p-0 flex text-body js-text-body">Progress</div>
                                    <div class="font-weight-bold text-muted">60%</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END header-layout__content -->

    </div>
    <!-- // END header-layout -->
<!-- App Settings FAB -->
    <div id="app-settings">
        <app-settings layout-active="default" :layout-location="{
      'default': 'instructor-dashboard.html',
      'fixed': 'fixed-instructor-dashboard.html',
      'fluid': 'fluid-instructor-dashboard.html',
      'mini': 'mini-instructor-dashboard.html'
    }"></app-settings>
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


    <!-- Flatpickr -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/flatpickr.js"></script>

    <!-- Global Settings -->
    <script src="<?= BASE_URL ?>assets/admin/js/settings.js"></script>


    <!-- Chart.js -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/Chart.min.js"></script>

    <!-- UI Charts Page JS -->
    <script src="<?= BASE_URL ?>assets/admin/js/chartjs-rounded-bar.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/charts.js"></script>

    <!-- Chart.js Samples -->
    <script src="<?= BASE_URL ?>assets/admin/js/page.instructor-dashboard.js"></script>

    <!-- List.js -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/list.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/list.js"></script>

    <!-- Quill -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/quill.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/quill.js"></script>

    <!-- Dropzone -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/dropzone.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/dropzone.js"></script>

    <!-- Select2 -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/select2/select2.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/select2.js"></script>

</body>

</html>
