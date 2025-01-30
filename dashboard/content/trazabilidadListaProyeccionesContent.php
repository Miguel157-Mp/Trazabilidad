<!-- Div principal -->
<div class="container-fluid">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .timeline {
            display: flex;
            align-items: center;
            /* margin: 20px; */
        }

        .step {
            text-align: center;
            cursor: pointer;
        }

        .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid gray;
            /* Color del borde */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .label {
            margin-top: 10px;
        }

        .arrow {
            width: 40px;
            height: 5px;
            background-color: gray;
            /* Color de la flecha */
        }

        .step.active .circle {
            background-color: #0D629A;
            /* Color de fondo al activar */
            border-color: #0D629A;
            /* Cambia el color del borde */
        }

        .step.active .circle i {
            color: white;
            /* Cambia el color del ícono a blanco */
        }
    </style>
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
                            <th scope="col" class="ocultarEnCel">Fecha</th>
                            <th scope="col">Periodo</th>
                            <th scope="col">Proyectado</th>
                            <th scope="col">Entregado</th>
                            <th scope="col" class="ocultarEnCel">Conglomerado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT fecha, hora, periodo, CONCAT( usd, '$ ') AS proyectado , '' AS entregado, '' AS conglomerado  
                                  FROM trazabilidad_proyeccion
                                  UNION ALL
                                  SELECT fecha, hora, '' AS periodo, '' AS proyectado ,  CONCAT(bs, 'Bs  ', usd, '$  ', eur, '€')  AS entregado, id AS conglomerado
                                  FROM trazabilidad_conglomerado 
                                  WHERE estatus = 'Confirmado por Tesoreria' OR estatus = 'Redirigido a Tesoreria' OR estatus = 'En espera de autorización'
                                  ORDER BY fecha, hora;";

                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                    <td class="ocultarEnCel">' . htmlspecialchars($row['fecha']) . '</td>
                                    <td class="ocultarEnCel">' . htmlspecialchars($row['periodo']) . '</td>
                                    <td>' . htmlspecialchars($row['proyectado']) . '</td>
                                    <td>' . htmlspecialchars($row['entregado']) . '</td>
                                    <td> <a class="btn btn-secondary" data-toggle="modal" data-target="#verConglomeradoModal" onclick="modalVerConglomerado(' . htmlspecialchars($row['conglomerado']) . ')" > Ver </a> </td>
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

<script>
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
</script>