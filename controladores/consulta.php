<?php
<<<<<<< HEAD
require_once "../config/conexion.php";

if (isset($_GET['buscar'])) {
    $fecha = $_GET['fecha'] ?? null;
    $municipio = $_GET['municipio'] ?? null;
    $departamento = $_GET['departamento'] ?? null;

    $query = "SELECT e.nombre, e.descripcion, e.municipio_id, e.fecha_inicio, e.fecha_fin
=======
require_once "../conexion.php";

if (isset($_GET['buscar'])) {
    $fecha = $_GET['fecha'] ?? null;
    $municipio = $_GET['municipio_id'] ?? null;
    $departamento = $_GET['departamento_id'] ?? null;

    $query = "SELECT e.id, e.nombre, e.descripcion, e.fecha_inicio, e.fecha_fin
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
              FROM events e
              INNER JOIN municipios m ON e.municipio_id = m.id
              INNER JOIN departamentos d ON m.departamento_id = d.id
              WHERE 1=1";

<<<<<<< HEAD
    if (!empty($fecha)) {
        $fecha = $conexion->real_escape_string($fecha);
        $query .= " AND DATE(e.fecha_inicio) = '$fecha'";
    }
    if (!empty($municipio)) {
        $municipio = $conexion->real_escape_string($municipio);
        $query .= " AND m.nombre LIKE '%$municipio%'";
    }
    if (!empty($departamento)) {
        $departamento = $conexion->real_escape_string($departamento);
        $query .= " AND d.nombre LIKE '%$departamento%'";
    }
=======
    if (!empty($fecha)) $query .= " AND DATE(e.fecha_inicio) = '$fecha'";
    if (!empty($municipio)) $query .= " AND e.municipio_id = $municipio";
    if (!empty($departamento)) $query .= " AND d.id = $departamento";
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e

    $result = $conexion->query($query);
    $eventos = [];

<<<<<<< HEAD
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }

        $data = json_encode($eventos);
        header("Location: ../vista/consultar_eventos.php?message=ok&resultados=" . urlencode($data));
        exit();
    } else {
        header("Location: ../vista/consultar_eventos.php?message=vacio");
        exit();
    }
} else {
    header("Location: ../vista/consultar_eventos.php?message=Escribe un criterio para buscar");
    exit();
}

=======
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }
        $data = json_encode($eventos);
        header("Location: ../vista/consultar_eventos.php?message=ok&resultados=" . urlencode($data));
    } else {
        header("Location: ../vista/consultar_eventos.php?message=vacio");
    }
    exit();
}
?>
>>>>>>> 77743fd8e293407eb2c967ab9e351ce092dc4c7e
