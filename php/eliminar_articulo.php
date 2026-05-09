<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

$id = $_GET["id"] ?? "";

if (empty($id)) {
    header("Location: ../admin_articulos.php");
    exit();
}

/* Obtener imagen */
$sql = "SELECT imagen FROM articulos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$articulo = $res->fetch_assoc();

/* borrar imagen */
if ($articulo && file_exists("../" . $articulo["imagen"])) {
    unlink("../" . $articulo["imagen"]);
}

/* borrar registro */
$sql2 = "DELETE FROM articulos WHERE id = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $id);

if ($stmt2->execute()) {
    header("Location: ../admin_articulos.php");
} else {
    echo "Error al eliminar";
}

$stmt->close();
$stmt2->close();
$conn->close();
?>