<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Recibos</h1>
    <p class="mb-4">Historial</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
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
                            <th scope="col" class="ocultarEnCel">Supervisor</th>
                            <th scope="col" class="ocultarEnCel">Entregado A</th>
                            <th scope="col" class="ocultarEnCel">Estatus</th>
                            <th scope="col" class="mostrarEnCel">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT a.id, fecha, hora, idTienda, idSupervisor, idSupervisorEdo, idConglomerado, bs, usd, eur, periodo, estatus, b.nombreCompleto AS tienda 
                                    FROM trazabilidad_recibo a 
                                    JOIN trazabilidad_usuario b ON  a.idTienda=b.id 
                                    ORDER BY a.id DESC;";

                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {

                            if ($row['idSupervisor']) {

                                $query = "SELECT nombreCompleto AS supervisor 
                                        FROM trazabilidad_usuario 
                                        WHERE id=? ";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i",  $row['idSupervisor']);
                                $stmt->execute();
                                $result2 = $stmt->get_result();
                                $row2 = $result2->fetch_assoc();
                            }

                            if ($row['idSupervisorEdo']) {

                                $query = "SELECT nombreCompleto AS supervisorEdo 
                                        FROM trazabilidad_usuario 
                                        WHERE id=? ";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i",  $row['idSupervisorEdo']);
                                $stmt->execute();
                                $result3 = $stmt->get_result();
                                $row3 = $result3->fetch_assoc();
                            }

                            // if ($row['idEntregado']) {

                            //     $query = "SELECT nombreCompleto AS entregado 
                            //     FROM trazabilidad_usuario 
                            //     WHERE id=? ";

                            //     $stmt = $conn->prepare($query);
                            //     $stmt->bind_param("i",  $row['idEntregado']);
                            //     $stmt->execute();
                            //     $result4 = $stmt->get_result();
                            //     $row4 = $result4->fetch_assoc();
                            // }

                            $supervisor = $row['idSupervisor'] ? $row2['supervisor'] : '';
                            $supervisorEdo = $row['idSupervisorEdo'] ? $row3['supervisorEdo'] : '';
                            // $entregado = $row['idEntregado'] ? $row4['entregado'] : '';

                            echo '<tr>
                                        <td>' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['tienda']) . '</td>
                                        <td> 
                                            <li> Bs ' . htmlspecialchars(number_format($row['bs'], 0, '', ' ')) . '</li> 
                                            <li> USD ' . htmlspecialchars(number_format($row['usd'], 0, '', ' ')) . '</li>
                                            <li> EUR ' . htmlspecialchars(number_format($row['eur'], 0, '', ' ')) . '</li>
                                        </td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['periodo']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($supervisor) . '</td>
                                        <td class="ocultarEnCel"> </td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['estatus']) . '</td>
                                        <td class="mostrarEnCel"> <a class="btn btn-secondary" data-toggle="modal"  data-target="#verReciboModal" onclick="modalVerRecibo(' . htmlspecialchars($row['id']) . ')">Ver</a> </td>
                                    </tr>';
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

<!-- Modal Ver Recibo -->
<div class="modal fade" id="verReciboModal" tabindex="-1" role="dialog" aria-labelledby="verReciboModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verReciboModalLabel"></h5>
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
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisorRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Monto</b> </div>
                        <div id="modalMontoRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Periodo</b></div>
                        <div id="modalPeriodoRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <span id="spanEntregado" class="ocultar" hidden>
                        <div class="row">
                            <div class="col col-md-3"> <b>Entregado a </b></div>
                            <div id="modalEntregadoARecibo" class="col col-md-8 campoModal"></div>
                        </div>
                        <!-- <div class="row">
                            <div class="col col-md-3"> <b>Observaciones</b></div>
                            <div id="modalObservacionRecibo" class="col col-md-8 campoModal"></div>
                        </div> -->
                    </span>
                    <div id="modalIdRecibo" hidden></div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function modalVerRecibo(idRecibo, idNotificacion) {

        const url = `./scripts/trazabilidadDetalleRecibo.php?id=${idRecibo}`;

        fetch(url)
            .then(response => response.json())
            .then(recibo => {

                $("#verReciboModalLabel").text(`Recibo Nº ${idRecibo} - ${recibo.estatus}`);
                $("#modalIdRecibo").text(idRecibo);
                $("#modalFechaRecibo").text(recibo.fecha);
                $("#modalHoraRecibo").text(recibo.hora);
                $("#modalSupervisorRecibo").text(recibo.supervisor);
                $("#modalTiendaRecibo").text(recibo.tienda);
                $("#modalMontoRecibo").text(recibo.monto);
                $("#modalPeriodoRecibo").text(recibo.periodo);

                if (recibo.estatus != 'Enviado a Supervisor' || recibo.estatus == 'Confirmado por Supervisor') {
                    $("#modalEntregadoARecibo").text(recibo.entregado);
                    // $("#modalObservacionRecibo").text(recibo.observacion);
                    $("#spanEntregado").removeAttr("hidden");
                }
            })
            .catch(error => console.error('Error:', error));

        formdata = {
            id: idNotificacion,
        };

        $.ajax({
            url: './scripts/trazabilidadNotificacionLeida.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                verificarNotificaciones();
                const trId = `#tr${idNotificacion}`;
                $(trId).removeClass("table-info");
            },
            error: function(jqXHR, status, error) {

                console.error(jqXHR, status, error);
            }
        });
    }
</script>