<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

$id = $_GET["id"] ?? "";

if (empty($id)) {
    header("Location: ../admin_usuarios.php");
    exit();
}

/* No permitir eliminarse a sí mismo */
if ($id == $_SESSION["usuario_id"]) {
    echo "<script>alert('No puedes eliminar tu propia cuenta desde aquí.'); window.location.href='../admin_usuarios.php';</script>";
    exit();
}

/* Validar si tiene pedidos asociados */
$sql_pedidos = "SELECT COUNT(*) AS total FROM pedidos WHERE usuario_id = ?";
$stmt_pedidos = $conn->prepare($sql_pedidos);
$stmt_pedidos->bind_param("i", $id);
$stmt_pedidos->execute();
$res_pedidos = $stmt_pedidos->get_result();
$fila_pedidos = $res_pedidos->fetch_assoc();

if ($fila_pedidos["total"] > 0) {
    echo "<script>alert('No se puede eliminar el usuario porque tiene pedidos registrados.'); window.location.href='../admin_usuarios.php';</script>";
    exit();
}

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Usuario eliminado correctamente.'); window.location.href='../admin_usuarios.php';</script>";
} else {
    echo "<script>alert('Error al eliminar el usuario.'); window.location.href='../admin_usuarios.php';</script>";
}

$stmt_pedidos->close();
$stmt->close();
$conn->close();
?>