<?php
require_once "php/session.php";
require_once "php/conexion.php";

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM articulos ORDER BY id DESC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Artículos | TecnoMarket</title>
    <link rel="stylesheet" href="css/admin_articulos.css">
</head>
<body>

<aside class="sidebar-admin" id="sidebarAdmin">
    <div class="sidebar-brand">
        <h2>TecnoMarket</h2>
        <span>Panel Admin</span>
    </div>

    <nav class="sidebar-nav">
        <a href="admin_productos">Productos</a>
        <a href="admin_pedidos">Pedidos</a>
        <a href="admin_usuarios">Usuarios</a>
        <a href="admin_articulos" class="activo">Artículos</a>
        <a href="index">Ver sitio</a>
        <a href="php/logout">Cerrar sesión</a>
    </nav>
</aside>

<main class="admin-main">
    <header class="topbar-admin">
        <div class="topbar-left">
            <button class="btn-menu-admin" onclick="toggleSidebar()">☰</button>
            <div>
                <h1>Gestión de artículos</h1>
                <p>Administra el contenido del portal</p>
            </div>
        </div>

        <div class="topbar-right">
            <div class="admin-user-box">
                <span class="admin-user-label">Administrador</span>
                <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong>
            </div>
        </div>
    </header>

    <section class="admin-grid">

        <section class="panel-admin form-panel">
            <div class="panel-header">
                <h2>Registrar artículo</h2>
                <p>Publica noticias, reseñas y tutoriales</p>
            </div>

            <form action="php/guardar_articulo.php" method="POST" class="form-admin" enctype="multipart/form-data">
                <div class="grupo-input">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" required>
                </div>

                <div class="grupo-input">
                    <label for="resumen">Resumen</label>
                    <textarea name="resumen" id="resumen" rows="3" required></textarea>
                </div>

                <div class="grupo-input">
                    <label for="contenido">Contenido</label>
                    <textarea name="contenido" id="contenido" rows="8" required></textarea>
                </div>

                <div class="fila-formulario">
                    <div class="grupo-input">
                        <label for="categoria">Categoría</label>
                        <input type="text" name="categoria" id="categoria" placeholder="ia, hardware, software..." required>
                    </div>

                    <div class="grupo-input">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" required>
                            <option value="publicado">Publicado</option>
                            <option value="borrador">Borrador</option>
                        </select>
                    </div>
                </div>

                <div class="grupo-input">
                    <label for="imagen">Imagen del artículo</label>
                    <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.webp" required>
                </div>

                <button type="submit" class="btn-principal">Guardar artículo</button>
            </form>
        </section>

        <section class="panel-admin tabla-panel">
            <div class="panel-header">
                <h2>Listado de artículos</h2>
                <p>Consulta y administra publicaciones</p>
            </div>

            <?php if ($resultado->num_rows > 0): ?>
                <div class="tabla-articulos">
                    <div class="fila encabezado">
                        <span>ID</span>
                        <span>Título</span>
                        <span>Categoría</span>
                        <span>Estado</span>
                        <span>Imagen</span>
                        <span>Acciones</span>
                    </div>

                    <?php while ($articulo = $resultado->fetch_assoc()): ?>
                        <div class="fila">
                            <span><?php echo $articulo["id"]; ?></span>
                            <span><?php echo htmlspecialchars($articulo["titulo"]); ?></span>
                            <span><?php echo htmlspecialchars($articulo["categoria"]); ?></span>
                            <span><?php echo htmlspecialchars($articulo["estado"]); ?></span>
                            <span class="ruta-img">
                                <img src="<?php echo htmlspecialchars($articulo["imagen"]); ?>" alt="Artículo" class="miniatura-admin">
                            </span>
                            <span class="acciones">
                                <a class="btn-editar" href="editar_articulo.php?id=<?php echo $articulo["id"]; ?>">Editar</a>

                                    <a class="btn-eliminar" 
                                        href="php/eliminar_articulo.php?id=<?php echo $articulo["id"]; ?>" 
                                        onclick="return confirm('¿Eliminar este artículo?')">
                                        Eliminar
                                    </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="sin-registros">
                    <p>No hay artículos registrados.</p>
                </div>
            <?php endif; ?>
        </section>

    </section>
</main>

<script src="js/admin_articulos.js"></script>
</body>
</html>
<?php $conn->close(); ?>