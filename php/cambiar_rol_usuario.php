<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

$id = $_GET["id"] ?? "";
$rolActual = $_GET["rol"] ?? "";

if (empty($id) || empty($rolActual)) {
    header("Location: ../admin_usuarios.php");
    exit();
}

/* No permitir cambiarse el rol a sí mismo */
if ($id == $_SESSION["usuario_id"]) {
    echo "<script>alert('No puedes cambiar tu propio rol desde aquí.'); window.location.href='../admin_usuarios.php';</script>";
    exit();
}

$nuevoRol = ($rolActual === "admin") ? "cliente" : "admin";

$sql = "UPDATE usuarios SET rol = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nuevoRol, $id);

if ($stmt->execute()) {
    echo "<script>alert('Rol actualizado correctamente.'); window.location.href='../admin_usuarios.php';</script>";
} else {
    echo "<script>alert('Error al actualizar el rol.'); window.location.href='../admin_usuarios.php';</script>";
}

$stmt->close();
$conn->close();
?>