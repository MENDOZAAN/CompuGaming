<?php
session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validación: Evitar que los campos estén vacíos
    if (empty($nombre_usuario) || empty($password)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: /compugaming/login");
        exit();
    }

    // Consulta segura
    $stmt = $pdo->prepare("SELECT id, nombre, apellido, password, estado FROM usuarios WHERE nombre_usuario = ?");
    $stmt->execute([$nombre_usuario]);
    $usuario = $stmt->fetch();

    // Verificar credenciales
    if ($usuario && password_verify($password, $usuario['password'])) {
        if ($usuario['estado']) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'] . " " . $usuario['apellido'];
            header("Location: /compugaming/index"); // Redirige al panel principal
            exit();
        } else {
            $_SESSION['error'] = "Tu cuenta está desactivada.";
        }
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
    }

    header("Location: /compugaming/login");
    exit();
}
?>
