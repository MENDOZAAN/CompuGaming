<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/ClienteModel.php';
require_once __DIR__ . '/../../models/MarcaModel.php';
require_once __DIR__ . '/../../models/TipoEquipoModel.php';
require_once __DIR__ . '/../../models/ServicioModel.php';

session_start();
if (!isset($_SESSION['usuario'])) {
  header('Location: ' . BASE_URL . '/login');
  exit;
}

// Obtener datos desde los modelos
$clientes = ClienteModel::obtenerTodos();
$marcas = array_column(MarcaModel::obtenerTodas(), 'nombre');
$tipos = array_column(TipoEquipoModel::obtenerTodos(), 'nombre');
$servicios = array_column(ServicioModel::obtenerTodos(), 'descripcion');

include __DIR__ . '/../../includes/header.php';
?>
<meta name="base-url" content="<?= BASE_URL ?>">
<meta name="api-base" content="<?= API_CONSULTA_BASE ?>">
<meta name="api-token" content="<?= API_TOKEN ?>">

<body>
  <div class="main-content">
    <div class="container-fluid">

      <!-- Encabezado -->
      <div class="mt-3 mb-4">
        <h4><i class="ik ik-hard-drive"></i> Nuevo Internamiento</h4>
      </div>

      <form action="<?= BASE_URL ?>/controllers/InternamientoController.php" method="POST">
      <!-- Cliente -->
        <div class="card">
          <div class="card-header bg-dark text-white">Datos del Cliente</div>
          <div class="card-body">
            <div class="form-group">
              <label for="cliente_id">Seleccionar cliente (por DNI/RUC):</label>
              <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">-- Cliente nuevo --</option>
                <?php foreach ($clientes as $c): ?>
                  <?php
                  $nombre = $c['tipo_doc'] === 'DNI'
                    ? $c['nombres'] . ' ' . $c['apellidos']
                    : $c['razon_social'];
                  ?>
                  <option value="<?= $c['id'] ?>">
                    <?= $c['tipo_doc'] ?> <?= $c['dni_ruc'] ?> - <?= $nombre ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="alert alert-info">
              Si el cliente no existe, llena los siguientes campos para registrarlo automáticamente:
            </div>

            <div class="form-row">
              <div class="col">
                <label>DNI o RUC</label>
                <input type="text" name="nuevo_dni_ruc" class="form-control">
              </div>
              <div class="col">
                <label>Nombres</label>
                <input type="text" name="nuevo_nombres" class="form-control">
              </div>
              <div class="col">
                <label>Apellidos / Razón social</label>
                <input type="text" name="nuevo_apellidos" class="form-control">
              </div>
            </div>
          </div>
        </div>

        <!-- Internamiento general -->
        <div class="card mt-3">
          <div class="card-header bg-dark text-white">Datos del Internamiento</div>
          <div class="card-body">
            <div class="form-group">
              <label for="observaciones">Observaciones generales</label>
              <textarea name="observaciones" id="observaciones" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>

        <!-- Equipos -->
        <div class="card mt-3">
          <div class="card-header bg-dark text-white d-flex justify-content-between">
            Equipos Ingresados
            <button type="button" class="btn btn-sm btn-success" id="agregarEquipo">+ Agregar equipo</button>
          </div>
          <div class="card-body" id="equiposContainer"></div>
        </div>

        <div class="text-right mt-3">
          <button type="submit" class="btn btn-primary">
            <i class="ik ik-save"></i> Guardar Internamiento
          </button>
        </div>
      </form>

      <script>
        const tipos = <?= json_encode($tipos); ?>;
        const marcas = <?= json_encode($marcas); ?>;
        const servicios = <?= json_encode($servicios); ?>;

        document.getElementById('agregarEquipo').addEventListener('click', () => {
          const div = document.createElement('div');
          div.classList.add('border', 'p-3', 'mb-3');

          div.innerHTML = `
                        <div class="form-row">
                            <div class="col-md-3">
                                <label>Tipo de equipo</label>
                                <select name="tipo_equipo[]" class="form-control">
                                    ${tipos.map(t => `<option>${t}</option>`).join('')}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Marca</label>
                                <select name="marca[]" class="form-control">
                                    ${marcas.map(m => `<option>${m}</option>`).join('')}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Modelo</label>
                                <input type="text" name="modelo[]" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>N° Serie</label>
                                <input type="text" name="nro_serie[]" class="form-control">
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col-md-4">
                                <label>Accesorios</label>
                                <input type="text" name="accesorios[]" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Falla reportada</label>
                                <input type="text" name="falla_reportada[]" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Servicio solicitado</label>
                                <select name="servicio[]" class="form-control">
                                    ${servicios.map(s => `<option>${s}</option>`).join('')}
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm quitarEquipo">&times;</button>
                            </div>
                        </div>
                    `;
          document.getElementById('equiposContainer').appendChild(div);
        });

        document.getElementById('equiposContainer').addEventListener('click', e => {
          if (e.target.classList.contains('quitarEquipo')) {
            e.target.closest('.border').remove();
          }
        });
      </script>

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