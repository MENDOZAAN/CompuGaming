<?php
require_once __DIR__ . '/../../config/config.php'; // se carga UNA vez
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
require_once __DIR__ . '/../../models/UsuarioModel.php';
$usuarios = Usuario::obtenerTodos();



include __DIR__ . '/../../includes/header.php';
?>

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
                                            <a href="#" class="editarUsuarioBtn"
                                                data-id="<?= $usuario['id']; ?>"
                                                data-nombre="<?= htmlspecialchars($usuario['nombre']); ?>"
                                                data-apellido="<?= htmlspecialchars($usuario['apellido']); ?>"
                                                data-usuario="<?= htmlspecialchars($usuario['nombre_usuario']); ?>"
                                                data-rol="<?= htmlspecialchars($usuario['rol']); ?>"
                                                data-estado="<?= $usuario['estado']; ?>">
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
            <div id="noResultsMessage" style="display: none; text-align: center; margin-top: 20px;">
                <p class="text-muted">No se encontraron resultados.</p>
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
                                                <option value="Admin">Admin</option>
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

            <!-- MODAL PARA EDITAR USUARIO -->
            <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="editarUsuarioLabel">
                                <i class="ik ik-user"></i> Editar Usuario
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form id="editarUsuarioForm">
                                <input type="hidden" name="id" id="editar_id">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editar_nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editar_apellido" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="editar_apellido" name="apellido" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="editar_nombre_usuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="editar_nombre_usuario" name="nombre_usuario" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editar_rol" class="form-label">Rol</label>
                                    <select class="form-control" id="editar_rol" name="rol" required>
                                        <option value="Admin">Admin</option>
                                        <option value="Usuario">Usuario</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="editar_estado" class="form-label">Estado</label>
                                    <select class="form-control" id="editar_estado" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>

                                <!-- Cambiar contraseña -->
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="togglePasswordFields">
                                    <label class="form-check-label" for="togglePasswordFields">¿Cambiar contraseña?</label>
                                </div>

                                <div id="passwordFields" style="display: none;">
                                    <div class="mb-3">
                                        <label for="editar_password_actual" class="form-label">Contraseña Actual</label>
                                        <input type="password" class="form-control" id="editar_password_actual" name="password_actual">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editar_password_nueva" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="editar_password_nueva" name="password_nueva">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="ik ik-save"></i> Actualizar Usuario
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- busqueda -->
    <script>
        const input = document.getElementById("searchUserInput");
        const mensaje = document.getElementById("noResultsMessage");

        input.addEventListener("keyup", function() {
            const filtro = this.value.toLowerCase().trim();
            const filas = document.querySelectorAll(".table tbody tr");

            let encontrados = 0;

            filas.forEach(fila => {
                const columnas = fila.querySelectorAll("td");
                const coincide = Array.from(columnas).some(col =>
                    col.textContent.toLowerCase().includes(filtro)
                );

                if (coincide) {
                    fila.style.display = "";
                    encontrados++;
                } else {
                    fila.style.display = "none";
                }
            });

            // Mostrar o ocultar mensaje según resultados
            mensaje.style.display = (encontrados === 0) ? "block" : "none";
        });
    </script>
    <!-- agregar usuario -->
    <script>
        document.getElementById("agregarUsuarioForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("accion", "crear");

            fetch("<?= BASE_URL ?>/controllers/UsuarioController.php", {
                    method: "POST",
                    body: formData
                })
                .then(async res => {
                    const text = await res.text();
                    console.log("Respuesta cruda del servidor:", text); // Para depurar

                    try {
                        const data = JSON.parse(text);
                        if (data.status === "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario agregado correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload(); // Recargar tabla
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al guardar',
                                text: data.message || 'No se pudo insertar el usuario.'
                            });
                        }
                    } catch (err) {
                        console.error("Error al convertir JSON:", err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error inesperado',
                            text: 'Respuesta inválida del servidor'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error de red o conexión:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo comunicar con el servidor.'
                    });
                });
        });
    </script>

    <!-- editar usuario -->
    <script>
        // Mostrar/ocultar los campos de contraseña
        document.getElementById('togglePasswordFields').addEventListener('change', function() {
            const campos = document.getElementById('passwordFields');
            campos.style.display = this.checked ? 'block' : 'none';
        });

        // Capturar clic en el botón de editar
        document.querySelectorAll('.editarUsuarioBtn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                // Obtener los valores desde los atributos del botón
                const id = this.dataset.id;
                const nombre = this.dataset.nombre;
                const apellido = this.dataset.apellido;
                const usuario = this.dataset.usuario;
                const rol = this.dataset.rol;
                const estado = this.dataset.estado;

                // Asignar los valores a los campos del modal
                document.getElementById('editar_id').value = id;
                document.getElementById('editar_nombre').value = nombre;
                document.getElementById('editar_apellido').value = apellido;
                document.getElementById('editar_nombre_usuario').value = usuario;
                document.getElementById('editar_rol').value = rol;
                document.getElementById('editar_estado').value = estado;

                // Ocultar campos de contraseña por defecto
                document.getElementById('togglePasswordFields').checked = false;
                document.getElementById('passwordFields').style.display = 'none';
                document.getElementById('editar_password_actual').value = '';
                document.getElementById('editar_password_nueva').value = '';

                // Mostrar el modal con Bootstrap 5
                const modal = new bootstrap.Modal(document.getElementById('editarUsuarioModal'));
                modal.show();
            });
        });
    </script>



    <script>
        $('#agregarUsuarioModal').on('hidden.bs.modal', function() {
            const form = document.getElementById("agregarUsuarioForm");
            form.reset();
            delete form.dataset.accion;
            delete form.dataset.id;

            document.getElementById("modalUsuarioTitulo").textContent = "Editar Usuario";
            document.getElementById("btnGuardarUsuario").innerHTML = '<i class="ik ik-save"></i> Guardar Usuario';
        });
    </script>
    <script>
        document.getElementById('togglePasswordFields').addEventListener('change', function() {
            const fields = document.getElementById('passwordFields');
            fields.style.display = this.checked ? 'block' : 'none';
        });
    </script>
    <script>
        document.getElementById("editarUsuarioForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            formData.append("accion", "editar");

            fetch("<?= BASE_URL ?>/controllers/UsuarioController.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario actualizado',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al actualizar',
                            text: data.message || 'No se pudo actualizar el usuario.'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error en el servidor:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'No se pudo conectar con el servidor.'
                    });
                });
        });
    </script>

    <!-- elimina usuario -->
    <script>
        document.querySelectorAll('.eliminarUsuarioBtn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.dataset.id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará al usuario permanentemente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('accion', 'eliminar');
                        formData.append('id', userId);

                        fetch("<?= BASE_URL ?>/controllers/UsuarioController.php", {
                                method: "POST",
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'ok') {
                                    Swal.fire('Eliminado', 'El usuario fue eliminado.', 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(err => {
                                console.error('Error de red', err);
                                Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
                            });
                    }
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>