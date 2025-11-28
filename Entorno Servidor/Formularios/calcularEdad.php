<?php
$dia = isset($_POST['dia']) ? (int)$_POST['dia'] : 0;
$mes = isset($_POST['mes']) ? (int)$_POST['mes'] : 0;
$anio = isset($_POST['anio']) ? (int)$_POST['anio'] : 0;
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($dia < 1 || $dia > 31 || $mes < 1 || $mes > 12 || $anio < 1900) {
        $mensaje = "Selecciona una fecha válida.";
    } else {
        if (!checkdate($mes, $dia, $anio)) {
            $mensaje = "La fecha seleccionada no es válida.";
        } else {
            $fechaNacimiento = DateTime::createFromFormat('Y-n-j', "$anio-$mes-$dia");
            $hoy = new DateTime();
            $diff = $hoy->diff($fechaNacimiento);
            $edad = $diff->y;
            $mensaje = "Tienes $edad años.";
        }
    }
}

$anioActual = (int)date('Y');
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>/calcularEdad</title>
</head>
<body>
  <h1>/calcularEdad</h1>

  <form method="post" action="">
    <label>Día:
      <select name="dia">
        <option value="0">--</option>
        <?php for ($d = 1; $d <= 31; $d++): ?>
          <option value="<?php echo $d; ?>" <?php echo ($d === $dia) ? 'selected' : ''; ?>><?php echo $d; ?></option>
        <?php endfor; ?>
      </select>
    </label>

    <label>Mes:
      <select name="mes">
        <option value="0">--</option>
        <?php for ($m = 1; $m <= 12; $m++): ?>
          <option value="<?php echo $m; ?>" <?php echo ($m === $mes) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endfor; ?>
      </select>
    </label>

    <label>Año:
      <select name="anio">
        <option value="0">--</option>
        <?php for ($a = $anioActual; $a >= 1900; $a--): ?>
          <option value="<?php echo $a; ?>" <?php echo ($a === $anio) ? 'selected' : ''; ?>><?php echo $a; ?></option>
        <?php endfor; ?>
      </select>
    </label>

    <br><br>
    <button type="submit">Calcular edad</button>
  </form>

  <?php if ($mensaje !== ''): ?>
    <p><strong>Resultado:</strong> <?php echo htmlspecialchars($mensaje); ?></p>
  <?php endif; ?>
</body>
</html>
