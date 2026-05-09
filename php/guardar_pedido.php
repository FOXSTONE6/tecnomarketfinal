<?php
session_start();
require_once "conexion.php";

header("Content-Type: application/json");

/* Verificar sesión */
if (!isset($_SESSION["usuario_id"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Debes iniciar sesión para finalizar la compra."
    ]);
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

/* Leer JSON enviado desde JS */
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || !isset($data["carrito"]) || !is_array($data["carrito"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibió información válida del carrito."
    ]);
    exit();
}

$carrito = $data["carrito"];

if (count($carrito) === 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "El carrito está vacío."
    ]);
    exit();
}

/* Calcular total */
$total = 0;
foreach ($carrito as $item) {
    $precio = floatval($item["precio"]);
    $cantidad = intval($item["cantidad"]);
    $subtotal = $precio * $cantidad;
    $total += $subtotal;
}

$conn->begin_transaction();

try {
    /* Insertar pedido */
    $sqlPedido = "INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)";
    $stmtPedido = $conn->prepare($sqlPedido);
    $stmtPedido->bind_param("id", $usuario_id, $total);

    if (!$stmtPedido->execute()) {
        throw new Exception("No se pudo registrar el pedido.");
    }

    $pedido_id = $conn->insert_id;

    /* Insertar detalle del pedido */
    $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, nombre_producto, precio, cantidad, subtotal)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmtDetalle = $conn->prepare($sqlDetalle);

    foreach ($carrito as $item) {
        $producto_id = intval($item["id"]);
        $nombre_producto = trim($item["nombre"]);
        $precio = floatval($item["precio"]);
        $cantidad = intval($item["cantidad"]);
        $subtotal = $precio * $cantidad;

        $stmtDetalle->bind_param(
            "iisdid",
            $pedido_id,
            $producto_id,
            $nombre_producto,
            $precio,
            $cantidad,
            $subtotal
        );

        if (!$stmtDetalle->execute()) {
            throw new Exception("No se pudo registrar el detalle del pedido.");
        }
    }

    $conn->commit();

    echo json_encode([
        "ok" => true,
        "mensaje" => "Pedido registrado correctamente.",
        "pedido_id" => $pedido_id
    ]);
} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        "ok" => false,
        "mensaje" => $e->getMessage()
    ]);
}

$conn->close();
?>