<?php
$carpeta = __DIR__ . '/uploads/equipos';

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$archivo = $carpeta . '/test.txt';

if (file_put_contents($archivo, 'prueba')) {
    echo '✔ PHP puede escribir en la carpeta.';
} else {
    echo '❌ No se pudo escribir en la carpeta.';
}
