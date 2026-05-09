<?php
require_once "php/session.php";
require_once "php/conexion.php";

/* Proteger acceso: solo admin */
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$sql_usuarios = "SELECT id, nombres, apellidos, correo, telefono, rol, fecha_registro 
                 FROM usuarios 
                 ORDER BY id DESC";
$resultado_usuarios = $conn->query($sql_usuarios);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Usuarios | TecnoMarket</title>
    <link rel="stylesheet" href="css/admin_usuarios.css">
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
            <a href="admin_productos">Productos</a>
            <a href="admin_pedidos">Pedidos</a>
            <a href="admin_usuarios" class="activo">Usuarios</a>
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
                    <h1>Gestión de usuarios</h1>
                    <p>Consulta y administra las cuentas registradas</p>
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
                <h3>Total usuarios</h3>
                <p>
                    <?php
                    $sql_total = "SELECT COUNT(*) AS total FROM usuarios";
                    $res_total = $conn->query($sql_total);
                    $fila_total = $res_total->fetch_assoc();
                    echo $fila_total["total"];
                    ?>
                </p>
            </div>

            <div class="metrica-card">
                <h3>Administradores</h3>
                <p>
                    <?php
                    $sql_admins = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'admin'";
                    $res_admins = $conn->query($sql_admins);
                    $fila_admins = $res_admins->fetch_assoc();
                    echo $fila_admins["total"];
                    ?>
                </p>
            </div>

            <div class="metrica-card">
                <h3>Clientes</h3>
                <p>
                    <?php
                    $sql_clientes = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'cliente'";
                    $res_clientes = $conn->query($sql_clientes);
                    $fila_clientes = $res_clientes->fetch_assoc();
                    echo $fila_clientes["total"];
                    ?>
                </p>
            </div>
        </section>

        <section class="panel-admin">
            <div class="panel-header">
                <h2>Listado de usuarios</h2>
                <p>Administra roles y cuentas del sistema</p>
            </div>

            <?php if ($resultado_usuarios->num_rows > 0): ?>
                <div class="tabla-usuarios">
                    <div class="fila encabezado">
                        <span>ID</span>
                        <span>Nombre completo</span>
                        <span>Correo</span>
                        <span>Teléfono</span>
                        <span>Rol</span>
                        <span>Registro</span>
                        <span>Acciones</span>
                    </div>

                    <?php while ($usuario = $resultado_usuarios->fetch_assoc()): ?>
                        <div class="fila">
                            <span><?php echo $usuario["id"]; ?></span>
                            <span><?php echo htmlspecialchars($usuario["nombres"] . " " . $usuario["apellidos"]); ?></span>
                            <span><?php echo htmlspecialchars($usuario["correo"]); ?></span>
                            <span><?php echo htmlspecialchars($usuario["telefono"]); ?></span>
                            <span>
                                <span class="badge-rol <?php echo $usuario["rol"] === "admin" ? "admin" : "cliente"; ?>">
                                    <?php echo htmlspecialchars($usuario["rol"]); ?>
                                </span>
                            </span>
                            <span><?php echo date("d/m/Y", strtotime($usuario["fecha_registro"])); ?></span>
                            <span class="acciones">
                                <?php if ($usuario["id"] != $_SESSION["usuario_id"]): ?>
                                    <a class="btn-rol" href="php/cambiar_rol_usuario.php?id=<?php echo $usuario["id"]; ?>&rol=<?php echo $usuario["rol"]; ?>">
                                        Cambiar rol
                                    </a>

                                    <a class="btn-eliminar" href="php/eliminar_usuario.php?id=<?php echo $usuario["id"]; ?>" onclick="return confirm('¿Eliminar este usuario?')">
                                        Eliminar
                                    </a>
                                <?php else: ?>
                                    <span class="usuario-actual">Tu cuenta</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="sin-registros">
                    <p>No hay usuarios registrados.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <script src="js/admin_usuarios.js"></script>
</body>
</html>
<?php $conn->close(); ?>