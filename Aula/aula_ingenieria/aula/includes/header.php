<?php  

if (empty($_SESSION['active'])) {
    header('location: ../');
}

?>
<!-- Header -->

        <div id="header" class="mdk-header bg-dark js-mdk-header m-0" data-fixed data-effects="waterfall">
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-primary pl-md-0 pr-0" id="navbar" data-primary>
                    <div class="container">
                        <div class="d-flex sidebar-account flex-shrink-0 mr-auto mr-lg-0">
                            <a href="./" class="flex d-flex align-items-center text-underline-0">
                                <span class="mr-1  text-white">
                                    <!-- LOGO -->
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="30" height="30">
                                        <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                            <img width="170" src="/assets/images/logo_icc.png" alt="ICC">
                                        </g>
                                    </svg>
                                </span>
                                <span class="flex d-flex flex-column text-white">
                                    <strong class="sidebar-brand"></strong>
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

                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle navbar-toggler-dashboard d-flex align-items-center ml-3 text-decoration-none" data-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']); ?>&background=e5c924&color=111625&bold=true" class="rounded-circle shadow-sm" width="36" alt="avatar">
                                <span class="ml-2 d-flex-inline">
                                    <span class="text-light" style="font-weight: 600; letter-spacing: 0.5px;"><?php echo $_SESSION['user'] ?></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-modern">
                                <div class="dropdown-item d-flex align-items-center py-3">
                                    <span class="mr-3">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']); ?>&background=e5c924&color=111625&bold=true" class="rounded-circle" width="48" alt="avatar">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong class="h6 m-0 text-white" style="font-weight: 700;"> <?php echo $_SESSION['user'] ?></strong>
                                        <small style="color: #e5c924; font-weight: 600; letter-spacing: 1px; font-size: 0.7rem;">ESTUDIANTE</small>
                                    </span>
                                </div>
                                <div class="dropdown-divider" style="border-top-color: rgba(255,255,255,0.1);"></div>
                                <a class="dropdown-item dropdown-item-modern d-flex align-items-center py-2" href="#">
                                    <i class="material-icons mr-3" style="font-size: 20px;">account_circle</i> Mi Perfil
                                </a>
                                <a class="dropdown-item dropdown-item-modern d-flex align-items-center py-2" href="#">
                                    <i class="material-icons mr-3" style="font-size: 20px;">shopping_cart</i> Mis Compras
                                </a>
                                <div class="dropdown-divider" style="border-top-color: rgba(255,255,255,0.1);"></div>
                                <a class="dropdown-item dropdown-item-modern d-flex align-items-center py-2" href="salir.php">
                                    <i class="material-icons mr-3" style="font-size: 20px; color: #ef4444;">exit_to_app</i> <span style="color: #ef4444;">Cerrar Sesión</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- // END Header -->