document.getElementById('agregarEquipoForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const res = await fetch(BASE_URL + '/controllers/InternamientoController.php', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.status === 'ok') {
            Swal.fire({
                icon: 'success',
                title: 'Equipo registrado',
                text: 'El internamiento fue guardado correctamente.'
            });

            form.reset();
            $('#agregarEquipoModal').modal('hide');
        } else {
            Swal.fire('Error', 'No se pudo registrar el internamiento.', 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Ocurrió un problema en la solicitud.', 'error');
    }
});

document.getElementById('buscarClienteBtn').addEventListener('click', async () => {
    const dni = document.getElementById('buscar_dni').value.trim();
    if (!dni) return Swal.fire('Campo vacío', 'Ingresa un DNI o RUC.', 'warning');

    try {
      // Buscar en la BD primero
      const res = await fetch('<?= BASE_URL ?>/controllers/BuscarClienteController.php', {
        method: 'POST',
        body: new URLSearchParams({ dni_ruc: dni })
      });
      const data = await res.json();

      if (data.encontrado) {
        document.getElementById('cliente_id').value = data.cliente.id;
        document.getElementById('nombreClientePreview').innerText = data.cliente.nombres + ' ' + data.cliente.apellidos;
      } else {
        // Buscar en API externa
        const apiRes = await fetch('<?= BASE_URL ?>/api/consulta_dni_ruc.php?numero=' + dni);
        const clienteApi = await apiRes.json();

        if (clienteApi.success) {
          document.getElementById('modal_dni').value = clienteApi.numero;
          document.getElementById('modal_nombres').value = clienteApi.nombre_completo;
          document.getElementById('modal_direccion').value = clienteApi.direccion || '';
          document.getElementById('modal_telefono').value = '';
          $('#modalAgregarCliente').modal('show');
        } else {
          Swal.fire('No encontrado', 'No se encontró en la BD ni en la API.', 'info');
        }
      }
    } catch (err) {
      console.error(err);
      Swal.fire('Error', 'Ocurrió un problema al buscar.', 'error');
    }

    document.getElementById('agregarClienteForm').addEventListener('submit', async function (e) {
      e.preventDefault();
      const formData = new FormData(this);
  
      const res = await fetch(`${BASE_URL}/controllers/GuardarClienteDesdeInternamientoController.php`, {
          method: 'POST',
          body: formData
      });
  
      const data = await res.json();
      if (data.status === 'ok') {
          // Cerrar el modal
          const modal = bootstrap.Modal.getInstance(document.getElementById('agregarClienteModal'));
          modal.hide();
  
          // Actualizar el formulario de internamiento
          document.getElementById('clienteSeleccionado').innerText = data.nombre;
          document.getElementById('cliente_id').value = data.id;
  
          Swal.fire('Éxito', 'Cliente registrado correctamente.', 'success');
      } else {
          Swal.fire('Error', 'No se pudo registrar el cliente.', 'error');
      }
  });
  
}