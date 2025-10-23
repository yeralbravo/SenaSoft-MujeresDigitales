<?php
$conexion = new mysqli("localhost", "root", "", "festivales");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>



<?php
include("../config/conexion.php");


if (isset($_GET['eliminar_usuario'])) {
    $id = $_GET['eliminar_usuario'];
    $conexion->query("DELETE FROM usuarios WHERE id = $id");
    header("Location: crud_completo.php");
    exit();
}

if (isset($_POST['editar_usuario'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];

    $conexion->query("UPDATE usuarios SET 
        nombre='$nombre', 
        apellidos='$apellidos', 
        email='$email',
        telefono='$telefono',
        rol='$rol'
        WHERE id=$id");

    header("Location: crud_completo.php");
    exit();
}

if (isset($_GET['eliminar_evento'])) {
    $id = $_GET['eliminar_evento'];
    $conexion->query("DELETE FROM events WHERE id = $id");
    header("Location: crud_completo.php");
    exit();
}

if (isset($_POST['editar_evento'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $conexion->query("UPDATE events SET 
        nombre='$nombre', 
        descripcion='$descripcion', 
        fecha_inicio='$fecha_inicio',
        fecha_fin='$fecha_fin'
        WHERE id=$id");

    header("Location: crud_completo.php");
    exit();
}

// Consultas
$usuarios = $conexion->query("SELECT * FROM usuarios");
$eventos = $conexion->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuarios y Eventos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        h2 { background-color: #007BFF; color: white; padding: 10px; border-radius: 5px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
        form { background-color: #f9f9f9; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 10px; }
        button { background-color: #007BFF; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        hr { margin: 40px 0; }
    </style>
</head>
<body>

    <h2>Usuarios</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $usuarios->fetch_assoc()) { ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['nombre'] ?></td>
                <td><?= $fila['apellidos'] ?></td>
                <td><?= $fila['email'] ?></td>
                <td><?= $fila['telefono'] ?></td>
                <td><?= $fila['rol'] ?></td>
                <td>
                    <a href="?editar_usuario=<?= $fila['id'] ?>">Editar</a> |
                    <a href="?eliminar_usuario=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php
    if (isset($_GET['editar_usuario'])) {
        $id = $_GET['editar_usuario'];
        $usuario = $conexion->query("SELECT * FROM usuarios WHERE id = $id")->fetch_assoc();
    ?>
        <h3>Editar Usuario</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>" required>

            <label>Apellidos:</label>
            <input type="text" name="apellidos" value="<?= $usuario['apellidos'] ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= $usuario['email'] ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?= $usuario['telefono'] ?>" required>

            <label>Rol:</label>
            <select name="rol">
                <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="usuario" <?= $usuario['rol'] == 'usuario' ? 'selected' : '' ?>>Usuario</option>
            </select>

            <button type="submit" name="editar_usuario">Guardar Cambios</button>
        </form>
    <?php } ?>

    <hr>

    <h2>Eventos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $eventos->fetch_assoc()) { ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['nombre'] ?></td>
                <td><?= $fila['descripcion'] ?></td>
                <td><?= $fila['fecha_inicio'] ?></td>
                <td><?= $fila['fecha_fin'] ?></td>
                <td>
                    <a href="?editar_evento=<?= $fila['id'] ?>">Editar</a> |
                    <a href="?eliminar_evento=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este evento?')">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php
    if (isset($_GET['editar_evento'])) {
        $id = $_GET['editar_evento'];
        $evento = $conexion->query("SELECT * FROM events WHERE id = $id")->fetch_assoc();
    ?>
        <h3>Editar Evento</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?= $evento['id'] ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= $evento['nombre'] ?>" required>

            <label>Descripción:</label>
            <textarea name="descripcion" required><?= $evento['descripcion'] ?></textarea>

            <label>Fecha Inicio:</label>
            <input type="datetime-local" name="fecha_inicio" value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha_inicio'])) ?>" required>

            <label>Fecha Fin:</label>
            <input type="datetime-local" name="fecha_fin" value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha_fin'])) ?>" required>

            <button type="submit" name="editar_evento">Guardar Cambios</button>
        </form>
    <?php } ?>

</body>
</html>
