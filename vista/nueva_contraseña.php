
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Actualizar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>
    <div class="main-container">
        <div class="login-box p-4 shadow rounded">
            <div class="text-center mb-4">
                <h2 class="text-white">Actualizar Contraseña</h2>
                <p class="text-light">Ingresa tu nueva contraseña</p>
            </div>

            <form action="../controladores/newcontraseña.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="new_contrasena" name="new_contrasena"
                        placeholder="Nueva contraseña" required />
                    <label for="new_contrasena">Nueva contraseña</label>
                </div>

                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="hidden" name="tipo" value="<?php echo $_GET['tipo']; ?>">

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>