<?php
$modo = isset($_POST['modo']) ? $_POST['modo'] : 'epoch2iso';
$entrada = isset($_POST['entrada']) ? trim($_POST['entrada']) : '';
$resultado = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($modo === 'epoch2iso') {
        if ($entrada === '' || !is_numeric($entrada)) {
            $error = "Introduce un número (segundos desde 1970).";
        } else {
            $epoch = (int)$entrada;
            $dt = new DateTime('@' . $epoch);
            $dt->setTimezone(new DateTimeZone('UTC'));
            $resultado = $dt->format('Y-m-d H:i:s') . " UTC";
        }
    } else {
        if ($entrada === '') {
            $error = "Introduce una fecha/hora válida.";
        } else {
            try {
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $entrada)) {
                    $entradaIso = $entrada . ' 00:00:00';
                } else {
                    $entradaIso = $entrada;
                }
                $dt = new DateTime($entradaIso, new DateTimeZone('UTC'));
                $resultado = $dt->getTimestamp();
            } catch (Exception $e) {
                $error = "Formato de fecha no válido. Usa YYYY-MM-DD o YYYY-MM-DD HH:MM:SS";
            }
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>/epochAtimestamp</title>
</head>
<body>
  <h1>/epochAtimestamp</h1>

  <form method="post" action="">
    <label>
      <input type="radio" name="modo" value="epoch2iso" <?php echo ($modo==='epoch2iso') ? 'checked' : ''; ?>>
      Epoch → Fecha y hora UTC
    </label><br>
    <label>
      <input type="radio" name="modo" value="iso2epoch" <?php echo ($modo==='iso2epoch') ? 'checked' : ''; ?>>
      Fecha/hora UTC → Epoch
    </label>
    <br><br>

    <label>Entrada:<br>
      <input type="text" name="entrada" value="<?php echo htmlspecialchars($entrada); ?>" style="width:420px;">
    </label>
    <br><small>
      Ejemplo epoch: <code>1633024800</code><br>
      Ejemplo fecha: <code>2021-10-01 12:34:56</code>
    </small>
    <br><br>
    <button type="submit">Convertir</button>
  </form>

  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php elseif ($resultado !== ''): ?>
    <p><strong>Resultado:</strong> <?php echo htmlspecialchars($resultado); ?></p>
  <?php endif; ?>
</body>
</html>
