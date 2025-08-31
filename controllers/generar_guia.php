<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$internamiento_id = intval($_GET['id']);

// Obtener internamiento y cliente
$stmt = $pdo->prepare("SELECT 
    i.*, 
    c.tipo_doc, c.dni_ruc, c.nombres, c.apellidos, c.razon_social, c.telefono,
    u.nombre AS tecnico_nombre, u.apellido AS tecnico_apellido
FROM internamientos i
JOIN clientes c ON c.id = i.cliente_id
LEFT JOIN usuarios u ON u.id = i.tecnico_id
WHERE i.id = ?");

$stmt->execute([$internamiento_id]);
$internamiento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$internamiento) die("Internamiento no encontrado");

// Obtener equipos
$stmt2 = $pdo->prepare("SELECT * FROM equipos_internamiento WHERE internamiento_id = ?");
$stmt2->execute([$internamiento_id]);
$equipos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Construir HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }

        .info {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td width="65%">
                <img src="file://<?= realpath(__DIR__ . '/../assets/img/logo_negro_rojo.png'); ?>" height="45">
                <strong>COMPU GAMING STORE E.I.R.L.</strong><br>
                <small>Dirección Fiscal: Jr. Grau N° 874, El Tambo - Huancayo - Junín</small><br>
                <small>Sucursal: Av. Giráldez N° 274 Int. S-18 / S-07 - Huancayo</small><br>
                <small>Whatsapp: 977457951 / 925428541 / 924143694</small><br>
                <small>Correo: compugaming.store@gmail.com</small>
            </td>
            <td width="35%" align="right" style="border: 1px solid black; padding: 8px;">
                <div><strong>R.U.C. 20604235694</strong></div>
                <div><strong>GUÍA DE INTERNAMIENTO</strong></div>
                <div><strong>N° <?= $internamiento['correlativo'] ?></strong></div>
            </td>
        </tr>
    </table>

    <hr>

    <table width="100%" style="font-size: 12px; margin-top: 10px;">
        <tr>
            <td><strong>Cliente:</strong> <?= $internamiento['tipo_doc'] === 'DNI'
                                                ? $internamiento['nombres'] . ' ' . $internamiento['apellidos']
                                                : $internamiento['razon_social']; ?></td>
        </tr>
        <tr>
            <td><strong>DNI/RUC:</strong> <?= $internamiento['dni_ruc'] ?></td>

        <tr>
            <td><strong>Teléfono:</strong> <?= $internamiento['telefono'] ?></td>
        </tr>
        <tr>
            <td><strong>Fecha Ingreso:</strong> <?= date('d/m/Y H:i', strtotime($internamiento['fecha_ingreso'])) ?></td>
        </tr>
        <tr>
            <td><strong>Observaciones:</strong> <?= $internamiento['observaciones'] ?></td>
        </tr>
        <tr>
            <td><strong>Técnico Asignado:</strong> <?= $internamiento['tecnico_nombre'] . ' ' . $internamiento['tecnico_apellido'] ?></td>
        </tr>
    </table>


    <h4 style="margin-top: 15px;">Equipos Ingresados</h4>
    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 11px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>#</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Falla</th>
                <th>Servicio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipos as $i => $eq): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $eq['tipo_equipo'] ?></td>
                    <td><?= $eq['marca'] ?></td>
                    <td><?= $eq['modelo'] ?></td>
                    <td><?= $eq['nro_serie'] ?></td>
                    <td><?= $eq['falla_reportada'] ?></td>
                    <td><?= $eq['servicio_solicitado'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    $total = 0;
    foreach ($equipos as $eq) {
        $total += floatval($eq['precio_aprox']);
    }
    ?>

    <div class="bloque">
        <h4>Resumen</h4>
        <table>
            <tr>
                <td><strong>Total aproximado:</strong></td>
                <td>S/ <?= number_format($total, 2) ?></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 20px; text-align: left;">
        <img src="file://<?= realpath(__DIR__ . '/../assets/img/qr_internamiento.png'); ?>" width="90">
        <div style="font-size: 10px;">Código QR para seguimiento</div>
    </div>
</body>

</html>
<?php
$html = ob_get_clean();

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("guia_internamiento_{$internamiento['correlativo']}.pdf", ["Attachment" => false]);
