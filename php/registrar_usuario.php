<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../registro.php");
    exit();
}

$nombres = trim($_POST["nombres"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$password = trim($_POST["password"] ?? "");
$confirmarPassword = trim($_POST["confirmarPassword"] ?? "");

if (
    empty($nombres) || empty($apellidos) || empty($correo) ||
    empty($telefono) || empty($password) || empty($confirmarPassword)
) {
    echo "<script>alert('Completa todos los campos.'); window.location.href='../registro';</script>";
    exit();
}

if ($password !== $confirmarPassword) {
    echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='../registro';</script>";
    exit();
}

if (strlen($password) < 6) {
    echo "<script>alert('La contraseña debe tener al menos 6 caracteres.'); window.location.href='../registro';</script>";
    exit();
}

$sql_verificar = "SELECT id FROM usuarios WHERE correo = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("s", $correo);
$stmt_verificar->execute();
$resultado = $stmt_verificar->get_result();

if ($resultado->num_rows > 0) {
    echo "<script>alert('Ya existe una cuenta con ese correo.'); window.location.href='../registro';</script>";
    exit();
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql_insertar = "INSERT INTO usuarios (nombres, apellidos, correo, telefono, password, rol) VALUES (?, ?, ?, ?, ?, 'cliente')";
$stmt_insertar = $conn->prepare($sql_insertar);
$stmt_insertar->bind_param("sssss", $nombres, $apellidos, $correo, $telefono, $passwordHash);

if ($stmt_insertar->execute()) {
    echo "<script>alert('Cuenta creada correctamente. Ahora inicia sesión.'); window.location.href='../login';</script>";
} else {
    echo "<script>alert('Error al registrar el usuario.'); window.location.href='../registro';</script>";
}

$stmt_verificar->close();
$stmt_insertar->close();
$conn->close();
?>