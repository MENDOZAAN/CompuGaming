<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/ClienteModel.php';
require_once __DIR__ . '/../../models/MarcaModel.php';
require_once __DIR__ . '/../../models/TipoEquipoModel.php';
require_once __DIR__ . '/../../models/ServicioModel.php';
require_once __DIR__ . '/../../models/InternamientoModel.php';

session_start();
if (!isset($_SESSION['usuario'])) {
  header('Location: ' . BASE_URL . '/login');
  exit;
}

// Obtener datos desde los modelos
$internamientos = InternamientoModel::obtenerTodosConCliente();
$clientes = ClienteModel::obtenerTodos();
$marcas = array_column(MarcaModel::obtenerTodas(), 'nombre');
$tipos = array_column(TipoEquipoModel::obtenerTodos(), 'nombre');
$servicios = array_column(ServicioModel::obtenerTodos(), 'descripcion');

include __DIR__ . '/../../includes/header.php';
?>
<meta name="base-url" content="<?= BASE_URL ?>">
<meta name="api-base" content="<?= API_CONSULTA_BASE ?>">
<meta name="api-token" content="<?= API_TOKEN ?>">
<link rel="stylesheet" href="../../assets/css/modal_Internamiento.css">

<body>
  <div class="main-content">
    <div class="container-fluid">

      <!-- Encabezado -->
      <div class="mt-3 mb-4">
        <!-- Modal -->
        <div class="modal fade" id="modalInternamiento" tabindex="-1" role="dialog" aria-labelledby="modalInternamientoLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="ik ik-monitor"></i> Registrar Internamiento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form action="<?= BASE_URL ?>/controllers/InternamientoController.php" method="POST">
                <div class="modal-body px-4 pt-4">

                  <!-- CLIENTE -->
                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label for="cliente_id" class="font-weight-bold">Cliente</label>
                      <select name="cliente_id" id="cliente_id" class="form-control form-control-lg">
                        <option value="">-- Cliente nuevo --</option>
                        <?php foreach ($clientes as $c): ?>
                          <?php $nombre = $c['tipo_doc'] === 'DNI' ? $c['nombres'] . ' ' . $c['apellidos'] : $c['razon_social']; ?>
                          <option value="<?= $c['id'] ?>"><?= $c['tipo_doc'] ?> <?= $c['dni_ruc'] ?> - <?= $nombre ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="font-weight-bold">DNI / RUC (si es nuevo)</label>
                      <input type="text" name="nuevo_dni_ruc" class="form-control form-control-lg">
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6">
                      <label class="font-weight-bold">Nombres</label>
                      <input type="text" name="nuevo_nombres" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-6">
                      <label class="font-weight-bold">Apellidos o Razón Social</label>
                      <input type="text" name="nuevo_apellidos" class="form-control form-control-lg">
                    </div>
                  </div>

                  <!-- TABS INTERNAMIENTO / EQUIPOS -->
                  <ul class="nav nav-tabs mt-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#tabInternamiento" role="tab">Internamiento</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#tabEquipos" role="tab">Equipos</a>
                    </li>
                  </ul>

                  <div class="tab-content p-3 border border-top-0 rounded-bottom">
                    <!-- INTERNAMIENTO -->
                    <div class="tab-pane fade show active" id="tabInternamiento" role="tabpanel">
                      <div class="form-group">
                        <label for="observaciones" class="font-weight-bold">Observaciones generales</label>
                        <textarea name="observaciones" class="form-control form-control-lg" rows="3"></textarea>
                      </div>
                    </div>

                    <!-- EQUIPOS -->
                    <div class="tab-pane fade" id="tabEquipos" role="tabpanel">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Equipos Ingresados</h5>
                        <button type="button" class="btn btn-success btn-lg" id="agregarEquipo">
                          <i class="ik ik-plus"></i> Agregar equipo
                        </button>
                      </div>
                      <div id="equiposContainer"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tecnico_id" class="font-weight-bold">Técnico Asignado</label>
                    <select name="tecnico_id" id="tecnico_id" class="form-control form-control-lg">
                      <option value="">-- Seleccionar técnico --</option>
                      <?php
                      $stmt = $pdo->query("SELECT id, nombre, apellido FROM usuarios WHERE rol = 'Admin' OR rol = 'Usuario'");
                      foreach ($stmt as $row): ?>
                        <option value="<?= $row['id'] ?>">
                          <?= $row['nombre'] . ' ' . $row['apellido'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="ik ik-save"></i> Guardar Internamiento
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Fin del modal -->

        <!-- Tabla de Internamientos con estilo moderno -->
        <div class="card mt-4">
          <div class="card-header row">
            <div class="col-sm-6">
              <h3>Lista de Internamientos</h3>
            </div>
            <div class="col-sm-6 text-right">
              <button class="btn btn-dark" data-toggle="modal" data-target="#modalInternamiento">
                <i class="ik ik-plus"></i> Registrar Internamiento
              </button>
            </div>
          </div>

          <div class="card-body">
            <!-- Búsqueda -->
            <input type="text" id="searchInternamientoInput" class="form-control" placeholder="Buscar internamiento..." style="max-width: 250px;">
            <br>

            <table class="table" id="tablaInternamientos">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Correlativo</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>Estado</th>
                  <th>Observaciones</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($internamientos as $i => $row): ?>
                  <?php
                  $cliente = $row['tipo_doc'] === 'DNI'
                    ? $row['nombres'] . ' ' . $row['apellidos']
                    : $row['razon_social'];
                  ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($row['correlativo']) ?></td>
                    <td><?= htmlspecialchars($cliente) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['fecha_ingreso'])) ?></td>
                    <td>
                      <?php
                      $estado = $row['estado_general'];
                      $clase = match ($estado) {
                        'Recibido'      => 'badge-secondary',
                        'En reparación' => 'badge-warning',
                        'Terminado'     => 'badge-info',
                        'Entregado'     => 'badge-success',
                        default         => 'badge-dark',
                      };
                      ?>
                      <span class="badge <?= $clase ?>"><?= $estado ?></span>
                    </td>
                    <td><?= htmlspecialchars($row['observaciones']) ?></td>
                    <td>
                      <div style="display: flex; gap: 20px;">
                        <!-- Ver -->
                        <a href="#" class="btnVerEquipos" data-id="<?= $row['id']; ?>">
                          <i class="ik ik-eye"></i>
                        </a>

                        <!-- Editar -->
                        <a href="#"
                          class="btnEditarInternamiento"
                          data-id="<?= $row['id']; ?>"
                          data-observaciones="<?= htmlspecialchars($row['observaciones']) ?>"
                          data-fecha="<?= $row['fecha_ingreso'] ?>"
                          data-tecnico="<?= $row['tecnico_id'] ?>"
                          data-estado="<?= $row['estado_general'] ?>">
                          <i class="ik ik-edit" style="color: red;"></i>
                        </a>

                        <!-- PDF o guía -->
                        <a href="<?= BASE_URL ?>/controllers/generar_guia.php?id=<?= $row['id']; ?>" target="_blank">
                          <i class="ik ik-printer" style="color: blue;"></i>
                        </a>

                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Mensaje si no hay resultados -->
        <div id="noResultsMessageInternamiento" style="display: none; text-align: center; margin-top: 20px;">
          <p class="text-muted">No se encontraron resultados.</p>
        </div>
        <!-- Modal Ver Equipos -->
        <div class="modal fade" id="modalVerEquipos" tabindex="-1" aria-labelledby="modalVerEquiposLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalVerEquiposLabel">
                  <i class="ik ik-monitor"></i> Equipos del Internamiento
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tipo</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Serie</th>
                      <th>Falla</th>
                      <th>Servicio</th>
                    </tr>
                  </thead>
                  <tbody id="tablaEquiposInternamiento">
                    <tr>
                      <td colspan="7" class="text-center">Cargando...</td>
                    </tr>
                  </tbody>
                </table>
                <!-- Formulario de subida de imagen -->
                <hr>
                <h6>Subir imagen para un equipo</h6>
                <form class="form-subir-imagen" data-equipo-id="<?= $eq['id'] ?>">
                  <input type="file" name="imagen" accept="image/*" required>
                  <img class="preview-img" style="display:none; max-width:100px;">
                  <button type="submit" class="btn btn-primary btn-sm">Subir</button>
                </form>
                <!-- Aquí se mostrarán las imágenes ya subidas -->
                <div id="imagenesSubidas" class="mt-3"></div>

              </div>
            </div>
          </div>
        </div>


        <!-- Modal Editar Internamiento -->
        <div class="modal fade" id="modalEditarInternamiento" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <form id="formEditarInternamiento">
                <div class="modal-header bg-dark text-white">
                  <h5 class="modal-title"><i class="ik ik-edit"></i> Editar Internamiento</h5>
                  <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                  <input type="hidden" name="id" id="editar_internamiento_id">

                  <div class="form-group">
                    <label>Observaciones generales</label>
                    <textarea name="observaciones" id="editar_observaciones" class="form-control" rows="3"></textarea>
                  </div>

                  <div class="form-group">
                    <label>Técnico asignado</label>
                    <select name="tecnico_id" id="editar_tecnico_id" class="form-control">
                      <option value="">-- Seleccionar técnico --</option>
                      <?php
                      $stmt = $pdo->query("SELECT id, nombre, apellido FROM usuarios WHERE rol IN ('Admin', 'Usuario')");
                      foreach ($stmt as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= $u['nombre'] . ' ' . $u['apellido'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Estado del internamiento</label>
                    <select name="estado_general" id="editar_estado_general" class="form-control">
                      <option value="Recibido">Recibido</option>
                      <option value="En reparación">En reparación</option>
                      <option value="Terminado">Terminado</option>
                      <option value="Entregado">Entregado</option>
                    </select>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="ik ik-save"></i> Guardar cambios</button>
                </div>
              </form>
            </div>
          </div>
        </div>



        <!-- Script de búsqueda -->
        <script>
          const inputInternamiento = document.getElementById("searchInternamientoInput");
          const mensajeInternamiento = document.getElementById("noResultsMessageInternamiento");

          inputInternamiento.addEventListener("keyup", function() {
            const filtro = this.value.toLowerCase().trim();
            const filas = document.querySelectorAll("#tablaInternamientos tbody tr");

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

            mensajeInternamiento.style.display = (encontrados === 0) ? "block" : "none";
          });
        </script>



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

<script>
  document.querySelectorAll('.btnVerEquipos').forEach(btn => {
    btn.addEventListener('click', async function(e) {
      e.preventDefault();
      const internamientoId = this.dataset.id;
      const tbody = document.getElementById('tablaEquiposInternamiento');

      // Mostrar modal inmediatamente
      $('#modalVerEquipos').modal('show');
      tbody.innerHTML = '<tr><td colspan="7" class="text-center">Cargando...</td></tr>';

      try {
        const res = await fetch(`${BASE_URL}/controllers/get_equipos_internamiento.php?id=${internamientoId}`);
        const data = await res.json();

        if (data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No se encontraron equipos.</td></tr>';
          return;
        }

        let rows = '';
        data.forEach((eq, i) => {
          rows += `
          <tr>
            <td>${i + 1}</td>
            <td>${eq.tipo_equipo}</td>
            <td>${eq.marca}</td>
            <td>${eq.modelo}</td>
            <td>${eq.nro_serie}</td>
            <td>${eq.falla_reportada}</td>
            <td>${eq.servicio_solicitado}</td>
          </tr>
        `;
        });
        tbody.innerHTML = rows;

      } catch (err) {
        console.error(err);
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al cargar los equipos.</td></tr>';
      }
    });
  });
</script>

<script>
  document.querySelectorAll('.btnEditarInternamiento').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const obs = this.dataset.observaciones;
      const tecnico = this.dataset.tecnico;
      const estado = this.dataset.estado;

      document.getElementById('editar_internamiento_id').value = id;
      document.getElementById('editar_observaciones').value = obs;
      document.getElementById('editar_tecnico_id').value = tecnico;
      document.getElementById('editar_estado_general').value = estado;

      $('#modalEditarInternamiento').modal('show');
    });
  });
