<?php
require_once 'empleados_data.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de empleados</title>
</head>
<body>
    <h1>Listado de empleados</h1>

    <table border="1" cellpadding="8">
        <tr>
            <th>Nombre</th>
            <th>Puesto</th>
        </tr>

        <?php foreach ($empleados as $emp): ?>
        <tr>
            <td><?php echo $emp['nombre']; ?></td>
            <td><?php echo $emp['puesto']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <button onclick="window.location.href='crear_empleado.php'">
        ← Volver a Crear Empleado
    </button>
</body>
</html>
