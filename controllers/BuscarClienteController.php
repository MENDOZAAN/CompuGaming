<?php
require_once __DIR__ . '/../models/ClienteModel.php';
header('Content-Type: application/json');

$dni_ruc = $_POST['dni_ruc'] ?? '';

$cliente = ClienteModel::buscarPorDniRuc($dni_ruc);

if ($cliente) {
    echo json_encode([
        'status' => 'ok',
        'id' => $cliente['id'],
        'nombre_completo' => $cliente['razon_social'] ?: $cliente['nombres'] . ' ' . $cliente['apellidos']
    ]);
} else {
    echo json_encode(['status' => 'no_encontrado']);
}
