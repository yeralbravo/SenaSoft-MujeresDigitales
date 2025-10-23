<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperación de contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a2f003879a.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/style.css?v=2">
</head>

<body>
    <div class="main-container">
        <div class="left-panel"></div>

        <div class="right-panel">
            <div class="login-box p-5 shadow rounded">
                <div class="text-center mb-4">
                    <h2 class="text-white">Recuperar Contraseña</h2>
                    <p class="text-light">Ingresa tu correo y te enviaremos un enlace</p>
                </div>

                <form action="../controladores/recuperar.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label text-white">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" required />
                    </div>

                    <div class="d-grid">
                        <input type="submit" value="Recuperar contraseña" class="btn btn-primary" /> <br>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="formulariologin.php" class="btn btn-outline-light">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>