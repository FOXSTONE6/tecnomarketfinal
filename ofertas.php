<?php require_once "php/session.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas | TecnoMarket</title>
    <link rel="stylesheet" href="css/ofertas.css">
</head>
<body>

<header class="header">
    <div class="logo">TecnoMarket</div>

    <input type="text" id="buscadorOfertas" placeholder="Buscar ofertas..." class="buscador">

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

<section class="hero-ofertas">
    <div class="hero-ofertas-texto">
        <h1>Ofertas Especiales</h1>
        <p>Aprovecha descuentos exclusivos en productos tecnológicos seleccionados.</p>
    </div>
</section>

<section class="contenedor-ofertas">
    <div class="barra-ofertas">
        <h2>Promociones</h2>
        <p><span id="totalOfertas">0</span> ofertas disponibles</p>
    </div>

    <div class="grid-ofertas" id="listaOfertas"></div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/ofertas.js"></script>
</body>
</html>