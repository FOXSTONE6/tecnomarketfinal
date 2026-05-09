<?php require_once "php/session.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito | TecnoMarket</title>
    <link rel="stylesheet" href="css/carrito.css">
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

<section class="hero-carrito">
    <div class="hero-carrito-texto">
        <h1>Tu Carrito de Compras</h1>
        <p>Revisa tus productos antes de finalizar tu pedido.</p>
    </div>
</section>

<section class="contenido-carrito">
    <div class="carrito-lista-box">
        <div class="carrito-lista-header">
            <h2>Productos seleccionados</h2>
            <button class="btn-vaciar" onclick="vaciarCarrito()">Vaciar carrito</button>
        </div>

        <div id="listaCarrito" class="lista-carrito"></div>
    </div>

    <aside class="resumen-compra">
        <h2>Resumen</h2>

        <div class="resumen-linea">
            <span>Productos</span>
            <span id="resumenCantidad">0</span>
        </div>

        <div class="resumen-linea">
            <span>Subtotal</span>
            <span>S/ <span id="resumenSubtotal">0.00</span></span>
        </div>

        <div class="resumen-linea">
            <span>Envío</span>
            <span id="resumenEnvio">Gratis</span>
        </div>

        <div class="resumen-total">
            <span>Total</span>
            <span>S/ <span id="resumenTotal">0.00</span></span>
        </div>

        <button class="btn-finalizar" onclick="finalizarCompra()">Finalizar compra</button>
        <a href="tienda.php" class="btn-seguir">Seguir comprando</a>
    </aside>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/carrito.js"></script>
</body>
</html>