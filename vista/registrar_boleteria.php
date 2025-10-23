<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Boletería</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
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
                <li><a href="index.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <h2>Registrar Boletería</h2>

    <?php
    require_once "../config/conexion.php";

    // Obtener lista de eventos, localidades y artistas
    $eventos = $conexion->query("SELECT id, nombre FROM events");
    $localidades = $conexion->query("SELECT id, nombre FROM localidades");
    $artistas = $conexion->query("SELECT id, nombres, apellidos FROM artistas");
    ?>

    <form action="../controladores/boleteria.php" method="POST">
        <label>Evento:</label>
        <select name="nombre_evento" required>
            <option value="">-- Selecciona un evento --</option>
            <?php while ($row = $eventos->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($row['nombre']) ?>">
                    <?= htmlspecialchars($row['nombre']) ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Localidad:</label>
        <select name="nombre_localidad" required>
            <option value="">-- Selecciona una localidad --</option>
            <?php while ($row = $localidades->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($row['nombre']) ?>">
                    <?= htmlspecialchars($row['nombre']) ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Artista:</label>
        <select name="nombre_artista" required>
            <option value="">-- Selecciona un artista --</option>
            <?php while ($row = $artistas->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($row['nombres']) ?>">
                    <?= htmlspecialchars($row['nombres'] . " " . $row['apellidos']) ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="tipo_ticket">Tipo de boleta:</label>
        <select name="tipo_ticket" id="tipo_ticket" required>
            <option value="">-- Selecciona --</option>
            <option value="VIP">VIP</option>
            <option value="general">General</option>
            <option value="preferencial">Preferencial</option>
        </select><br>

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
                    echo 'Boletería registrada correctamente.';
                    break;
                case 'error':
                    echo 'Error al registrar la boletería.';
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
