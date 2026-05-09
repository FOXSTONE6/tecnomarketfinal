<?php
require_once "php/session.php";
require_once "php/conexion.php";

$sql_articulos = "SELECT id, titulo, resumen, categoria, imagen, fecha_publicacion 
                  FROM articulos 
                  ORDER BY fecha_publicacion DESC";
$resultado_articulos = $conn->query($sql_articulos);

$articulos = [];
if ($resultado_articulos && $resultado_articulos->num_rows > 0) {
    while ($fila = $resultado_articulos->fetch_assoc()) {
        $articulos[] = $fila;
    }
}

$sql_categorias = "SELECT DISTINCT categoria FROM articulos ORDER BY categoria ASC";
$resultado_categorias = $conn->query($sql_categorias);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos | TecnoMarket</title>
    <link rel="stylesheet" href="css/articulos.css">
</head>
<body>

<header class="header">
    <div class="logo">TecnoMarket</div>

    <input type="text" id="buscadorArticulos" placeholder="Buscar artículos..." class="buscador">

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

<section class="hero-articulos">
    <div class="hero-articulos-texto">
        <h1>Artículos Tecnológicos</h1>
        <p>Noticias, tendencias, guías y tutoriales del mundo tech.</p>
    </div>
</section>

<section class="filtros-articulos">
    <div class="filtro-grupo">
        <label for="categoriaArticulo">Categoría</label>
        <select id="categoriaArticulo">
            <option value="todos">Todos</option>
            <?php if ($resultado_categorias && $resultado_categorias->num_rows > 0): ?>
                <?php while ($cat = $resultado_categorias->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($cat["categoria"]); ?>">
                        <?php echo htmlspecialchars($cat["categoria"]); ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>
    </div>
</section>

<section class="contenedor-articulos">
    <div class="barra-articulos">
        <h2>Publicaciones</h2>
        <p><span id="totalArticulos">0</span> artículos encontrados</p>
    </div>

    <div class="grid-articulos" id="listaArticulos"></div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script>
    const articulosDB = <?php echo json_encode($articulos, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="js/articulos.js"></script>
</body>
</html>
<?php $conn->close(); ?>