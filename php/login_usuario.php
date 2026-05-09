<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
session_start();

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit();
}

$correo = trim($_POST["correo"] ?? "");
$password = trim($_POST["password"] ?? "");

if (empty($correo) || empty($password)) {
    echo "<script>alert('Completa todos los campos.'); window.location.href='../login.php';</script>";
    exit();
}

$sql = "SELECT id, nombres, apellidos, correo, telefono, password, rol 
        FROM usuarios 
        WHERE correo = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($password, $usuario["password"])) {

        session_regenerate_id(true);

        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["nombres"] = $usuario["nombres"];
        $_SESSION["apellidos"] = $usuario["apellidos"];
        $_SESSION["correo"] = $usuario["correo"];
        $_SESSION["rol"] = $usuario["rol"];

        header("Location: ../index.php");
        exit();
    }
}

echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href='../login.php';</script>";

$stmt->close();
$conn->close();
?>