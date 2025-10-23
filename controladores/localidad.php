<?php
<<<<<<< HEAD
require_once "../config/conexion.php";
=======
require_once "../conexion.php";
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e

if (isset($_POST['registrar'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
<<<<<<< HEAD
    $capacidad = $_POST['capacidad'];

    
    if (empty($codigo) || empty($nombre) || $capacidad <= 0) {
        header("Location: ../vista/registrar_localidad.php?message=error");
        exit();
    }

    $sql = "INSERT INTO localidades (codigo, nombre, capacidad) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $codigo, $nombre, $capacidad);
=======

    $sql = "INSERT INTO localidades (codigo, nombre) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $codigo, $nombre);
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e

    if ($stmt->execute()) {
        header("Location: ../vista/registrar_localidad.php?message=ok");
    } else {
        header("Location: ../vista/registrar_localidad.php?message=error");
    }
    exit();
}
?>
<<<<<<< HEAD
=======

>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
