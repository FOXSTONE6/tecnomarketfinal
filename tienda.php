<?php
require_once "php/session.php";
require_once "php/conexion.php";

$sql_productos = "SELECT * FROM productos ORDER BY id DESC";
$resultado_productos = $conn->query($sql_productos);

$productos_array = [];
if ($resultado_productos->num_rows > 0) {
    while ($fila = $resultado_productos->fetch_assoc()) {
        $productos_array[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda | TecnoMarket</title>
    <link rel="stylesheet" href="css/tienda.css">
</head>
<body>

<header class="header">
    <div class="logo">TecnoMarket</div>

    <input type="text" id="buscadorProductos" placeholder="Buscar productos..." class="buscador">

    <div class="hamburguesa" onclick="toggleMenu()">☰</div>

<nav class="menu" id="menu">
    <a href="index">Inicio</a>
    <a href="tienda">Tienda</a>
    <a href="articulos">Artículos</a>
    <a href="ofertas">Ofertas</a>
    <a href="contacto">Contacto</a>

    <?php if ($usuario_logueado): ?>
        <a href="perfil">Hola, <?php echo htmlspecialchars($nombre_usuario); ?></a>

        <?php if ($rol_usuario === "admin"): ?>
            <a href="admin_productos">Panel Admin</a>
        <?php endif; ?>

        <a href="php/logout.php">Cerrar sesión</a>
    <?php else: ?>
        <a href="login">Login</a>
    <?php endif; ?>
</nav>
</header>

<section class="hero-tienda">
    <div class="hero-tienda-texto">
        <h1>Tienda Tecnológica</h1>
        <p>Encuentra laptops, celulares, accesorios y más productos al mejor precio.</p>
    </div>
</section>

<section class="filtros-tienda">
    <div class="filtro-grupo">
        <label for="filtroCategoria">Categoría</label>
        <select id="filtroCategoria">
            <option value="todos">Todos</option>
            <?php
            $sql_categorias = "SELECT DISTINCT categoria FROM productos ORDER BY categoria ASC";
            $resultado_categorias = $conn->query($sql_categorias);
            if ($resultado_categorias->num_rows > 0):
                while ($categoria = $resultado_categorias->fetch_assoc()):
            ?>
                <option value="<?php echo htmlspecialchars($categoria["categoria"]); ?>">
                    <?php echo htmlspecialchars($categoria["categoria"]); ?>
                </option>
            <?php
                endwhile;
            endif;
            ?>
        </select>
    </div>

    <div class="filtro-grupo">
        <label for="ordenPrecio">Ordenar por precio</label>
        <select id="ordenPrecio">
            <option value="ninguno">Seleccionar</option>
            <option value="menor">Menor a mayor</option>
            <option value="mayor">Mayor a menor</option>
        </select>
    </div>
</section>

<section class="contenido-tienda">
    <div class="columna-productos">
        <div class="barra-productos">
            <h2>Productos</h2>
            <p><span id="totalProductos">0</span> productos encontrados</p>
        </div>

        <div class="grid-tienda" id="listaProductos"></div>
    </div>

    <aside class="resumen-carrito">
        <div class="carrito-header">
            <h2>Carrito</h2>
            <span class="carrito-badge" id="carritoCantidad">0</span>
        </div>

        <div class="carrito-acciones">
            <button class="btn-vaciar" onclick="vaciarCarrito()">Vaciar carrito</button>
        </div>

        <div id="carritoItems" class="carrito-items"></div>

        <div class="carrito-total-box">
            <p><strong>Total:</strong> S/ <span id="carritoTotal">0.00</span></p>
            <button class="btn-carrito" onclick="irAlCarrito()">Ver carrito</button>
        </div>
    </aside>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script>
    const productosDB = <?php echo json_encode($productos_array, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="js/tienda.js"></script>
</body>
</html>
<?php $conn->close(); ?>