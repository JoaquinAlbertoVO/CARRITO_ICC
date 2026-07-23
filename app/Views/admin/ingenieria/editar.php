<div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center justify-content-between">
            <h1 class="m-0">Actualizar Curso</h1>
        </div>
    </div>

    <div class="container-fluid" id="container-wrapper">
    <!-- Updated file to force SFTP sync: 2026-07-23 -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div><?php echo isset($alert) ? $alert : ''; ?></div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-form__body card-body">

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <input type="hidden" name="id_usuario" value="<?php echo $data['iduser']; ?>">
                                        <input type="hidden" id="foto_actual" name="foto_actual"
                                            value="<?php echo $data['boucher']; ?>">
                                        <input type="hidden" id="foto_remove" name="foto_remove"
                                            value="<?php echo $data['boucher']; ?>">
                                        <label for="fname">Nombres y Apellifos completos</label>
                                        <input id="fname" type="text" name="nombre" class="form-control"
                                            value="<?php echo $data['nombre']; ?>"
                                            placeholder="Ingresar nombres y apellidos">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Correo Electronico</label>
                                        <input id="fname" type="text" name="correo" class="form-control"
                                            value="<?php echo $data['correo']; ?>"
                                            placeholder="Ingresar correo electronico">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Teléfono</label>
                                        <input id="fname" type="number" name="telefono" class="form-control"
                                            value="<?php echo $data['telefono']; ?>"
                                            placeholder="Ingresar número celular">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">DNI</label>
                                        <input id="fname" type="number" name="dni" class="form-control"
                                            value="<?php echo $data['dni']; ?>" placeholder="Ingresar DNI">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Número de Operación</label>
                                        <input id="fname" type="number" name="nopera" class="form-control"
                                            value="<?php echo $data['n_operacion']; ?>"
                                            placeholder="Ingresar N. de operacion">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="fname">Monto Pagado</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" step="any" name="mpagado"
                                                class="form-control form-control-prepended" required=""
                                                value="<?php echo $data['m_pagado']; ?>"
                                                placeholder="Ingresar monto pagar">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <span class="material-icons">S/</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="fname">Encargado de Registro</label>
                                        <input id="fname" type="text" name="encargado" class="form-control" readonly
                                            value="<?php echo htmlspecialchars($_SESSION['nombre'] ?? ''); ?>">

                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="fname">Banco registrado</label><br>
                                        <select id="select01" data-toggle="select" name="banco" class="form-control">
                                            <option selected=""><?php echo $data['banco']; ?></option>
                                            <option>BCP</option>
                                            <option>BanBif</option>
                                            <option>Banco Pichincha</option>
                                            <option>BBVA</option>
                                            <option>Interbank</option>
                                            <option>MiBanco</option>
                                            <option>Scotiabank Perú</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="flatpickrSample01">Fecha registro</label>
                                        <input id="flatpickrSample01" type="text" name="fecha" class="form-control"
                                            placeholder="Flatpickr example" data-toggle="flatpickr"
                                            value="<?php echo $data['fecha_deposito']; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Usuario</label>
                                        <input id="fname" type="text" class="form-control" name="usuario"
                                            value="<?php echo $data['usuario']; ?>" placeholder="Ingresar usuario">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="fname">Contraseña</label>
                                        <input id="fname" type="text" name="pass" class="form-control"
                                            value="<?php echo $data['password']; ?>" placeholder="Ingresar contraseña">
                                    </div>
                                </div>
                                <style type="text/css">
                                    img {
                                        max-width: 180px;
                                    }

                                    input[type=file] {
                                        padding: 10px;
                                        background: #efefef;
                                    }
                                </style>
                                <div class="form-group">
                                    <label>Ingresar Baucher</label><br><br>
                                    <input type="file" name="foto" onchange="readURL(this);" /><br><br>
                                    <img id="blah" src="img/uploads/<?php echo $data['boucher']; ?>" alt="your image" />
                                </div>
                                <script type="text/javascript">
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function (e) {
                                                $('#blah')
                                                    .attr('src', e.target.result);
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                                <div class="form-group"><br>
                                    <label style="font-size: 20px;" for="fname">Seleccionar Cursos
                                        Matriculados</label><br><br>
                                    <div class="form-row">
                                        <?php
                                        if (isset($data['cursos_matriculados'])) {
                                            foreach ($data['cursos_matriculados'] as $mostrar) {
                                                if (!empty($mostrar['titulo'])) {
                                                    echo "

                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>PROGRAMACIÓN BÁSICA P.L.C</label>
                                                    <select id='select01' data-toggle='select' name='2' class='form-control'>
                                                        <option value='2'>{$mostrar['titulo']}</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>

                                                ";
                                            } else {
                                                echo "

                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>PROGRAMACIÓN BÁSICA P.L.C</label>
                                                    <select id='select01' data-toggle='select' name='2' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='2'>PROGRAMACIÓN BÁSICA P.L.C</option>
                                                    </select>
                                                </div>

                                              ";
                                            }
                                        }
                                        }
                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql1 = "SELECT i.id_inscrito, e.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria e ON i.e_basica = e.idinge WHERE i.id_user = $id_usuario";

                                        $result1 = mysqli_query($conection, $sql1);

                                        while ($mostrar1 = mysqli_fetch_row($result1)) {
                                            //PRIMER CURSO ELECTRICIDAD BASICA
                                            if ($mostrar1[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ELECTRICIDAD BASICA</label>
                                                    <select id='select01' data-toggle='select' name='3' class='form-control'>
                                                        <option value='3'>$mostrar1[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ELECTRICIDAD BASICA</label>
                                                    <select id='select01' data-toggle='select' name='3' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='3'>ELECTRICIDAD BASICA</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql2 = "SELECT i.id_inscrito, s.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria s ON i.s_p_tierra = s.idinge WHERE i.id_user = $id_usuario";

                                        $result2 = mysqli_query($conection, $sql2);

                                        while ($mostrar2 = mysqli_fetch_row($result2)) {
                                            //PRIMER CURSO SISTEMA PUESTA A TIERRA
                                            if ($mostrar2[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>SISTEMA PUESTA A TIERRA</label>
                                                    <select id='select01' data-toggle='select' name='4' class='form-control'>
                                                        <option value='4'>$mostrar2[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>SISTEMA PUESTA A TIERRA</label>
                                                    <select id='select01' data-toggle='select' name='4' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='4'>SISTEMA PUESTA A TIERRA</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql3 = "SELECT i.id_inscrito, m.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria m ON i.m_electrico = m.idinge WHERE i.id_user = $id_usuario";

                                        $result3 = mysqli_query($conection, $sql3);

                                        while ($mostrar3 = mysqli_fetch_row($result3)) {
                                            //PRIMER CURSO MOTORES ELECTRICOS
                                            if ($mostrar3[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>MOTORES ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='5' class='form-control'>
                                                        <option value='5'>$mostrar3[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>MOTORES ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='5' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='5'>MOTORES ELECTRICOS</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>


                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql4 = "SELECT i.id_inscrito, b.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria b ON i.banco_c = b.idinge WHERE i.id_user = $id_usuario";

                                        $result4 = mysqli_query($conection, $sql4);

                                        while ($mostrar4 = mysqli_fetch_row($result4)) {
                                            //PRIMER CURSO BANCO CONDENSADORES
                                            if ($mostrar4[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>BANCO CONDENSADORES</label>
                                                    <select id='select01' data-toggle='select' name='6' class='form-control'>
                                                        <option value='6'>$mostrar4[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>BANCO CONDENSADORES</label>
                                                    <select id='select01' data-toggle='select' name='6' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='6'>BANCO CONDENSADORES</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql5 = "SELECT i.id_inscrito, a.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria a ON i.a_facturas_t_e = a.idinge WHERE i.id_user = $id_usuario";

                                        $result5 = mysqli_query($conection, $sql5);

                                        while ($mostrar5 = mysqli_fetch_row($result5)) {
                                            //PRIMER CURSO ANÁLISIS DE FACTURAS Y EVALUACIÓN DE TARIFAS ELÉCTRICAS
                                            if ($mostrar5[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ANÁLISIS DE FACTURAS Y EVALUACIÓN DE TARIFAS ELÉCTRICAS</label>
                                                    <select id='select01' data-toggle='select' name='7' class='form-control'>
                                                        <option value='7'>$mostrar5[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ANÁLISIS DE FACTURAS Y EVALUACIÓN DE TARIFAS ELÉCTRICAS</label>
                                                    <select id='select01' data-toggle='select' name='7' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='7'>ANÁLISIS DE FACTURAS Y EVALUACIÓN DE TARIFAS ELÉCTRICAS</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql6 = "SELECT i.id_inscrito, g.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria g ON i.g_seguridad_t = g.idinge WHERE i.id_user = $id_usuario";

                                        $result6 = mysqli_query($conection, $sql6);

                                        while ($mostrar6 = mysqli_fetch_row($result6)) {
                                            //PRIMER CURSO GESTION Y SEGURIDAD EN EL TRABAJO LEY N° 29783
                                            if ($mostrar6[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>GESTION Y SEGURIDAD EN EL TRABAJO LEY N° 29783</label>
                                                    <select id='select01' data-toggle='select' name='8' class='form-control'>
                                                        <option value='8'>$mostrar6[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>GESTION Y SEGURIDAD EN EL TRABAJO LEY N° 29783</label>
                                                    <select id='select01' data-toggle='select' name='8' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='8'>GESTION Y SEGURIDAD EN EL TRABAJO LEY N° 29783</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql7 = "SELECT i.id_inscrito, r.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria r ON i.r_mercado_e = r.idinge WHERE i.id_user = $id_usuario";

                                        $result7 = mysqli_query($conection, $sql7);

                                        while ($mostrar7 = mysqli_fetch_row($result7)) {
                                            //PRIMER CURSO REGULACION DE MERCADO DE ENERGIA
                                            if ($mostrar7[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>REGULACION DE MERCADO DE ENERGIA</label>
                                                    <select id='select01' data-toggle='select' name='9' class='form-control'>
                                                        <option value='9'>$mostrar7[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>REGULACION DE MERCADO DE ENERGIA</label>
                                                    <select id='select01' data-toggle='select' name='9' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='9'>REGULACION DE MERCADO DE ENERGIA</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql8 = "SELECT i.id_inscrito, re.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria re ON i.a_redes = re.idinge WHERE i.id_user = $id_usuario";

                                        $result8 = mysqli_query($conection, $sql8);

                                        while ($mostrar8 = mysqli_fetch_row($result8)) {
                                            //PRIMER CURSO CONFIGURACION E INSTALACION DE ANALIZADORES DE REDES
                                            if ($mostrar8[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>CONFIGURACION E INSTALACION DE ANALIZADORES DE REDES</label>
                                                    <select id='select01' data-toggle='select' name='10' class='form-control'>
                                                        <option value='10'>$mostrar8[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>CONFIGURACION E INSTALACION DE ANALIZADORES DE REDES</label>
                                                    <select id='select01' data-toggle='select' name='10' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='10'>CONFIGURACION E INSTALACION DE ANALIZADORES DE REDES</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql9 = "SELECT i.id_inscrito, ri.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria ri ON i.riesgo_e = ri.idinge WHERE i.id_user = $id_usuario";

                                        $result9 = mysqli_query($conection, $sql9);

                                        while ($mostrar9 = mysqli_fetch_row($result9)) {
                                            //PRIMER CURSO RIESGO ELECTRICO
                                            if ($mostrar9[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>RIESGO ELECTRICO</label>
                                                    <select id='select01' data-toggle='select' name='11' class='form-control'>
                                                        <option value='11'>$mostrar9[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>RIESGO ELECTRICO</label>
                                                    <select id='select01' data-toggle='select' name='11' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='11'>RIESGO ELECTRICO</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql10 = "SELECT i.id_inscrito, t.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria t ON i.t_altura = t.idinge WHERE i.id_user = $id_usuario";

                                        $result10 = mysqli_query($conection, $sql10);

                                        while ($mostrar10 = mysqli_fetch_row($result10)) {
                                            //PRIMER CURSO TRABAJO EN ALTURA
                                            if ($mostrar10[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>TRABAJO EN ALTURA</label>
                                                    <select id='select01' data-toggle='select' name='12' class='form-control'>
                                                        <option value='12'>$mostrar10[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>TRABAJO EN ALTURA</label>
                                                    <select id='select01' data-toggle='select' name='12' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='12'>TRABAJO EN ALTURA</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }
                                        ?>
                                        
                                        <?php
                                        // IMPLEMENTACIÓN CURSO ELECTRICIDAD RESIDENCIAL - INICIO
                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql13 = "SELECT i.id_inscrito, t.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria t ON i.id_residencial = t.idinge WHERE i.id_user = $id_usuario";

                                        $result13 = mysqli_query($conection, $sql13);

                                        while ($mostrar13 = mysqli_fetch_row($result13)) {
                                            //PRIMER CURSO TRABAJO EN ALTURA
                                            if ($mostrar13[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ELECTRICIDAD RESIDENCIAL</label>
                                                    <select id='select01' data-toggle='select' name='17' class='form-control'>
                                                        <option value='17'>$mostrar13[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ELECTRICIDAD RESIDENCIAL</label>
                                                    <select id='select01' data-toggle='select' name='17' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='17'>ELECTRICIDAD RESIDENCIAL</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }
                                        //IMPLEMENTACIÓN CURSO ELECTRICIDAD RESIDENCIAL - FIN

                                        ?>

                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql14 = "SELECT i.id_inscrito, s.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria s ON i.costo_p = s.idinge WHERE i.id_user = $id_usuario";

                                        $result14 = mysqli_query($conection, $sql14);

                                        while ($mostrar14 = mysqli_fetch_row($result14)) {
                                            //COSTOS Y PRESUPUESTOS PARA PROYECTOS ELECTRICOS
                                            if ($mostrar14[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>COSTOS Y PRESUPUESTOS PARA PROYECTOS ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='15' class='form-control'>
                                                        <option value='15'>$mostrar14[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>COSTOS Y PRESUPUESTOS PARA PROYECTOS ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='15' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='15'>COSTOS Y PRESUPUESTOS PARA PROYECTOS ELECTRICOS</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql15 = "SELECT i.id_inscrito, m.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria m ON i.idtermo = m.idinge WHERE i.id_user = $id_usuario";

                                        $result15 = mysqli_query($conection, $sql15);

                                        while ($mostrar15 = mysqli_fetch_row($result15)) {
                                            //TERMOGRAFIA INFRARROJA EN SISTEMAS ELECTRICOS
                                            if ($mostrar15[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>TERMOGRAFIA INFRARROJA EN SISTEMAS ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='5' class='form-control'>
                                                        <option value='5'>$mostrar15[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>TERMOGRAFIA INFRARROJA EN SISTEMAS ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='5' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='5'>TERMOGRAFIA INFRARROJA EN SISTEMAS ELECTRICOS</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>


                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql16 = "SELECT i.id_inscrito, s.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria s ON i.id_medicion = s.idinge WHERE i.id_user = $id_usuario";

                                        $result16 = mysqli_query($conection, $sql16);

                                        while ($mostrar16 = mysqli_fetch_row($result16)) {
                                            //MEDICION DE AISLAMIENTO EN BAJA Y MEDIA TENSION
                                            if ($mostrar16[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>MEDICION DE AISLAMIENTO EN BAJA Y MEDIA TENSION</label>
                                                    <select id='select01' data-toggle='select' name='18' class='form-control'>
                                                        <option value='18'>$mostrar16[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>MEDICION DE AISLAMIENTO EN BAJA Y MEDIA TENSION</label>
                                                    <select id='select01' data-toggle='select' name='18' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='18'>MEDICION DE AISLAMIENTO EN BAJA Y MEDIA TENSION</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql17 = "SELECT i.id_inscrito, m.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria m ON i.m_t_electricos = m.idinge WHERE i.id_user = $id_usuario";

                                        $result17 = mysqli_query($conection, $sql17);

                                        while ($mostrar17 = mysqli_fetch_row($result17)) {
                                            //MANTENIMIENTO DE TABLEROS ELECTRICOS
                                            if ($mostrar17[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>MANTENIMIENTO DE TABLEROS ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='19' class='form-control'>
                                                        <option value='19'>$mostrar17[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>MANTENIMIENTO DE TABLEROS ELECTRICOS</label>
                                                    <select id='select01' data-toggle='select' name='19' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='19'>MANTENIMIENTO DE TABLEROS ELECTRICOS</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>


                                    </div>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql18 = "SELECT i.id_inscrito, s.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria s ON i.redes_electricas = s.idinge WHERE i.id_user = $id_usuario";

                                        $result18 = mysqli_query($conection, $sql18);

                                        while ($mostrar18 = mysqli_fetch_row($result18)) {
                                            //REDES DE DISTRIBUCION DE ENERGIA ELECTRICA
                                            if ($mostrar18[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>REDES DE DISTRIBUCION DE ENERGIA ELECTRICA</label>
                                                    <select id='select01' data-toggle='select' name='20' class='form-control'>
                                                        <option value='20'>$mostrar18[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>REDES DE DISTRIBUCION DE ENERGIA ELECTRICA</label>
                                                    <select id='select01' data-toggle='select' name='20' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='20'>REDES DE DISTRIBUCION DE ENERGIA ELECTRICA</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql19 = "SELECT i.id_inscrito, m.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria m ON i.t_caliente = m.idinge WHERE i.id_user = $id_usuario";

                                        $result19 = mysqli_query($conection, $sql19);

                                        while ($mostrar19 = mysqli_fetch_row($result19)) {
                                            //TRABAJO EN CALIENTE
                                            if ($mostrar19[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>TRABAJO EN CALIENTE</label>
                                                    <select id='select01' data-toggle='select' name='21' class='form-control'>
                                                        <option value='21'>$mostrar19[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>TRABAJO EN CALIENTE</label>
                                                    <select id='select01' data-toggle='select' name='21' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='21'>TRABAJO EN CALIENTE</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>


                                    </div>
                                </div>
                                <div class="form-group"><br>
                                    <label style="font-size: 20px;" for="fname">Cursos Antiguos</label><br><br>
                                    <div class="form-row">
                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql11 = "SELECT i.id_inscrito, e.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria e ON i.e_motores_e = e.idinge WHERE i.id_user = $id_usuario";

                                        $result11 = mysqli_query($conection, $sql11);

                                        while ($mostrar11 = mysqli_fetch_row($result11)) {
                                            //PRIMER CURSO TRABAJO EN ALTURA
                                            if ($mostrar11[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ESPECIALIZACION DE MOTORES ELECTRICOS TRIFASICOS</label>
                                                    <select id='select01' data-toggle='select' name='13' class='form-control'>
                                                        <option value='13'>$mostrar11[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>ESPECIALIZACION DE MOTORES ELECTRICOS TRIFASICOS</label>
                                                    <select id='select01' data-toggle='select' name='13' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='13'>ESPECIALIZACION DE MOTORES ELECTRICOS TRIFASICOS</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                        <?php

                                        if (!isset($conection)) {
                                            $con_host = $_ENV['DB_HOST'] ?? 'localhost';
                                            $con_user = $_ENV['DB_USER'] ?? 'icccom_icc';
                                            $con_pass = $_ENV['DB_PASS'] ?? 'pWhOD~@e{DZ5ie%x';
                                            $con_db = $_ENV['DB_NAME'] ?? 'icccom_icc';
                                            $conection = @mysqli_connect($con_host, $con_user, $con_pass, $con_db);
                                        }
                                        $id_usuario = $_GET['id'];
                                        mysqli_set_charset($conection, "utf8");

                                        $sql12 = "SELECT i.id_inscrito, si.titulo FROM inscrito i INNER JOIN usuario u ON i.id_user = u.iduser INNER JOIN ingenieria si ON i.s_p_t_antiguo = si.idinge WHERE i.id_user = $id_usuario";

                                        $result12 = mysqli_query($conection, $sql12);

                                        while ($mostrar12 = mysqli_fetch_row($result12)) {
                                            //PRIMER CURSO SISTEMA PUESTA A TIERRA ANTIGUO
                                            if ($mostrar12[1]) {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>SISTEMA PUESTA A TIERRA ANTIGUO</label>
                                                    <select id='select01' data-toggle='select' name='14' class='form-control'>
                                                        <option value='14'>$mostrar12[1]</option>
                                                        <option value='1'>No</option>
                                                    </select>
                                                </div>
                                                ";
                                            } else {
                                                echo "
                                                <div class='col-12 col-md-6 mb-3'>
                                                    <label for='fname'>SISTEMA PUESTA A TIERRA ANTIGUO</label>
                                                    <select id='select01' data-toggle='select' name='14' class='form-control'>
                                                        <option value='1'>No</option>
                                                        <option value='14'>SISTEMA PUESTA A TIERRA ANTIGUO</option>
                                                    </select>
                                                </div>
                                                ";
                                            }
                                        }

                                        ?>

                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-body text-center">

                            <button type="submit" class="btn btn-success">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


</div>
