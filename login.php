<?php

require_once "php/session.php";

if ($usuario_logueado) {
    header("Location: index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TecnoMarket</title>
    <link rel="stylesheet" href="css/login.css">
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

<section class="hero-login">
    <div class="hero-login-texto">
        <h1>Iniciar Sesión</h1>
        <p>Accede a tu cuenta para gestionar tus compras y pedidos.</p>
    </div>
</section>

<section class="contenedor-login">
    <div class="login-box">
        <div class="login-encabezado">
            <h2>Bienvenido</h2>
            <p>Ingresa tus datos para continuar.</p>
        </div>

        <form id="formLogin" class="form-login" action="php/login_usuario.php" method="POST">
            <div class="grupo-input">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="grupo-input">
                <label for="password">Contraseña</label>
                <div class="input-password">
                    <input type="password" id="password" name="password" placeholder="********" required>
                    <button type="button" class="btn-ver" onclick="togglePassword()">👁</button>
                </div>
            </div>

            <button type="submit" class="btn-login">Ingresar</button>
            <p id="mensajeLogin" class="mensaje-login"></p>
        </form>

        <div class="login-footer">
            <p>¿No tienes cuenta?</p>
            <a href="registro.php">Crear cuenta</a>
        </div>
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/login.js"></script>
</body>
</html>