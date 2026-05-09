<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

$id = $_GET["id"] ?? "";

if (empty($id)) {
    header("Location: ../admin_productos.php");
    exit();
}

/* Obtener imagen antes de borrar */
$sqlBuscar = "SELECT imagen FROM productos WHERE id = ?";
$stmtBuscar = $conn->prepare($sqlBuscar);
$stmtBuscar->bind_param("i", $id);
$stmtBuscar->execute();
$resultado = $stmtBuscar->get_result();

if ($resultado->num_rows === 1) {
    $producto = $resultado->fetch_assoc();
    $rutaImagen = "../" . $producto["imagen"];

    $sqlEliminar = "DELETE FROM productos WHERE id = ?";
    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bind_param("i", $id);

    if ($stmtEliminar->execute()) {
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
        echo "<script>alert('Producto eliminado correctamente.'); window.location.href='../admin_productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto.'); window.location.href='../admin_productos.php';</script>";
    }

    $stmtEliminar->close();
}

$stmtBuscar->close();
$conn->close();
?>