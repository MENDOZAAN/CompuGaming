<?php
require_once "../controllers/listar_usuarios.php";
?>

<?php include("../public/include/header.php"); ?>

<body>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-sm-6">
                        <h3>Lista de Usuarios</h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#agregarUsuarioModal">
                            <i class="ik ik-user-plus"></i> Agregar Usuario
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Barra de búsqueda en tiempo real -->
                    <input type="text" id="searchUserInput" class="form-control" placeholder="Buscar usuario..." style="max-width: 250px;">
                    <br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                                    <td><?php echo $usuario['estado'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                                    <td>
                                        <div style="display: flex; gap: 20px;">
                                            <!-- Botón Editar -->
                                            <a href="#" class="editarUsuarioBtn" data-id="<?= $usuario['id']; ?>">
                                                <i class="ik ik-edit"></i>
                                            </a>

                                            <!-- Botón Eliminar -->
                                            <a href="#" class="eliminarUsuarioBtn" data-id="<?= $usuario['id']; ?>">
                                                <i class="ik ik-trash" style="color: red;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- MODAL PARA AGREGAR USUARIO -->
            <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="agregarUsuarioLabel">
                                <i class="ik ik-user-plus"></i> Agregar Nuevo Usuario
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form id="agregarUsuarioForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="apellido" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre_usuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rol" class="form-label">Rol</label>
                                            <select class="form-control" id="rol" name="rol" required>
                                                <option value="">Seleccione un rol</option>
                                                <option value="Administrador">Administrador</option>
                                                <option value="Técnico">Técnico</option>
                                                <option value="Usuario">Usuario</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estado" class="form-label">Estado</label>
                                            <select class="form-control" id="estado" name="estado" required>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="ik ik-save"></i> Guardar Usuario
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script de búsqueda en tiempo real -->
    <script>
        document.getElementById("searchUserInput").addEventListener("keyup", function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll(".table tbody tr");

            rows.forEach(row => {
                let nombre = row.cells[0].textContent.toLowerCase();
                let apellido = row.cells[1].textContent.toLowerCase();
                let usuario = row.cells[2].textContent.toLowerCase();
                let rol = row.cells[3].textContent.toLowerCase();

                if (nombre.includes(input) || apellido.includes(input) || usuario.includes(input) || rol.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
    
</body>

</html>