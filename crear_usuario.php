<?php
require_once 'config/database.php';

$nombre = "Marlon";
$apellido = "Canta";
$nombre_usuario = "marlon";
$password_plano = "marlon"; 
$rol_id = 1;
$estado = 1;

$password_hash = password_hash($password_plano, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, nombre_usuario, password, estado, rol_id) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $apellido, $nombre_usuario, $password_hash, $estado, $rol_id]);

    echo "✅ Usuario creado correctamente. Ahora puedes iniciar sesión con el usuario: <strong>$nombre_usuario</strong> y contraseña: <strong>$password_plano</strong>";
} catch (PDOException $e) {
    echo "❌ Error al crear el usuario: " . $e->getMessage();
}
