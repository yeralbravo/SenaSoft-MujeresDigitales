<?php 
session_start();
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $clave = trim($_POST['contrasena'] ?? '');
    

    if (empty($email) || empty($clave)) {
        header("Location: ../vista/login.php?error=" . urlencode("Todos los campos son obligatorios."));
        exit();
    }

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT id, nombre, email, contrasena, rol FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($clave, $usuario['contrasena'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['rol'] = $usuario['rol'];

            if ($usuario['rol'] === 'admin') {
                header("Location: ../vista/registrar_evento.php");
            } else {
                header("Location: ../vista/paginausuario.php");
            }
            exit();
        } else {
            header("Location: ../vista/login.php?error=" . urlencode("Contraseña incorrecta."));
            exit();
        }
    } else {
        header("Location: ../vista/login.php?error=" . urlencode("No existe una cuenta con ese correo."));
        exit();
    }

    if (isset($stmt)) {
        $stmt->close();
    }

    if (isset($conexion)) {
        $conexion->close();
    }

} else {
    header("Location: ../vista/login.php");
    exit();
}
?>
