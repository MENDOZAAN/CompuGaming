<?php
require_once 'models/UserModel.php';

class LoginController {
    public function index() {
        require 'views/login/index.php';
    }

    public function autenticar() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuario = UserModel::getByUsername($username);
        
        

        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($usuario['estado'] == 1) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: " . BASE_URL . "/admin");
                exit;
            } else {
                echo "Cuenta inactiva.";
            }
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    }
}
