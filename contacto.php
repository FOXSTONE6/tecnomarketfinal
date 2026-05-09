<?php require_once "php/session.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | TecnoMarket</title>
    <link rel="stylesheet" href="css/contacto.css">
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

<section class="hero-contacto">
    <div class="hero-contacto-texto">
        <h1>Contáctanos</h1>
        <p>Estamos listos para ayudarte con tus compras, consultas y soporte técnico.</p>
    </div>
</section>

<section class="contenedor-contacto">
    <div class="info-contacto">
        <h2>Información de contacto</h2>
        <div class="info-item">
            <h3>Dirección</h3>
            <p>Av. Tecnología 123, Huancayo, Perú</p>
        </div>
        <div class="info-item">
            <h3>Teléfono</h3>
            <p>+51 999 999 999</p>
        </div>
        <div class="info-item">
            <h3>Correo</h3>
            <p>contacto@tecnomarket.com</p>
        </div>
        <div class="info-item">
            <h3>Horario</h3>
            <p>Lunes a sábado de 9:00 a.m. a 7:00 p.m.</p>
        </div>
    </div>

    <div class="formulario-contacto-box">
        <h2>Envíanos un mensaje</h2>
        <form id="formContacto" class="form-contacto">
            <div class="grupo-input">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" required>
            </div>

            <div class="grupo-input">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" required>
            </div>

            <div class="grupo-input">
                <label for="asunto">Asunto</label>
                <input type="text" id="asunto" required>
            </div>

            <div class="grupo-input">
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-contacto">Enviar mensaje</button>
            <p id="respuestaContacto" class="respuesta-contacto"></p>
        </form>
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/contacto.js"></script>
</body>
</html>