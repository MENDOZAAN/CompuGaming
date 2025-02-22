<?php
require_once("../controllers/RolController.php");
?>

<?php include("../public/include/header.php"); ?>

<body>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-sm-6">
                        <h3>Lista de Roles</h3>
                    </div>
                    <!-- Botón para abrir el modal -->
                    <div class="col-sm-6 text-right">
                        <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#agregarRolModal" style="background-color: #6c757d; border-color: #6c757d;">
                            <i class="ik ik-user-plus"></i> Agregar Rol
                        </a>

                    </div>
                    <!-- Modal para agregar un rol -->
                    <div class="modal fade" id="agregarRolModal" tabindex="-1" role="dialog" aria-labelledby="agregarRolLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="agregarRolLabel">Agregar Nuevo Rol</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="agregarRolForm">
                                        <div class="form-group">
                                            <label for="nombreRol">Nombre del Rol</label>
                                            <input type="text" class="form-control" id="nombreRol" name="nombre" required>
                                        </div>
                                        <button type="submit" class="btn" style="background-color: #343a40; border-color: #343a40; color: white;">
                                            Guardar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="agregarRolModal" tabindex="-1" aria-labelledby="agregarRolLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="agregarRolLabel">Agregar Nuevo Rol</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formAgregarRol">
                                        <div class="mb-3">
                                            <label for="nombreRol" class="form-label">Nombre del Rol</label>
                                            <input type="text" class="form-control" id="nombreRol" name="nombreRol" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" form="formAgregarRol">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <!-- Barra de búsqueda -->
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar rol..." style="max-width: 250px;">
                    <br>
                    <table class="table" id="rolesTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($roles)) : ?>
                                <?php foreach ($roles as $rol) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($rol['nombre']); ?></td>
                                        <td><?= date("d/m/Y H:i:s", strtotime($rol['fecha_creacion'])); ?></td>
                                        <td>
                                            <div style="display: flex; gap: 20px;">
                                                <a href="editar.php?id=<?= $rol['id']; ?>">
                                                    <i class="ik ik-edit"></i>
                                                </a>
                                                <a href="eliminar.php?id=<?= $rol['id']; ?>">
                                                    <i class="ik ik-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay roles registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de búsqueda en tiempo real -->
    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll("#rolesTable tbody tr");

            rows.forEach(row => {
                let nombre = row.cells[0].textContent.toLowerCase();
                if (nombre.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>