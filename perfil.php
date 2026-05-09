<?php
require_once "php/session.php";
require_once "php/conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

$sql_usuario = "SELECT id, nombres, apellidos, correo, telefono, rol, fecha_registro FROM usuarios WHERE id = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();

if ($resultado_usuario->num_rows !== 1) {
    header("Location: php/logout.php");
    exit();
}

$usuario = $resultado_usuario->fetch_assoc();

/* Total pedidos */
$sql_pedidos = "SELECT COUNT(*) AS total_pedidos FROM pedidos WHERE usuario_id = ?";
$stmt_pedidos = $conn->prepare($sql_pedidos);
$stmt_pedidos->bind_param("i", $usuario_id);
$stmt_pedidos->execute();
$res_pedidos = $stmt_pedidos->get_result();
$fila_pedidos = $res_pedidos->fetch_assoc();
$total_pedidos = $fila_pedidos["total_pedidos"] ?? 0;

/* Total gastado */
$sql_total = "SELECT COALESCE(SUM(total),0) AS total_gastado FROM pedidos WHERE usuario_id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $usuario_id);
$stmt_total->execute();
$res_total = $stmt_total->get_result();
$fila_total = $res_total->fetch_assoc();
$total_gastado = $fila_total["total_gastado"] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | TecnoMarket</title>
    <link rel="stylesheet" href="css/perfil.css">
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

<section class="hero-perfil">
    <div class="hero-perfil-texto">
        <h1>Mi perfil</h1>
        <p>Gestiona tu cuenta, revisa tus pedidos y accede a tus opciones personales.</p>
    </div>
</section>

<section class="contenedor-perfil">

    <div class="perfil-info-box">
        <div class="perfil-header">
            <div class="avatar-perfil">
                <?php echo strtoupper(substr($usuario["nombres"], 0, 1)); ?>
            </div>

            <div>
                <h2><?php echo htmlspecialchars($usuario["nombres"] . " " . $usuario["apellidos"]); ?></h2>
                <p class="perfil-rol"><?php echo htmlspecialchars($usuario["rol"]); ?></p>
            </div>
        </div>

        <div class="perfil-datos">
            <div class="dato-item">
                <span class="dato-label">Correo</span>
                <span class="dato-valor"><?php echo htmlspecialchars($usuario["correo"]); ?></span>
            </div>

            <div class="dato-item">
                <span class="dato-label">Teléfono</span>
                <span class="dato-valor"><?php echo htmlspecialchars($usuario["telefono"]); ?></span>
            </div>

            <div class="dato-item">
                <span class="dato-label">Miembro desde</span>
                <span class="dato-valor"><?php echo date("d/m/Y", strtotime($usuario["fecha_registro"])); ?></span>
            </div>
        </div>
    </div>

    <div class="perfil-metricas">
        <div class="metrica-card">
            <h3>Pedidos realizados</h3>
            <p><?php echo $total_pedidos; ?></p>
        </div>

        <div class="metrica-card">
            <h3>Total gastado</h3>
            <p>S/ <?php echo number_format($total_gastado, 2); ?></p>
        </div>
    </div>

    <div class="perfil-opciones">
        <a href="mis_pedidos.php" class="opcion-card">
            <h3>Mis pedidos</h3>
            <p>Consulta el historial completo de tus compras.</p>
        </a>

        <a href="carrito.php" class="opcion-card">
            <h3>Mi carrito</h3>
            <p>Revisa los productos que has agregado antes de comprar.</p>
        </a>

        <a href="editar_perfil.php" class="opcion-card">
            <h3>Editar perfil</h3>  
            <p>Actualiza tus datos personales y de contacto.</p>
        </a>

        <?php if ($usuario["rol"] === "admin"): ?>
            <a href="admin_productos.php" class="opcion-card admin-card">
                <h3>Panel Admin</h3>
                <p>Gestiona productos y módulos administrativos del sistema.</p>
            </a>
        <?php endif; ?>
    </div>

</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/perfil.js"></script>
</body>
</html>
<?php
$stmt_usuario->close();
$stmt_pedidos->close();
$stmt_total->close();
$conn->close();
?>