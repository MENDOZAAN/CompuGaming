<?php
require_once __DIR__ . '/models/UsuarioModel.php';

$insertado = Usuario::insertar([
    'nombre' => 'Prueba',
    'apellido' => 'Test',
    'nombre_usuario' => 'tester',
    'password' => '123456',
    'rol_id' => 1,
    'estado' => 1
]);

var_dump($insertado);
