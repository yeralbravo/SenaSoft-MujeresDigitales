<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Usuario - Ticketify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<!-- ENCABEZADO -->
<header class="bg-secondary text-light py-3 mb-4 shadow">
  <div class="container d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
      <img src="../img/logo.png" alt="Logo Ticketify" style="width:60px; height:60px; margin-right:10px;">
      <h2 class="m-0">Ticketify - Bienvenido <?= htmlspecialchars($_SESSION['nombre'] ?? '') ?></h2>
    </div>
    <nav>
        <a href="paginausuario.php" class="btn btn-outline-light m-1">
        <i class="bi bi-search"></i> Inicio
      </a>
      <a href="consultar_eventos_usuarios.php" class="btn btn-outline-light m-1">
        <i class="bi bi-search"></i> Consultar Eventos
      </a>
      <a href="historial.php" class="btn btn-outline-light m-1">
        <i class="bi bi-clock-history"></i> Historial
      </a>
      <a href="perfil.php" class="btn btn-outline-light m-1">
        <i class="bi bi-person-gear"></i> Actualizar Perfil
      </a>
      <a href="../index.php" class="btn btn-danger m-1">
        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
      </a>
    </nav>
  </div>
</header>




<!-- SECCIÓN DE CONSULTAR EVENTOS -->
<div class="container py-4">
  <h2 class="text-center mb-4">Consultar Eventos Disponibles</h2>

  <form method="GET" action="../controladores/consulta_usuario.php" class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
    <input type="date" name="fecha" class="form-control w-auto">
    <input type="text" name="municipio" class="form-control w-auto" placeholder="Municipio">
    <input type="text" name="departamento" class="form-control w-auto" placeholder="Departamento">
    <button type="submit" class="btn btn-primary" name="buscar">Buscar</button>
  </form>

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


<!-- Script para limpiar URL -->
<script>
  if (window.location.search) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }
</script>


<!-- PIE DE PÁGINA -->
<footer class="bg-secondary text-center text-light py-3 mt-5">
  <p>© 2025 Ticketify</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
