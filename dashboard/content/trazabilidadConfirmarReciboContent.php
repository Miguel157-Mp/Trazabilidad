<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Confirmar Recibo</h1>
    <p class="mb-4">Procesar recibo</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recibos pendientes</h6>
        </div>

        <div class="card-body">


            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#Recibo - Tienda</th>
                            <th scope="col">Monto</th>
                            <th scope="col" class="ocultarEnCel">Periodo</th>
                            <th scope="col" class="ocultarEnCel">Fecha</th>
                            <th scope="col" class="ocultarEnCel text-center">Estatus</th>
                            <th scope="col" class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idSupervisor = $_SESSION['idUser'];
                        $query = "SELECT a.id, fecha, hora, idTienda, bs, usd, eur, periodo, estatus, b.nombreCompleto AS tienda 
                                    FROM trazabilidad_recibo a 
                                    JOIN trazabilidad_usuario b ON  a.idTienda=b.id
                                    WHERE estatus= 'Enviado a Supervisor' AND idSupervisor = ? 
                                    ORDER BY a.id DESC;";

                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("i", $idSupervisor);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {

                                echo '<tr>
                                        <td>' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['tienda']) . '</td>
                                        <td>
                                            <li> Bs ' . htmlspecialchars(number_format($row['bs'], 0, '', ' ')) . '</li> 
                                            <li> USD ' . htmlspecialchars(number_format($row['usd'], 0, '', ' ')) . '</li>
                                            <li> EUR ' . htmlspecialchars(number_format($row['eur'], 0, '', ' ')) . '</li>
                                        </td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['periodo']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                        <td id= "tdStatus' . htmlspecialchars($row['id']) . '" class="ocultarEnCel text-center">' . htmlspecialchars($row['estatus']) . '</td>
                                        <td class="text-center"> <a id= "btnConfirmar' . htmlspecialchars($row['id']) . '" class="btn btn-secondary" data-toggle="modal" data-target="#confirmarModal" onclick="modalConfirmarRecibo(' . htmlspecialchars($row['id']) . ')">Confirmar</a> </td>
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
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFechaRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalHoraRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Tienda</b></div>
                        <div id="modalTiendaRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Periodo</b></div>
                        <div id="modalPeriodoRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3 font-weight-bold"> Monto </div>
                        <div class="col col-md-8 campoModal font-weight-bold"> Bs <span id="modalMontoBs"></span>, $ <span id="modalMontoUsd"></span>, € <span id="modalMontoEur"></span> </div>
                    </div>

                    <div id="modalIdRecibo" hidden></div>

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

                </div>

            </div>
            <div class="modal-footer">
                <button id="btnConfirmarModal" class="btn btn-primary" type="button" onclick="confirmarRecibo()">Confirmar</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //Detectar cuando se cierra el modal para limpiar el form
        $('.modal').on('hidden.bs.modal', function() {
            $(".ocultar").attr("hidden", true);
            $("#btnConfirmarModal").prop('disabled', false);
        });
    })

    function modalConfirmarRecibo(id) {

        const url = `./controllers/trazabilidadDetalleRecibo.php?id=${id}`;

        fetch(url)
            .then(response => response.json())
            .then(recibo => {

                $("#confirmarModalLabel").text(`Recibo Nº ${id} - ${recibo.estatus}`);
                $("#modalIdRecibo").text(id);
                $("#modalFechaRecibo").text(recibo.fecha);
                $("#modalHoraRecibo").text(recibo.hora);
                $("#modalTiendaRecibo").text(recibo.tienda);
                $("#modalPeriodoRecibo").text(recibo.periodo);
                $("#modalMontoBs").text(recibo.bs);
                $("#modalMontoUsd").text(recibo.usd);
                $("#modalMontoEur").text(recibo.eur);

            })
            .catch(error => console.error('Error:', error));
    }

    function confirmarRecibo() {

        const id = $("#modalIdRecibo").text()

        formdata = {
            id: id,
        };

        $.ajax({
            url: './controllers/trazabilidadConfirmarRecibo.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {

                $("#msj").removeAttr("hidden");
                $("#btnConfirmarModal").prop('disabled', true);

                if (response.estatus) {
                    $("#msjExito").children("span").text(response.msj);
                    $("#msjExito").removeAttr("hidden");
                    const tdStatus = `#tdStatus${id}`;
                    $(tdStatus).text("Confirmado").css("color", "blue");
                    const btnConfirmar = `#btnConfirmar${id}`;
                    $(btnConfirmar).prop('hidden', true);

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