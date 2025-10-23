<?php
session_start();
require_once "../config/conexion.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../vista/login.php?error=" . urlencode("Debes iniciar sesión primero."));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../vista/compra.php?message=error");
    exit();
}

$usuario_id = $_SESSION['id'];
$numero_documento = isset($_POST['numero_documento']) ? trim($_POST['numero_documento']) : '';
$evento_id = intval($_POST['evento_id'] ?? 0);
$localidad_id = intval($_POST['localidad_id'] ?? 0);
$ticket_id = intval($_POST['ticket_id'] ?? 0);
$cantidad = intval($_POST['cantidad'] ?? 0);
$metodo_pago = trim($_POST['metodo_pago'] ?? '');
$precio_unitario = floatval($_POST['precio'] ?? 0.0);

// datos para redirección en caso de fallo
$redir = "../vista/compra.php?evento_id={$evento_id}&localidad_id={$localidad_id}&ticket_id={$ticket_id}";

if ($usuario_id <= 0 || $evento_id <= 0 || $localidad_id <= 0 || $ticket_id <= 0 || $cantidad <= 0 || $numero_documento === '' || $metodo_pago === '') {
    header("Location: {$redir}&message=error");
    exit();
}

try {
    $checkStmt = $conexion->prepare("SELECT precio, cantidad FROM tickets WHERE id = ?");
    if (!$checkStmt) {
        throw new Exception("Prepare check failed: " . $conexion->error);
    }
    $checkStmt->bind_param("i", $ticket_id);
    $checkStmt->execute();
    $res = $checkStmt->get_result();
    if (!$res || $res->num_rows === 0) {
        throw new Exception("Ticket no encontrado.");
    }
    $ticket = $res->fetch_assoc();
    $disponible = intval($ticket['cantidad']);
    $precio_unitario_bd = floatval($ticket['precio']);

    $precio_unitario = $precio_unitario_bd;

    if ($disponible < $cantidad) {
        header("Location: {$redir}&message=error");
        exit();
    }

    $valor_total = $precio_unitario * $cantidad;

    $conexion->begin_transaction();

    
    $insertSql = "INSERT INTO compras (usuario_id, numero_documento, evento_id, localidad_id, cantidad, valor_total, metodo_pago, estado)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $estado = 'exitosa';
    $insertStmt = $conexion->prepare($insertSql);
    if (!$insertStmt) {
        throw new Exception("Prepare insert failed: " . $conexion->error);
    }
    $insertStmt->bind_param("isiiidss", $usuario_id, $numero_documento, $evento_id, $localidad_id, $cantidad, $valor_total, $metodo_pago, $estado);

    if (!$insertStmt->execute()) {
        throw new Exception("Error al insertar compra: " . $insertStmt->error);
    }

    
    $updateSql = "UPDATE tickets SET cantidad = cantidad - ? WHERE id = ? AND cantidad >= ?";
    $updateStmt = $conexion->prepare($updateSql);
    if (!$updateStmt) {
        throw new Exception("Prepare update failed: " . $conexion->error);
    }
    $updateStmt->bind_param("iii", $cantidad, $ticket_id, $cantidad);
    if (!$updateStmt->execute()) {
        throw new Exception("Error al actualizar tickets: " . $updateStmt->error);
    }
    if ($updateStmt->affected_rows === 0) {
        throw new Exception("No se pudo descontar el stock (quizá no hay suficientes boletas).");
    }

    $conexion->commit();

    header("Location: {$redir}&message=ok");
    exit();

} catch (Exception $e) {
    if ($conexion->$in_transaction) {
        $conexion->rollback();
    }
    
    header("Location: {$redir}&message=error");
    exit();
}
