<?php
require_once "../controllers/listar_usuarios.php";
?>

<?php include("../public/include/header.php"); ?>

<body>
<div class="main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
                <div class="col-sm-6">
                    <h3>Lista de Equipos Internados</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#internarEquipoModal">
                        <i class="ik ik-monitor"></i> Internar Equipo
                    </a>
                </div>
            </div>

            <div class="card-body">
                <input type="text" id="searchEquiposInput" class="form-control" placeholder="Buscar equipo..." style="max-width: 250px;">
                <br>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Correlativo</th>
                            <th>Cliente</th>
                            <th>DNI/RUC</th>
                            <th>Equipo</th>
                            <th>Fecha Internamiento</th>
                            <th>Fecha Entrega</th>
                            <th>Saldo Pendiente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A03-001</td>
                            <td>Juan Pérez</td>
                            <td>12345678</td>
                            <td>Laptop HP Pavilion</td>
                            <td>25/02/2025</td>
                            <td>28/02/2025</td>
                            <td>S/ 150.00</td>
                            <td>
                                <div style="display: flex; gap: 20px;">
                                    <a href="#" class="editarEquipoBtn"><i class="ik ik-edit"></i></a>
                                    <a href="#" class="eliminarEquipoBtn"><i class="ik ik-trash" style="color: red;"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL PARA INTERNAR EQUIPO -->
        <div class="modal fade" id="internarEquipoModal" tabindex="-1" aria-labelledby="internarEquipoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="internarEquipoLabel">
                            <i class="ik ik-monitor"></i> Internar Nuevo Equipo
                        </h5>
                    </div>
                    <div class="modal-body">
                        <form id="internarEquipoForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="correlativo" class="form-label">Correlativo</label>
                                        <input type="text" class="form-control" id="correlativo" name="correlativo" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fecha_internamiento" class="form-label">Fecha Internamiento</label>
                                        <input type="date" class="form-control" id="fecha_internamiento" name="fecha_internamiento" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="cliente" class="form-label">Cliente</label>
                                <input type="text" class="form-control" id="cliente" name="cliente" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dni_ruc" class="form-label">DNI/RUC</label>
                                        <input type="text" class="form-control" id="dni_ruc" name="dni_ruc" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="vendedor" class="form-label">Vendedor</label>
                                        <input type="text" class="form-control" id="vendedor" name="vendedor" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tipo_equipo" class="form-label">Tipo de Equipo</label>
                                <select class="form-control" id="tipo_equipo" name="tipo_equipo" required>
                                    <option value="">Seleccione</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="PC">PC</option>
                                    <option value="Impresora">Impresora</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="marca" class="form-label">Marca</label>
                                        <input type="text" class="form-control" id="marca" name="marca" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="modelo" class="form-label">Modelo</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="serie" class="form-label">Número de Serie</label>
                                        <input type="text" class="form-control" id="serie" name="serie" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="accesorios" class="form-label">Accesorios</label>
                                <input type="text" class="form-control" id="accesorios" name="accesorios">
                            </div>

                            <div class="mb-3">
                                <label for="clave" class="form-label">Clave del Equipo</label>
                                <input type="text" class="form-control" id="clave" name="clave">
                            </div>

                            <div class="mb-3">
                                <label for="precio_revision" class="form-label">Precio de Revisión</label>
                                <input type="number" class="form-control" id="precio_revision" name="precio_revision" required>
                            </div>

                            <div class="mb-3">
                                <label for="abono" class="form-label">Abono Inicial</label>
                                <input type="number" class="form-control" id="abono" name="abono" required>
                            </div>

                            <div class="mb-3">
                                <label for="saldo_pendiente" class="form-label">Saldo Pendiente</label>
                                <input type="number" class="form-control" id="saldo_pendiente" name="saldo_pendiente" readonly>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="ik ik-save"></i> Guardar Equipo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


    <!-- Script de búsqueda en tiempo real -->
    <script>
        document.getElementById("searchUserInput").addEventListener("keyup", function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll(".table tbody tr");

            rows.forEach(row => {
                let nombre = row.cells[0].textContent.toLowerCase();
                let apellido = row.cells[1].textContent.toLowerCase();
                let usuario = row.cells[2].textContent.toLowerCase();
                let rol = row.cells[3].textContent.toLowerCase();

                if (nombre.includes(input) || apellido.includes(input) || usuario.includes(input) || rol.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
    
</body>

</html>