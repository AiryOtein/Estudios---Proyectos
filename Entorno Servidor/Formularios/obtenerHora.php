<?php
date_default_timezone_set('UTC');
$zonaSeleccionada = isset($_POST['zona']) ? $_POST['zona'] : date_default_timezone_get();
$horaActual = null;
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tz = new DateTimeZone($zonaSeleccionada);
        $dt = new DateTime('now', $tz);
        $horaActual = $dt->format('d/m/Y H:i:s');
    } catch (Exception $e) {
        $mensaje = "Zona horaria no válida.";
    }
}

$zonas = DateTimeZone::listIdentifiers();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>/obtenerHora</title>
</head>
<body>
  <h1>/obtenerHora</h1>

  <form method="post" action="">
    <label>Selecciona zona horaria:<br>
      <select name="zona" style="width:460px;">
        <?php foreach ($zonas as $zona): ?>
          <option value="<?php echo htmlspecialchars($zona); ?>" <?php echo ($zona === $zonaSeleccionada) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($zona); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <br><br>
    <button type="submit">Obtener fecha y hora</button>
  </form>

  <?php if ($mensaje): ?>
    <p style="color:red;"><?php echo htmlspecialchars($mensaje); ?></p>
  <?php elseif ($horaActual): ?>
    <p><strong>Fecha y hora en <?php echo htmlspecialchars($zonaSeleccionada); ?>:</strong> <?php echo $horaActual; ?></p>
  <?php endif; ?>
</body>
</html>
