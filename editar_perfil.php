<?php
require_once "php/session.php";
require_once "php/conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

$sql_usuario = "SELECT id, nombres, apellidos, correo, telefono, rol FROM usuarios WHERE id = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();

if ($resultado_usuario->num_rows !== 1) {
    header("Location: php/logout.php");
    exit();
}

$usuario = $resultado_usuario->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil | TecnoMarket</title>
    <link rel="stylesheet" href="css/editar_perfil.css">
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

<section class="hero-editar">
    <div class="hero-editar-texto">
        <h1>Editar perfil</h1>
        <p>Actualiza tu información personal y, si deseas, cambia tu contraseña.</p>
    </div>
</section>

<section class="contenedor-editar">
    <div class="editar-box">
        <div class="editar-header">
            <h2>Mis datos</h2>
            <p>Modifica tu información y guarda los cambios.</p>
        </div>

        <form id="formEditarPerfil" class="form-editar" action="php/actualizar_perfil.php" method="POST">
            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuario["nombres"]); ?>" required>
                </div>

                <div class="grupo-input">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario["apellidos"]); ?>" required>
                </div>
            </div>

            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario["correo"]); ?>" required>
                </div>

                <div class="grupo-input">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario["telefono"]); ?>" required>
                </div>
            </div>

            <div class="seccion-password">
                <h3>Cambiar contraseña</h3>
                <p>Déjala en blanco si no deseas cambiarla.</p>
            </div>

            <div class="fila-formulario">
                <div class="grupo-input">
                    <label for="password">Nueva contraseña</label>
                    <div class="input-password">
                        <input type="password" id="password" name="password" placeholder="********">
                        <button type="button" class="btn-ver" onclick="togglePassword('password')">👁</button>
                    </div>
                </div>

                <div class="grupo-input">
                    <label for="confirmarPassword">Confirmar nueva contraseña</label>
                    <div class="input-password">
                        <input type="password" id="confirmarPassword" name="confirmarPassword" placeholder="********">
                        <button type="button" class="btn-ver" onclick="togglePassword('confirmarPassword')">👁</button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-guardar">Guardar cambios</button>
            <p id="mensajePerfil" class="mensaje-perfil"></p>
        </form>
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/editar_perfil.js"></script>
</body>
</html>
<?php
$stmt_usuario->close();
$conn->close();
?>