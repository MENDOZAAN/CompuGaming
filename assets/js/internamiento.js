document.addEventListener('DOMContentLoaded', () => {
  const btnBuscarCliente = document.getElementById('btnBuscarClienteDB');
  const btnAgregarEquipo = document.getElementById('btnAgregarEquipo');
  const tablaEquiposBody = document.getElementById('tablaEquiposBody');
  const totalPrecioElement = document.getElementById('totalPrecio');
  const formInternamiento = document.getElementById('agregarEquipoForm');

  let equiposAgregados = [];

  // Buscar cliente por DNI o RUC
  btnBuscarCliente.addEventListener('click', async () => {
      const dni = document.getElementById('buscar_dni_ruc').value.trim();
      if (!dni) {
          Swal.fire('Campo vacío', 'Ingresa un DNI o RUC.', 'warning');
          return;
      }

      try {
          const res = await fetch(`${BASE_URL}/controllers/BuscarClienteController.php`, {
              method: 'POST',
              body: new URLSearchParams({ dni_ruc: dni })
          });

          const data = await res.json();
          if (data.status === 'ok') {
              document.getElementById('cliente_id').value = data.id;
              document.getElementById('clienteSeleccionado').innerText = data.nombre_completo;
          } else {
              Swal.fire('No encontrado', 'Cliente no encontrado.', 'info');
          }
      } catch (err) {
          console.error(err);
          Swal.fire('Error', 'Ocurrió un problema al buscar.', 'error');
      }
  });

  // Añadir equipo a la tabla temporal
  btnAgregarEquipo.addEventListener('click', () => {
      const tipo = document.getElementById('tipo_equipo_id');
      const marca = document.getElementById('marca_id');
      const modelo = document.getElementById('modelo').value.trim();
      const serie = document.getElementById('serie').value.trim();
      const accesorios = document.getElementById('accesorios').value.trim();
      const falla = document.getElementById('falla_reportada').value.trim();
      const servicio = document.getElementById('servicio_id');
      const precio = parseFloat(document.getElementById('precio_equipo').value) || 0;

      if (!tipo.value || !marca.value || !modelo || !servicio.value) {
          Swal.fire('Campos obligatorios', 'Completa los campos requeridos.', 'warning');
          return;
      }

      const equipo = {
          tipo_id: tipo.value,
          tipo_texto: tipo.options[tipo.selectedIndex].text,
          marca_id: marca.value,
          marca_texto: marca.options[marca.selectedIndex].text,
          modelo,
          serie,
          accesorios,
          falla,
          servicio_id: servicio.value,
          servicio_texto: servicio.options[servicio.selectedIndex].text,
          precio
      };

      equiposAgregados.push(equipo);
      renderTablaEquipos();
  });

  // Renderizar la tabla
  function renderTablaEquipos() {
      tablaEquiposBody.innerHTML = '';
      let total = 0;

      equiposAgregados.forEach((eq, index) => {
          total += eq.precio;
          const row = document.createElement('tr');
          row.innerHTML = `
              <td>${eq.tipo_texto}</td>
              <td>${eq.marca_texto}</td>
              <td>${eq.modelo}</td>
              <td>${eq.serie}</td>
              <td>${eq.accesorios}</td>
              <td>${eq.falla}</td>
              <td>${eq.servicio_texto}</td>
              <td>${eq.precio.toFixed(2)}</td>
              <td><button class="btn btn-danger btn-sm" onclick="eliminarEquipo(${index})"><i class="ik ik-trash-2"></i></button></td>
          `;
          tablaEquiposBody.appendChild(row);
      });

      totalPrecioElement.textContent = total.toFixed(2);
  }

  // Eliminar equipo
  window.eliminarEquipo = (index) => {
      equiposAgregados.splice(index, 1);
      renderTablaEquipos();
  };

  // Enviar internamiento
  formInternamiento.addEventListener('submit', async (e) => {
      e.preventDefault();

      const clienteId = document.getElementById('cliente_id').value;
      const adelanto = document.getElementById('adelanto').value;

      if (!clienteId || equiposAgregados.length === 0) {
          Swal.fire('Error', 'Faltan datos del cliente o equipos.', 'error');
          return;
      }

      const payload = {
          cliente_id: clienteId,
          adelanto: adelanto,
          equipos: equiposAgregados
      };

      try {
          const res = await fetch(`${BASE_URL}/controllers/InternamientoController.php`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify(payload)
          });

          const data = await res.json();

          if (data.status === 'ok') {
              Swal.fire('Registrado', 'Internamiento guardado correctamente.', 'success');
              formInternamiento.reset();
              equiposAgregados = [];
              renderTablaEquipos();
              $('#agregarEquipoModal').modal('hide');
          } else {
              Swal.fire('Error', 'No se pudo guardar.', 'error');
          }
      } catch (err) {
          console.error(err);
          Swal.fire('Error', 'Fallo al enviar datos.', 'error');
      }
  });
});
