<?php
require_once "../config/conexion.php";

if (isset($_POST['registrar'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $capacidad = $_POST['capacidad'];

    
    if (empty($codigo) || empty($nombre) || $capacidad <= 0) {
        header("Location: ../vista/registrar_localidad.php?message=error");
        exit();
    }

    $sql = "INSERT INTO localidades (codigo, nombre, capacidad) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $codigo, $nombre, $capacidad);

    if ($stmt->execute()) {
        header("Location: ../vista/registrar_localidad.php?message=ok");
    } else {
        header("Location: ../vista/registrar_localidad.php?message=error");
    }
    exit();
}
?>
