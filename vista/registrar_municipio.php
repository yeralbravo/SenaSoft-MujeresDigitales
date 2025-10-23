<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Municipio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=5">
</head>

<body class="bg-dark d-flex align-items-center justify-content-center vh-100">
    <header>
        <h1>Ticketify</h1>
        <nav>
            <ul>
                <li><a href="registrar_evento.php">Inicio</a></li>
                <li><a href="registrar_evento.php">Eventos</a></li>
                <li><a href="registrar_artista.php">Artistas</a></li>
                <li><a href="registrar_localidad.php">Localidades</a></li>
                <li><a href="registrar_boleteria.php">Boletería</a></li>
                <li><a href="consultar_eventos.php">Consultar</a></li>
                <li><a href="crud.php">Editar y Eliminar</a></li>
                <li><a href="../index.php">Cerrar Sesión </a></li>
            </ul>
        </nav>
    </header>

    <div class="login-box p-5 shadow rounded bg-secondary" style="width:420px;">
        <h2 class="text-center text-white mb-4">Registrar Municipio</h2>

        <?php
        // Conexión
        $conexion = new mysqli("localhost", "root", "", "festivales");
        $departamentos = $conexion->query("SELECT id, nombre FROM departamentos");
        ?>

        <form action="../controladores/municipio.php" method="POST">
            <div class="mb-3">
                <label class="text-white">Nombre del Municipio:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Departamento:</label>
                <select name="departamento_id" class="form-select" required>
                    <option value="">Seleccione un departamento</option>
                    <?php while ($fila = $departamentos->fetch_assoc()): ?>
                        <option value="<?php echo $fila['id']; ?>"><?php echo htmlspecialchars($fila['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit" name="registrar">Registrar</button>
            </div>
        </form>

        <?php if (isset($_GET['message'])) { ?>
            <div class="alert mt-3 text-center text-white">
                <?php
                switch ($_GET['message']) {
                    case 'ok':
                        echo 'Municipio registrado correctamente';
                        break;
                    case 'error':
                        echo 'Error al registrar el municipio';
                        break;
                    default:
                        echo 'Algo salió mal.';
                        break;
                }
                ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
