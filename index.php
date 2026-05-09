<?php require_once "php/session.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TecnoMarket</title>
    <link rel="stylesheet" href="css/styles.css">
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

<section class="hero">
    <div class="hero-texto">
        <h1>Bienvenido a TecnoMarket</h1>
        <p>Lo mejor en tecnología al mejor precio</p>
        <button class="btn-hero" onclick="window.location.href='tienda'">Comprar ahora</button>
    </div>
</section>

<section class="categorias">
    <h2>Categorías</h2>

    <div class="carrusel-categorias" id="carruselCategorias">
        <div class="track-categorias" id="trackCategorias">
            <div class="categoria">
                <img src="img/laptop.jpg" alt="Laptops">
                <h3>Laptops</h3>
                <p>Equipos de alto rendimiento para estudio, trabajo y gaming.</p>
            </div>

            <div class="categoria">
                <img src="img/celular.jpg" alt="Celulares">
                <h3>Celulares</h3>
                <p>Smartphones modernos con gran potencia y mejores cámaras.</p>
            </div>

            <div class="categoria">
                <img src="img/cargador.webp" alt="Accesorios">
                <h3>Accesorios</h3>
                <p>Complementos ideales para mejorar tu experiencia tecnológica.</p>
            </div>

            <div class="categoria">
                <img src="img/ram.jpg" alt="Componentes">
                <h3>Componentes</h3>
                <p>Partes y hardware para potenciar tu PC.</p>
            </div>

            <div class="categoria">
                <img src="img/monitor.png" alt="Monitores">
                <h3>Monitores</h3>
                <p>Pantallas de alta calidad para oficina, diseño y gaming.</p>
            </div>

            <div class="categoria">
                <img src="img/teclado.webp" alt="Periféricos">
                <h3>Periféricos</h3>
                <p>Teclados, mouse y dispositivos para productividad y juego.</p>
            </div>
        </div>
    </div>
</section>

<section class="productos">
    <h2>Productos Destacados</h2>
    <div class="grid-productos">
        <div class="card">
            <img src="img/laptopgamer.png">
            <h3>Laptop Gamer</h3>
            <p>Potente laptop para juegos exigentes.</p>
            <span class="precio">S/. 3500</span>
        </div>

        <div class="card">
            <img src="img/iphone.webp">
            <h3>Smartphone Pro</h3>
            <p>Alta gama con excelente cámara.</p>
            <span class="precio">S/. 1800</span>
        </div>

        <div class="card">
            <img src="img/audifono.jpg">
            <h3>Auriculares</h3>
            <p>Sonido envolvente y comodidad.</p>
            <span class="precio">S/. 200</span>
        </div>

        <div class="card">
            <img src="img/camara.webp">
            <h3>Camaras de Video
            <p>protege tus momentos con calidad 4K.</p>
            <span class="precio">S/. 250</span>
        </div>
    </div>
</section>

<section class="articulos">
    <h2>Últimos Artículos</h2>
    <div class="grid-articulos">
        <div class="card">
            <img src="img/iacurso.jpg">
            <h3>Inteligencia Artificial</h3>
            <p>Descubre las tendencias de la IA en 2026.</p>
        </div>

        <div class="card">
            <img src="img/cursoweb.webp">
            <h3>Cursos Web</h3>
            <p>Aprende a programar con los mejores cursos en línea.</p> 
        </div>

        <div class="card">
            <img src="img/framework.png">
            <h3>Frameworks JS</h3>
            <p>Los más usados en desarrollo web moderno.</p>
        </div>
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/main.js"></script>
</body>
</html>