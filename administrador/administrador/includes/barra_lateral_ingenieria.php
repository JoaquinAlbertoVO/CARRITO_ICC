                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left bg-white" data-perfect-scrollbar>


                            <div class="sidebar-block p-0 m-0">
                                <div class="d-flex align-items-center sidebar-p-a border-bottom bg-light">
                                    <a href="#" class="flex d-flex align-items-center text-body text-underline-0">
                                        <span class="flex d-flex flex-column">
                                            <strong style="font-size: 15px"><?php echo $_SESSION['nombre']; ?></strong>
                                            <?php
                                            include '../conexion.php';
                                            $id_pla = $_SESSION['idUser'];  
                                            $sql = mysqli_query($conection, "SELECT r.rol FROM plataforma p INNER JOIN rol r ON p.rol = r.id_rol WHERE p.id_pla = '$id_pla'");
                                            mysqli_close($conection);
                                            $result = mysqli_num_rows($sql);
                                            ?>
                                            <?php  
                                            if ($result > 0) {
                                                while ($rol = mysqli_fetch_array($sql)) {
                                                    ?>
                                                    <small class="text-muted text-uppercase"><?php echo $rol["rol"]; ?></small>
                                                    <?php 
                                                }
                                            }
                                            ?>
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


                                    <li class="sidebar-menu-item">
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
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button" href="ingenieria_lista.php">
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
                                    <div class="sidebar-heading">Gestión de Cursos y Certificados</div>
                                    <ul class="sidebar-menu mt-0">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="cursos_lista.php">
                                                <span class="sidebar-menu-icon sidebar-menu-icon--left">
                                                    <i class="material-icons text-muted">school</i>
                                                </span>
                                                <span class="sidebar-menu-text">Cursos Dinámicos</span>
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
                                        <a class="sidebar-menu-button" href="derecho_lista.php">
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