<?php
require_once __DIR__ . '/../config/database.php'; // Esto carga $pdo

class Usuario
{
    public static function obtenerTodos()
    {
        global $pdo;

        $sql = "SELECT * FROM usuarios";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function insertar($data)
    {
        global $pdo;

        try {
            $sql = "INSERT INTO usuarios (nombre, apellido, nombre_usuario, password, rol, estado)
                    VALUES (:nombre, :apellido, :nombre_usuario, :password, :rol, :estado)";

            $stmt = $pdo->prepare($sql);
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            return $stmt->execute([
                ':nombre' => $data['nombre'],
                ':apellido' => $data['apellido'],
                ':nombre_usuario' => $data['nombre_usuario'],
                ':password' => $data['password'],
                ':rol' => $data['rol'],
                ':estado' => $data['estado']
            ]);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/../logs/error_insertar.log', $e->getMessage());
            return false;
        }
    }
    public static function verificarPassword($id, $password_actual)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario && password_verify($password_actual, $usuario['password']);
    }

    public static function actualizar($data)
    {
        global $pdo;

        $campos = "nombre = :nombre, apellido = :apellido, nombre_usuario = :nombre_usuario, rol = :rol, estado = :estado";
        $params = [
            ':id' => $data['id'],
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'],
            ':nombre_usuario' => $data['nombre_usuario'],
            ':rol' => $data['rol'],
            ':estado' => $data['estado']
        ];

        if (!empty($data['password'])) {
            $campos .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql = "UPDATE usuarios SET $campos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }
    public static function eliminar($id)
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/../logs/error_eliminar.log', $e->getMessage());
            return false;
        }
    }
}
