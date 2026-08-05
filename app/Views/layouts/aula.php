<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'ICC - Aula Virtual' ?></title>

    <meta name="robots" content="noindex">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>assets/images/logo_icc.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>assets/images/logo_icc.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>assets/images/logo_icc.png" />

    <link type="text/css" href="<?= BASE_URL ?>assets/aula/vendor/perfect-scrollbar.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/aula/css/app.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/aula/css/app.rtl.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/aula/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/aula/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/aula/css/vendor-ion-rangeslider.css" rel="stylesheet">
    <link type="text/css" href="<?= BASE_URL ?>assets/css/modern_override.css" rel="stylesheet">
</head>
<body class="layout-fixed layout-sticky-subnav">

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">
        <div id="header" class="mdk-header bg-dark js-mdk-header m-0" data-fixed data-effects="waterfall">
            <div class="mdk-header__content">
                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-primary pl-md-0 pr-0" id="navbar" data-primary>
                    <div class="container">
                        <div class="d-flex sidebar-account flex-shrink-0 mr-auto mr-lg-0">
                            <a href="<?= BASE_URL ?>aula" class="flex d-flex align-items-center text-underline-0">
                                <span class="mr-1 text-white">
                                    <img width="170" src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC">
                                </span>
                            </a>
                        </div>

                        <style>
                        .dropdown-menu-modern {
                            background: rgba(17, 22, 37, 0.95) !important;
                            backdrop-filter: blur(10px);
                            border: 1px solid rgba(229, 201, 36, 0.2) !important;
                            border-radius: 12px !important;
                            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
                            padding: 10px 0 !important;
                            min-width: 220px;
                        }
                        .dropdown-item-modern {
                            color: #f3f4f6 !important;
                            transition: all 0.3s ease;
                        }
                        .dropdown-item-modern:hover {
                            background: rgba(229, 201, 36, 0.1) !important;
                            color: #e5c924 !important;
                        }
                        .navbar-toggler-dashboard {
                            background: rgba(255,255,255,0.05);
                            border-radius: 30px;
                            padding: 5px 15px 5px 5px !important;
                            transition: all 0.3s ease;
                            border: 1px solid transparent !important;
                            cursor: pointer;
                        }
                        .navbar-toggler-dashboard:hover {
                            background: rgba(255,255,255,0.1);
                            border-color: rgba(229, 201, 36, 0.3) !important;
                        }
                        </style>

                        <ul class="nav navbar-nav ml-auto d-none d-md-flex">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>aula" class="nav-link">
                                    <i class="material-icons mr-1">dashboard</i> Dashboard
                                </a>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                            <li class="nav-item dropdown">
                                <a href="#account_menu" class="nav-link dropdown-toggle navbar-toggler-dashboard d-flex align-items-center" data-toggle="dropdown" data-caret="false">
                                    <div class="avatar avatar-sm mr-2">
                                        <span class="avatar-title rounded-circle bg-warning text-dark font-weight-bold">
                                            <i class="material-icons">person</i>
                                        </span>
                                    </div>
                                    <span class="text-white mr-2"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Estudiante') ?></span>
                                    <i class="material-icons text-white-50">arrow_drop_down</i>
                                </a>
                                <div id="account_menu" class="dropdown-menu dropdown-menu-right dropdown-menu-modern">
                                    <div class="dropdown-item-text dropdown-item-text-modern d-flex align-items-center px-3 py-2 mb-2 border-bottom" style="border-color: rgba(255,255,255,0.05) !important;">
                                        <div class="avatar avatar-sm mr-3">
                                            <span class="avatar-title rounded-circle bg-warning text-dark font-weight-bold">
                                                <i class="material-icons">person</i>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-white"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Estudiante') ?></div>
                                            <div class="text-muted small"><?= htmlspecialchars($_SESSION['correo'] ?? '') ?></div>
                                        </div>
                                    </div>
                                    <a class="dropdown-item dropdown-item-modern px-3 py-2" href="<?= BASE_URL ?>aula"><i class="material-icons mr-2 text-warning">school</i> Mis Cursos</a>
                                    <div class="dropdown-divider" style="border-color: rgba(255,255,255,0.05);"></div>
                                    <a class="dropdown-item dropdown-item-modern px-3 py-2 text-danger" href="<?= BASE_URL ?>aula/logout"><i class="material-icons mr-2">exit_to_app</i> Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $content; ?>

        <div class="bg-dark text-white" id="footer">
            <div class="container page__container">
                <div class="row">
                    <div class="col-md-8">
                        <a href="./" class="brand d-flex align-items-center mb-4">
                            <span class="mr-2">
                                <img width="200" src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC">
                            </span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-sm-6 col-md-12">
                                <h5>Contáctenos</h5>
                                <div class="d-flex ">
                                    <a href="https://wa.link/zw6o1w" target="_black" class="btn btn-facebook btn-rounded-social d-flex align-items-center justify-content-center mr-2"><i class="fab fa-whatsapp"></i></a>
                                    <a href="https://www.facebook.com/icc.com.pe/" target="_blank" class="btn btn-facebook btn-rounded-social d-flex align-items-center justify-content-center mr-2"><i class="fab fa-facebook"></i></a>
                                    <a href="https://www.linkedin.com/company/icc-per%C3%BA-capacitaciones-en-ingenier%C3%ADa-el%C3%A9ctrica/" target="_black" class="btn btn-twitter btn-rounded-social d-flex align-items-center justify-content-center mr-2"><i class="fab fa-linkedin"></i></a>
                                    <a href="https://www.instagram.com/capacitacionesicc/" target="_black" class="btn btn-twitter btn-rounded-social d-flex align-items-center justify-content-center mr-2"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?= BASE_URL ?>assets/aula/vendor/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/vendor/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/vendor/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/vendor/dom-factory.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/vendor/material-design-kit.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/vendor/ion.rangeSlider.min.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/js/dropdown.js"></script>
    <script src="<?= BASE_URL ?>assets/aula/js/app.js"></script>
</body>
</html>
