<?php
require 'remember_middleware.php';
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Mi web</title></head>
<body>
  <header>
    <?php if (!empty($currentUser)): ?>
      <a href="logout.php">Salir</a>
      <span>
        Bienvenida, <?php echo htmlspecialchars($currentUser['username']); ?>.
        <?php if (!empty($currentUser['last_visit'])): ?>
          Última visita: <?php echo htmlspecialchars($currentUser['last_visit']); ?>
        <?php endif; ?>
      </span>
    <?php else: ?>
      <a href="login_form.html">Entrar</a>
    <?php endif; ?>
  </header>

  <main>
    <h1>Página principal</h1>
    <p>Contenido público.</p>
  </main>
</body>
</html>
