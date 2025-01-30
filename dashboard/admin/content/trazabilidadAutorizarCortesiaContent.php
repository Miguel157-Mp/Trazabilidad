<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Autorizar Cortesía</h1>
    <p class="mb-4">Aprobar cortesía</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cortesías procesadas</h6>
        </div>

        <div class="card-body">
            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tienda</th>
                            <th scope="col">Nota de Entrega</th>
                            <th scope="col" class="ocultarEnCel">Monto</th>
                            <th scope="col" class="ocultarEnCel">Supervisor</th>
                            <th scope="col" class="ocultarEnCel text-center">Estatus</th>
                            <th scope="col" class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idDirector = $_SESSION['idUser'];
                        $query = "SELECT a.id, fecha, hora, notaEntrega, b.nombreCompleto AS supervisor, c.nombreCompleto AS tienda, estatus, monto
                                    FROM trazabilidad_cortesia a 
                                    JOIN  trazabilidad_usuario b
                                    JOIN  trazabilidad_usuario c
                                    WHERE estatus='Procesado' AND idDirector=? AND a.idSupervisor = b.id AND a.idTienda = c.id 
                                    ORDER BY a.id DESC";

                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("i", $idDirector);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {

                                echo '<tr>
                                        <td>' . $row['id'] . '</td>
                                        <td>' . htmlspecialchars($row['tienda']) . '</td>
                                        <td>' . $row['notaEntrega'] . '</td>
                                        <td class="ocultarEnCel">' . number_format($row['monto'], 2, ',', '.') . ' Bs </td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['supervisor']) . '</td>
                                        <td id= "tdStatus' . htmlspecialchars($row['id']) . '" class="ocultarEnCel text-center">' . htmlspecialchars($row['estatus']) . '</td>
                                        <td class="text-center"> <a id= "btnAutorizar' . htmlspecialchars($row['id']) . '" class="btn btn-secondary" data-toggle="modal" data-target="#autorizarModal" onclick="modalAutorizarCortesia(' . htmlspecialchars($row['id']) . ')">Autorizar</a> </td>
                                    </tr>';
                            }
                        } else {
                            echo "Error preparando la consulta: " . $conn->error;
                        }
                        $stmt->close();
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
<div class="modal fade" id="autorizarModal" tabindex="-1" role="dialog" aria-labelledby="autorizarModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autorizarModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Director</b></div>
                        <div id="modalDirector" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisor" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Tienda</b></div>
                        <div id="modalTienda" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Productos</b></div>
                        <div id="modalProductos" class="col col-md-8"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Nota de Entrega</b></div>
                        <div id="modalNotaEntrega" class="col col-md-8"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Monto</b></div>
                        <div id="modalMonto" class="col col-md-8"></div>
                    </div>
                    <div id="modalId" hidden></div>

                    <hr>

                    <div class="row">
                        <div class="col col-md-3"><i class="fas fa-clock" style="color:#0D629A"></i> <b>Registrada</b></div>
                        <div class="col col-md-8">
                            <span id="modalFecha" class="campoModal"></span>
                            <span id="modalHora" class="campoModal pl-2"></span>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col col-md-3"> <i class="fas fa-solid fa-gift" style="color:#0D629A"></i> <b>Procesada</b></div>
                        <div class="col col-md-8">
                            <span id="modalFechaProcesada" class="campoModal"></span>
                            <span id="modalHoraProcesada" class="campoModal pl-2"></span>
                        </div>
                    </div>

                    <!-- Mensajes de éxito o error -->
                    <div id="msj" hidden>
                        <hr class="sidebar-divider">
                        <span id="msjExito" hidden>
                            <a href="#" class="btn btn-success btn-circle btn-sm"> <i class="fas fa-check"></i></a>
                            <span>Mensaje de Exito</span>
                        </span>
                        <span id="msjError" hidden>
                            <a href="#" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-info-circle"></i></a>
                            <span>Mensaje de Error</span>
                        </span>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button id="btnAutorizarCortesia" class="btn btn-primary" type="button" onclick="formAutorizarCortesia()">Autorizar</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //Detectar cuando se cierra el modal para limpiar el form
        $('#autorizarModal').on('hidden.bs.modal', function() {
            $("#msj").attr("hidden", true);
            $("#msjExito").attr("hidden", true);
            $("#msjError").attr("hidden", true);
            $("#btnAutorizarCortesia").prop('disabled', false);
        });
    })

    function modalAutorizarCortesia(id) {

        const url = `./controllers/trazabilidadDetalleCortesia.php?id=${id}`;

        fetch(url)
            .then(response => response.json())
            .then(cortesia => {

                $("#autorizarModalLabel").text(`Cortesía Nº ${id}`);
                $("#modalId").text(id);
                $("#modalDirector").text(cortesia.director);
                $("#modalSupervisor").text(cortesia.supervisor);
                $("#modalTienda").text(cortesia.tienda);
                $("#modalProductos").text(cortesia.productos);
                $("#modalNotaEntrega").text(cortesia.notaEntrega);
                $("#modalFecha").text(cortesia.fecha);
                $("#modalHora").text(cortesia.hora);
                $("#modalFechaProcesada").text(cortesia.fechaProcesada);
                $("#modalHoraProcesada").text(cortesia.horaProcesada);

                //Dar formato al monto
                let formatter = new Intl.NumberFormat("es-ES", {
                    style: "currency",
                    currency: "XXX",
                });
                let monto = formatter.format(cortesia.monto).replace("XXX", "Bs");
                $("#modalMonto").text(monto);
                //

            })
            .catch(error => console.error('Error:', error));
    }

    function formAutorizarCortesia() {
        event.preventDefault();

        const id = $("#modalId").text();

        formdata = {
            id: id,
        };

        $.ajax({
            url: './controllers/trazabilidadFormAutorizarCortesia.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {

                $("#msj").removeAttr("hidden");
                $("#btnAutorizarCortesia").prop('disabled', true);

                if (response.estatus) {
                    $("#msjExito").children("span").text(response.msj);
                    $("#msjExito").removeAttr("hidden");
                    const tdStatus = `#tdStatus${id}`;
                    $(tdStatus).text("Autorizado").css("color", "blue");
                    const btnAutorizar = `#btnAutorizar${id}`;
                    $(btnAutorizar).prop('hidden', true);
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