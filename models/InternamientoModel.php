<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class InternamientoModel {
    public static function insertar($datos) {
        global $pdo;

        $sql = "INSERT INTO internamientos 
            (cliente_id, tipo_equipo, marca_id, modelo, serie, accesorios, falla_reportada, servicio_id, precio_total, adelanto)
            VALUES 
            (:cliente_id, :tipo_equipo, :marca_id, :modelo, :serie, :accesorios, :falla_reportada, :servicio_id, :precio_total, :adelanto)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':cliente_id' => $datos['cliente_id'],
            ':tipo_equipo' => $datos['tipo_equipo'],
            ':marca_id' => $datos['marca_id'],
            ':modelo' => $datos['modelo'],
            ':serie' => $datos['serie'],
            ':accesorios' => $datos['accesorios'],
            ':falla_reportada' => $datos['falla_reportada'],
            ':servicio_id' => $datos['servicio_id'],
            ':precio_total' => $datos['precio_total'],
            ':adelanto' => $datos['adelanto']
        ]);
    }
}
