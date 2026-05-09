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

$id = trim($_POST["id"] ?? "");
$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$precio = trim($_POST["precio"] ?? "");
$categoria = trim($_POST["categoria"] ?? "");
$stock = trim($_POST["stock"] ?? "");
$imagenActual = trim($_POST["imagen_actual"] ?? "");

if (empty($id) || empty($nombre) || empty($descripcion) || empty($precio) || empty($categoria) || $stock === "") {
    echo "<script>alert('Completa todos los campos.'); window.location.href='../admin_productos.php';</script>";
    exit();
}

$rutaBD = $imagenActual;

/* Si subió nueva imagen */
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
    $archivo = $_FILES["imagen"];
    $nombreOriginal = $archivo["name"];
    $tmpNombre = $archivo["tmp_name"];
    $tamano = $archivo["size"];

    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
    $extensionesPermitidas = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($extension, $extensionesPermitidas)) {
        echo "<script>alert('Solo se permiten imágenes JPG, JPEG, PNG o WEBP.'); window.location.href='../admin_productos.php';</script>";
        exit();
    }

    if ($tamano > 5 * 1024 * 1024) {
        echo "<script>alert('La imagen no debe superar los 5MB.'); window.location.href='../admin_productos.php';</script>";
        exit();
    }

    $nombreNuevo = uniqid("prod_", true) . "." . $extension;
    $rutaServidor = "../img/productos/" . $nombreNuevo;
    $rutaBD = "img/productos/" . $nombreNuevo;

    if (!move_uploaded_file($tmpNombre, $rutaServidor)) {
        echo "<script>alert('No se pudo guardar la nueva imagen.'); window.location.href='../admin_productos.php';</script>";
        exit();
    }

    /* Eliminar imagen anterior si existe */
    if (!empty($imagenActual)) {
        $rutaAnteriorServidor = "../" . $imagenActual;
        if (file_exists($rutaAnteriorServidor)) {
            unlink($rutaAnteriorServidor);
        }
    }
}

$sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria=?, imagen=?, stock=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdssii", $nombre, $descripcion, $precio, $categoria, $rutaBD, $stock, $id);

if ($stmt->execute()) {
    echo "<script>alert('Producto actualizado correctamente.'); window.location.href='../admin_productos.php';</script>";
} else {
    echo "<script>alert('Error al actualizar el producto.'); window.location.href='../admin_productos.php';</script>";
}

$stmt->close();
$conn->close();
?>