<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Notificaciones</h1>
    <p class="mb-4">Ver notificaciones</p>

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
                            <th scope="col">Fecha</th>
                            <th scope="col" class="ocultarEnCel">Hora</th>
                            <th scope="col">Notificación</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idUser = $_SESSION['idUser'];
                        $query = "SELECT id, fecha, hora, notificacion, idCortesia, idRecibo, idConglomerado, idProyeccion, leido
                                    FROM trazabilidad_notificaciones 
                                    WHERE idUser = ?
                                    ORDER BY fecha DESC, hora DESC;";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i",  $idUser);

                        if ($stmt->execute()) {

                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {

                                $class = $row['leido'] ? '' : 'class="table-info"';
                                if ($row['idCortesia']) {
                                    $funcionBoton = ' data-target="#verCortesiaModal" onclick="modalVerCortesia(' . htmlspecialchars($row['idCortesia']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                } else if ($row['idRecibo']) {
                                    $funcionBoton = 'data-target="#verReciboModal" onclick="modalVerRecibo(' . htmlspecialchars($row['idRecibo']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                } else if ($row['idConglomerado']) {
                                    $funcionBoton = 'data-target="#verConglomeradoModal" onclick="modalVerConglomerado(' . htmlspecialchars($row['idConglomerado']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                } else if ($row['idProyeccion']) {
                                    $funcionBoton = 'data-target="#verProyeccionModal" onclick="modalVerProyeccion(' . htmlspecialchars($row['idProyeccion']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                }

                                echo '<tr id="tr' . htmlspecialchars($row['id']) . '" ' . $class . ' >
                                        <td>' . htmlspecialchars($row['fecha']) . ' <span class="mostrarEnCel"> ' . htmlspecialchars($row['hora']) . ' </span> </td>
                                        <td class ="ocultarEnCel">' . htmlspecialchars($row['hora']) . '</td>
                                        <td>' . htmlspecialchars($row['notificacion']) . '</td>
                                        <td> <a class="btn btn-secondary" data-toggle="modal"  ' . $funcionBoton . '  >Ver</a> </td>
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

<!-- Modal Ver Cortesía -->
<div class="modal fade" id="verCortesiaModal" tabindex="-1" role="dialog" aria-labelledby="verCortesiaModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verCortesiaModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFecha" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalHora" class="col col-md-8 campoModal"></div>
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
                        <div class="col col-md-3"> <b>Tienda</b></div>
                        <div id="modalTienda" class="col col-md-8 campoModal"></div>
                    </div>
                    <span id="spanProcesado" class="ocultar" hidden>
                        <div class="row">
                            <div class="col col-md-3"> <b>Nota de Entrega</b></div>
                            <div id="modalNotaEntrega" class="col col-md-8 campoModal"></div>
                        </div>
                    </span>
                    <div id="modalId" hidden></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
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
                        <div class="col col-md-3"> <b>Periodo</b></div>
                        <div id="modalPeriodoRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <span id="spanEntregado" class="ocultar" hidden>
                        <div class="row">
                            <div class="col col-md-3"> <b>Entregado a </b></div>
                            <div id="modalEntregadoARecibo" class="col col-md-8 campoModal"></div>
                        </div>
                    </span>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalMontoBs" class="campoModal"></span>, $ <span id="modalMontoUsd" class="campoModal"></span>, € <span id="modalMontoEur" class="campoModal"></span> </div>
                    </div>
                    <div id="modalIdRecibo" hidden></div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Conglomerado -->
<div class="modal fade" id="verConglomeradoModal" tabindex="-1" role="dialog" aria-labelledby="verConglomeradoModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verConglomeradoModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFechaConglomerado" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalHoraConglomerado" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisorConglomerado" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalMontoConglomeradoBs" class="campoModal"></span>, $ <span id="modalMontoConglomeradoUsd" class="campoModal"></span>, € <span id="modalMontoConglomeradoEur" class="campoModal"></span> </div>
                    </div>
                    <span id="spanEntregado" class="ocultar" hidden>
                        <div class="row">
                            <div class="col col-md-3"> <b>Entregado a </b></div>
                            <div id="modalEntregadoAConglomerado" class="col col-md-8 campoModal"></div>
                        </div>
                    </span>
                    <div id="modalIdConglomerado" hidden></div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Proyeccion -->
<div class="modal fade" id="verProyeccionModal" tabindex="-1" role="dialog" aria-labelledby="verProyeccionModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verProyeccionModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFechaProyeccion" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalHoraProyeccion" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Periodo</b></div>
                        <div id="modalPeriodoProyeccion" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalMontoProyeccionBs" class="campoModal"></span>, $ <span id="modalMontoProyeccionUsd" class="campoModal"></span>, € <span id="modalMontoProyeccionEur" class="campoModal"></span> </div>
                    </div>
                    <div id="modalIdProyeccion" hidden></div>
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

        //Detectar cuando se cierra el modal para limpiarlo
        $('.modal').on('hidden.bs.modal', function() {
            $(".ocultar").attr("hidden", true);
            $(".campoModal").text('');
        });

    })

    function modalVerCortesia(idCortesia, idNotificacion) {

        const url = `./controllers/trazabilidadDetalleCortesia.php?id=${idCortesia}`;

        fetch(url)
            .then(response => response.json())
            .then(cortesia => {

                $("#verCortesiaModalLabel").text(`Cortesía Nº ${idCortesia} - ${cortesia.estatus}`);
                $("#modalId").text(idCortesia);
                $("#modalFecha").text(cortesia.fecha);
                $("#modalHora").text(cortesia.hora);
                $("#modalDirector").text(cortesia.director);
                $("#modalSupervisor").text(cortesia.supervisor);
                $("#modalTienda").text(cortesia.tienda);
                $("#modalBeneficiario").text(cortesia.beneficiario);
                $("#modalProductosAsignados").text(cortesia.productosAsignados);
                if (cortesia.estatus == 'Procesado' || cortesia.estatus == 'Autorizado') {
                    $("#modalProductosEntregados").text(cortesia.productosEntregados);
                    $("#modalNotaEntrega").text(cortesia.notaEntrega);
                    $("#spanProcesado").removeAttr("hidden");
                }
                if (cortesia.estatus == 'Autorizado') {
                    $("#modalTipoAprobacion").text(cortesia.tipoAprobacion);
                    $("#modalObservacion").text(cortesia.observacion);
                    $("#spanAutorizado").removeAttr("hidden");
                }
            })
            .catch(error => console.error('Error:', error));

        formdata = {
            id: idNotificacion,
        };

        $.ajax({
            url: './controllers/trazabilidadNotificacionLeida.php',
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

    function modalVerRecibo(idRecibo, idNotificacion) {

        const url = `./controllers/trazabilidadDetalleRecibo.php?id=${idRecibo}`;

        fetch(url)
            .then(response => response.json())
            .then(recibo => {

                $("#verReciboModalLabel").text(`Recibo Nº ${idRecibo} - ${recibo.estatus}`);
                $("#modalIdRecibo").text(idRecibo);
                $("#modalFechaRecibo").text(recibo.fecha);
                $("#modalHoraRecibo").text(recibo.hora);
                $("#modalSupervisorRecibo").text(recibo.supervisor);
                $("#modalTiendaRecibo").text(recibo.tienda);
                $("#modalPeriodoRecibo").text(recibo.periodo);
                $("#modalMontoBs").text(recibo.bs);
                $("#modalMontoUsd").text(recibo.usd);
                $("#modalMontoEur").text(recibo.eur);

                if (recibo.estatus != 'Enviado a Supervisor' && recibo.estatus != 'Confirmado por Supervisor') {
                    $("#modalEntregadoARecibo").text(recibo.entregado);
                    $("#spanEntregado").removeAttr("hidden");
                }
            })
            .catch(error => console.error('Error:', error));

        formdata = {
            id: idNotificacion,
        };

        $.ajax({
            url: './controllers/trazabilidadNotificacionLeida.php',
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

    function modalVerConglomerado(idConglomerado, idNotificacion) {

        const url = `./controllers/trazabilidadDetalleConglomerado.php?id=${idConglomerado}`;

        fetch(url)
            .then(response => response.json())
            .then(conglomerado => {

                $("#verConglomeradoModalLabel").text(`Conglomerado Nº ${idConglomerado} - ${conglomerado.estatus}`);
                $("#modalIdConglomerado").text(idConglomerado);
                $("#modalFechaConglomerado").text(conglomerado.fecha);
                $("#modalHoraConglomerado").text(conglomerado.hora);
                $("#modalSupervisorConglomerado").text(conglomerado.supervisor);
                $("#modalTiendaConglomerado").text(conglomerado.tienda);
                $("#modalPeriodoConglomerado").text(conglomerado.periodo);
                $("#modalMontoConglomeradoBs").text(conglomerado.bs);
                $("#modalMontoConglomeradoUsd").text(conglomerado.usd);
                $("#modalMontoConglomeradoEur").text(conglomerado.eur);

                if (Conglomerado.estatus == 'Confirmado por Director' || conglomerado.estatus == 'Confirmado por Tesoreria') {
                    $("#modalEntregadoAConglomerado").text(conglomerado.entregado);
                    $("#spanEntregado").removeAttr("hidden");
                }
            })
            .catch(error => console.error('Error:', error));

        formdata = {
            id: idNotificacion,
        };

        $.ajax({
            url: './controllers/trazabilidadNotificacionLeida.php',
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

    function modalVerProyeccion(idProyeccion, idNotificacion) {

        const url = `./controllers/trazabilidadDetalleProyeccion.php?id=${idProyeccion}`;

        fetch(url)
            .then(response => response.json())
            .then(proyeccion => {
                $("#verProyeccionModalLabel").text(`Proyeccion Nº ${idProyeccion}`);
                $("#modalIdProyeccion").text(idProyeccion);
                $("#modalFechaProyeccion").text(proyeccion.fecha);
                $("#modalHoraProyeccion").text(proyeccion.hora);
                $("#modalPeriodoProyeccion").text(proyeccion.periodo);
                $("#modalMontoProyeccionBs").text(proyeccion.bs);
                $("#modalMontoProyeccionUsd").text(proyeccion.usd);
                $("#modalMontoProyeccionEur").text(proyeccion.eur);
            })
            .catch(error => console.error('Error:', error));

        formdata = {
            id: idNotificacion,
        };

        $.ajax({
            url: './controllers/trazabilidadNotificacionLeida.php',
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