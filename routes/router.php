<?php
session_start();

// Obtiene la ruta desde la URL
$request = $_SERVER['REQUEST_URI'];
$basePath = '/compugaming'; // Ruta base de tu proyecto
$route = str_replace($basePath, '', $request);
$route = explode('?', $route)[0]; // Elimina parámetros GET

// Rutas
switch ($route) {
    case '/login':
        require '../views/login.php';
        break;

    case '/auth/login':
        require '../controllers/LoginController.php';
        break;

    case '/':
    case '/index':
        require '../views/index.php';
        break;

    default:
        echo "404 - Página no encontrada";
        break;
}
?>
