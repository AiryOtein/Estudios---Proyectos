<?php
$resultado = "";
$frase = "";
$palabra = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = isset($_POST['frase']) ? trim($_POST['frase']) : '';
    $palabra = isset($_POST['palabra']) ? trim($_POST['palabra']) : '';

    if ($frase === '' || $palabra === '') {
        $resultado = "Rellena ambos campos.";
    } else {
        // stripos = busca una palabra sin importar mayúsculas o minúsculas
        if (stripos($frase, $palabra) !== false) {
            $resultado = "Contiene la palabra '" . htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8') . "'.";
        } else {
            $resultado = "No contiene la palabra '" . htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8') . "'.";
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>/comprobarSiContiene</title>
</head>
<body>
  <h1>/comprobarSiContiene</h1>

  <form method="post" action="">
    <label>Frase:<br>
      <input type="text" name="frase" value="<?php echo htmlspecialchars($frase, ENT_QUOTES, 'UTF-8'); ?>" style="width:420px;">
    </label><br><br>

    <label>Palabra a buscar:<br>
      <input type="text" name="palabra" value="<?php echo htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8'); ?>">
    </label><br><br>

    <button type="submit">Comprobar</button>
  </form>

  <?php if ($resultado !== ""): ?>
    <p><strong>Resultado:</strong> <?php echo $resultado; ?></p>
  <?php endif; ?>
</body>
</html>
