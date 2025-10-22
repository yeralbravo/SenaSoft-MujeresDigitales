<?php
require_once "../conexion.php";

if (isset($_GET['buscar'])) {
    $fecha = $_GET['fecha'] ?? null;
    $municipio = $_GET['municipio_id'] ?? null;
    $departamento = $_GET['departamento_id'] ?? null;

    $query = "SELECT e.id, e.nombre, e.descripcion, e.fecha_inicio, e.fecha_fin
              FROM events e
              INNER JOIN municipios m ON e.municipio_id = m.id
              INNER JOIN departamentos d ON m.departamento_id = d.id
              WHERE 1=1";

    if (!empty($fecha)) $query .= " AND DATE(e.fecha_inicio) = '$fecha'";
    if (!empty($municipio)) $query .= " AND e.municipio_id = $municipio";
    if (!empty($departamento)) $query .= " AND d.id = $departamento";

    $result = $conexion->query($query);
    $eventos = [];

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
