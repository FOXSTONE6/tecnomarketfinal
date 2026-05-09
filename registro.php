<?php require_once "php/session.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | TecnoMarket</title>
    <link rel="stylesheet" href="css/registro.css">
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

<section class="hero-registro">
    <div class="hero-registro-texto">
        <h1>Crear Cuenta</h1>
        <p>Regístrate para comprar y gestionar tus pedidos.</p>
    </div>
</section>

<section class="contenedor-registro">
    <div class="registro-box">
        <div class="registro-encabezado">
            <h2>Únete a TecnoMarket</h2>
            <p>Completa tus datos para crear tu cuenta.</p>
        </div>

        <form id="formRegistro" class="form-registro" action="php/registrar_usuario.php" method="POST">
            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" placeholder="Tus nombres" required>
                </div>

                <div class="grupo-input">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" placeholder="Tus apellidos" required>
                </div>
            </div>

            <div class="grupo-input">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="grupo-input">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" placeholder="999999999" required>
            </div>

            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="password">Contraseña</label>
                    <div class="input-password">
                        <input type="password" id="password" name="password" placeholder="********" required>
                        <button type="button" class="btn-ver" onclick="togglePassword('password')">👁</button>
                    </div>
                </div>

                <div class="grupo-input">
                    <label for="confirmarPassword">Confirmar contraseña</label>
                    <div class="input-password">
                        <input type="password" id="confirmarPassword" name="confirmarPassword" placeholder="********" required>
                        <button type="button" class="btn-ver" onclick="togglePassword('confirmarPassword')">👁</button>
                    </div>
                </div>
            </div>

            <div class="grupo-check">
                <label class="check-box">
                    <input type="checkbox" id="terminos" name="terminos" required>
                    <span>Acepto los términos y condiciones</span>
                </label>
            </div>

            <button type="submit" class="btn-registro">Crear cuenta</button>
            <p id="mensajeRegistro" class="mensaje-registro"></p>
        </form>

        <div class="registro-footer">
            <p>¿Ya tienes una cuenta?</p>
            <a href="login">Iniciar sesión</a>
        </div>
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/registro.js"></script>
</body>
</html>