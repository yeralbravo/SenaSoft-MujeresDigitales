<?php
session_start();
require_once "../config/conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php?error=" . urlencode("Debes iniciar sesión primero."));
    exit();
}

// Verificar parámetros del boleto
if (!isset($_GET['evento_id']) || !isset($_GET['localidad_id']) || !isset($_GET['ticket_id'])) {
    die("<div style='color:white; background:#c00; padding:15px;'>Error: faltan datos del boleto seleccionado.</div>");
}

$evento_id = intval($_GET['evento_id']);
$localidad_id = intval($_GET['localidad_id']);
$ticket_id = intval($_GET['ticket_id']);

// Consultar los datos del boleto
$sql = "
SELECT 
    e.nombre AS evento,
    e.descripcion,
    e.fecha_inicio,
    e.fecha_fin,
    m.nombre AS municipio,
    l.nombre AS localidad,
    l.capacidad,
    t.precio,
    t.tipo_ticket,
    t.cantidad AS disponibles
FROM tickets t
INNER JOIN events e ON t.event_id = e.id
INNER JOIN localidades l ON t.localidad_id = l.id
INNER JOIN municipios m ON e.municipio_id = m.id
WHERE t.id = ? AND e.id = ? AND l.id = ?
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iii", $ticket_id, $evento_id, $localidad_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<div style='color:white; background:#c00; padding:15px;'>No se encontró el boleto seleccionado.</div>");
}

$boleto = $result->fetch_assoc();
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

<div class="container bg-secondary rounded p-4 shadow">
  <h2 class="text-center mb-4">Confirmar Compra de Boleta</h2>

  <!-- Mensaje de confirmación -->
  <?php if (isset($_GET['message'])): ?>
      <div class="alert alert-<?= $_GET['message'] === 'ok' ? 'success' : 'danger' ?>">
          <?= $_GET['message'] === 'ok' ? ' Compra realizada correctamente.' : ' Error al procesar la compra.' ?>
      </div>
  <?php endif; ?>

  <!-- Información del boleto -->
  <div class="mb-4 border rounded p-3 bg-dark">
    <h5 class="text-warning"><i class="bi bi-ticket-detailed"></i> Información del Boleto</h5>
    <p><strong>Evento:</strong> <?= htmlspecialchars($boleto['evento']) ?></p>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($boleto['descripcion']) ?></p>
    <p><strong>Municipio:</strong> <?= htmlspecialchars($boleto['municipio']) ?></p>
    <p><strong>Localidad:</strong> <?= htmlspecialchars($boleto['localidad']) ?></p>
    <p><strong>Tipo de Entrada:</strong> <?= htmlspecialchars($boleto['tipo_ticket']) ?></p>
    <p><strong>Precio Unitario:</strong> $<span id="precio"><?= number_format($boleto['precio'], 2) ?></span></p>
    <p><strong>Boletas Disponibles:</strong> <?= intval($boleto['disponibles']) ?></p>
  </div>

  <!-- Formulario de pago -->
  <form method="POST" action="../controladores/compra.php">
      <input type="hidden" name="evento_id" value="<?= $evento_id ?>">
      <input type="hidden" name="localidad_id" value="<?= $localidad_id ?>">
      <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">
      <input type="hidden" name="precio" id="precio_valor" value="<?= $boleto['precio'] ?>">

      <!-- Documento editable -->
      <div class="mb-3">
          <label class="form-label">Número de Documento</label>
          <input type="number" name="numero_documento" placeholder="Ingrese su número de documento" class="form-control" required>
      </div>

      <!-- Desplegable de cantidad -->
      <div class="mb-3">
          <label class="form-label">Cantidad de Boletas</label>
          <select name="cantidad" id="cantidad" class="form-select" required>
              <option value="">Seleccione cantidad...</option>
              <?php
              $max = min(10, intval($boleto['disponibles']));
              for ($i = 1; $i <= $max; $i++): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
          </select>
      </div>

      <!-- Total -->
      <div class="mb-3">
          <label class="form-label">Valor Total</label>
          <input type="text" id="total" class="form-control" value="$0.00" readonly>
      </div>

      <!-- Método de pago -->
      <div class="mb-3">
          <label class="form-label">Método de Pago</label>
          <select name="metodo_pago" class="form-select" required>
              <option value="">Seleccionar método...</option>
              <option value="Nequi">Nequi</option>
              <option value="Daviplata">Daviplata</option>
              <option value="Bancolombia">Bancolombia</option>
              <option value="PSE">PSE</option>
              <option value="Tarjeta de crédito">Tarjeta de crédito</option>
              <option value="Tarjeta débito">Tarjeta débito</option>
              <option value="Efecty">Efecty</option>
          </select>
      </div>

      <button type="submit" class="btn btn-success w-100"> Confirmar y Pagar</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const cantidad = document.getElementById('cantidad');
  const precio = parseFloat(document.getElementById('precio_valor').value);
  const total = document.getElementById('total');

  cantidad.addEventListener('change', () => {
      const valor = cantidad.value ? cantidad.value * precio : 0;
      total.value = '$' + valor.toLocaleString('es-CO', {minimumFractionDigits: 2});
  });
</script>
</body>
</html>
