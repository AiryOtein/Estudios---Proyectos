<?php
$DB_HOST = 'localhost';
$DB_USER = 'usuario';
$DB_PASS = 'contraseña';
$DB_NAME = 'app';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("Error conexión DB: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>
