<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../perfil.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];
$nombres = trim($_POST["nombres"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$password = trim($_POST["password"] ?? "");
$confirmarPassword = trim($_POST["confirmarPassword"] ?? "");

if (empty($nombres) || empty($apellidos) || empty($correo) || empty($telefono)) {
    echo "<script>alert('Completa todos los campos obligatorios.'); window.location.href='../editar_perfil.php';</script>";
    exit();
}

/* Verificar si el correo ya existe en otro usuario */
$sql_verificar = "SELECT id FROM usuarios WHERE correo = ? AND id != ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("si", $correo, $usuario_id);
$stmt_verificar->execute();
$resultado_verificar = $stmt_verificar->get_result();

if ($resultado_verificar->num_rows > 0) {
    echo "<script>alert('Ese correo ya está registrado en otra cuenta.'); window.location.href='../editar_perfil.php';</script>";
    exit();
}

/* Si quiere cambiar contraseña */
if (!empty($password) || !empty($confirmarPassword)) {
    if ($password !== $confirmarPassword) {
        echo "<script>alert('Las nuevas contraseñas no coinciden.'); window.location.href='../editar_perfil.php';</script>";
        exit();
    }

    if (strlen($password) < 6) {
        echo "<script>alert('La nueva contraseña debe tener al menos 6 caracteres.'); window.location.href='../editar_perfil.php';</script>";
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET nombres=?, apellidos=?, correo=?, telefono=?, password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombres, $apellidos, $correo, $telefono, $passwordHash, $usuario_id);
} else {
    $sql = "UPDATE usuarios SET nombres=?, apellidos=?, correo=?, telefono=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombres, $apellidos, $correo, $telefono, $usuario_id);
}

if ($stmt->execute()) {
    $_SESSION["nombres"] = $nombres;
    $_SESSION["apellidos"] = $apellidos;
    $_SESSION["correo"] = $correo;

    echo "<script>alert('Perfil actualizado correctamente.'); window.location.href='../perfil.php';</script>";
} else {
    echo "<script>alert('Ocurrió un error al actualizar el perfil.'); window.location.href='../editar_perfil.php';</script>";
}

$stmt_verificar->close();
$stmt->close();
$conn->close();
?>