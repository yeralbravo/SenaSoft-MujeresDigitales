<?php
session_start();
require_once "../config/conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php?error=" . urlencode("Debes iniciar sesión primero."));
    exit();
}

$usuario_id = $_SESSION['id'];

$sql = "SELECT c.*, e.nombre AS evento, l.nombre AS localidad 
        FROM compras c
        JOIN events e ON c.evento_id = e.id
        JOIN localidades l ON c.localidad_id = l.id
        WHERE c.usuario_id = ?
        ORDER BY c.fecha_compra DESC";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
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
<div class="container">
  <h2 class="text-center mb-4">Historial de Compras</h2>
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>Evento</th>
        <th>Localidad</th>
        <th>Cantidad</th>
        <th>Valor Total</th>
        <th>Estado</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['evento']) ?></td>
          <td><?= htmlspecialchars($row['localidad']) ?></td>
          <td><?= htmlspecialchars($row['cantidad']) ?></td>
          <td>$<?= number_format($row['valor_total'], 2) ?></td>
          <td><?= htmlspecialchars($row['estado']) ?></td>
          <td><?= htmlspecialchars($row['fecha_compra']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="../vista/paginausuario.php" class="btn btn-outline-light">Volver</a>
</div>
</body>
</html>
