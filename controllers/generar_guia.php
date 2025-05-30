<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Consulta de Estado - Compu Gaming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f7fc;
      font-family: 'Roboto', sans-serif;
      color: #333;
    }
    .estado-box {
      max-width: 900px;
      margin: 50px auto;
      background: #ffffff;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    .estado-box h4 {
      color: #495057;
      font-size: 1.7rem;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .form-control {
      border-radius: 10px;
      padding: 18px;
      font-size: 1rem;
      border: 1px solid #ccc;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .form-control:focus {
      border-color: #17a2b8;
      box-shadow: 0 0 5px rgba(23, 162, 184, 0.6);
    }
    .btn-dark {
      background-color: #343a40;
      border-color: #343a40;
      font-size: 1.2rem;
      padding: 12px 24px;
      border-radius: 10px;
      transition: background-color 0.3s ease;
    }
    .btn-dark:hover {
      background-color: #23272b;
    }
    .badge-info {
      background-color: #17a2b8;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
    table {
      margin-top: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    th, td {
      text-align: center;
      padding: 12px;
    }
    th {
      background-color: #f8f9fa;
      font-weight: 600;
    }
    .table-bordered {
      border: 1px solid #ddd;
    }
    .table-responsive {
      margin-top: 20px;
    }
    .card {
      margin-top: 20px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #f8f9fa;
      font-weight: 600;
      font-size: 1.2rem;
    }
    .card-body {
      font-size: 1rem;
    }
    .mt-4 {
      margin-top: 30px;
    }
  </style>
</head>
<body>

<div class="estado-box text-center">
  <h4 class="mb-4">Consulta el estado de tu Equipo</h4>
  <form id="formConsulta">
    <div class="form-group">
      <input type="text" name="codigo" class="form-control form-control-lg" placeholder="DNI o Correlativo" required>
    </div>
    <button type="submit" class="btn btn-dark btn-lg btn-block">Consultar</button>
  </form>
  <hr>
  <div id="resultadoEstado" class="mt-4 text-left" style="display:none;"></div>
</div>

<script>
document.getElementById('formConsulta').addEventListener('submit', async function(e) {
  e.preventDefault();
  const form = new FormData(this);
  const res = await fetch('../../controllers/ConsultarEstadoController.php', {
    method: 'POST',
    body: form
  });
  const data = await res.json();
  const box = document.getElementById('resultadoEstado');
  box.style.display = 'block';

  if (data.status === 'ok') {
    let equiposHtml = '';
    if (data.equipos.length > 0) {
      equiposHtml += `
        <h5>Equipos ingresados:</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="thead-light">
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
            <tbody>
      `;
      data.equipos.forEach((e, i) => {
        equiposHtml += `
          <tr>
            <td>${i + 1}</td>
            <td>${e.tipo_equipo}</td>
            <td>${e.marca}</td>
            <td>${e.modelo || '-'}</td>
            <td>${e.nro_serie || '-'}</td>
            <td>${e.falla_reportada || '-'}</td>
            <td>${e.servicio_solicitado || '-'}</td>
          </tr>
        `;
      });
      equiposHtml += `
            </tbody>
          </table>
        </div>
      `;
    }

    box.innerHTML = `
      <div class="card">
        <div class="card-header">Detalles del Cliente</div>
        <div class="card-body">
          <p><strong>Cliente:</strong> ${data.cliente}</p>
          <p><strong>Correlativo:</strong> ${data.correlativo}</p>
          <p><strong>Fecha de ingreso:</strong> ${data.fecha}</p>
          <p><strong>Estado:</strong> <span class="badge badge-info">${data.estado}</span></p>
          <p><strong>Técnico asignado:</strong> ${data.tecnico}</p>
          <p><strong>Observaciones:</strong> ${data.observaciones || 'Sin observaciones'}</p>
        </div>
      </div>
      ${equiposHtml}
    `;
  } else {
    box.innerHTML = `<div class="alert alert-danger">${data.mensaje}</div>`;
  }
});
</script>

</body>
</html>
