<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Consultar Eventos</title>
  <link rel="stylesheet" href="../css/style.css?v=4">
</head>
<body class="bg-dark text-white p-5">
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

  <h2 class="text-center mb-4">Consultar Eventos Disponibles</h2>

  <form method="GET" action="../controladores/consulta.php" class="d-flex justify-content-center gap-3 mb-4">
    <input type="date" name="fecha" class="form-control w-auto">
    <input type="text" name="municipio" class="form-control w-auto" placeholder="Municipio">
    <input type="text" name="departamento" class="form-control w-auto" placeholder="Departamento">
    <button type="submit" class="btn btn-primary">Buscar</button>
  </form>

  <div class="container">
    <?php if (isset($_GET['mensaje'])): ?>
      <div class="alert alert-info text-center"><?= htmlspecialchars($_GET['mensaje']) ?></div>
    <?php endif; ?>
  </div>

</body>
</html>
