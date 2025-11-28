<?php
// Datos de conexión 
$conexion = new mysqli("localhost", "root", "", "empresa");

// Comprobar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recoger datos del formulario
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];

// Buscar el máximo id actual
$sql_max = "SELECT MAX(id) AS max_id FROM empleados";
$resultado = $conexion->query($sql_max);

if ($resultado && $fila = $resultado->fetch_assoc()) {
    $nuevo_id = $fila['max_id'] + 1;
} else {
    $nuevo_id = 1; // si no hay empleados aún
}

// Insertar el nuevo registro
$sql_insert = "INSERT INTO empleados (id, nombre, edad) VALUES ($nuevo_id, '$nombre', $edad)";

if ($conexion->query($sql_insert) === TRUE) {
    echo "<h3>Empleado añadido correctamente ✅</h3>";
    echo "<p>ID asignado: $nuevo_id</p>";
} else {
    echo "Error al insertar: " . $conexion->error;
}

$conexion->close();
?>
