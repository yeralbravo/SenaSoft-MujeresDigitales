<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Evento</title>
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
        <h2 class="text-center text-white mb-4">Registrar Evento</h2>

        <?php
        // Conexión
        $conexion = new mysqli("localhost", "root", "", "festivales");
        $municipios = $conexion->query("SELECT id, nombre FROM municipios");
        ?>

        <form action="../controladores/evento.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="text-white">Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Descripción:</label>
                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="text-white">Municipio:</label>
                <select name="municipio_id" class="form-select" required>
                    <option value="">Seleccione un municipio</option>
                    <?php while ($fila = $municipios->fetch_assoc()): ?>
                        <option value="<?php echo $fila['id']; ?>"><?php echo htmlspecialchars($fila['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="text-white">Fecha y hora de inicio:</label>
                <input type="datetime-local" name="fecha_inicio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Fecha y hora de fin:</label>
                <input type="datetime-local" name="fecha_fin" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Foto del evento:</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit" name="registrar">Registrar</button>
                <a href="consultar_eventos.php" class="btn btn-outline-light">Ver Eventos</a>
            </div>
        </form>

        <?php if (isset($_GET['message'])) { ?>
            <div class="alert mt-3 text-center text-white">
                <?php
                switch ($_GET['message']) {
                    case 'ok':
                        echo ' Evento registrado correctamente';
                        break;
                    case 'error':
                        echo ' Error al registrar el evento';
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
