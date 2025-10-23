<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Consultar Eventos</title>
  <link rel="stylesheet" href="../css/style.css?v=5">
</head>
<body class="bg-dark text-white p-5">
<header>
  <h1>Ticketify</h1>
  <nav>
    <ul>
      <li><a href="registrar_evento.php">Inicio</a></li>
      <li><a href="registrar_evento.php">Eventos</a></li>
      <li><a href="registrar_artista.php">Artistas</a></li>
      <li><a href="registrar_localidad.php">Localidades</a></li>
      <li><a href="registrar_boleteria.php">Boletería</a></li>
      <li><a href="consultar_evento.php">Consultar</a></li>
      <li><a href="crud.php">Editar y Eliminar</a></li>
      <li><a href="index.php">Cerrar Sesion </a></li>
    </ul>
  </nav>
</header>

<h2 class="text-center mb-4">Consultar Eventos Disponibles</h2>

<form method="GET" action="../controladores/consulta.php" class="d-flex justify-content-center gap-3 mb-4">
  <input type="date" name="fecha" class="form-control w-auto">
  <input type="text" name="municipio" class="form-control w-auto" placeholder="Municipio">
  <input type="text" name="departamento" class="form-control w-auto" placeholder="Departamento">
  <button type="submit" class="btn btn-primary" name="buscar">Buscar</button>
</form>


<div class="container py-4">
  <?php
  // Solo cargamos resultados si se enviaron por GET
  $resultados = [];
  if (isset($_GET['resultados'])) {
      $decoded = urldecode($_GET['resultados']);
      $resultados = json_decode($decoded, true);
  }

  // Mostrar tabla solo si realmente hay resultados
  if (!empty($resultados)):
  ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered text-white">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Municipio</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultados as $ev): ?>
            <tr>
              <td><?= htmlspecialchars($ev['nombre'] ?? '') ?></td>
              <td><?= htmlspecialchars($ev['descripcion'] ?? '') ?></td>
              <td><?= htmlspecialchars($ev['municipio_id'] ?? '') ?></td>
              <td><?= htmlspecialchars($ev['fecha_inicio'] ?? '') ?></td>
              <td><?= htmlspecialchars($ev['fecha_fin'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- 🧹 Script para limpiar URL al recargar -->
<script>
  if (window.location.search) {
    // Limpia los parámetros GET después de cargar la página
    window.history.replaceState({}, document.title, window.location.pathname);
  }
</script>

</body>
</html>
