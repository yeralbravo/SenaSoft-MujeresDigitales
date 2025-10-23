<?php
if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $municipio_id = $_POST['municipio_id'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "festivales");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // --- Guardar imagen ---
    $foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $directorio = "../uploads/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = uniqid() . "_" . basename($_FILES["foto"]["name"]);
        $rutaArchivo = $directorio . $nombreArchivo;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaArchivo)) {
            $foto = "uploads/" . $nombreArchivo; // ruta relativa
        }
    }

    $sql = "INSERT INTO events (nombre, descripcion, municipio_id, fecha_inicio, fecha_fin, foto)
            VALUES ('$nombre', '$descripcion', '$municipio_id', '$fecha_inicio', '$fecha_fin', '$foto')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vista/registrar_evento.php?message=ok");
    } else {
        header("Location: ../vista/registrar_evento.php?message=error");
    }

    $conexion->close();
}
?>
