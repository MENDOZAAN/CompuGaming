<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
class ClienteModel
{
    public static function insertar($datos)
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("INSERT INTO clientes 
            (tipo_doc, dni_ruc, nombres, apellidos, razon_social, direccion, telefono, correo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            return $stmt->execute([
                $datos['tipo_doc'],
                $datos['dni_ruc'],
                $datos['nombres'],
                $datos['apellidos'],
                $datos['razon_social'],
                $datos['direccion'],
                $datos['telefono'],
                $datos['correo']
            ]);
        } catch (PDOException $e) {
            error_log("Error al insertar cliente: " . $e->getMessage());  // <-- importante para revisar en logs
            return false;
        }
    }
    public static function existe($dni_ruc)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE dni_ruc = ?");
        $stmt->execute([$dni_ruc]);

        return $stmt->fetchColumn() > 0;
    }
    public static function obtenerTodos()
    {
        global $pdo;

        $stmt = $pdo->query("SELECT * FROM clientes ORDER BY fecha_registro DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function eliminar($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public static function actualizar($datos)
    {
        global $pdo;

        $sql = "UPDATE clientes SET 
                tipo_doc = :tipo_doc,
                dni_ruc = :dni_ruc,
                nombres = :nombres,
                apellidos = :apellidos,
                razon_social = :razon_social,
                direccion = :direccion,
                telefono = :telefono,
                correo = :correo
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':tipo_doc' => $datos['tipo_doc'],
            ':dni_ruc' => $datos['dni_ruc'],
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':razon_social' => $datos['razon_social'],
            ':direccion' => $datos['direccion'],
            ':telefono' => $datos['telefono'],
            ':correo' => $datos['correo'],
            ':id' => $datos['id'],
        ]);
    }
    public static function buscarPorDniRuc($dni_ruc)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE dni_ruc = ?");
        $stmt->execute([$dni_ruc]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
