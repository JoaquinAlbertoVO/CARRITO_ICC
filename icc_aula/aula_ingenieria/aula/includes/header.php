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
                                            <img width="170" src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/favicons/icc-logo1.png" alt="ICC">
                                        </g>
                                    </svg>
                                </span>
                                <span class="flex d-flex flex-column text-white">
                                    <strong class="sidebar-brand"></strong>
                                </span>
                            </a>
                        </div>

                        <ul class="nav navbar-nav d-none d-md-flex">
                            <li class="nav-item">
                                <a href="./" data-toggle="sidebar" class="nav-link d-flex align-items-center">
                                    <span class=" nav-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="25" height="25">
                                            <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                                                <img width="150" src="<?php echo isset($base_path) ? $base_path : \'\'; ?>assets/images/favicons/icc-logo-electrica.png" alt="ICC-electrica">
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </li>

                        </ul>

                        <div class="dropdown">
                            <a href="#account_menu" class="dropdown-toggle navbar-toggler navbar-toggler-dashboard border-left d-flex align-items-center ml-navbar" data-toggle="dropdown">
                                <img src="https://us.123rf.com/450wm/tuktukdesign/tuktukdesign1705/tuktukdesign170500025/77461813-icono-de-usuario-hombre-hombre-avatar-avatar-pictograma-pictograma-vector-ilustraci%C3%B3n.jpg" class="rounded-circle" width="32" alt="Frontted">
                                <span class="ml-1 d-flex-inline">
                                    <span class="text-light"> <?php echo $_SESSION['nombre'] ?></span>
                                </span>
                            </a>
                            <div id="company_menu" class="dropdown-menu dropdown-menu-right navbar-company-menu">
                                <div class="dropdown-item d-flex align-items-center py-2 navbar-company-info py-3">

                                    <span class="mr-3">
                                        <img src="https://us.123rf.com/450wm/tuktukdesign/tuktukdesign1705/tuktukdesign170500025/77461813-icono-de-usuario-hombre-hombre-avatar-avatar-pictograma-pictograma-vector-ilustraci%C3%B3n.jpg" width="43" height="43" alt="avatar">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong class="h5 m-0"> <?php echo $_SESSION['nombre'] ?></strong>
                                        <small class="text-muted text-uppercase">USUARIO</small>
                                    </span>

                                </div>
                                <div class="dropdown-divider"></div>
                                <!--<a class="dropdown-item d-flex align-items-center py-2" href="fixed-student-edit-account.html">
                                    <span class="material-icons mr-2">account_circle</span> Editar Cuenta
                                </a>-->
                                <!--<a class="dropdown-item d-flex align-items-center py-2" href="#">
                                    <span class="material-icons mr-2">settings</span> Ajustes
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