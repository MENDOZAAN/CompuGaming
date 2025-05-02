<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/UsuarioModel.php';
session_start();

header('Content-Type: application/json');

try {
    file_put_contents(__DIR__ . '/../logs/post_debug.log', print_r($_POST, true));

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'crear') {
            $resultado = Usuario::insertar([
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'nombre_usuario' => trim($_POST['nombre_usuario'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'rol' => trim($_POST['rol'] ?? ''),
                'estado' => $_POST['estado'] ?? '1'
            ]);

            echo json_encode([
                'status' => $resultado ? 'ok' : 'error',
                'message' => $resultado ? '' : 'No se pudo insertar.'
            ]);
            exit;
        }

        if ($accion === 'editar') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'ID faltante.']);
                exit;
            }

            $datos = [
                'id' => $id,
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'nombre_usuario' => trim($_POST['nombre_usuario'] ?? ''),
                'rol' => trim($_POST['rol'] ?? ''),
                'estado' => $_POST['estado'] ?? '1'
            ];

            $cambiarPassword = !empty($_POST['password_actual']) && !empty($_POST['password_nueva']);

            if ($cambiarPassword) {
                if (!Usuario::verificarPassword($id, $_POST['password_actual'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Contraseña actual incorrecta.']);
                    exit;
                }
                $datos['password'] = $_POST['password_nueva'];
            }

            $resultado = Usuario::actualizar($datos);

            echo json_encode([
                'status' => $resultado ? 'ok' : 'error',
                'message' => $resultado ? '' : 'No se pudo actualizar.'
            ]);
            exit;
        }

        if ($accion === 'eliminar') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado.']);
                exit;
            }

            if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $id) {
                echo json_encode(['status' => 'error', 'message' => 'No puedes eliminar al usuario con sesión activa.']);
                exit;
            }

            $resultado = Usuario::eliminar($id);
            echo json_encode([
                'status' => $resultado ? 'ok' : 'error',
                'message' => $resultado ? '' : 'No se pudo eliminar el usuario.'
            ]);
            exit;
        }

        echo json_encode(['status' => 'error', 'message' => 'Acción inválida.']);
    }
} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error del servidor: ' . $e->getMessage()]);
}
