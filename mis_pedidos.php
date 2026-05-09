<?php
require_once "php/session.php";
require_once "php/conexion.php";

/* Proteger acceso */
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

/* Obtener pedidos del usuario */
$sql_pedidos = "SELECT id, total, fecha 
                FROM pedidos 
                WHERE usuario_id = ? 
                ORDER BY fecha DESC";

$stmt_pedidos = $conn->prepare($sql_pedidos);
$stmt_pedidos->bind_param("i", $usuario_id);
$stmt_pedidos->execute();
$resultado_pedidos = $stmt_pedidos->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos | TecnoMarket</title>
    <link rel="stylesheet" href="css/mis_pedidos.css">
</head>
<body>

<header class="header">
    <div class="logo">TecnoMarket</div>

    <input type="text" placeholder="Buscar..." class="buscador">

    <div class="hamburguesa" onclick="toggleMenu()">☰</div>

        <nav class="menu" id="menu">
            <a href="index.php">Inicio</a>
            <a href="tienda.php">Tienda</a>

            <?php if ($usuario_logueado): ?>
                <a href="mis_pedidos.php">Mis pedidos</a>
            <?php endif; ?>

            <a href="articulos.php">Artículos</a>
            <a href="ofertas.php">Ofertas</a>
            <a href="contacto.php">Contacto</a>

            <?php if ($usuario_logueado): ?>
                <a href="#">Hola, <?php echo htmlspecialchars($nombre_usuario); ?></a>

                <?php if ($rol_usuario === "admin"): ?>
                    <a href="admin_productos.php">Panel Admin</a>
                <?php endif; ?>

                <a href="php/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
</header>

<section class="hero-pedidos">
    <div class="hero-pedidos-texto">
        <h1>Mis pedidos</h1>
        <p>Consulta el historial de tus compras realizadas en TecnoMarket.</p>
    </div>
</section>

<section class="contenedor-pedidos">
    <div class="pedidos-box">
        <div class="pedidos-header">
            <h2>Historial de compras</h2>
        </div>

        <?php if ($resultado_pedidos->num_rows > 0): ?>
            <div class="lista-pedidos">
                <?php while ($pedido = $resultado_pedidos->fetch_assoc()): ?>
                    <div class="pedido-card">
                        <div class="pedido-top">
                            <div>
                                <h3>Pedido #<?php echo $pedido["id"]; ?></h3>
                                <p class="fecha-pedido">
                                    Fecha: <?php echo date("d/m/Y H:i", strtotime($pedido["fecha"])); ?>
                                </p>
                            </div>
                            <div class="pedido-total">
                                Total: S/ <?php echo number_format($pedido["total"], 2); ?>
                            </div>
                        </div>

                        <div class="detalle-pedido">
                            <h4>Detalle del pedido</h4>

                            <?php
                            $pedido_id = $pedido["id"];
                            $sql_detalle = "SELECT nombre_producto, precio, cantidad, subtotal
                                            FROM detalle_pedidos
                                            WHERE pedido_id = ?";
                            $stmt_detalle = $conn->prepare($sql_detalle);
                            $stmt_detalle->bind_param("i", $pedido_id);
                            $stmt_detalle->execute();
                            $resultado_detalle = $stmt_detalle->get_result();
                            ?>

                            <div class="tabla-detalle">
                                <div class="fila encabezado">
                                    <span>Producto</span>
                                    <span>Precio</span>
                                    <span>Cantidad</span>
                                    <span>Subtotal</span>
                                </div>

                                <?php while ($item = $resultado_detalle->fetch_assoc()): ?>
                                    <div class="fila">
                                        <span><?php echo htmlspecialchars($item["nombre_producto"]); ?></span>
                                        <span>S/ <?php echo number_format($item["precio"], 2); ?></span>
                                        <span><?php echo $item["cantidad"]; ?></span>
                                        <span>S/ <?php echo number_format($item["subtotal"], 2); ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="sin-pedidos">
                <h3>Aún no tienes pedidos registrados</h3>
                <p>Cuando realices una compra, aparecerá aquí tu historial.</p>
                <a href="tienda.php" class="btn-ir-tienda">Ir a la tienda</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<footer class="footer">
    <p>© 2026 TecnoMarket - Todos los derechos reservados</p>
</footer>

<script src="js/mis_pedidos.js"></script>
</body>
</html>
<?php
$stmt_pedidos->close();
$conn->close();
?>