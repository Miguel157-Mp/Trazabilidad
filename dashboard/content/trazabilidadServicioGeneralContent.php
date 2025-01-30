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

                            <th scope="col">tienda</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../../db/conexion.php");

                        $sql = "SELECT idSolicitud, fecha, requerimiento, nombreTienda,leido FROM solicitud";
                        $result = $conn->query($sql);

                        // Verificar si hay resultados y llenarlos en la tabla
                        if ($result->num_rows > 0) {


                            // Salida de cada fila
                            while ($row = $result->fetch_assoc()) {
                                $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : '';
                                echo '<tr ' . $rowStyle . ' id="row-' . $row["idSolicitud"] . '" onclick="markAsRead(' . $row["idSolicitud"] . ')">';
                                echo '<td>' . $row["fecha"] . '</td>';
                                echo '<td>' . $row["nombreTienda"] . '</td>';
                                // Agregar el requerimiento como atributo de datos para usarlo en el modal
                                echo '<td><button class="btn btn-primary" onclick="verDetalle(\'' . addslashes($row["requerimiento"]) . '\', \'' . $row["fecha"] . '\')">Ver</button></td>'; 
                                echo '</tr>';
                            }

                        } else {
                            echo "0 resultados";
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

<!-- Modal para mostrar detalles del requerimiento -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalleModalLabel">Detalles del Requerimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="detalleRequerimiento"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script>
function markAsRead(idSolicitud) {
    console.log("Enviando idSolicitud:", idSolicitud); // Para verificar qué ID se está enviando
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "actualizarLeido.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Cambiar el color de fondo a blanco después de marcar como leído
            document.getElementById('row-' + idSolicitud).style.backgroundColor = '';
        }
    };
    
    xhr.send("idSolicitud=" + encodeURIComponent(idSolicitud));
}

function verDetalle(requerimiento, fecha) {
    // Mostrar el requerimiento en el modal
    document.getElementById('detalleRequerimiento').innerText = requerimiento;
    
    // Mostrar el modal
    $('#detalleModal').modal('show');

    // Marcar como leído al abrir el modal
    markAsRead(fecha);
}



    $(document).ready(function () {

        //Detectar cuando se cierra el modal para limpiarlo
        $('.modal').on('hidden.bs.modal', function () {
            $(".ocultar").attr("hidden", true);
            $(".campoModal").text('');
        });

    })

    function modalVerCortesia(idCortesia, idNotificacion) {

        const url = `./scripts/trazabilidadDetalleCortesia.php?id=${idCortesia}`;

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
            url: './scripts/trazabilidadNotificacionLeida.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function (response) {
                verificarNotificaciones();
                const trId = `#tr${idNotificacion}`;
                $(trId).removeClass("table-info");
            },
            error: function (jqXHR, status, error) {

                console.error(jqXHR, status, error);
            }
        });
    }

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
            url: './scripts/trazabilidadNotificacionLeida.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function (response) {
                verificarNotificaciones();
                const trId = `#tr${idNotificacion}`;
                $(trId).removeClass("table-info");
            },
            error: function (jqXHR, status, error) {

                console.error(jqXHR, status, error);
            }
        });
    }

    function modalVerConglomerado(idConglomerado, idNotificacion) {

        const url = `./scripts/trazabilidadDetalleConglomerado.php?id=${idConglomerado}`;

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
            url: './scripts/trazabilidadNotificacionLeida.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function (response) {
                verificarNotificaciones();
                const trId = `#tr${idNotificacion}`;
                $(trId).removeClass("table-info");
            },
            error: function (jqXHR, status, error) {

                console.error(jqXHR, status, error);
            }
        });
    }
</script>