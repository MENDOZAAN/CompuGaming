<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class InternamientoModel
{
    public static function generarCorrelativo()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) + 1 AS total FROM internamientos");
        $correlativo = "CGS-" . str_pad($stmt->fetchColumn(), 5, "0", STR_PAD_LEFT);
        return $correlativo;
    }

    public static function registrarInternamiento($cliente_id, $observaciones)
    {
        global $pdo;
        $correlativo = self::generarCorrelativo();
        $sql = "INSERT INTO internamientos (correlativo, cliente_id, observaciones) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$correlativo, $cliente_id, $observaciones]);

        return $pdo->lastInsertId();
    }

    public static function registrarEquipos($internamiento_id, $equipos)
    {
        global $pdo;
        $sql = "INSERT INTO equipos_internamiento 
            (internamiento_id, tipo_equipo, marca, modelo, nro_serie, accesorios, falla_reportada, servicio_solicitado, precio_aprox)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        foreach ($equipos as $eq) {
            $stmt->execute([
                $internamiento_id,
                $eq['tipo_equipo'],
                $eq['marca'],
                $eq['modelo'],
                $eq['nro_serie'],
                $eq['accesorios'],
                $eq['falla_reportada'],
                $eq['servicio'],
                $eq['precio'] ?: 0
            ]);
        }
    }
}
