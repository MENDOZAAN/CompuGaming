<?php
require_once '../models/UserModel.php';
include_once '../config/config.php';



class LoginController {
    public function index() {
        require_once 'views/login/index.php';
    }

    public function autenticar() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $usuario = UserModel::getByUsername($username);

        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($usuario['estado'] == 1) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: " . URL_WEB . "/admin/index.php");
                exit;
            } else {
                echo "Cuenta inactiva.";
            }
        } else {
            echo "Credenciales incorrectas.";
        }
    }
}
