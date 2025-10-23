<?php 
$conexion = new mysqli("localhost", "root", "", "festivales");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$where = "";
if (!empty($_GET['fecha'])) {
    $fecha = $_GET['fecha'];
    $where .= " AND DATE(e.fecha_inicio) = '$fecha'";
}
if (!empty($_GET['municipio'])) {
    $municipio = $conexion->real_escape_string($_GET['municipio']);
    $where .= " AND m.nombre LIKE '%$municipio%'";
}
if (!empty($_GET['departamento'])) {
    $departamento = $conexion->real_escape_string($_GET['departamento']);
    $where .= " AND d.nombre LIKE '%$departamento%'";
}

$sql = "
SELECT 
    e.id,
    e.nombre AS nombre_evento,
    e.descripcion,
    e.fecha_inicio,
    e.fecha_fin,
    e.foto,
    m.nombre AS municipio,
    d.nombre AS departamento
FROM events e
LEFT JOIN municipios m ON e.municipio_id = m.id
LEFT JOIN departamentos d ON m.departamento_id = d.id
WHERE 1=1 $where
ORDER BY e.fecha_inicio ASC
";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ticketify</title>
  <link rel="stylesheet" href="css/index.css" />
</head>
<body>

  <div class="main-container">
    <header class="top-header">
      <div class="brand-logo">
        <img src="css/logo-ticketify.jpg" alt="Ticketify Logo" class="logo-image" />
        <h1 class="brand-name">Ticketify</h1>
      </div>
      <nav class="navigation-menu">
        <div class="banner-actions">
          <a href="vista/login.php" class="action-button login-action">Iniciar Sesión</a>
          <a href="vista/registro.php" class="action-button register-action">Registrarse</a>
        </div>
      </nav>
    </header>

    <section class="hero-banner">
      <div class="banner-content">
        <h2 class="banner-heading">Atrévete a disfrutar de los mejores eventos de Colombia</h2>
        <p class="banner-text">
          Explora nuestra sección de eventos más esperados
        </p>
      </div>
    </section>

    <main>

      
      <section class="filter-section">
    <h2>Filtrar Eventos</h2>
    <form method="GET" action="/vista/consultar_eventos_visitante.php" class="filter-form">
        <div>
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo isset($_GET['fecha']) ? htmlspecialchars($_GET['fecha']) : ''; ?>">
        </div>

        <div>
            <label for="municipio">Municipio:</label>
            <input type="text" name="municipio" id="municipio" placeholder="Ej: Pereira" value="<?php echo isset($_GET['municipio']) ? htmlspecialchars($_GET['municipio']) : ''; ?>">
        </div>

        <div>
            <label for="departamento">Departamento:</label>
            <input type="text" name="departamento" id="departamento" placeholder="Ej: Risaralda" value="<?php echo isset($_GET['departamento']) ? htmlspecialchars($_GET['departamento']) : ''; ?>">
        </div>

        <button type="submit" class="filter-button">Buscar</button>
        <a href="index.php" class="filter-button">Limpiar filtros</a>
    </form>
</section>

      <section class="event-list-section">
        <h2>Próximos Eventos</h2>
        <div class="card-container">
          <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
              <?php 
                $foto = !empty($fila['foto']) ? $fila['foto'] : 'css/evento_default.jpg';
              ?>
              <div class="event-card-wrapper">
                <input type="checkbox" id="toggle-<?php echo $fila['id']; ?>" class="event-toggle">

                <label for="toggle-<?php echo $fila['id']; ?>" class="event-card">
                  <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($fila['nombre_evento']); ?>" class="event-img">
                  <div class="event-card-content">
                    <h3><?php echo htmlspecialchars($fila['nombre_evento']); ?></h3>
                    <p><strong>Fecha:</strong> <?php echo date("d/m/Y", strtotime($fila['fecha_inicio'])); ?></p>
                    <p><strong>Lugar:</strong> <?php echo htmlspecialchars($fila['municipio']); ?></p>
                    <p><strong>Departamento:</strong> <?php echo htmlspecialchars($fila['departamento']); ?></p>
                    <span class="ver-detalles">Ver detalles...</span>
                  </div>
                </label>

                <div class="event-details">
                  <h4>Detalles del Evento</h4>
                  <p><strong>Descripción:</strong> <?php echo htmlspecialchars($fila['descripcion']); ?></p>
                  <p><strong>Fecha de inicio:</strong> <?php echo $fila['fecha_inicio']; ?></p>
                  <p><strong>Fecha de fin:</strong> <?php echo $fila['fecha_fin']; ?></p>
                  <a href="vista/compra.php?id=<?php echo $fila['id']; ?>" class="buy-button">Comprar Boletos</a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No hay eventos registrados con esos filtros.</p>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 Ticketify</p>
  </footer>

  <style>
    .filter-section {
      background: #f4f4f4;
      padding: 20px;
      text-align: center;
      border-bottom: 2px solid #ccc;
    }
    .filter-form {
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
    }
    .filter-form input {
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .filter-button {
      background: #28a745;
      color: #fff;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .filter-button:hover {
      background: #218838;
    }
    .clear-filter {
      color: #555;
      text-decoration: underline;
      margin-left: 10px;
    }

    /* --- EVENTOS --- */
    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 20px;
      gap: 20px;
    }

    .event-card-wrapper {
      width: 300px;
      position: relative;
    }

    .event-toggle {
      display: none;
    }

    .event-card {
      display: block;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
      transition: transform 0.3s;
    }

    .event-card:hover {
      transform: scale(1.02);
    }

    .event-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .event-card-content {
      padding: 15px;
    }

    .ver-detalles {
      color: #007bff;
      text-decoration: underline;
      font-weight: bold;
    }

    .event-details {
      display: none;
      background: #f9f9f9;
      padding: 15px;
      border-radius: 0 0 12px 12px;
    }

    .event-toggle:checked ~ .event-details {
      display: block;
    }

    .buy-button {
      display: inline-block;
      background: #28a745;
      color: #fff;
      padding: 8px 12px;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s;
    }

    .buy-button:hover {
      background: #218838;
    }
  </style>

</body>
</html>

<?php
$conexion->close();
?>
