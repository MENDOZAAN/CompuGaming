<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/ClienteModel.php';
require_once __DIR__ . '/../../models/MarcaModel.php';
require_once __DIR__ . '/../../models/TipoEquipoModel.php';

$tipos = TipoEquipoModel::obtenerTodos();
$marcas = MarcaModel::obtenerTodas();
$clientes = ClienteModel::obtenerTodos();

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

include __DIR__ . '/../../includes/header.php';
?>
<meta name="base-url" content="<?= BASE_URL ?>">

<meta name="api-base" content="<?= API_CONSULTA_BASE ?>">
<meta name="api-token" content="<?= API_TOKEN ?>">

<body>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-sm-6">
                        <h3>Equipos Ingresados</h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="#agregarEquipoModal" class="btn btn-secondary" data-toggle="modal">
                            <i class="ik ik-monitor"></i> Registrar Equipo
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <input type="text" id="searchEquipoInput" class="form-control" placeholder="Buscar equipo..." style="max-width: 250px;">
                    <br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listaEquipos">
                            <!-- Aquí se cargarán los equipos con PHP o AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL Registrar Internamiento de Equipo -->
            <div class="modal fade" id="agregarEquipoModal" tabindex="-1" aria-labelledby="agregarEquipoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="agregarEquipoLabel">
                                <i class="ik ik-monitor"></i> Registrar Internamiento de Equipo
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <form id="agregarEquipoForm">
                                <!-- Sección: Cliente -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="buscar_dni_ruc" class="form-label">Buscar cliente por DNI o RUC</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="buscar_dni_ruc" class="form-control" placeholder="Ingrese DNI o RUC">
                                            <button id="btnBuscarClienteDB" type="button" class="btn btn-outline-primary">
                                                <i class="ik ik-search"></i>
                                            </button>
                                            <!-- CORRECTO para Bootstrap 4 -->
                                            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#agregarClienteModal">
                                                <i class="ik ik-user-plus"></i>
                                            </button>


                                        </div>
                                        <p>Cliente seleccionado: <span id="clienteSeleccionado" class="text-success">Ninguno</span></p>
                                        <input type="hidden" id="cliente_id" name="cliente_id">
                                    </div>
                                </div>

                                <hr>

                                <!-- Sección: Información del equipo -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label d-flex justify-content-between align-items-center">
                                            Tipo de Equipo
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalAgregarTipo">
                                                <i class="ik ik-plus"></i>
                                            </button>
                                        </label>
                                        <select class="form-control mb-3" id="tipo_equipo_id" name="tipo_equipo_id" required>
                                            <option value="">Seleccione</option>
                                            <?php foreach ($tipos as $tipo): ?>
                                                <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label d-flex justify-content-between align-items-center">
                                            Marca
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalAgregarMarca">
                                                <i class="ik ik-plus"></i>
                                            </button>
                                        </label>
                                        <select class="form-control mb-3" id="marca_id" name="marca_id" required>
                                            <option value="">Seleccione</option>
                                            <?php foreach ($marcas as $marca): ?>
                                                <option value="<?= $marca['id'] ?>"><?= htmlspecialchars($marca['nombre']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="modelo" class="form-label">Modelo</label>
                                            <input type="text" class="form-control" id="modelo" name="modelo">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="serie" class="form-label">Número de Serie</label>
                                            <input type="text" class="form-control" id="serie" name="serie">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Sección: Descripción -->
                                <div class="mb-3">
                                    <label for="accesorios" class="form-label">Accesorios entregados</label>
                                    <textarea class="form-control" id="accesorios" name="accesorios" rows="2" placeholder="Cargador, cable, etc."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="falla_reportada" class="form-label">Falla reportada por el cliente</label>
                                    <textarea class="form-control" id="falla_reportada" name="falla_reportada" rows="2"></textarea>
                                </div>

                                <hr>

                                <!-- Sección: Servicio -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="servicio_id" class="form-label">Servicio</label>
                                        <select class="form-control mb-3" id="servicio_id" name="servicio_id" required>
                                            <option value="">Seleccione</option>
                                            <?php foreach ($servicios as $servicio): ?>
                                                <option value="<?= $servicio['id'] ?>"><?= htmlspecialchars($servicio['descripcion']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="precio_total" class="form-label">Precio total (S/.)</label>
                                        <input type="number" step="0.01" class="form-control" id="precio_total" name="precio_total" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="adelanto" class="form-label">Adelanto (S/.)</label>
                                        <input type="number" step="0.01" class="form-control" id="adelanto" name="adelanto">
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="ik ik-save"></i> Registrar Internamiento
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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


        </div>
    </div>
</body>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/assets/js/internamiento.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>/assets/js/buscarCliente.js"></script>
<script src="<?= BASE_URL ?>/assets/js/consultaClienteAPI.js"></script>
