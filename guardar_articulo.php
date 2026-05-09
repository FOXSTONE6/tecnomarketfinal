<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../admin_articulos.php");
    exit();
}

$titulo = trim($_POST["titulo"] ?? "");
$resumen = trim($_POST["resumen"] ?? "");
$contenido = trim($_POST["contenido"] ?? "");
$categoria = trim($_POST["categoria"] ?? "");

if (empty($titulo) || empty($resumen) || empty($contenido) || empty($categoria)) {
    echo "<script>alert('Completa todos los campos.'); window.location.href='../admin_articulos.php';</script>";
    exit();
}

if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] !== 0) {
    echo "<script>alert('Debes seleccionar una imagen válida.'); window.location.href='../admin_articulos.php';</script>";
    exit();
}

$archivo = $_FILES["imagen"];
$nombreOriginal = $archivo["name"];
$tmp = $archivo["tmp_name"];
$tamano = $archivo["size"];

$extensionesPermitidas = ["jpg", "jpeg", "png", "webp"];
$extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

if (!in_array($extension, $extensionesPermitidas)) {
    echo "<script>alert('Formato no permitido.'); window.location.href='../admin_articulos.php';</script>";
    exit();
}

if ($tamano > 2 * 1024 * 1024) {
    echo "<script>alert('La imagen no debe superar 2MB.'); window.location.href='../admin_articulos.php';</script>";
    exit();
}

if (!is_dir("../img/articulos")) {
    mkdir("../img/articulos", 0777, true);
}

$nuevoNombre = "articulo_" . time() . "_" . uniqid() . "." . $extension;
$rutaFisica = "../img/articulos/" . $nuevoNombre;
$rutaBD = "img/articulos/" . $nuevoNombre;

if (!move_uploaded_file($tmp, $rutaFisica)) {
    echo "<script>alert('No se pudo guardar la imagen.'); window.location.href='../admin_articulos.php';</script>";
    exit();
}

$sql = "INSERT INTO articulos (titulo, resumen, contenido, categoria, imagen) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $titulo, $resumen, $contenido, $categoria, $rutaBD);

if ($stmt->execute()) {
    echo "<script>alert('Artículo guardado correctamente.'); window.location.href='../admin_articulos.php';</script>";
} else {
    if (file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }
    echo "<script>alert('Error al guardar el artículo.'); window.location.href='../admin_articulos.php';</script>";
}

$stmt->close();
$conn->close();
?>