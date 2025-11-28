<?php
session_start();

if (isset($_POST['username'])) {
    setcookie('simon_user', $_POST['username'], time() + 31536000);
    $_COOKIE['simon_user'] = $_POST['username'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['highscore'])) {
    $newScore = intval($_POST['highscore']);
    $oldScore = isset($_COOKIE['simon_highscore']) ? intval($_COOKIE['simon_highscore']) : 0;
    if ($newScore > $oldScore) {
        setcookie('simon_highscore', $newScore, time() + 31536000);
        $_COOKIE['simon_highscore'] = $newScore;
    }
    echo 'ok';
    exit;
}

$user = isset($_COOKIE['simon_user']) ? $_COOKIE['simon_user'] : '';
$highscore = isset($_COOKIE['simon_highscore']) ? $_COOKIE['simon_highscore'] : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simón dice</title>
    <link rel="stylesheet" href="coloreh.css">
</head>
<body>
<?php if (!$user): ?>
    <form method="POST" style="color:white;">
        Nombre: <input type="text" name="username" required>
        <button type="submit">Jugar</button>
    </form>
<?php else: ?>
    <div id="game">
        <div class="cell" pos="1"></div>
        <div class="cell" pos="2"></div>
        <div class="cell" pos="3"></div>
        <div class="cell" pos="4"></div>
    </div>
    <div id="bottom">
        <div id="message"></div>
        <button id="start">Start</button>
        <div style="margin-top:1rem;color:white;">
            Jugador: <?php echo htmlspecialchars($user); ?> | Highscore: <span id="highscore"><?php echo $highscore; ?></span>
        </div>
    </div>
    <script src="movimientos.js"></script>
<?php endif; ?>
</body>
</html>
