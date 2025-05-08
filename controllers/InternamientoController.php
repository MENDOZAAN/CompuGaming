<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/InternamientoModel.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar_internamiento') {
    try {
        $id = intval($_POST['id']);
        $observaciones = trim($_POST['observaciones']);
        $tecnico_id = !empty($_POST['tecnico_id']) ? intval($_POST['tecnico_id']) : null;
        $estado = trim($_POST['estado_general']);

        $stmt = $pdo->prepare("UPDATE internamientos SET observaciones = ?, tecnico_id = ?, estado_general = ? WHERE id = ?");
        $stmt->execute([$observaciones, $tecnico_id, $estado, $id]);

        echo json_encode(['status' => 'ok']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
    }
    exit;
}



try {
    // 1. Cliente existente o nuevo
    if (!empty($_POST['cliente_id'])) {
        $cliente_id = $_POST['cliente_id'];
    } else {
        $dni_ruc = trim($_POST['nuevo_dni_ruc']);
        $nombres = trim($_POST['nuevo_nombres']);
        $apellidos = trim($_POST['nuevo_apellidos']);

        if (!$dni_ruc || (!$nombres && !$apellidos)) {
            throw new Exception('Datos incompletos para registrar un nuevo cliente.');
        }

        $tipo_doc = strlen($dni_ruc) == 8 ? 'DNI' : 'RUC';
        $datos_cliente = [
            'tipo_doc' => $tipo_doc,
            'dni_ruc' => $dni_ruc,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'razon_social' => '',
            'direccion' => '',
            'telefono' => '',
            'correo' => ''
        ];
        
        $exito = ClienteModel::insertar($datos_cliente);
        
        if (!$exito) {
            throw new Exception('No se pudo registrar el nuevo cliente.');
        }
        
        // Obtener el ID recién insertado
        global $pdo;
        $cliente_id = $pdo->lastInsertId();
        
        
    }

    // 2. Registrar internamiento
    $observaciones = trim($_POST['observaciones']);
    $internamiento_id = InternamientoModel::registrarInternamiento($cliente_id, $observaciones);

    // 3. Preparar equipos
    $equipos = [];
    foreach ($_POST['tipo_equipo'] as $i => $tipo) {
        $equipos[] = [
            'tipo_equipo' => $tipo,
            'marca' => $_POST['marca'][$i],
            'modelo' => $_POST['modelo'][$i],
            'nro_serie' => $_POST['nro_serie'][$i],
            'accesorios' => $_POST['accesorios'][$i],
            'falla_reportada' => $_POST['falla_reportada'][$i],
            'servicio' => $_POST['servicio'][$i],
            'precio' => $_POST['precio'][$i] ?? 0
        ];
    }

    InternamientoModel::registrarEquipos($internamiento_id, $equipos);

    // 4. Redirigir o mostrar éxito
    header('Location: ' . BASE_URL . '/views/admin/internamiento.php?success=1');
    exit;

} catch (Exception $e) {
    echo "<h4>Error:</h4><p>" . $e->getMessage() . "</p>";
    echo "<a href='javascript:history.back()'>← Volver</a>";
}
