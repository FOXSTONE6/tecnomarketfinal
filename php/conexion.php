<?php

$host = "fdb1034.awardspace.net";
$usuario = "4757646_tecnomarket";
$contrasena = "WxnU%a*T0YZ}qEw6";
$base_datos = "4757646_tecnomarket";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>