<?php
require_once __DIR__ . '/../models/ClienteModel.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Editar cliente
        if (isset($_POST['editar_id'])) {
            $id = $_POST['editar_id'];
            $data = [
                'tipo_doc' => $_POST['tipo_doc'] ?? '',
                'dni_ruc' => $_POST['dni_ruc'] ?? '',
                'nombres' => $_POST['nombres'] ?? '',
                'apellidos' => $_POST['apellidos'] ?? '',
                'razon_social' => $_POST['razon_social'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'id' => $id 
            ];
        
            $ok = ClienteModel::actualizar($data);
        
            echo json_encode([
                'status' => $ok ? 'ok' : 'error'
            ]);
            exit;
        }

        // Si llega un 'eliminar', se elimina por ID
        if (isset($_POST['eliminar'])) {
            $id = $_POST['eliminar'];
            $ok = ClienteModel::eliminar($id);
            echo json_encode(['status' => $ok ? 'ok' : 'error']);
            exit;
        }

        // 👉 Insertar nuevo cliente
        $dni_ruc = $_POST['dni_ruc'] ?? '';

        // Verificar si ya existe
        if (ClienteModel::existe($dni_ruc)) {
            echo json_encode([
                'status' => 'duplicado',
                'message' => 'El cliente ya está registrado.'
            ]);
            exit;
        }

        // Datos a insertar
        $data = [
            'tipo_doc' => $_POST['tipo_doc'] ?? '',
            'dni_ruc' => $dni_ruc,
            'nombres' => $_POST['nombres'] ?? '',
            'apellidos' => $_POST['apellidos'] ?? '',
            'razon_social' => $_POST['razon_social'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'correo' => $_POST['correo'] ?? ''
        ];

        $ok = ClienteModel::insertar($data);
        echo json_encode(['status' => $ok ? 'ok' : 'error']);
        exit;
    }
} catch (Throwable $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
