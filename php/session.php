<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_logueado = false;
$nombre_usuario = "";
$rol_usuario = "";

if (isset($_SESSION["usuario_id"])) {
    $usuario_logueado = true;
    $nombre_usuario = $_SESSION["nombres"] ?? "";
    $rol_usuario = $_SESSION["rol"] ?? "";
}
?>