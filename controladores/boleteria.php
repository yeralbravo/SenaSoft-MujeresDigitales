<?php
require_once "../config/conexion.php";

if (isset($_POST['registrar'])) {
    $nombre_evento = $_POST['nombre_evento'];
    $nombre_localidad = $_POST['nombre_localidad'];
    $nombre_artista = $_POST['nombre_artista'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $tipo_ticket = $_POST['tipo_ticket'];

    // Obtener IDs desde los nombres
    $stmt_evento = $conexion->prepare("SELECT id FROM events WHERE nombre = ?");
    $stmt_evento->bind_param("s", $nombre_evento);
    $stmt_evento->execute();
    $stmt_evento->bind_result($event_id);
    $stmt_evento->fetch();
    $stmt_evento->close();

    $stmt_localidad = $conexion->prepare("SELECT id FROM localidades WHERE nombre = ?");
    $stmt_localidad->bind_param("s", $nombre_localidad);
    $stmt_localidad->execute();
    $stmt_localidad->bind_result($localidad_id);
    $stmt_localidad->fetch();
    $stmt_localidad->close();

    $stmt_artista = $conexion->prepare("SELECT id FROM artistas WHERE nombres = ?");
    $stmt_artista->bind_param("s", $nombre_artista);
    $stmt_artista->execute();
    $stmt_artista->bind_result($artista_id);
    $stmt_artista->fetch();
    $stmt_artista->close();

    // Validar que existan
    if (empty($event_id) || empty($localidad_id) || empty($artista_id)) {
        header("Location: ../vista/registrar_boleteria.php?message=error");
        exit();
    }

    // Registrar boletería
    $sql = "INSERT INTO tickets (event_id, localidad_id, precio, cantidad, tipo_ticket)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("iidis", $event_id, $localidad_id, $precio, $cantidad, $tipo_ticket);

    if ($stmt->execute()) {
        $check = $conexion->prepare("SELECT * FROM evento_artista WHERE event_id = ? AND artista_id = ?");
        $check->bind_param("ii", $event_id, $artista_id);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows === 0) {
            $insert_relation = $conexion->prepare("INSERT INTO evento_artista (event_id, artista_id) VALUES (?, ?)");
            $insert_relation->bind_param("ii", $event_id, $artista_id);
            $insert_relation->execute();
            $insert_relation->close();
        }

        header("Location: ../vista/registrar_boleteria.php?message=ok");
    } else {
        header("Location: ../vista/registrar_boleteria.php?message=error");
    }
    $stmt->close();
    exit();
}
?>
