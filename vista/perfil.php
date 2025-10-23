<?php 
session_start();
require_once "../config/conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php?error=" . urlencode("Debes iniciar sesión para acceder."));
    exit();
}

$id_usuario = $_SESSION['id'];

// 🔹 Obtener datos del usuario
$sql_usuario = "SELECT id, nombre, apellidos, tipo_documento, numero_documento, telefono, email, foto 
                FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_usuario);
if (!$stmt) die("Error al preparar la consulta: " . $conexion->error);

$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// 🔹 Actualizar foto de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $directorio = "../uploads/";
    if (!file_exists($directorio)) mkdir($directorio, 0777, true);

    $nombreArchivo = "perfil_" . $id_usuario . "_" . basename($_FILES["foto"]["name"]);
    $rutaDestino = $directorio . $nombreArchivo;
    $tipoArchivo = strtolower(pathinfo($rutaDestino, PATHINFO_EXTENSION));

    $permitidos = ["jpg", "jpeg", "png", "gif"];
    if (in_array($tipoArchivo, $permitidos) && move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        $stmt_foto = $conexion->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
        if (!$stmt_foto) die("Error al preparar la actualización de foto: " . $conexion->error);

        $stmt_foto->bind_param("si", $nombreArchivo, $id_usuario);
        $stmt_foto->execute();
        $usuario['foto'] = $nombreArchivo;
        $mensaje = "Foto actualizada correctamente.";
    } else {
        $error = "Error al subir la imagen. Asegúrate de que sea JPG, PNG o GIF.";
    }
}

// 🔹 Consultar las boletas compradas
$sql_boletas = "SELECT 
                    c.id AS compra_id,
                    e.nombre AS evento,
                    e.descripcion,
                    e.fecha_inicio,
                    e.fecha_fin,
                    l.nombre AS localidad,
                    t.tipo_ticket,                
                    t.precio,
                    c.cantidad,
                    (t.precio * c.cantidad) AS total
                FROM compras c
                INNER JOIN tickets t 
                    ON c.evento_id = t.event_id AND c.localidad_id = t.localidad_id
                INNER JOIN events e 
                    ON e.id = c.evento_id
                INNER JOIN localidades l 
                    ON l.id = c.localidad_id
                WHERE c.usuario_id = ?
                ORDER BY c.fecha_compra DESC";

$stmt_boletas = $conexion->prepare($sql_boletas);
if (!$stmt_boletas) die("Error al preparar consulta de boletas: " . $conexion->error);

$stmt_boletas->bind_param("i", $id_usuario);
$stmt_boletas->execute();
$result_boletas = $stmt_boletas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Perfil - Ticketify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

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
      <a href="perfil.php" class="btn btn-outline-light m-1"><i class="bi bi-person-gear"></i> Perfil</a>
      <a href="../index.php" class="btn btn-danger m-1"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </nav>
  </div>
</header>

<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-secondary text-white shadow">
        <div class="card-body text-center">
          <h3 class="mb-3"><i class="bi bi-person-circle"></i> Mi Perfil</h3>

          <div class="mb-3">
            <img src="../uploads/<?= htmlspecialchars($usuario['foto'] ?? 'default.png') ?>" 
                 alt="Foto de perfil" class="rounded-circle border border-light" width="150" height="150">
          </div>

          <form action="" method="POST" enctype="multipart/form-data" class="mb-3">
            <input type="file" name="foto" accept="image/*" class="form-control mb-2" required>
            <button type="submit" class="btn btn-light"><i class="bi bi-upload"></i> Cambiar Foto</button>
          </form>

          <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success"><?= $mensaje ?></div>
          <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <!-- Datos personales -->
          <h5 class="mt-4 text-start"><i class="bi bi-info-circle"></i> Información Personal</h5>
          <ul class="list-group list-group-flush bg-secondary">
            <li class="list-group-item bg-secondary text-light"><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?> <?= htmlspecialchars($usuario['apellidos']) ?></li>
            <li class="list-group-item bg-secondary text-light"><strong>Tipo Documento:</strong> <?= htmlspecialchars($usuario['tipo_documento']) ?></li>
            <li class="list-group-item bg-secondary text-light"><strong>Número Documento:</strong> <?= htmlspecialchars($usuario['numero_documento']) ?></li>
            <li class="list-group-item bg-secondary text-light"><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono']) ?></li>
            <li class="list-group-item bg-secondary text-light"><strong>Correo:</strong> <?= htmlspecialchars($usuario['email']) ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Boletas compradas -->
  <div class="mt-5">
    <h3 class="text-center mb-4"><i class="bi bi-ticket-perforated"></i> Mis Boletas Compradas</h3>

    <?php if ($result_boletas->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th>Evento</th>
              <th>Tipo Ticket</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Total</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($b = $result_boletas->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($b['evento']) ?></td>
                <td><?= htmlspecialchars($b['tipo_ticket']) ?></td>
                <td><?= htmlspecialchars($b['cantidad']) ?></td>
                <td>$<?= number_format($b['precio'], 0) ?></td>
                <td>$<?= number_format($b['total'], 0) ?></td>
                <td><?= htmlspecialchars($b['fecha_inicio']) ?></td>
                <td><?= htmlspecialchars($b['fecha_fin']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-center text-light">Aún no has comprado ninguna boleta.</p>
    <?php endif; ?>
  </div>
</div>

<footer class="bg-secondary text-center text-light py-3 mt-5">
  <p>© 2025 Ticketify</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
