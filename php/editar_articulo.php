<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

$id = $_POST["id"];
$titulo = $_POST["titulo"];
$resumen = $_POST["resumen"];
$contenido = $_POST["contenido"];
$categoria = $_POST["categoria"];
$imagenActual = $_POST["imagen_actual"];

$rutaBD = $imagenActual;

/* Si sube nueva imagen */
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {

    $archivo = $_FILES["imagen"];
    $nombreOriginal = $archivo["name"];
    $tmp = $archivo["tmp_name"];

    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

    $nuevoNombre = "articulo_" . time() . "." . $extension;
    $rutaFisica = "../img/articulos/" . $nuevoNombre;
    $rutaBDNueva = "img/articulos/" . $nuevoNombre;

    if (!move_uploaded_file($tmp, $rutaFisica)) {
        die("Error al subir imagen");
    }

    /* borrar imagen anterior */
    if (!empty($imagenActual) && file_exists("../" . $imagenActual)) {
        unlink("../" . $imagenActual);
    }

    $rutaBD = $rutaBDNueva;
}

$sql = "UPDATE articulos 
        SET titulo=?, resumen=?, contenido=?, categoria=?, imagen=? 
        WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $titulo, $resumen, $contenido, $categoria, $rutaBD, $id);

if ($stmt->execute()) {
    header("Location: ../admin_articulos.php");
} else {
    echo "Error al actualizar";
}

$stmt->close();
$conn->close();
?>