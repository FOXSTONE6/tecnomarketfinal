<?php
require_once "php/session.php";
require_once "php/conexion.php";

$id = $_GET["id"] ?? "";

if (empty($id) || !is_numeric($id)) {
    header("Location: articulos.php");
    exit();
}

$sql = "SELECT id, titulo, resumen, contenido, categoria, imagen, fecha_publicacion 
        FROM articulos 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    header("Location: articulos.php");
    exit();
}

$articulo = $resultado->fetch_assoc();

/* Artículos relacionados */
$sql_relacionados = "SELECT id, titulo, imagen, categoria 
                     FROM articulos 
                     WHERE categoria = ? AND id != ? 
                     ORDER BY fecha_publicacion DESC 
                     LIMIT 3";
$stmt_rel = $conn->prepare($sql_relacionados);
$stmt_rel->bind_param("si", $articulo["categoria"], $id);
$stmt_rel->execute();
$resultado_rel = $stmt_rel->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($articulo["titulo"]); ?> | TecnoMarket</title>
    <link rel="stylesheet" href="css/detalle_articulo.css">
</head>
<body>

<header class="header">
    <div class="logo">TecnoMarket</div>

    <input type="text" placeholder="Buscar..." class="buscador">

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

<section class="hero-detalle">
    <div class="hero-detalle-texto">
        <span class="badge-categoria"><?php echo htmlspecialchars($articulo["categoria"]); ?></span>
        <h1><?php echo htmlspecialchars($articulo["titulo"]); ?></h1>
        <p><?php echo htmlspecialchars($articulo["resumen"]); ?></p>
        <small>
            Publicado el <?php echo date("d/m/Y H:i", strtotime($articulo["fecha_publicacion"])); ?>
        </small>
    </div>
</section>

<section class="contenedor-detalle">
    <article class="articulo-completo">
        <img src="<?php echo htmlspecialchars($articulo["imagen"]); ?>" alt="<?php echo htmlspecialchars($articulo["titulo"]); ?>" class="imagen-principal">

        <div class="contenido-articulo">
            <p><?php echo nl2br(htmlspecialchars($articulo["contenido"])); ?></p>
        </div>

        <div class="acciones-articulo">
            <a href="articulos.php" class="btn-volver">← Volver a artículos</a>
        </div>
    </article>

    <aside class="sidebar-relacionados">
        <h2>Artículos relacionados</h2>

        <?php if ($resultado_rel->num_rows > 0): ?>
            <div class="lista-relacionados">
                <?php while ($rel = $resultado_rel->fetch_assoc()): ?>
                    <a href="detalle_articulo.php?id=<?php echo $rel["id"]; ?>" class="relacionado-card">
                        <img src="<?php echo htmlspecialchars($rel["imagen"]); ?>" alt="<?php echo htmlspecialchars($rel["titulo"]); ?>">
                        <div>
                            <span class="rel-cat"><?php echo htmlspecialchars($rel["categoria"]); ?></span>
                            <h3><?php echo htmlspecialchars($rel["titulo"]); ?></h3>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="sin-relacionados">No hay artículos relacionados disponibles.</p>
        <?php endif; ?>
    </aside>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/detalle_articulo.js"></script>
</body>
</html>
<?php
$stmt->close();
$stmt_rel->close();
$conn->close();
?>