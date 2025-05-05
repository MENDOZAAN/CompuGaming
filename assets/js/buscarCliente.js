document.getElementById('btnBuscarClienteDB').addEventListener('click', async function () {
    const dniRuc = document.getElementById('buscar_dni_ruc').value.trim();
    if (!dniRuc) return alert("Ingrese un DNI o RUC válido");

    try {
        const res = await fetch(`${BASE_URL}/controllers/BuscarClienteController.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `dni_ruc=${encodeURIComponent(dniRuc)}`
        });

        const data = await res.json();

        if (data.status === 'ok') {
            document.getElementById('clienteSeleccionado').innerText = data.nombre_completo;
            document.getElementById('cliente_id').value = data.id;
        } else {
            if (confirm("Cliente no encontrado. ¿Deseas registrarlo ahora?")) {
                $('#modalAgregarCliente').modal('show');
 // o redireccionar al módulo cliente
                document.getElementById('dni_ruc').value = dniRuc; // precarga el valor
            }
        }
    } catch (err) {
        console.error("Error:", err);
        alert("Ocurrió un error en la búsqueda.");
    }
});
