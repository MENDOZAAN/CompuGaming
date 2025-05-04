<?php
require_once __DIR__ . '/../../config/config.php'; // se carga UNA vez
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
require_once __DIR__ . '/../../models/ClienteModel.php';
$clientes = ClienteModel::obtenerTodos();

include __DIR__ . '/../../includes/header.php';
?>

<body>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-sm-6">
                        <h3>Lista de Clientes</h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#agregarClienteModal">
                            <i class="ik ik-user-plus"></i> Agregar Cliente / Empresa
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Barra de búsqueda en tiempo real -->
                    <input type="text" id="searchUserInput" class="form-control" placeholder="Buscar cliente..." style="max-width: 250px;">
                    <br>

                    <table class="table" id="tablaClientes">
                        <thead>
                            <tr>
                                <th>Tipo Doc</th>
                                <th>DNI/RUC</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Razón Social</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>
                        <tbody id="tbodyClientes">
                            <?php foreach ($clientes as $cliente) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($cliente['tipo_doc']) ?></td>
                                    <td><?= htmlspecialchars($cliente['dni_ruc']) ?></td>
                                    <td><?= htmlspecialchars($cliente['nombres']) ?></td>
                                    <td><?= htmlspecialchars($cliente['apellidos']) ?></td>
                                    <td><?= htmlspecialchars($cliente['razon_social']) ?></td>
                                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                                    <td><?= htmlspecialchars($cliente['correo']) ?></td>
                                    <td><?= (new DateTime($cliente['fecha_registro']))->format('d/m/Y H:i') ?></td>
                                    <td>
                                        <div style="display: flex; gap: 20px;">
                                            <!-- Botón Editar -->
                                            <a href="#" class="editarClienteBtn"
                                                data-id="<?= $cliente['id']; ?>"
                                                data-tipo="<?= htmlspecialchars($cliente['tipo_doc']); ?>"
                                                data-dni="<?= htmlspecialchars($cliente['dni_ruc']); ?>"
                                                data-nombres="<?= htmlspecialchars($cliente['nombres']); ?>"
                                                data-apellidos="<?= htmlspecialchars($cliente['apellidos']); ?>"
                                                data-razon="<?= htmlspecialchars($cliente['razon_social']); ?>"
                                                data-direccion="<?= htmlspecialchars($cliente['direccion']); ?>"
                                                data-telefono="<?= htmlspecialchars($cliente['telefono']); ?>"
                                                data-correo="<?= htmlspecialchars($cliente['correo']); ?>">
                                                <i class="ik ik-edit"></i>
                                            </a>

                                            <!-- Botón Eliminar -->
                                            <a href="#" class="eliminarClienteBtn" data-id="<?= $cliente['id']; ?>">
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

            <!-- MODAL PARA AGREGAR CLIENTE -->
            <div class="modal fade" id="agregarClienteModal" tabindex="-1" aria-labelledby="agregarClienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="agregarClienteLabel">
                                <i class="ik ik-user-plus"></i> Agregar Cliente / Empresa
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form id="agregarClienteForm">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="tipo_doc" class="form-label">Tipo de Documento</label>
                                        <select class="form-control" id="tipo_doc" name="tipo_doc" required>
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="dni_ruc" class="form-label">DNI o RUC</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="dni_ruc" name="dni_ruc" required>
                                            <div class="input-group-append ms-2">
                                                <button type="button" class="btn btn-secondary" id="btnBuscarCliente">
                                                    <i class="ik ik-search"></i> Buscar
                                                </button>
                                            </div>
                                            <div class="input-group-append ms-2">
                                                <button type="button" class="btn btn-outline-danger" id="btnLimpiarCampos">
                                                    <i class="ik ik-x"></i> Limpiar
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="razon_social" class="form-label">Razón Social (opcional para empresas)</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social">
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" autocomplete="off">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="correo" class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" id="correo" name="correo" autocomplete="off">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="ik ik-save"></i> Guardar Cliente
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Editar Cliente -->
            <div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="editarClienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="editarClienteLabel">
                                <i class="ik ik-user"></i> Editar Cliente / Empresa
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form id="editarClienteForm">
                                <input type="hidden" name="editar_id" id="editar_id">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="editar_tipo_doc" class="form-label">Tipo de Documento</label>
                                        <select class="form-control" id="editar_tipo_doc" name="tipo_doc" required>
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="editar_dni_ruc" class="form-label">DNI o RUC</label>
                                        <input type="text" class="form-control" id="editar_dni_ruc" name="dni_ruc" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editar_nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="editar_nombres" name="nombres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editar_apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="editar_apellidos" name="apellidos">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="editar_razon_social" class="form-label">Razón Social</label>
                                    <input type="text" class="form-control" id="editar_razon_social" name="razon_social">
                                </div>

                                <div class="mb-3">
                                    <label for="editar_direccion" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="editar_direccion" name="direccion" rows="2"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editar_telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="editar_telefono" name="telefono">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editar_correo" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="editar_correo" name="correo">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="ik ik-save"></i> Actualizar Cliente
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

    <!-- consulta API -->
    <script>
        const API_CONSULTA_BASE = "<?= API_CONSULTA_BASE ?>";
        const API_TOKEN = "<?= API_TOKEN ?>";

        const tipoDocSelect = document.getElementById('tipo_doc');
        const nombresInput = document.getElementById('nombres');
        const apellidosInput = document.getElementById('apellidos');
        const razonSocialInput = document.getElementById('razon_social');
        const direccionInput = document.getElementById('direccion');

        function actualizarCamposPorTipo(tipo) {
            if (tipo === 'DNI') {
                nombresInput.disabled = false;
                apellidosInput.disabled = false;
                razonSocialInput.disabled = true;
                direccionInput.disabled = true;
                razonSocialInput.value = '';
                direccionInput.value = '';
            } else if (tipo === 'RUC') {
                nombresInput.disabled = true;
                apellidosInput.disabled = true;
                razonSocialInput.disabled = false;
                direccionInput.disabled = false;
                nombresInput.value = '';
                apellidosInput.value = '';
            }
        }

        // Detectar cambio de tipo de documento
        tipoDocSelect.addEventListener('change', function() {
            actualizarCamposPorTipo(this.value);
        });

        // Al hacer clic en buscar
        document.getElementById('btnBuscarCliente').addEventListener('click', async function() {
            const tipo = tipoDocSelect.value;
            const nro = document.getElementById('dni_ruc').value.trim();

            if (!nro) return alert("Ingrese un número válido");

            if ((tipo === "DNI" && nro.length !== 8) || (tipo === "RUC" && nro.length !== 11)) {
                return alert("Número de documento inválido para el tipo seleccionado.");
            }

            const url = `${API_CONSULTA_BASE}/${tipo.toLowerCase()}/${nro}?token=${API_TOKEN}`;

            try {
                const res = await fetch(url);
                const data = await res.json();

                if (data.success !== false) {
                    if (tipo === "DNI") {
                        nombresInput.value = data.nombres || '';
                        apellidosInput.value = `${data.apellidoPaterno || ''} ${data.apellidoMaterno || ''}`.trim();
                    } else {
                        razonSocialInput.value = data.razonSocial || '';
                        direccionInput.value = data.direccion || '';
                    }
                } else {
                    alert("No se encontró información para ese documento.");
                }
            } catch (err) {
                console.error("Error al consultar API:", err);
                alert("Ocurrió un error al consultar el documento.");
            }
        });

        // Ejecutar una vez al cargar
        actualizarCamposPorTipo(tipoDocSelect.value);
    </script>

    <!-- limpiar y resetear campos -->
    <script>
        // Función para limpiar todos los campos
        function limpiarFormularioCliente() {
            document.getElementById('tipo_doc').value = 'DNI';
            document.getElementById('dni_ruc').value = '';
            document.getElementById('nombres').value = '';
            document.getElementById('apellidos').value = '';
            document.getElementById('razon_social').value = '';
            document.getElementById('direccion').value = '';
            document.getElementById('telefono').value = '';
            document.getElementById('correo').value = '';
            actualizarCamposPorTipo('DNI');
        }

        // Botón "Limpiar"
        document.getElementById('btnLimpiarCampos').addEventListener('click', limpiarFormularioCliente);

        // Al cerrar modal (usando Bootstrap evento ocultar)
        $('#agregarClienteModal').on('hidden.bs.modal', function() {
            limpiarFormularioCliente();
        });
    </script>

    <!-- agregar Cliente -->
    <script>
        document.getElementById('agregarClienteForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            try {
                const res = await fetch('<?= BASE_URL ?>/controllers/ClienteController.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (data.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente registrado',
                        text: 'Se guardó correctamente el cliente.',
                        confirmButtonColor: '#3085d6'
                    });

                    // Agregar a la tabla directamente
                    const nuevaFila = `
                        <tr>
                            <td>${formData.get('tipo_doc') || ''}</td>
                            <td>${formData.get('dni_ruc') || ''}</td>
                            <td>${formData.get('nombres') || ''}</td>
                            <td>${formData.get('apellidos') || ''}</td>
                            <td>${formData.get('razon_social') || ''}</td>
                            <td>${formData.get('telefono') || ''}</td>
                            <td>${formData.get('correo') || ''}</td>
                            <td>${new Date().toLocaleString('es-PE', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                            <td>
                                <i class="ik ik-edit"></i>
                                <i class="ik ik-trash text-danger"></i>
                            </td>
                        </tr>`;

                    document.getElementById('tbodyClientes').insertAdjacentHTML('afterbegin', nuevaFila);

                    form.reset();
                    $('#agregarClienteModal').modal('hide');

                } else if (data.status === 'duplicado') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cliente existente',
                        text: 'Ya hay un cliente registrado con ese DNI o RUC.',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al guardar el cliente.',
                    });
                }

            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: 'No se pudo procesar la solicitud.',
                });
            }
        });
    </script>
    <!-- eliminar cliente -->
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.eliminarClienteBtn')) {
                const btn = e.target.closest('.eliminarClienteBtn');
                const id = btn.dataset.id;

                Swal.fire({
                    title: '¿Eliminar cliente?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Sí, eliminar'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('eliminar', id);

                        const res = await fetch('<?= BASE_URL ?>/controllers/ClienteController.php', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await res.json();
                        if (data.status === 'ok') {
                            btn.closest('tr').remove();
                            Swal.fire('Eliminado', 'El cliente fue eliminado.', 'success');
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar el cliente.', 'error');
                        }
                    }
                });
            }
        });
    </script>

    <!-- editar cliente -->
    <script>
        // Abrir modal y rellenar datos
        document.querySelectorAll('.editarClienteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editar_id').value = this.dataset.id;
                document.getElementById('editar_tipo_doc').value = this.dataset.tipo;
                document.getElementById('editar_dni_ruc').value = this.dataset.dni;
                document.getElementById('editar_nombres').value = this.dataset.nombres;
                document.getElementById('editar_apellidos').value = this.dataset.apellidos;
                document.getElementById('editar_razon_social').value = this.dataset.razon;
                document.getElementById('editar_direccion').value = this.dataset.direccion;
                document.getElementById('editar_telefono').value = this.dataset.telefono;
                document.getElementById('editar_correo').value = this.dataset.correo;

                $('#editarClienteModal').modal('show');
            });
        });
        // Enviar actualización por AJAX
        document.getElementById('editarClienteForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('accion', 'actualizar');

            try {
                const res = await fetch('<?= BASE_URL ?>/controllers/ClienteController.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (data.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario actualizado',
                        showConfirmButton: false,
                        timer: 1300,
                        timerProgressBar: true
                    }).then(() => {
                        $('#editarClienteModal').modal('hide');
                        location.reload();
                    });


                } else {
                    Swal.fire('Error', 'No se pudo actualizar el cliente.', 'error');
                }

            } catch (err) {
                console.error(err);
                Swal.fire('Error', 'Hubo un problema en la solicitud.', 'error');
            }
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>