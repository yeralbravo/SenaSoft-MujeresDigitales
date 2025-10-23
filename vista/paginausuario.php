<?php
session_start();
require_once "../config/conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php?error=" . urlencode("Debes iniciar sesión para acceder."));
    exit();
}


// reemplaza la consulta previa por esta
$sql = "
SELECT 
  e.id AS evento_id,
  e.nombre AS evento,
  e.descripcion,
  e.fecha_inicio,
  e.fecha_fin,
  m.nombre AS municipio,
  l.id AS localidad_id,
  l.nombre AS localidad,
  l.capacidad,
  t.id AS ticket_id,
  t.precio,
  t.cantidad AS ticket_disponible,
  t.tipo_ticket,
  GROUP_CONCAT(CONCAT(a.nombres, ' ', a.apellidos) SEPARATOR ', ') AS artistas
FROM events e
INNER JOIN municipios m ON e.municipio_id = m.id
INNER JOIN tickets t ON t.event_id = e.id
INNER JOIN localidades l ON t.localidad_id = l.id
LEFT JOIN evento_artista ae ON e.id = ae.event_id
LEFT JOIN artistas a ON ae.artista_id = a.id
WHERE t.cantidad > 0
GROUP BY e.id, l.id, t.id
ORDER BY e.fecha_inicio ASC
";
$result = $conexion->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conexion->error);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Usuario - Ticketify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<!-- Encabezado -->
<header class="bg-secondary text-light py-3 mb-4 shadow">
  <div class="container d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
      <img src="../img/logo.png" alt="Logo Ticketify" style="width:60px; height:60px; margin-right:10px;">
      <h2 class="m-0">Ticketify - Bienvenido <?= htmlspecialchars($_SESSION['nombre'] ?? '') ?></h2>
    </div>
    <nav>
     <a href="paginausuario.php" class="btn btn-outline-light m-1"><i class="bi bi-search"></i> Inicio</a>
      <a href="consultar_eventos_usuarios.php" class="btn btn-outline-light m-1"><i class="bi bi-search"></i> Consultar Eventos</a>
      <a href="historial.php" class="btn btn-outline-light m-1"><i class="bi bi-clock-history"></i> Historial</a>
      <a href="perfil.php" class="btn btn-outline-light m-1"><i class="bi bi-person-gear"></i> Actualizar Perfil</a>
      <a href="../index.php" class="btn btn-danger m-1"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </nav>
  </div>
</header>


<div class="container mb-5">
  <h3 class="text-center mb-4"><i class="bi bi-ticket-detailed"></i> Boletos Disponibles</h3>

  <?php if ($result && $result->num_rows > 0): ?>
    <div class="accordion" id="eventosAccordion">
      <?php $index = 0; while ($evento = $result->fetch_assoc()): ?>
        <div class="accordion-item bg-dark border border-light mb-3">
          <h2 class="accordion-header" id="heading<?= $index ?>">
            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
              <div class="d-flex justify-content-between w-100">
                <span><strong><?= htmlspecialchars($evento['evento']) ?></strong> - <?= htmlspecialchars($evento['localidad']) ?></span>
                <span>$<?= number_format($evento['precio'], 0) ?></span>
              </div>
            </button>
          </h2>
          
          <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#eventosAccordion">
            <div class="accordion-body text-light">
              <div class="row">
                <div class="col-md-8">
                  <p><strong>Descripción:</strong> <?= htmlspecialchars($evento['descripcion']) ?></p>
                  <p><strong>Artistas:</strong> <?= htmlspecialchars($evento['artistas'] ?? 'No registrados') ?></p>
                  <p><strong>Tipo de Entrada:</strong> <?= htmlspecialchars($evento['tipo_ticket'] ?? 'General') ?></p>
                  <p><strong>Localidad:</strong> <?= htmlspecialchars($evento['localidad']) ?></p>
                  <p><strong>Municipio:</strong> <?= htmlspecialchars($evento['municipio']) ?></p>
                  <p><strong>Capacidad:</strong> <?= htmlspecialchars($evento['capacidad']) ?></p>
                </div>
                <div class="col-md-4">
          <p><strong>Fecha de Inicio:</strong> <?= htmlspecialchars($evento['fecha_inicio']) ?></p>
          <p><strong>Fecha de Fin:</strong> <?= htmlspecialchars($evento['fecha_fin']) ?></p>
          <p><strong>Precio por Boleta:</strong> $<?= number_format($evento['precio'], 2) ?></p>
          <p><strong>Boletas Disponibles:</strong> <?= intval($evento['ticket_disponible']) ?></p>
          <div class="mt-4 text-center">
            <a href="compra.php?evento_id=<?= $evento['evento_id'] ?>&localidad_id=<?= $evento['localidad_id'] ?>&ticket_id=<?= $evento['ticket_id'] ?>" class="btn btn-success w-75<?= ($evento['ticket_disponible'] <= 0) ? ' disabled' : '' ?>">
              <i class="bi bi-cart-plus"></i> Comprar Boletas
            </a>
          </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php $index++; endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-light mt-4">No hay eventos disponibles actualmente.</p>
  <?php endif; ?>
</div>

<footer class="bg-secondary text-center text-light py-3 mt-5">
  <p>© 2025 Ticketify </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
