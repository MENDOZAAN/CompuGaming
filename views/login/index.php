<?php
require_once '../../routes.php';
require_once '../../config/config.php';
require_once '../../config/database.php';

?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <img src="../../assets/img/Logo grande.png" alt="Logo" style="height: 60px;">
            <h3 class="mt-3" style="font-family: var(--fuente-logo);">Iniciar sesión</h3>
        </div>

        <form method="post" action="<?= URL_WEB ?>/login/autenticar">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-danger">Ingresar</button>
            </div>
        </form>
    </div>
</div>