<?php  

$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
    header('location: aula/');
}else{
    if (!empty($_POST)) {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '
            <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Aviso - </strong> Ingrese su usuario, contrase«Ða al que pertenece.
            </div>
            ';
        }else{
            require_once "conexion.php";

            $user = mysqli_real_escape_string($conection,$_POST['usuario']);
            $pass = mysqli_real_escape_string($conection,$_POST['clave']);

            $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass' ");
            mysqli_close($conection);
            $result = mysqli_num_rows($query);

            if ($result > 0) {
                $data = mysqli_fetch_array($query);

                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['iduser'];
                $_SESSION['id_pla'] = $data['id_pla'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['user'] = $data['usuario'];

                header('location: aula/');
            }else{
                $alert = '

                <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Aviso - </strong> El usuario, clave o rol son incorrectos!
                </div>

                ';
                session_destroy();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="aula/assets/images/favicons/icc_favicon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="aula/assets/images/favicons/icc_favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="aula/assets/images/favicons/icc_favicon.png" />

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="aula/assets/vendor/perfect-scrollbar.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="aula/assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="aula/assets/css/app.rtl.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="aula/assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="aula/assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="aula/assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="aula/assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">

    <!-- ion Range Slider -->
    <link type="text/css" href="aula/assets/css/vendor-ion-rangeslider.css" rel="stylesheet">
    <link type="text/css" href="aula/assets/css/vendor-ion-rangeslider.rtl.css" rel="stylesheet">

</head>

<body class="layout-login-centered-boxed" style="background: url(aula/assets/images/favicons/fondo.jpg);">


    <div class="layout-login-centered-boxed__form">
        <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-4 navbar-light">
            <a href="./" class="text-center text-light-gray mb-4">

                <!-- LOGO -->
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" width="60" height="60">
                    <g transform="matrix(1.6666666666666667,0,0,1.6666666666666667,0,0)">
                        <img width="350" src="aula/assets/images/favicons/icc-logo1.png" alt="">
                    </g>
                </svg>

            </a>
        </div>

        <div class="card card-body" style="background-color: #1f202ad9;">

            <form action="" novalidate method="POST">
                <div><?php echo isset($alert)? $alert : ''; ?></div>
                <div class="form-group">
                    <center>
                        <img width="200" src="aula/assets/images/favicons/icc-logo-electrica.png" alt="ICC">
                    </center>
                    
                </div>
                <div class="form-group">
                    <label class="text-label" for="email_2" style="color: white;">Usuario:</label>
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
                    <label class="text-label" for="password_2" style="color: white;">ContraseÃ±a:</label>
                    <div class="input-group input-group-merge">
                        <input id="password_2" type="password" name="clave" required="" class="form-control form-control-prepended" placeholder="Ingresa tu contraseÃ±a">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-key"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-1">
                    <button class="btn btn-block btn-primary" type="submit">Iniciar SesiÃ³n</button>
                </div>
            </form>
        </div>
    </div>


    <!-- jQuery -->
    <script src="aula/assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="aula/assets/vendor/popper.min.js"></script>
    <script src="aula/assets/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="aula/assets/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="aula/assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="aula/assets/vendor/material-design-kit.js"></script>

    <!-- Range Slider -->
    <script src="aula/assets/vendor/ion.rangeSlider.min.js"></script>
    <script src="aula/assets/js/ion-rangeslider.js"></script>

    <!-- App -->
    <script src="aula/assets/js/toggle-check-all.js"></script>
    <script src="aula/assets/js/check-selected-row.js"></script>
    <script src="aula/assets/js/dropdown.js"></script>
    <script src="aula/assets/js/sidebar-mini.js"></script>
    <script src="aula/assets/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="aula/assets/js/app-settings.js"></script>




</body>

</html>