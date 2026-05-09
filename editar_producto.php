<?php
require_once "php/session.php";
require_once "php/conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$id = $_GET["id"] ?? "";

if (empty($id)) {
    header("Location: admin_productos.php");
    exit();
}

$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    header("Location: admin_productos.php");
    exit();
}

$producto = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto | TecnoMarket</title>
    <link rel="stylesheet" href="css/admin_productos.css">
</head>
<body>

<header class="header">
    <div class="logo">TecnoMarket Admin</div>

    <input type="text" placeholder="Buscar..." class="buscador">

    <div class="hamburguesa" onclick="toggleMenu()">☰</div>

    <nav class="menu" id="menu">
        <a href="index.php">Inicio</a>
        <a href="admin_productos.php">Admin productos</a>
        <a href="php/logout.php">Cerrar sesión</a>
    </nav>
</header>

<section class="hero-admin">
    <div class="hero-admin-texto">
        <h1>Editar producto</h1>
        <p>Actualiza la información del producto seleccionado.</p>
    </div>
</section>

<section class="contenedor-admin">
    <div class="form-box">
        <h2>Actualizar producto</h2>
        <form action="php/editar_producto.php" method="POST" class="form-admin" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $producto["id"]; ?>">
            <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($producto["imagen"]); ?>">

            <div class="grupo-input">
                <label for="nombre">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($producto["nombre"]); ?>" required>
            </div>

            <div class="grupo-input">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" required><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea>
            </div>

            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" name="precio" id="precio" value="<?php echo $producto["precio"]; ?>" required>
                </div>

                <div class="grupo-input">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" value="<?php echo $producto["stock"]; ?>" required>
                </div>
            </div>

            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="categoria">Categoría</label>
                    <input type="text" name="categoria" id="categoria" value="<?php echo htmlspecialchars($producto["categoria"]); ?>" required>
                </div>

                <div class="grupo-input">
                    <label for="imagen">Cambiar imagen</label>
                    <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.webp">
                </div>
            </div>

            <div class="preview-imagen-admin">
                <p>Imagen actual:</p>
                <img src="<?php echo htmlspecialchars($producto["imagen"]); ?>" alt="Imagen actual" class="imagen-editar-admin">
            </div>

            <button type="submit" class="btn-principal">Actualizar producto</button>
        </form>

        
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/admin_productos.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>