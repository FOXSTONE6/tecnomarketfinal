<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin_productos.php");
    exit();
}

$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$precio = trim($_POST["precio"] ?? "");
$categoria = trim($_POST["categoria"] ?? "");
$stock = trim($_POST["stock"] ?? "");

if (empty($nombre) || empty($descripcion) || empty($precio) || empty($categoria) || $stock === "") {
    echo "<script>alert('Completa todos los campos.'); window.location.href='../admin_productos.php';</script>";
    exit();
}

if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] !== 0) {
    echo "<script>alert('Debes seleccionar una imagen válida.'); window.location.href='../admin_productos.php';</script>";
    exit();
}

$archivo = $_FILES["imagen"];
$nombreOriginal = $archivo["name"];
$tmp = $archivo["tmp_name"];
$tamano = $archivo["size"];

$extensionesPermitidas = ["jpg", "jpeg", "png", "webp"];
$extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

if (!in_array($extension, $extensionesPermitidas)) {
    echo "<script>alert('Formato de imagen no permitido. Usa JPG, JPEG, PNG o WEBP.'); window.location.href='../admin_productos.php';</script>";
    exit();
}

if ($tamano > 2 * 1024 * 1024) {
    echo "<script>alert('La imagen no debe superar los 2MB.'); window.location.href='../admin_productos.php';</script>";
    exit();
}

$nuevoNombre = "producto_" . time() . "_" . uniqid() . "." . $extension;
$rutaFisica = "../img/productos/" . $nuevoNombre;
$rutaBD = "img/productos/" . $nuevoNombre;

if (!move_uploaded_file($tmp, $rutaFisica)) {
    echo "<script>alert('No se pudo guardar la imagen en el servidor.'); window.location.href='../admin_productos.php';</script>";
    exit();
}

$sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $categoria, $rutaBD, $stock);

if ($stmt->execute()) {
    echo "<script>alert('Producto registrado correctamente.'); window.location.href='../admin_productos.php';</script>";
} else {
    if (file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }
    echo "<script>alert('Error al registrar el producto.'); window.location.href='../admin_productos.php';</script>";
}

$stmt->close();
$conn->close();
?>