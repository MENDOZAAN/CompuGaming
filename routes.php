<?
$controllerName = ucfirst($params[0]) . 'Controller'; // LoginController
$method = $params[1] ?? 'index';

$controllerPath = "controllers/{$controllerName}.php";


?>
