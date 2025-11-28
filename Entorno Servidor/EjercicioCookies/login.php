<?php
// login_cookie_min.php

$TTL = 120; // 2 minutos

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['usuario'])) {
    $usuario = trim($_POST['usuario']);
    if ($usuario !== '') {
        setcookie('usuario', $usuario, time() + $TTL, '/');
        setcookie('logged_once', '', time() - 3600, '/'); // limpiar aviso antiguo
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Detectar expiración
if (!isset($_COOKIE['usuario']) && isset($_COOKIE['logged_once'])) {
    // Cookie de usuario ya caducó, mostramos aviso
    $mensaje = "Se ha cerrado la sesión";
    setcookie('logged_once', '', time() - 3600, '/'); // limpiar aviso tras mostrarlo
} elseif (isset($_COOKIE['usuario'])) {
    $mensaje = "Sesión iniciada";
} else {
    $mensaje = '';
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Login</title>
</head>
<body>
<?php if ($mensaje): ?>
    <div><?= $mensaje ?></div>
<?php elseif (!isset($_COOKIE['usuario'])): ?>
    <form method="post" action="">
      <input type="text" name="usuario" placeholder="Tu nombre" required autofocus>
      <input type="submit" value="Entrar">
    </form>
<?php endif; ?>
</body>
</html>
