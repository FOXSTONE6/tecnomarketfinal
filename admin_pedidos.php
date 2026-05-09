<?php
require_once "php/session.php";
require_once "php/conexion.php";

/* Proteger acceso: solo admin */
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$sql_pedidos = "SELECT 
                    p.id,
                    p.total,
                    p.fecha,
                    u.nombres,
                    u.apellidos,
                    u.correo
                FROM pedidos p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                ORDER BY p.fecha DESC";

$resultado_pedidos = $conn->query($sql_pedidos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pedidos | TecnoMarket</title>
    <link rel="stylesheet" href="css/admin_pedidos.css">
</head>
<body>

    <!-- SIDEBAR ADMIN -->
    <aside class="sidebar-admin" id="sidebarAdmin">
        <div class="sidebar-brand">
            <h2>TecnoMarket</h2>
            <span>Panel Admin</span>
        </div>

        <nav class="sidebar-nav">
            <a href="admin_articulos">Artículos</a>
            <a href="admin_productos" class="activo">Productos</a>
            <a href="admin_pedidos">Pedidos</a>
            <a href="admin_usuarios">Usuarios</a>
            <a href="index">Ver sitio</a>
            <a href="php/logout">Cerrar sesión</a>
        </nav>
    </aside>

    <!-- CONTENIDO -->
    <main class="admin-main">

        <header class="topbar-admin">
            <div class="topbar-left">
                <button class="btn-menu-admin" onclick="toggleSidebar()">☰</button>
                <div>
                    <h1>Gestión de pedidos</h1>
                    <p>Consulta las compras realizadas por los usuarios</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="admin-user-box">
                    <span class="admin-user-label">Administrador</span>
                    <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong>
                </div>
            </div>
        </header>

        <section class="metricas-admin">
            <div class="metrica-card">
                <h3>Total pedidos</h3>
                <p>
                    <?php
                    $sql_total_pedidos = "SELECT COUNT(*) AS total FROM pedidos";
                    $res_total_pedidos = $conn->query($sql_total_pedidos);
                    $fila_total_pedidos = $res_total_pedidos->fetch_assoc();
                    echo $fila_total_pedidos["total"];
                    ?>
                </p>
            </div>

            <div class="metrica-card">
                <h3>Ventas acumuladas</h3>
                <p>
                    <?php
                    $sql_total_ventas = "SELECT COALESCE(SUM(total),0) AS total FROM pedidos";
                    $res_total_ventas = $conn->query($sql_total_ventas);
                    $fila_total_ventas = $res_total_ventas->fetch_assoc();
                    echo "S/ " . number_format($fila_total_ventas["total"], 2);
                    ?>
                </p>
            </div>

            <div class="metrica-card">
                <h3>Sesión activa</h3>
                <p><?php echo htmlspecialchars($rol_usuario); ?></p>
            </div>
        </section>

        <section class="panel-admin">
            <div class="panel-header">
                <h2>Listado de pedidos</h2>
                <p>Detalle completo de pedidos registrados en el sistema</p>
            </div>

            <?php if ($resultado_pedidos->num_rows > 0): ?>
                <div class="lista-pedidos-admin">
                    <?php while ($pedido = $resultado_pedidos->fetch_assoc()): ?>
                        <article class="pedido-admin-card">
                            <div class="pedido-admin-top">
                                <div>
                                    <h3>Pedido #<?php echo $pedido["id"]; ?></h3>
                                    <p class="pedido-admin-cliente">
                                        Cliente: <?php echo htmlspecialchars($pedido["nombres"] . " " . $pedido["apellidos"]); ?>
                                    </p>
                                    <p class="pedido-admin-correo">
                                        Correo: <?php echo htmlspecialchars($pedido["correo"]); ?>
                                    </p>
                                </div>

                                <div class="pedido-admin-meta">
                                    <span class="pedido-admin-fecha">
                                        <?php echo date("d/m/Y H:i", strtotime($pedido["fecha"])); ?>
                                    </span>
                                    <span class="pedido-admin-total">
                                        S/ <?php echo number_format($pedido["total"], 2); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="pedido-admin-detalle">
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
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="sin-registros">
                    <p>No hay pedidos registrados todavía.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <script src="js/admin_pedidos.js"></script>
</body>
</html>
<?php $conn->close(); ?>