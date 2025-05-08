
document.addEventListener('DOMContentLoaded', function () {
  let contadorEquipos = 0;

  // Agregar fila de equipo
  document.getElementById('btnAgregarEquipo').addEventListener('click', () => {
    const fila = `
      <tr>
        <td>
          <select name="tipo_equipo[]" class="form-control" required>
            <option value="">Seleccionar</option>
            <option value="Laptop">Laptop</option>
            <option value="PC de Escritorio">PC de Escritorio</option>
            <option value="Impresora">Impresora</option>
            <option value="Monitor">Monitor</option>
          </select>
        </td>
        <td>
          <select name="marca[]" class="form-control" required>
            <option value="">Seleccionar</option>
            <option value="HP">HP</option>
            <option value="Lenovo">Lenovo</option>
            <option value="Epson">Epson</option>
            <option value="Dell">Dell</option>
          </select>
        </td>
        <td><input type="text" name="modelo[]" class="form-control" required></td>
        <td><input type="text" name="nro_serie[]" class="form-control"></td>
        <td><input type="text" name="accesorios[]" class="form-control"></td>
        <td><textarea name="falla_reportada[]" class="form-control" rows="1" required></textarea></td>
        <td>
          <select name="servicio[]" class="form-control" required>
            <option value="">Seleccionar</option>
            <option value="Formateo">Formateo</option>
            <option value="Cambio de disco">Cambio de disco</option>
            <option value="Mantenimiento">Mantenimiento</option>
          </select>
        </td>
        <td><input type="number" step="0.01" name="precio[]" class="form-control"></td>
        <td>
          <button type="button" class="btn btn-danger btn-sm btnQuitarFila">
            <i class="ik ik-trash-2"></i>
          </button>
        </td>
      </tr>
    `;
    document.getElementById('equiposBody').insertAdjacentHTML('beforeend', fila);
  });

  // Eliminar fila
  document.getElementById('tablaEquipos').addEventListener('click', function (e) {
    if (e.target.closest('.btnQuitarFila')) {
      e.target.closest('tr').remove();
    }
  });

  // Enviar formulario
  document.getElementById('btnGuardarInternamiento').addEventListener('click', function () {
    const form = document.getElementById('formInternamiento');
    const formData = new FormData(form);

    fetch('controllers/InternamientoController.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire('Guardado', 'Internamiento registrado correctamente.', 'success');
          $('#agregarInternamientoModal').modal('hide');
          form.reset();
          document.getElementById('equiposBody').innerHTML = '';
        } else {
          Swal.fire('Error', data.message || 'Ocurrió un problema.', 'error');
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire('Error', 'No se pudo registrar.', 'error');
      });

      document.getElementById('btnBuscarCliente').addEventListener('click', () => {
        const dniRuc = document.getElementById('buscar_dni_ruc').value.trim();
      
        if (dniRuc === '') {
          Swal.fire('Advertencia', 'Ingresa un DNI o RUC para buscar.', 'warning');
          return;
        }
      
        fetch('controllers/BuscarClienteController.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ dni_ruc: dniRuc })
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              document.getElementById('cliente_id').value = data.cliente_id;
              document.getElementById('clienteSeleccionado').innerText = `Cliente: ${data.nombre}`;
            } else {
              Swal.fire('Error', data.message, 'error');
              document.getElementById('cliente_id').value = '';
              document.getElementById('clienteSeleccionado').innerText = '';
            }
          })
          .catch(err => {
            console.error(err);
            Swal.fire('Error', 'No se pudo realizar la búsqueda.', 'error');
          });
      });
      
  });
  

});

