<?php

function genToken($bytes = 16) {
    return bin2hex(random_bytes($bytes));
}
function hashToken($token) {
    return hash('sha256', $token);
}

define('REMEMBER_DAYS', 90);
?>

