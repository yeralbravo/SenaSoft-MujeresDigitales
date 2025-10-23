<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ticketify | Registro</title>
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
      width: 420px;
      color: #fff;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      overflow-y: auto;
      max-height: 90vh;
    }

    .login-box h2 {
      font-weight: 700;
      color: #fff;
      margin-bottom: 10px;
    }

    .login-box p {
      color: #dcdcdc;
      font-size: 0.9rem;
    }

    /* ===== Inputs y select ===== */
    .form-control, .form-select {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 10px;
    }

    .form-control::placeholder {
      color: #ccc;
    }

    .form-control:focus, .form-select:focus {
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

    .alert {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: #fff;
    }

    /* ===== Scrollbar elegante ===== */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.2);
      border-radius: 10px;
    }

    .logo {
      width: 70px;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <div class="login-box text-center">
    <img src="../css/logo-ticketify.jpg" alt="Ticketify Logo" class="logo rounded-circle shadow-sm">
    <h2>¡Bienvenido!</h2>
    <p>Regístrate con tu información personal</p>

    <form action="../controladores/registro.php" method="POST">
      <div class="mb-3 text-start">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Tu nombre" required>
      </div>

      <div class="mb-3 text-start">
        <label for="apellidos" class="form-label">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Tus apellidos" required>
      </div>

      <div class="mb-3 text-start">
        <label for="tipo_documento" class="form-label">Tipo de documento:</label>
        <select name="tipo_documento" id="tipo_documento" class="form-select" required>
          <option value="">-- Selecciona --</option>
          <option value="TI">Tarjeta de Identidad</option>
          <option value="CC">Cédula de Ciudadanía</option>
          <option value="CE">Cédula de Extranjería</option>
        </select>
      </div>

      <div class="mb-3 text-start">
        <label for="numero_documento" class="form-label">Número de documento:</label>
        <input type="text" id="numero_documento" name="numero_documento" class="form-control" placeholder="Ej: 1234567890" required>
      </div>

      <div class="mb-3 text-start">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Ej: 3204567890" pattern="[0-9]{7,15}" maxlength="15" required>
      </div>

      <div class="mb-3 text-start">
        <label for="email" class="form-label">Correo electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@gmail.com" required>
      </div>

      <div class="mb-3 text-start">
        <label for="contrasena" class="form-label">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="••••••••" minlength="4" required>
      </div>

      <div class="d-grid gap-2 mt-4">
        <button type="submit" class="btn btn-primary">Registrarse</button>
        <a href="login.php" class="btn btn-outline-light">Iniciar sesión</a>
      </div>

      <?php if (isset($error)) { ?>
        <div class="alert alert-danger mt-3" role="alert">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php } ?>
    </form>
  </div>
</body>
</html>
