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
        <h1>🎟️ Ticketify</h1>
        <nav>
            <ul>
                <li><a href="registrar_evento.php">Inicio</a></li>
                <li><a href="registrar_evento.php">Eventos</a></li>
                <li><a href="registrar_artista.php">Artistas</a></li>
                <li><a href="registrar_localidad.php">Localidades</a></li>
                <li><a href="registrar_boleteria.php">Boletería</a></li>
                <li><a href="consultar_eventos.php">Consultar</a></li>
            </ul>
        </nav>
    </header>

    <div class="login-box p-5 shadow rounded bg-secondary" style="width:420px;">
        <h2 class="text-center text-white mb-4">Registrar Evento</h2>

        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['mensaje']) ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="../controladores/evento.php" method="POST">
            <div class="mb-3">
                <label class="text-white">Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Descripción:</label>
                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="text-white">Municipio ID:</label>
                <input type="number" name="municipio_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Fecha y hora de inicio:</label>
                <input type="datetime-local" name="fecha_inicio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="text-white">Fecha y hora de fin:</label>
                <input type="datetime-local" name="fecha_fin" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Registrar</button>
                <a href="consultar_eventos.php" class="btn btn-outline-light">Ver Eventos</a>
            </div>
        </form>
    </div>
</body>
</html>


