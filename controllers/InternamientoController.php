<?php
require_once __DIR__ . '/../models/InternamientoModel.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datos = [
            'cliente_id' => $_POST['cliente_id'] ?? null,
            'tipo_equipo' => $_POST['tipo_equipo'] ?? '',
            'marca_id' => $_POST['marca_id'] ?? null,
            'modelo' => $_POST['modelo'] ?? '',
            'serie' => $_POST['serie'] ?? '',
            'accesorios' => $_POST['accesorios'] ?? '',
            'falla_reportada' => $_POST['falla_reportada'] ?? '',
            'servicio_id' => $_POST['servicio_id'] ?? null,
            'precio_total' => $_POST['precio_total'] ?? 0,
            'adelanto' => $_POST['adelanto'] ?? 0
        ];

        $ok = InternamientoModel::insertar($datos);

        echo json_encode([
            'status' => $ok ? 'ok' : 'error'
        ]);
        exit;
    }
} catch (Throwable $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
