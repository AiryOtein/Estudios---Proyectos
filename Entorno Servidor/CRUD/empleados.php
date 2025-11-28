<?php
require_once "db.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $sql = "SELECT id, nombre, apellidos FROM empleado";
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {

    $id = $_GET['id'];

    // 1. Datos del empleado
    $sql = "
        SELECT e.*, d.departamento,
               r.nombre AS resp_nombre, r.apellidos AS resp_apellidos
        FROM empleado e
        LEFT JOIN departamento d ON e.id_departamento = d.id
        LEFT JOIN empleado r ON e.id_responsable = r.id
        WHERE e.id = ?
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $emp = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$emp) {
        echo json_encode(["error" => "Empleado no encontrado"]);
        exit;
    }

    // 2. Skills
    $sqlSkills = "
        SELECT s.nombre 
        FROM empleado_skill es
        JOIN skill s ON es.id_skill = s.id
        WHERE es.id_empleado = ?
    ";

    $stmt = $pdo->prepare($sqlSkills);
    $stmt->execute([$id]);
    $skills = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. Salida
    $out = [
        "id" => $emp["id"],
        "nombre" => $emp["nombre"],
        "apellidos" => $emp["apellidos"],
        "edad" => $emp["edad"],
        "fecha_alta" => $emp["fecha_alta"],
        "activo" => (bool)$emp["activo"],
        "skills" => $skills,
        "departamento" => $emp["departamento"],
        "responsable" => $emp["resp_nombre"] ? $emp["resp_nombre"] . " " . $emp["resp_apellidos"] : null
    ];

    echo json_encode($out);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM empleado WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo json_encode(["mensaje" => "Empleado eliminado"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['id'])) {

    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "
        INSERT INTO empleado (nombre, apellidos, edad, fecha_alta, activo, id_departamento, id_responsable)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data["nombre"],
        $data["apellidos"],
        $data["edad"],
        $data["fecha_alta"],
        $data["activo"],
        $data["id_departamento"],
        $data["id_responsable"]
    ]);

    echo json_encode(["mensaje" => "Empleado creado", "id" => $pdo->lastInsertId()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {

    $id = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "
        UPDATE empleado
        SET nombre=?, apellidos=?, edad=?, fecha_alta=?, activo=?, id_departamento=?, id_responsable=?
        WHERE id=?
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data["nombre"],
        $data["apellidos"],
        $data["edad"],
        $data["fecha_alta"],
        $data["activo"],
        $data["id_departamento"],
        $data["id_responsable"],
        $id
    ]);

    echo json_encode(["mensaje" => "Empleado actualizado"]);
    exit;
}
echo json_encode(["error" => "Ruta o método no válido"]);
