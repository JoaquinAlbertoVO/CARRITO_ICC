<?php  

session_start();
include '../conexion.php';
include 'includes/head.php';
include 'includes/header.php';

?>


        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content page">
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            
            <div class="home-banner text-white mb-4">
                <div class="container page__container">
                    <h1 class="display-4 bold" data-aos="fade-up" data-aos-duration="800">Bienvenido a ICC - Instituto de Capacitación Continua</h1>
                    <p class="lead mb-5" data-aos="fade-up" data-aos-duration="1000">Cursos en Ingeniería Eléctrica</p>
                </div>
            </div>

            <div class="container page__container">
                <div class="m-4 p-4">
                    <h2 class="bold mb-1 text-center" style="color: #fff;">Cursos Activos</h2>
                    <p class="lead text-muted text-center" style="color: #fad705;">Nuestros cursos matriculados</p>
                </div>
                <div class="d-flex justify-content-around pb-4">

                    <div class="row">
                        
                        <!-- 21 TRABAJO EN CALIENTE -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.t_caliente = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='trabajo_caliente.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='trabajo_caliente.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='trabajo_caliente.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        
                        
                        <!-- 19 MANTENIMIENTO DE TABLEROS ELECTRICOS -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.m_t_electricos = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='mantenimiento_tableros_electricos.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='mantenimiento_tableros_electricos.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='mantenimiento_tableros_electricos.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        <!-- 18 MEDICION DE AISLAMIENTO EN BAJA Y MEDIA TENSION -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.id_medicion = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='medicion.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='medicion.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='medicion.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        <!-- 17 ELECTRICIDAD RESIDENCIAL -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.id_residencial = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='residencial.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='residencial.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='residencial.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        <!-- 10 ANALIZADOR DE REDES -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.a_redes = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='analizador_redes.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='analizador_redes.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='analizador_redes.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        <!-- 16 TERMOGRAFIA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.idtermo = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='termografia.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='termografia.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='termografia.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        
                        <!-- 2 PROGRAMACION BASICA PLC -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.plc = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='plc.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='plc.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='plc.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>
                        
                        <!-- 15 COSTOS Y PRESUPUESTOS PARA PROYECTOS E. -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.costo_p = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='costo_presupuesto.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='costo_presupuesto.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='costo_presupuesto.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>

                        

                        <!-- 3 ELECTRICIDAD BASICA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.e_basica = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='electricidad_basica.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='electricidad_basica.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='electricidad_basica.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 4 SISTEMA PUESTA A TIERRA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.s_p_tierra = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='sistema_puesta_tierra.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='sistema_puesta_tierra.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='sistema_puesta_tierra.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 5 MOTORES ELECTRICOS -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.m_electrico = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='motores_electricos.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='motores_electricos.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='motores_electricos.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 6 BANCO CONDENSADORES -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.banco_c = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='banco_condensadores.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='banco_condensadores.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='banco_condensadores.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 7 ANALISIS DE FACTURAS Y E. DE TARIFAS E. -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.a_facturas_t_e = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='tarifas_electricas.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='tarifas_electricas.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='tarifas_electricas.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 8 GESTION Y SEGURIDAD EN EL TRABAJO LEY N°29783 -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.g_seguridad_t = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='gestion_seguridad.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='gestion_seguridad.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='gestion_seguridad.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 11 RIESGO ELECTRICO -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.riesgo_e = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='riesgo_electrico.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='riesgo_electrico.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='riesgo_electrico.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 12 TRABAJO EN ALTURA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.t_altura = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='trabajo_altura.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='trabajo_altura.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='trabajo_altura.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 13 ESPECIALIZACION DE MOTORES ELECTRICOS T. -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.e_motores_e = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='electricos_trifasicos.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='electricos_trifasicos.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='electricos_trifasicos.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>


                        <!-- 4 SISTEMA PUESTA A TIERRA ANTIGUA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo,p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.s_p_t_antiguo = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "

                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='puesta_tierra_a.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='puesta_tierra_a.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='puesta_tierra_a.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div>        

                                ";
                            }
                        }

                        ?>

                        <!-- IMPLEMENTACIÓN - 2 CURSOS: REGULACIÓN DE MERCADO DE ENERGÍA & REDES DE DISTRIBUCIÓN DE ENERGÍA ELÉCTRICA -->
                        <!-- INICIO -->
                        
                        <!-- REGULACIÓN DE MERCADO DE ENERGÍA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.r_mercado_e = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='mercado_energia.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='mercado_energia.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='mercado_energia.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>

                        <!-- REDES DE DISTRIBUCIÓN DE ENERGÍA ELÉCTRICA -->
                        <?php  

                        $iduser = $_SESSION['idUser'];
                        mysqli_set_charset($conection,"utf8");

                        $sql = "SELECT i.id_inscrito, p.titulo, p.portada,p.sesion,p.horas FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria p ON i.redes_electricas = p.idinge WHERE i.id_user = $iduser";

                        $result = mysqli_query($conection, $sql);

                        while ($dato = mysqli_fetch_row($result)) {
                            if ($dato[1]) {
                                echo "
                        <div class='col-md-6 col-lg-4'>
                            <div class='card card__course card__course__animate'>
                               <a href='redes_electricas.php' class='card-img-top'>
                                    <img src='img/cursos/$dato[2]' style='width:100%;' alt='Card image cap'>
                                    <span class='play-button'>
                                        <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' width='60' height='60'>
                                            <g transform='matrix(2.0833333333333335,0,0,2.0833333333333335,0,0)'>
                                                <path d='M12,0C5.373,0,0,5.373,0,12s5.373,12,12,12s12-5.373,12-12C23.993,5.376,18.624,0.007,12,0z M16.828,12.894l-7.381,3.69 l0,0c-0.494,0.247-1.095,0.047-1.342-0.448C8.036,15.998,8,15.845,8,15.69V8.308c0-0.552,0.448-1,1-1 c0.155,0,0.307,0.036,0.446,0.105l7.383,3.687c0.495,0.245,0.698,0.845,0.453,1.34c-0.097,0.197-0.257,0.356-0.454,0.453V12.894z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>

                                <div class='p-3 text-center border-bottom'>
                                    <div class='bold mb-2'>
                                        <a href='redes_electricas.php' class='text-body'>
                                            <span class='course__title'>$dato[1]</span>
                                        </a>
                                    </div>
                                    <div class='d-flex justify-content-around'>


                                        <div class='mb-2 text-muted d-flex align-items-center align-self-center'>
                                            <small class='mr-3 d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M12.619,8.412c-0.001-0.41-0.333-0.742-0.743-0.742H5.938c-0.41,0.015-0.73,0.36-0.715,0.77 c0.014,0.389,0.326,0.701,0.715,0.715h5.938C12.286,9.155,12.619,8.822,12.619,8.412L12.619,8.412z M9.586,19 c-0.02-0.115-0.119-0.199-0.236-0.2H3.464c-0.276,0-0.5-0.224-0.5-0.5V5.443c0.003-0.274,0.226-0.495,0.5-0.495h10.887 c0.272,0.003,0.491,0.223,0.494,0.495v4.039c-0.002,0.135,0.106,0.245,0.241,0.247c0.018,0,0.037-0.002,0.054-0.005 c0.807-0.152,1.623-0.249,2.443-0.29c0.131-0.007,0.232-0.116,0.231-0.247V3.464c0.001-0.82-0.663-1.484-1.483-1.485 c0,0-0.001,0-0.001,0h-3.957c-0.085,0-0.163-0.046-0.205-0.119C11.103,0.059,8.78-0.537,6.979,0.528 C6.43,0.853,5.972,1.311,5.647,1.86c-0.042,0.073-0.12,0.118-0.205,0.119H1.485C0.665,1.979,0,2.644,0,3.464c0,0,0,0,0,0v16.825 c0.001,0.82,0.665,1.484,1.485,1.484h8.847c0.135,0,0.244-0.109,0.244-0.244c0-0.046-0.013-0.092-0.038-0.131 C10.091,20.657,9.769,19.846,9.586,19z M11.035,12.523c0.286-0.376,0.604-0.726,0.951-1.046c0.085-0.079,0.028-0.343-0.11-0.343 H5.938c-0.41,0.015-0.73,0.36-0.715,0.77c0.014,0.389,0.326,0.701,0.715,0.715h4.907C10.92,12.619,10.99,12.583,11.035,12.523z M5.938,14.6c-0.41,0-0.742,0.331-0.743,0.741c0,0.41,0.331,0.742,0.741,0.743c0,0,0.001,0,0.001,0h3.37 c0.117,0,0.216-0.085,0.235-0.2c0.061-0.337,0.145-0.669,0.251-0.995c0.032-0.1,0.055-0.29-0.129-0.29L5.938,14.6z M17.32,10.639 c-3.69-0.001-6.681,2.99-6.682,6.68s2.99,6.681,6.68,6.682c3.69,0.001,6.681-2.99,6.682-6.68c0,0,0-0.001,0-0.001 C23.996,13.632,21.008,10.643,17.32,10.639z M17.32,22.021c-2.596,0-4.7-2.104-4.7-4.7s2.104-4.7,4.7-4.7s4.7,2.104,4.7,4.7 C22.017,19.915,19.914,22.018,17.32,22.021z M19.3,16.33h-0.742c-0.137,0-0.248-0.111-0.248-0.248v-1.237 c-0.017-0.546-0.474-0.975-1.021-0.958c-0.522,0.017-0.941,0.436-0.958,0.958v2.475c0,0.546,0.443,0.989,0.989,0.989 c0,0,0.001,0,0.001,0H19.3c0.546,0.017,1.004-0.412,1.021-0.958s-0.412-1.004-0.958-1.021C19.342,16.329,19.321,16.329,19.3,16.33z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>$dato[3] Sesiones </span>
                                            </small>
                                            <small class='d-flex align-items-center'>
                                                <svg version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 40 40' width='18' height='18'>
                                                    <g transform='matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)'>
                                                        <path d='M19.159,8.257l1.548-1.549c0.397-0.384,0.408-1.017,0.025-1.414c-0.384-0.397-1.017-0.408-1.414-0.025 c-0.008,0.008-0.017,0.016-0.025,0.025l-1.6,1.6C16.324,5.867,14.702,5.231,13,5.054V2h2c0.552,0,1-0.448,1-1s-0.448-1-1-1H9 C8.448,0,8,0.448,8,1s0.448,1,1,1h2v3.054c-5.217,0.553-8.998,5.231-8.445,10.449s5.231,8.998,10.449,8.445 c5.217-0.553,8.998-5.231,8.445-10.449c-0.206-1.942-1.006-3.774-2.29-5.245V8.257z M12,22.5c-4.418,0-8-3.582-8-8s3.582-8,8-8 s8,3.582,8,8S16.418,22.5,12,22.5z M12,8c-3.59,0-6.5,2.91-6.5,6.5S8.41,21,12,21s6.5-2.91,6.5-6.5S15.59,8,12,8z M12.53,14.822 c-0.295,0.288-0.765,0.288-1.06,0l-2.042-2.04c-0.293-0.293-0.293-0.768,0-1.061s0.768-0.293,1.061,0l0,0l2.041,2.042 C12.802,14.052,12.785,14.518,12.53,14.822L12.53,14.822z' stroke='none' fill='currentColor' stroke-width='0' stroke-linecap='round' stroke-linejoin='round'></path>
                                                    </g>
                                                </svg>
                                                <span class='ml-1'>
                                                    $dato[4] horas
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class='p-3 text-center'>

                                    <a href='redes_electricas.php'><strong class='h4 m-0 text-primary'>INGRESAR</strong></a>

                                </div>         
                                
                            </div>
                        </div> 
                                ";
                            }
                        }

                        ?>

                        <!-- FIN -->

                        
                        <!-- NUEVOS CURSOS DINAMICOS Y CERTIFICADOS -->
                        <div class="col-12 mt-5">
                            <h3 class="text-white text-center mb-4 border-top pt-4">Tus Certificados y Nuevos Cursos</h3>
                        </div>
                        <?php
                        $iduser = $_SESSION['idUser'];
                        $query_dinamicos = mysqli_query($conection, "SELECT c.id_curso, c.nombre_curso, c.foto, c.horas_academicas FROM usuario_cursos uc INNER JOIN cursos c ON uc.id_curso = c.id_curso WHERE uc.id_usuario = $iduser AND c.estado = 1");
                        
                        if(mysqli_num_rows($query_dinamicos) > 0) {
                            while($curso_d = mysqli_fetch_array($query_dinamicos)) {
                                $img_curso = ($curso_d['foto'] == 'default.png') ? 'https://www.file-extension.info/images/resource/formats/img.png' : '../../administrador/administrador/img/cursos/'.$curso_d['foto'];
                                ?>
                                <div class='col-md-6 col-lg-4 mb-4'>
                                    <div class='card card__course'>
                                        <div class='card-img-top text-center bg-light' style='height:200px; overflow:hidden;'>
                                            <img src='<?php echo $img_curso; ?>' style='width:100%; object-fit: cover;' alt='Curso'>
                                        </div>
                                        <div class='p-3 text-center border-bottom'>
                                            <div class='bold mb-2'>
                                                <h5 class='course__title text-primary'><?php echo $curso_d['nombre_curso']; ?></h5>
                                            </div>
                                            <div class='mb-2 text-muted'>
                                                <small><?php echo $curso_d['horas_academicas']; ?> horas lectivas</small>
                                            </div>
                                        </div>
                                        <div class='p-3 text-center'>
                                            <a target="_blank" href='../../administrador/administrador/generar_certificado.php?id_usuario=<?php echo $iduser; ?>&id_curso=<?php echo $curso_d['id_curso']; ?>' class='btn btn-success btn-block' style='border-radius:20px;'>
                                                <i class="material-icons mr-1">file_download</i> Descargar Certificado
                                            </a>
                                        </div>         
                                    </div>
                                </div> 
                                <?php
                            }
                        } else {
                            echo "<div class='col-12 text-center text-white'><p>No tienes certificados o cursos nuevos asignados aún.</p></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>


            <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

            <script>
                AOS.init();
            </script>

<?php  

include 'includes/footer.php';
include 'includes/script.php';

?>