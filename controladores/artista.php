<?php
require_once "../config/conexion.php";

if (isset($_POST['registrar'])) {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $genero = $_POST['genero'];
    $ciudad_natal = $_POST['ciudad_natal'];

    $sql = "INSERT INTO artistas (nombres, apellidos, genero, ciudad_natal) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombres, $apellidos, $genero, $ciudad_natal);

    if ($stmt->execute()) {
        header("Location: ../vista/registrar_artista.php?message=ok");
    } else {
        header("Location: ../vista/registrar_artista.php?message=error");
    }
    exit();
}
?>
