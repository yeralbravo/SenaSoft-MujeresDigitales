<?php
require_once "../config/conexion.php";

if (isset($_GET['buscar'])) {
    $fecha = $_GET['fecha'] ?? null;
    $municipio = $_GET['municipio'] ?? null;
    $departamento = $_GET['departamento'] ?? null;

    $query = "SELECT e.nombre, e.descripcion, e.municipio_id, e.fecha_inicio, e.fecha_fin
              FROM events e
              INNER JOIN municipios m ON e.municipio_id = m.id
              INNER JOIN departamentos d ON m.departamento_id = d.id
              WHERE 1=1";

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

    $result = $conexion->query($query);
    $eventos = [];

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

