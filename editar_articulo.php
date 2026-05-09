<?php
require_once "php/session.php";
require_once "php/conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$id = $_GET["id"] ?? "";

if (empty($id) || !is_numeric($id)) {
    header("Location: admin_articulos.php");
    exit();
}

$sql = "SELECT * FROM articulos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    header("Location: admin_articulos.php");
    exit();
}

$articulo = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar artículo</title>
    <link rel="stylesheet" href="css/admin_articulos.css">
</head>
<body>

<main class="admin-main">
    <h1>Editar artículo</h1>

    <form action="php/editar_articulo.php" method="POST" enctype="multipart/form-data" class="form-admin">

        <input type="hidden" name="id" value="<?php echo $articulo["id"]; ?>">
        <input type="hidden" name="imagen_actual" value="<?php echo $articulo["imagen"]; ?>">

        <div class="grupo-input">
            <label>Título</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($articulo["titulo"]); ?>" required>
        </div>

        <div class="grupo-input">
            <label>Categoría</label>
            <select name="categoria" required>
                <option value="ia" <?php if($articulo["categoria"]=="ia") echo "selected"; ?>>IA</option>
                <option value="hardware" <?php if($articulo["categoria"]=="hardware") echo "selected"; ?>>Hardware</option>
                <option value="software" <?php if($articulo["categoria"]=="software") echo "selected"; ?>>Software</option>
                <option value="tutoriales" <?php if($articulo["categoria"]=="tutoriales") echo "selected"; ?>>Tutoriales</option>
            </select>
        </div>

        <div class="grupo-input">
            <label>Resumen</label>
            <textarea name="resumen" required><?php echo htmlspecialchars($articulo["resumen"]); ?></textarea>
        </div>

        <div class="grupo-input">
            <label>Contenido</label>
            <textarea name="contenido" rows="8" required><?php echo htmlspecialchars($articulo["contenido"]); ?></textarea>
        </div>

        <div class="grupo-input">
            <label>Imagen actual</label><br>
            <img src="<?php echo $articulo["imagen"]; ?>" width="120">
        </div>

        <div class="grupo-input">
            <label>Cambiar imagen</label>
            <input type="file" name="imagen">
        </div>

        <button type="submit" class="btn-principal">Actualizar</button>
    </form>
</main>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>