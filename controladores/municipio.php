<?php
session_start();
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $departamento_id = intval($_POST['departamento_id'] ?? 0);

    if (empty($nombre) || $departamento_id <= 0) {
        header("Location: ../vista/registrar_municipio.php?message=error");
        exit();
    }

    $sql = "INSERT INTO municipios (departamento_id, nombre) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("is", $departamento_id, $nombre);
        if ($stmt->execute()) {
            header("Location: ../vista/registrar_municipio.php?message=ok");
        } else {
            header("Location: ../vista/registrar_municipio.php?message=error");
        }
        $stmt->close();
    } else {
        header("Location: ../vista/registrar_municipio.php?message=error");
    }

    $conexion->close();
} else {
    header("Location: ../vista/registrar_municipio.php");
    exit();
}
?>
