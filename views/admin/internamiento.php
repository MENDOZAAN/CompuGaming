<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/ClienteModel.php';
require_once __DIR__ . '/../../models/MarcaModel.php';
require_once __DIR__ . '/../../models/TipoEquipoModel.php';
require_once __DIR__ . '/../../models/ServicioModel.php';

$servicios = ServicioModel::obtenerTodos();
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

            <!-- Modal Registrar Internamiento -->
            <div class="modal fade" id="agregarEquipoModal" tabindex="-1" aria-labelledby="agregarEquipoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="agregarEquipoLabel">
                                <i class="ik ik-monitor"></i> Registrar Internamiento
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="agregarEquipoForm">
                                <!-- Buscar cliente -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="buscar_dni_ruc">Buscar cliente por DNI o RUC</label>
                                        <div class="input-group">
                                            <input type="text" id="buscar_dni_ruc" class="form-control" placeholder="Ingrese DNI o RUC">
                                            <div class="input-group-append">
                                                <button id="btnBuscarClienteDB" type="button" class="btn btn-outline-primary">
                                                    <i class="ik ik-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">
                                            Cliente: <span id="clienteSeleccionado" class="text-success">Ninguno</span>
                                        </small>
                                        <input type="hidden" id="cliente_id" name="cliente_id">
                                    </div>
                                </div>

                                <hr>

                                <!-- Datos del equipo -->
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label for="tipo_equipo_id">Tipo de equipo</label>
                                        <select class="form-control" id="tipo_equipo_id" name="tipo_equipo_id">
                                            <option value="">Seleccione</option>
                                            <?php foreach ($tipos as $tipo): ?>
                                                <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="marca_id">Marca</label>
                                        <select class="form-control" id="marca_id" name="marca_id">
                                            <option value="">Seleccione</option>
                                            <?php foreach ($marcas as $marca): ?>
                                                <option value="<?= $marca['id'] ?>"><?= htmlspecialchars($marca['nombre']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="modelo">Modelo</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="serie">N° Serie</label>
                                        <input type="text" class="form-control" id="serie" name="serie">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="accesorios">Accesorios</label>
                                        <textarea class="form-control" id="accesorios" name="accesorios" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="falla_reportada">Falla reportada</label>
                                        <textarea class="form-control" id="falla_reportada" name="falla_reportada" rows="2"></textarea>
                                    </div>
                                </div>

                                <!-- Servicio y precio -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="servicio_id">Servicio</label>
                                        <select class="form-control" id="servicio_id" name="servicio_id" required>
                                            <option value="">Seleccione</option>
                                            <?php foreach ($servicios as $servicio): ?>
                                                <option value="<?= $servicio['id'] ?>"><?= htmlspecialchars($servicio['descripcion']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>

                                <!-- Botón Añadir equipo -->
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success btn-sm mb-2" id="btnAgregarEquipo">
                                            <i class="ik ik-plus"></i> Añadir equipo
                                        </button>
                                    </div>
                                </div>
                                <<div class="form-row mt-3">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Serie</th>
                                                    <th>Accesorios</th>
                                                    <th>Falla</th>
                                                    <th>Servicio</th>
                                                    <th>Precio (S/.)</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaEquiposBody">
                                                <!-- JS -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" class="text-right font-weight-bold">Total:</td>
                                                    <td id="totalPrecio" class="font-weight-bold">0.00</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-right font-weight-bold">Adelanto:</td>
                                                    <td colspan="2">
                                                        <input type="number" step="0.01" class="form-control" id="precio_equipo" name="precio_equipo" required>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                        </div>

                        <div class="d-grid mt-3 text-center">
                            <button type="submit" class="btn btn-dark btn-lg px-5">
                                <i class="ik ik-save"></i> Guardar Internamiento
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <style>
            .modal-xl {
                max-width: 90% !important;
            }

            #agregarEquipoModal .modal-body {
                padding: 1.5rem;
            }

            #tablaEquiposBody td {
                vertical-align: middle;
            }
        </style>


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