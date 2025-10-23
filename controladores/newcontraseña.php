<?php
include "../config/conexion.php";

if (!empty($_POST['new_contrasena']) && !empty($_POST['id']) && !empty($_POST['tipo'])) {
    $id = intval($_POST['id']);
    $tipo = $_POST['tipo'];
    $pass = password_hash($_POST['new_contrasena'], PASSWORD_BCRYPT);

    if ($tipo === "usuario") {
        $query = "UPDATE usuarios SET contrasena = ? WHERE id = ?";
    } else {
        $query = "UPDATE estudiantes SET contrasena_estudiante = ? WHERE id_estudiante = ?";
    }

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("si", $pass, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../formulariologin.php?message=success_password");
    } else {
        header("Location: ../formulariologin.php?message=error");
    }

    $stmt->close();
}
?>