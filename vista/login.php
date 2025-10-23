<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketify | Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2f003879a.js" crossorigin="anonymous"></script>
    <style>
        /* ===== Fondo general con degradado animado ===== */
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ===== Caja principal ===== */
        .login-box {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 370px;
            color: #fff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        /* ===== Logo o encabezado ===== */
        .login-box h2 {
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }
        .login-box p {
            color: #dcdcdc;
            font-size: 0.9rem;
        }

        /* ===== Inputs ===== */
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-color: #66b3ff;
            box-shadow: none;
        }

        /* ===== Botones ===== */
        .btn-primary {
            background: linear-gradient(45deg, #00b09b, #96c93d);
            border: none;
            transition: 0.3s;
            border-radius: 10px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(45deg, #00a589, #84b82f);
        }

        .btn-outline-light {
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-outline-light:hover {
            background: #fff;
            color: #2a5298;
        }

        /* ===== Enlace de recuperación ===== */
        .text-light:hover {
            color: #96c93d !important;
        }

        /* ===== Mensaje de alerta ===== */
        .alert {
            background-color: rgba(255,255,255,0.2);
            border: none;
            color: #fff;
        }

        /* ===== Logo superior opcional ===== */
        .logo {
            width: 70px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-box text-center">
        <img src="../css/logo-ticketify.jpg" alt="Ticketify Logo" class="logo rounded-circle shadow-sm">
        <h2>¡Bienvenido de nuevo!</h2>
        <p>Inicia sesión con tu información personal</p>

        <form action="../controladores/sesion.php" method="POST">
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@gmail.com" required>
            </div>

            <div class="mb-3 text-start">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                <a href="registro.php" class="btn btn-outline-light">Registrarse</a>
            </div>

            <div class="text-center mt-3">
                <a href="recuperar_contraseña.php" class="text-light text-decoration-none">¿Olvidaste tu contraseña?</a>
            </div>

            <?php if (isset($_GET['message'])) { ?>
                <div class="alert mt-3 text-center" role="alert">
                    <?= htmlspecialchars($_GET['message']) ?>
                </div>
            <?php } ?>
        </form>
    </div>
</body>
</html>

