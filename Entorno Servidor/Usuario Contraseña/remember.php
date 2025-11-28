<?php
require 'db.php';
require 'helpers.php';
session_start();

$currentUser = null;

if (empty($_SESSION['user_id']) && !empty($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $token_hash = hashToken($token);
    $stmt = $mysqli->prepare("
        SELECT rt.user_id, rt.expires_at, rt.last_used_at, u.username
        FROM remember_tokens rt
        JOIN users u ON rt.user_id = u.id
        WHERE rt.token_hash = ?
        LIMIT 1
    ");
    $stmt->bind_param('s', $token_hash);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row) {
        $now = new DateTime();
        $expires = new DateTime($row['expires_at']);
        if ($expires >= $now) {
            $_SESSION['user_id'] = $row['user_id'];
            $nowStr = $now->format('Y-m-d H:i:s');
            $upd = $mysqli->prepare("UPDATE remember_tokens SET last_used_at = ? WHERE token_hash = ?");
            $upd->bind_param('ss', $nowStr, $token_hash);
            $upd->execute();
            $upd->close();


            $currentUser = [
                'username' => $row['username'],
                'last_visit' => $row['last_used_at'] ?? $row['created_at']
            ];
        } else {
            $del = $mysqli->prepare("DELETE FROM remember_tokens WHERE token_hash = ?");
            $del->bind_param('s', $token_hash);
            $del->execute();
            $del->close();
            setcookie('remember_me', '', time() - 3600, '/', '', is_production(), true);
        }
    } else {
        setcookie('remember_me', '', time() - 3600, '/', '', is_production(), true);
    }
} elseif (!empty($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $s = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
    $s->bind_param('i', $uid);
    $s->execute();
    $r = $s->get_result()->fetch_assoc();
    $s->close();
    if ($r) {
        $currentUser = [
            'username' => $r['username'],
        
        ];
    }
}
?>
