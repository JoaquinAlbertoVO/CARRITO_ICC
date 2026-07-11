<?php  
$alert = '';
session_start();

// Si ya est activa la sesin, redirigir directo al aula
if (!empty($_SESSION['active'])) {
    header('location: /Aula/aula_ingenieria/aula/');
    exit;
}

if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $alert = '<div class="mo-toast mo-toast-error">
                    <span>⚠️</span> Ingrese su usuario y contraseña.
                  </div>';
    } else {
        // Conexin a la BD de ingeniera
        require_once "aula_ingenieria/conexion.php";

        $user = mysqli_real_escape_string($conection, $_POST['usuario']);
        $pass = mysqli_real_escape_string($conection, $_POST['clave']);

        $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass' ");
        mysqli_close($conection);
        
        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_array($query);

            $_SESSION['active'] = true;
            $_SESSION['idUser'] = $data['iduser'];
            $_SESSION['id_pla'] = $data['id_pla'];
            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['user'] = $data['usuario'];

            header('location: /Aula/aula_ingenieria/aula/');
            exit;
        } else {
            $alert = '<div class="mo-toast mo-toast-error">
                        <span>❌</span> Usuario o contraseña incorrectos.
                      </div>';
            session_destroy();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aula Virtual - ICC</title>
    
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/Favicon_Icc.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicons/Favicon_Icc.png" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #000000;
            --accent: #25d366;
            --text-light: #ffffff;
            --text-gray: #a0a0a0;
            --glass-bg: rgba(20, 20, 22, 0.65);
            --glass-border: rgba(255, 255, 255, 0.08);
            --input-bg: rgba(255, 255, 255, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Fondo moderno degradado oscuro con un toque de azul/verde */
            background: linear-gradient(135deg, #0f1115 0%, #171c26 50%, #0d1a15 100%);
            color: var(--text-light);
            overflow: hidden;
            position: relative;
        }

        /* Formas decorativas desenfocadas de fondo */
        .blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37,211,102,0.15) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 0;
        }
        
        .blob-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(41,98,255,0.1) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 10;
            position: relative;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--text-gray);
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #d1d1d1;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            background: var(--input-bg);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: #666;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #555;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.02);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #ffffff;
            color: #000000;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(255, 255, 255, 0.1);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Toasts de error modernos */
        .mo-toast-container {
            margin-bottom: 20px;
        }
        
        .mo-toast {
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mo-toast-error {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: var(--text-gray);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #fff;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Fondos decorativos -->
    <div class="blob-1"></div>
    <div class="blob-2"></div>

    <div class="login-container">
        <div class="login-header">
            <a href="../">
                <img src="/assets/images/logo_icc.png" alt="ICC Ingeniería" class="login-logo" style="width: 200px;">
            </a>
            <h1 class="login-title">Bienvenido</h1>
            <p class="login-subtitle">Ingresa tus credenciales para acceder al aula</p>
        </div>

        <div class="mo-toast-container">
            <?php echo isset($alert) ? $alert : ''; ?>
        </div>

        <form action="" method="POST" autocomplete="off">
            <div class="form-group">
                <label class="form-label" for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-input" placeholder="Ej: jperez" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="clave">Contraseña</label>
                <input type="password" id="clave" name="clave" class="form-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">Iniciar Sesión</button>
        </form>

        <a href="../" class="back-link">← Volver al sitio principal</a>
    </div>

</body>
</html>