<?php
require 'db.php';
require 'helpers.php';
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

if (!$username || !$password) {
    header('Location: login_form.html?error=missing');
    exit;
}

$stmt = $mysqli->prepare("SELECT id, password_hash FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: login_form.html?error=credentials');
    exit;
}
$_SESSION['user_id'] = $user['id'];


if ($remember) {
    $token = genToken();               
    $token_hash = hashToken($token); 
    $now = date('Y-m-d H:i:s');
    $expires = date('Y-m-d H:i:s', time() + 60*60*24*REMEMBER_DAYS);

    $ins = $mysqli->prepare("INSERT INTO remember_tokens (user_id, token_hash, created_at, expires_at) VALUES (?, ?, ?, ?)");
    $ins->bind_param('isss', $user['id'], $token_hash, $now, $expires);
    $ins->execute();
    $ins->close();

    $cookie_expire = time() + 60*60*24*REMEMBER_DAYS;
    setcookie('remember_me', $token, $cookie_expire, '/', '', is_production(), true); // httponly = true
}
header('Location: index.php');
exit;
?>
