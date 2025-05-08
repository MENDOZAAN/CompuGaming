const API_CONSULTA_BASE = document.querySelector('meta[name="api-base"]').getAttribute('content');
const API_TOKEN = document.querySelector('meta[name="api-token"]').getAttribute('content');

        const tipoDocSelect = document.getElementById('tipo_doc');
        const nombresInput = document.getElementById('nombres');
        const apellidosInput = document.getElementById('apellidos');
        const razonSocialInput = document.getElementById('razon_social');
        const direccionInput = document.getElementById('direccion');

        function actualizarCamposPorTipo(tipo) {
            if (tipo === 'DNI') {
                nombresInput.disabled = false;
                apellidosInput.disabled = false;
                razonSocialInput.disabled = true;
                direccionInput.disabled = true;
                razonSocialInput.value = '';
                direccionInput.value = '';
            } else if (tipo === 'RUC') {
                nombresInput.disabled = true;
                apellidosInput.disabled = true;
                razonSocialInput.disabled = false;
                direccionInput.disabled = false;
                nombresInput.value = '';
                apellidosInput.value = '';
            }
        }

        // Detectar cambio de tipo de documento
        tipoDocSelect.addEventListener('change', function() {
            actualizarCamposPorTipo(this.value);
        });

        // Al hacer clic en buscar
        document.getElementById('btnBuscarCliente').addEventListener('click', async function() {
            const tipo = tipoDocSelect.value;
            const nro = document.getElementById('dni_ruc').value.trim();

            if (!nro) return alert("Ingrese un número válido");

            if ((tipo === "DNI" && nro.length !== 8) || (tipo === "RUC" && nro.length !== 11)) {
                return alert("Número de documento inválido para el tipo seleccionado.");
            }

            const url = `${API_CONSULTA_BASE}/${tipo.toLowerCase()}/${nro}?token=${API_TOKEN}`;

            try {
                const res = await fetch(url);
                const data = await res.json();

                if (data.success !== false) {
                    if (tipo === "DNI") {
                        nombresInput.value = data.nombres || '';
                        apellidosInput.value = `${data.apellidoPaterno || ''} ${data.apellidoMaterno || ''}`.trim();
                    } else {
                        razonSocialInput.value = data.razonSocial || '';
                        direccionInput.value = data.direccion || '';
                    }
                } else {
                    alert("No se encontró información para ese documento.");
                }
            } catch (err) {
                console.error("Error al consultar API:", err);
                alert("Ocurrió un error al consultar el documento.");
            }
        });

        // Ejecutar una vez al cargar
        actualizarCamposPorTipo(tipoDocSelect.value);