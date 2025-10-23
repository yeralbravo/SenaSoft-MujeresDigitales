<?php
require_once "../config/conexion.php"; 

if (!$conexion || $conexion->connect_error) {
    header("Location: ../vista/login.php?msg=" . urlencode("Error de conexión: " . $conexion->connect_error));
    exit;
}
$nombre            = trim($_POST['nombre'] ?? '');
$apellidos         = trim($_POST['apellidos'] ?? '');
$tipo_documento    = trim($_POST['tipo_documento'] ?? '');
$numero_documento  = trim($_POST['numero_documento'] ?? '');
$telefono          = trim($_POST['telefono'] ?? '');
$email             = trim($_POST['email'] ?? '');
$contrasena        = trim($_POST['contrasena'] ?? '');


if (
    empty($nombre) || empty($apellidos) || empty($tipo_documento) ||
    empty($numero_documento) || empty($telefono) ||
    empty($email) || empty($contrasena)
) {
    header("Location: ../vista/login.php?msg=" . urlencode("Todos los campos son obligatorios."));
    exit;
}

$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);


$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? OR numero_documento = ?");
$stmt->bind_param("ss", $email, $numero_documento);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../vista/login.php?msg=" . urlencode("El correo o número de documento ya están registrados."));
    $stmt->close();
    $conexion->close();
    exit;
}
$stmt->close();

$stmt = $conexion->prepare("
    INSERT INTO usuarios 
    (nombre, apellidos, tipo_documento, numero_documento, telefono, email, contrasena, rol) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 'usuario')
");
$stmt->bind_param("sssssss", $nombre, $apellidos, $tipo_documento, $numero_documento, $telefono, $email, $contrasena_hash);

if ($stmt->execute()) {
    header("Location: ../vista/login.php?msg=" . urlencode("Usuario registrado con éxito."));
} else {
    header("Location: ../vista/login.php?msg=" . urlencode("Error al registrar usuario: " . $stmt->error));
}

$stmt->close();
$conexion->close();
exit;
?>
