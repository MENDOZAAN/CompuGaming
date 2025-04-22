<?php
require_once 'config/database.php';

class UserModel {

    // Obtener usuario por username
    class UserModel {
        public static function getByUsername($username) {
            global $pdo;
    
            $stmt = $pdo->prepare("SELECT * FROM users WHERE nombre_usuario = ? LIMIT 1");
            $stmt->execute([$username]);
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    
    

    // Verificar si existe un usuario
    public static function exists($username) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchColumn() > 0;
    }
}
?>