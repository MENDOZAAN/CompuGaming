<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Consulta de Estado - Compu Gaming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f2f2f2;
    }
    .estado-box {
      max-width: 900px;
      margin: 50px auto;
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>

<div class="estado-box text-center">
  <h4 class="mb-4">Consulta el estado de tu equipo</h4>
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
      <p><strong>Cliente:</strong> ${data.cliente}</p>
      <p><strong>Correlativo:</strong> ${data.correlativo}</p>
      <p><strong>Fecha de ingreso:</strong> ${data.fecha}</p>
      <p><strong>Estado:</strong> <span class="badge badge-info">${data.estado}</span></p>
      <p><strong>Técnico asignado:</strong> ${data.tecnico}</p>
      <p><strong>Observaciones:</strong> ${data.observaciones || 'Sin observaciones'}</p>
      ${equiposHtml}
    `;
  } else {
    box.innerHTML = `<div class="alert alert-danger">${data.mensaje}</div>`;
  }
});
</script>

</body>
</html>
