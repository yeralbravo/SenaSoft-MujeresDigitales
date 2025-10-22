<?php
require_once "../conexion.php";

if (isset($_POST['registrar'])) {
    $event_id = $_POST['event_id'];
    $localidad_id = $_POST['localidad_id'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO tickets (event_id, localidad_id, precio, cantidad)
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iidi", $event_id, $localidad_id, $precio, $cantidad);

    if ($stmt->execute()) {
        header("Location: ../vista/registrar_boleteria.php?message=ok");
    } else {
        header("Location: ../vista/registrar_boleteria.php?message=error");
    }
    exit();
}
?>
