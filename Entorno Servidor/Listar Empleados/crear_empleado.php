<?php
require_once 'empleados_data.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $puesto = trim($_POST['puesto']);

    if ($nombre !== "" && $puesto !== "") {
        // En un proyecto real se guardaría en BD,
        // aquí solo añadimos al array para simularlo
        $empleados[] = ["nombre" => $nombre, "puesto" => $puesto];
        $mensaje = "Empleado añadido correctamente";
    } else {
        $mensaje = "Rellena todos los campos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear empleado</title>
</head>
<body>
    <h1>Crear nuevo empleado</h1>

    <?php if ($mensaje): ?>
        <p><strong><?php echo $mensaje; ?></strong></p>
    <?php endif; ?>

    <form method="post" action="crear_empleado.php">
        <label>Nombre:</label><br>
        <input type="text" name="nombre"><br><br>

        <label>Puesto:</label><br>
        <input type="text" name="puesto"><br><br>

        <button type="submit">Guardar empleado</button>
    </form>

    <br>
    <a href="listar_empleados.php">Ver lista de empleados →</a>
</body>
</html>
