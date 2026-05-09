<?php
require_once "php/session.php";
require_once "php/conexion.php";

/* Proteger acceso: solo admin */
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM productos ORDER BY id DESC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Productos | TecnoMarket</title>
    <link rel="stylesheet" href="css/admin_productos.css">
</head>
<body>

    <!-- SIDEBAR ADMIN -->
    <aside class="sidebar-admin" id="sidebarAdmin">
        <div class="sidebar-brand">
            <h2>TecnoMarket</h2>
            <span>Panel Admin</span>
        </div>

        <nav class="sidebar-nav">
            <a href="admin_articulos">Artículos</a>
            <a href="admin_productos" class="activo">Productos</a>
            <a href="admin_pedidos">Pedidos</a>
            <a href="admin_usuarios">Usuarios</a>
            <a href="index">Ver sitio</a>
            <a href="php/logout">Cerrar sesión</a>
        </nav>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="admin-main">

        <!-- TOPBAR -->
        <header class="topbar-admin">
            <div class="topbar-left">
                <button class="btn-menu-admin" onclick="toggleSidebar()">☰</button>
                <div>
                    <h1>Gestión de productos</h1>
                    <p>Administra el catálogo del sistema</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="admin-user-box">
                    <span class="admin-user-label">Administrador</span>
                    <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong>
                </div>
            </div>
        </header>

        <!-- MÉTRICAS -->
        <section class="metricas-admin">
            <div class="metrica-card">
                <h3>Total productos</h3>
                <p>
                    <?php
                    $sql_count = "SELECT COUNT(*) AS total FROM productos";
                    $res_count = $conn->query($sql_count);
                    $fila_count = $res_count->fetch_assoc();
                    echo $fila_count["total"];
                    ?>
                </p>
            </div>

            <div class="metrica-card">
                <h3>Stock total</h3>
                <p>
                    <?php
                    $sql_stock = "SELECT SUM(stock) AS total_stock FROM productos";
                    $res_stock = $conn->query($sql_stock);
                    $fila_stock = $res_stock->fetch_assoc();
                    echo $fila_stock["total_stock"] ? $fila_stock["total_stock"] : 0;
                    ?>
                </p>
            </div>

            <div class="metrica-card">
                <h3>Sesión activa</h3>
                <p><?php echo htmlspecialchars($rol_usuario); ?></p>
            </div>
        </section>

        <!-- GRID ADMIN -->
        <section class="admin-grid">

            <!-- FORMULARIO -->
            <section class="panel-admin form-panel">
                <div class="panel-header">
                    <h2>Registrar producto</h2>
                    <p>Agrega un nuevo producto al catálogo</p>
                </div>

             <form action="php/guardar_producto.php" method="POST" class="form-admin" enctype="multipart/form-data">
                <div class="grupo-input">
                    <label for="nombre">Nombre del producto</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>

                <div class="grupo-input">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
                </div>

                <div class="fila-formulario">
                    <div class="grupo-input">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.01" name="precio" id="precio" required>
                    </div>

                    <div class="grupo-input">
                        <label for="stock">Stock</label>
                        <input type="number" name="stock" id="stock" required>
                    </div>
                </div>

                <div class="fila-formulario">
                    <div class="grupo-input">
                        <label for="categoria">Categoría</label>
                        <input type="text" name="categoria" id="categoria" required>
                    </div>

                    <div class="grupo-input">
                        <label for="imagen">Imagen del producto</label>
                        <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.webp" required>
                    </div>
                </div>

                <button type="submit" class="btn-principal">Guardar producto</button>
         </form>
        </section>

            <!-- TABLA -->
            <section class="panel-admin tabla-panel">
                <div class="panel-header">
                    <h2>Listado de productos</h2>
                    <p>Consulta y administra los productos registrados</p>
                </div>

                <?php if ($resultado->num_rows > 0): ?>
                    <div class="tabla-productos">
                        <div class="fila encabezado">
                            <span>ID</span>
                            <span>Nombre</span>
                            <span>Precio</span>
                            <span>Categoría</span>
                            <span>Stock</span>
                            <span>Imagen</span>
                            <span>Acciones</span>
                        </div>

                        <?php while ($producto = $resultado->fetch_assoc()): ?>
                            <div class="fila">
                                <span><?php echo $producto["id"]; ?></span>
                                <span><?php echo htmlspecialchars($producto["nombre"]); ?></span>
                                <span>S/ <?php echo number_format($producto["precio"], 2); ?></span>
                                <span><?php echo htmlspecialchars($producto["categoria"]); ?></span>
                                <span><?php echo $producto["stock"]; ?></span>
                                <span class="ruta-img">
                                    <img src="<?php echo htmlspecialchars($producto["imagen"]); ?>" alt="Producto" class="miniatura-admin">
                                </span>
                                <span class="acciones">
                                    <a class="btn-editar" href="editar_producto.php?id=<?php echo $producto["id"]; ?>">Editar</a>
                                    <a class="btn-eliminar" href="php/eliminar_producto.php?id=<?php echo $producto["id"]; ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                                </span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="sin-registros">
                        <p>No hay productos registrados todavía.</p>
                    </div>
                <?php endif; ?>
            </section>

        </section>

    </main>

    <script src="js/admin_productos.js"></script>
</body>
</html>
<?php $conn->close(); ?>