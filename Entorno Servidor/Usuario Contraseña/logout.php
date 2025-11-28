<?php
require 'db.php';
require 'helpers.php';
session_start();

if (!empty($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $token_hash = hashToken($token);

    $del = $mysqli->prepare("DELETE FROM remember_tokens WHERE token_hash = ?");
    $del->bind_param('s', $token_hash);
    $del->execute();
    $del->close();

    setcookie('remember_me', '', time() - 3600, '/', '', is_production(), true);
}

$_SESSION = [];
session_destroy();
header('Location: index.php');
exit;
?>
