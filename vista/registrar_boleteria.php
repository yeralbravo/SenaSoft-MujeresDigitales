<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Boletería</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
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
    <h2>Registrar Boletería</h2>

    <form action="../controladores/boleteria.php" method="POST">
        <label>ID del Evento:</label>
        <input type="number" name="event_id" required><br>

        <label>ID de la Localidad:</label>
        <input type="number" name="localidad_id" required><br>

        <label>Precio de la Boleta:</label>
        <input type="number" name="precio" step="0.01" required><br>

        <label>Cantidad Disponible:</label>
        <input type="number" name="cantidad" required><br>

        <button type="submit" name="registrar">Registrar</button>
    </form>

    <?php if (isset($_GET['message'])) { ?>
        <div class="alert">
            <?php
                switch ($_GET['message']) {
                    case 'ok':
                        echo 'Boletería registrada correctamente 🎟️';
                        break;
                    case 'error':
                        echo 'Error al registrar la boletería ❌';
                        break;
                    default:
                        echo 'Algo salió mal.';
                        break;
                }
            ?>
        </div>
    <?php } ?>
</body>
</html>

