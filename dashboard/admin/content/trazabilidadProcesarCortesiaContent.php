<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Entregar Cortesía</h1>
    <p class="mb-4">Procesar cortesia</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cortesias pendientes</h6>
        </div>

        <div class="card-body">


            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table " id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#Cortesía - Supervisor</th>
                            <th scope="col">Productos</th>
                            <th scope="col" class="ocultarEnCel">Fecha</th>
                            <th scope="col" class="ocultarEnCel">Autorizado por</th>
                            <th scope="col" class="ocultarEnCel text-center">Estatus</th>
                            <th scope="col" class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idTienda = $_SESSION['idUser'];
                        $query = "SELECT a.id, fecha, hora, b.nombreCompleto AS director, c.nombreCompleto AS supervisor, estatus, productos
                                    FROM trazabilidad_cortesia a
                                    JOIN trazabilidad_usuario b
                                    JOIN trazabilidad_usuario c
                                    WHERE estatus='Pendiente' AND idTienda=? AND a.idDirector = b.id AND a.idSupervisor = c.id 
                                    ORDER BY a.id DESC";

                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("i", $idTienda);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {

                                echo '<tr>
                                        <td>' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['supervisor']) . '</td>
                                        <td>' . htmlspecialchars($row['productos']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['director']) . '</td>
                                        <td id= "tdStatus' . htmlspecialchars($row['id']) . '" class="ocultarEnCel text-center">' . htmlspecialchars($row['estatus']) . '</td>
                                        <td class="text-center"> <a id= "btnProcesar' . htmlspecialchars($row['id']) . '" class="btn btn-secondary" data-toggle="modal" data-target="#procesarModal" onclick="modalProcesarCortesia(' . htmlspecialchars($row['id']) . ')">Procesar</a> </td>
                                    </tr>';
                            }
                            $stmt->close();
                        } else {
                            echo "Error preparando la consulta: " . $conn->error;
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</div>

<!-- Modal -->
<div class="modal fade" id="procesarModal" tabindex="-1" role="dialog" aria-labelledby="procesarModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="procesarModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFecha" class="col col-md-8"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Director</b></div>
                        <div id="modalDirector" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisor" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Productos</b></div>
                        <div id="modalProductos" class="col col-md-8 campoModal"></div>
                    </div>
                    <div id="modalId" hidden></div>

                    <hr>

                    <!-- Formulario -->
                    <form id="formProcesarCortesia" onsubmit="formProcesarCortesia()">

                        <div class="form-group row">
                            <label for="notaEntrega" class="col-md-3 col-form-label">Nota de Entrega</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="notaEntrega" name="notaEntrega" min="1" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="monto" class="col-md-3 col-form-label">Monto (Bs)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="monto" name="monto" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-user btn-block">Procesar</button>
                            </div>
                        </div>

                        <!-- Mensajes de éxito o error -->
                        <div id="msj" class="ocultar" hidden>
                            <hr class="sidebar-divider">
                            <span id="msjExito" class="ocultar" hidden>
                                <a href="#" class="btn btn-success btn-circle btn-sm"> <i class="fas fa-check"></i></a>
                                <span>Mensaje de Exito</span>
                            </span>
                            <span id="msjError" class="ocultar" hidden>
                                <a href="#" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-info-circle"></i></a>
                                <span>Mensaje de Error</span>
                            </span>
                        </div>

                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        //Detectar cuando se cierra el modal para limpiar el form
        $('#procesarModal').on('hidden.bs.modal', function() {
            $(".ocultar").attr("hidden", true);
            $("#formProcesarCortesia button[type='submit']").prop('disabled', false);
            $("#formProcesarCortesia")[0].reset();
        });

        $('#monto').mask('000.000.000.000.000,00', {
            reverse: true
        });

    })

    function modalProcesarCortesia(id) {

        const url = `./controllers/trazabilidadDetalleCortesia.php?id=${id}`;

        fetch(url)
            .then(response => response.json())
            .then(cortesia => {

                $("#procesarModalLabel").text(`Cortesía Nº ${id}`);
                $("#modalId").text(id);
                $("#modalFecha").text(cortesia.fecha);
                $("#modalDirector").text(cortesia.director);
                $("#modalSupervisor").text(cortesia.supervisor);
                $("#modalProductos").text(cortesia.productos);

            })
            .catch(error => console.error('Error:', error));
    }

    function formProcesarCortesia() {
        event.preventDefault();

        const id = $("#modalId").text();
        const notaEntrega = $("#notaEntrega").val();
        const monto = $('#monto').val();

        formdata = {
            id: id,
            notaEntrega: notaEntrega,
            monto: monto
        };

        $.ajax({
            url: './controllers/trazabilidadFormProcesarCortesia.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {

                $("#msj").removeAttr("hidden");
                $("#formProcesarCortesia button[type='submit']").prop('disabled', true);

                if (response.estatus) {
                    $("#msjExito").children("span").text(response.msj);
                    $("#msjExito").removeAttr("hidden");
                    const tdStatus = `#tdStatus${id}`;
                    $(tdStatus).text("Procesado").css("color", "blue");
                    const btnProcesar = `#btnProcesar${id}`;
                    $(btnProcesar).prop('hidden', true);

                } else {
                    $("#msjError").children("span").text(response.msj);
                    $("#msjError").removeAttr("hidden");
                }
            },
            error: function(jqXHR, status, error) {
                $("#msj").removeAttr("hidden");
                $("#msjError").children("span").text('Error en conexion');
                $("#msjError").removeAttr("hidden");
                console.error(jqXHR, status, error);
            }
        });
    }
</script>