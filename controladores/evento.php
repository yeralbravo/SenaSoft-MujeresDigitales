<?php
require_once "../conexion.php";

$mensaje = "";

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $municipio_id = $_POST['municipio_id'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $sql = "INSERT INTO events (nombre, descripcion, municipio_id, fecha_inicio, fecha_fin)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssiss", $nombre, $descripcion, $municipio_id, $fecha_inicio, $fecha_fin);

        if ($stmt->execute()) {
            $mensaje = "ok";
        } else {
            $mensaje = "error";
        }
        $stmt->close();
    } else {
        $mensaje = "error";
    }
}
?>
