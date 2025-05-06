<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['cliente_id']) || !is_array($data['equipos'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

$pdo->beginTransaction();

try {
    // Insertar internamiento principal
    $stmt = $pdo->prepare("INSERT INTO internamientos (cliente_id, fecha, adelanto) VALUES (?, NOW(), ?)");
    $stmt->execute([
        $data['cliente_id'],
        $data['adelanto'] ?? 0
    ]);

    $internamiento_id = $pdo->lastInsertId();

    // Insertar cada equipo asociado
    $stmtEquipo = $pdo->prepare("
        INSERT INTO equipos_internamiento (
            internamiento_id, tipo_equipo_id, marca_id, modelo, serie,
            accesorios, falla_reportada, servicio_id, precio
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($data['equipos'] as $eq) {
        $stmtEquipo->execute([
            $internamiento_id,
            $eq['tipo_id'],
            $eq['marca_id'],
            $eq['modelo'],
            $eq['serie'],
            $eq['accesorios'],
            $eq['falla'],
            $eq['servicio_id'],
            $eq['precio']
        ]);
    }

    $pdo->commit();

    echo json_encode(['status' => 'ok', 'internamiento_id' => $internamiento_id]);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Error al registrar internamiento: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar']);
}
