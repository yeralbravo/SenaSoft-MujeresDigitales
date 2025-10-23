<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Localidad</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
<<<<<<< HEAD
        <h1>Ticketify</h1>
=======
        <h1>🎟️ Ticketify</h1>
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
        <nav>
            <ul>
                <li><a href="registrar_evento.php">Inicio</a></li>
                <li><a href="registrar_evento.php">Eventos</a></li>
                <li><a href="registrar_artista.php">Artistas</a></li>
                <li><a href="registrar_localidad.php">Localidades</a></li>
                <li><a href="registrar_boleteria.php">Boletería</a></li>
                <li><a href="consultar_eventos.php">Consultar</a></li>
<<<<<<< HEAD
                <li><a href="crud.php">Editar y Eliminar</a></li>
                <li><a href="index.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

=======
            </ul>
        </nav>
    </header>
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
    <h2>Registrar Localidad</h2>
    
    <form action="../controladores/localidad.php" method="POST">
        <label>Código:</label>
        <input type="text" name="codigo" required><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

<<<<<<< HEAD
        <label>Capacidad:</label>
        <input type="number" name="capacidad" required><br>

=======
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
        <button type="submit" name="registrar">Registrar</button>
    </form>

    <?php if (isset($_GET['message'])) { ?>
        <div class="alert">
            <?php
<<<<<<< HEAD
                echo $_GET['message'] === 'ok' 
                    ? 'Localidad registrada correctamente.' 
                    : 'Error al registrar.';
=======
                echo $_GET['message'] === 'ok' ? 'Localidad registrada correctamente ✅' : 'Error al registrar ❌';
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
            ?>
        </div>
    <?php } ?>
</body>
</html>
