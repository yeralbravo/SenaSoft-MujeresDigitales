<?php
require_once "../conexion.php";

if (isset($_POST['registrar'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO localidades (codigo, nombre) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $codigo, $nombre);

    if ($stmt->execute()) {
        header("Location: ../vista/registrar_localidad.php?message=ok");
    } else {
        header("Location: ../vista/registrar_localidad.php?message=error");
    }
    exit();
}
?>

