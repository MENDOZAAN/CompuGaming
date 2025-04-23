<?php
$url = $_GET['url'] ?? 'login/index';
$params = explode('/', filter_var($url, FILTER_SANITIZE_URL));

$controllerName = ucfirst($params[0]) . 'Controller';
$method = $params[1] ?? 'index';
$args = array_slice($params, 2);

$controllerPath = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $args);
    } else {
        echo "❌ Método '$method' no encontrado.";
    }
} else {
    echo "❌ Controlador '$controllerName' no encontrado.";
}

