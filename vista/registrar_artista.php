<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Artista</title>
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
    <h2>Registrar Artista</h2>
    <form action="../controladores/artista.php" method="POST">
        <label>Nombres:</label>
        <input type="text" name="nombres" required><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required><br>

        <label>Género:</label>
        <input type="text" name="genero" required><br>

        <label>Ciudad Natal:</label>
        <input type="text" name="ciudad_natal" required><br>

        <button type="submit" name="registrar">Registrar</button>
    </form>

    <?php if (isset($_GET['message'])) { ?>
        <div class="alert">
            <?php
                echo $_GET['message'] === 'ok' ? 'Artista registrado correctamente 🎤' : 'Error al registrar artista ❌';
            ?>
        </div>
    <?php } ?>
</body>
</html>
