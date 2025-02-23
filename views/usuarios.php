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