<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['imagen']) || !isset($_POST['equipo_id'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'mensaje' => 'Datos incompletos']);
        exit;
    }

    $equipo_id = intval($_POST['equipo_id']);
    $imagen = $_FILES['imagen'];

    // Validar tipo permitido
    $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($imagen['type'], $permitidos)) {
        echo json_encode(['status' => 'error', 'mensaje' => 'Formato no permitido']);
        exit;
    }

    // Crear carpeta si no existe
    $carpeta = __DIR__ . '/../uploads/equipos';
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    // Guardar imagen con nombre único
    $nombre_archivo = uniqid('eq_', true) . '.' . pathinfo($imagen['name'], PATHINFO_EXTENSION);
    $ruta_destino = $carpeta . '/' . $nombre_archivo;

    if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
        try {
            // Guardar ruta en base de datos
            $stmt = $pdo->prepare("INSERT INTO imagenes_equipo (equipo_id, ruta_imagen, fecha_subida) VALUES (?, ?, NOW())");
            $stmt->execute([$equipo_id, 'uploads/equipos/' . $nombre_archivo]);

            echo json_encode(['status' => 'ok', 'ruta' => 'uploads/equipos/' . $nombre_archivo]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'mensaje' => 'Error en BD: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo mover el archivo']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'mensaje' => 'Método no permitido']);
}
