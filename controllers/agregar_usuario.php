<?php
require_once("../config/db.php"); 

header("Content-Type: application/json");

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recibir datos del formulario
        $nombre = trim($_POST["nombre"]);
        $apellido = trim($_POST["apellido"]);
        $usuario = trim($_POST["usuario"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hashear la contraseña
        $rol = intval($_POST["rol"]);
        $estado = 1; // Activo por defecto

        // Validar que los campos no estén vacíos
        if (empty($nombre) || empty($apellido) || empty($usuario) || empty($_POST["password"]) || empty($rol)) {
            echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
            exit;
        }

        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$usuario]);
        if ($stmt->fetch()) {
            echo json_encode(["success" => false, "message" => "El nombre de usuario ya está en uso."]);
            exit;
        }

        // Insertar el nuevo usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, nombre_usuario, password, rol_id, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $usuario, $password, $rol, $estado]);

        echo json_encode(["success" => true, "message" => "Usuario agregado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Método no permitido."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