</script>
<script>
  document.getElementById('formEditarInternamiento').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('accion', 'editar_internamiento');

    const res = await fetch(`${BASE_URL}/controllers/InternamientoController.php`, {
      method: 'POST',
      body: formData
    });

    const data = await res.json();

    if (data.status === 'ok') {
      Swal.fire('Actualizado', 'Internamiento modificado correctamente.', 'success')
        .then(() => location.reload());
    } else {
      Swal.fire('Error', data.mensaje || 'No se pudo actualizar.', 'error');
    }
  });
</script>

<!-- subir img -->
<script>
  document.addEventListener('submit', async function(e) {
    if (e.target.matches('.form-subir-imagen')) {
      e.preventDefault();

      const form = e.target;
      const equipoId = form.dataset.equipoId;
      const input = form.querySelector('input[type="file"]');
      const preview = form.querySelector('.preview-img');

      if (!input.files.length) return;

      const formData = new FormData();
      formData.append('imagen', input.files[0]);
      formData.append('equipo_id', equipoId);

      try {
        const res = await fetch(`${BASE_URL}/controllers/upload_imagen_equipo.php`, {
          method: 'POST',
          body: formData
        });
        const data = await res.json();

        if (data.status === 'ok') {
          Swal.fire('Imagen subida', 'La imagen fue guardada correctamente.', 'success');
          if (preview) {
            preview.src = `${BASE_URL}/${data.ruta}`;
            preview.style.display = 'block';
          }
        } else {
          Swal.fire('Error', data.mensaje || 'Error al subir imagen.', 'error');
        }
      } catch (err) {
        console.error(err);
        Swal.fire('Error', 'No se pudo subir la imagen.', 'error');
      }
    }
  });
</script>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>

<script src="<?= BASE_URL ?>/assets/js/internamiento.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>/assets/js/buscarCliente.js"></script>
<script src="<?= BASE_URL ?>/assets/js/consultaClienteAPI.js"></script>