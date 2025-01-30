<!-- Div principal -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Recorrido de Iconos</title>
</head>
<style>
body {
    font-family: Arial, sans-serif;
}

.timeline {
    display: flex;
    align-items: center;
    margin: 20px;
}

.step {
    text-align: center;
    cursor: pointer;
}

.circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid gray; /* Color del borde */
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s, border-color 0.3s;
}

.label {
    margin-top: 10px;
}

.arrow {
    width: 50px;
    height: 5px;
    background-color: gray; /* Color de la flecha */
}

.step.active .circle {
    background-color: #33D843; /* Color de fondo al activar */
    border-color: #33D843; /* Cambia el color del borde */
}

.step.active ~ .arrow {
    background-color: #33D843; /* Cambia el color de la flecha activa */
}

/* Llenar toda la línea hasta el paso activo */
.step.active ~ .arrow {
    background-color: #33D843; /* Cambia el color de la flecha activa */
}
</style>
<body>
<div class="timeline">
        <div class="step" id="step1">
            <div class="circle"><i class="fas fa-paper-plane"></i></div>
            <div class="label">Enviado</div>
        </div>
        <div class="arrow"></div>
        <div class="step" id="step2">
            <div class="circle"><i class="fas fa-check-circle"></i></div>
            <div class="label">Confirmado</div>
        </div>
        <div class="arrow"></div>
        <div class="step" id="step5">
            <div class="circle"><i class="fas fa-thumbs-up"></i></div>
            <div class="label">Autorizado</div>
        </div>
        <div class="arrow"></div>
        <div class="step" id="step6">
            <div class="circle"><i class="fas fa-box-open"></i></div>
            <div class="label">Recibido</div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
// Selecciona todos los pasos
const steps = document.querySelectorAll('.step');

// Agrega un evento de clic a cada paso
steps.forEach((step, index) => {
    step.addEventListener('click', () => {
        // Remueve la clase 'active' de todos los pasos
        steps.forEach(s => s.classList.remove('active'));
        
        // Agrega la clase 'active' al paso clicado
        step.classList.add('active');
        
        // Marca todos los pasos anteriores como activos
        for (let i = 0; i <= index; i++) {
            steps[i].classList.add('active');
        }
        
        // Cambia el color de las flechas hasta el paso activo
        const arrows = document.querySelectorAll('.arrow');
        arrows.forEach((arrow, arrowIndex) => {
            if (arrowIndex <= index - 1) { // Solo cambia las flechas antes del paso activo
                arrow.style.backgroundColor = 'green';
            } else {
                arrow.style.backgroundColor = 'gray'; // Restaura el color original
            }
        });
    });
});
    </script>
</body>
</html>
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
                            <th scope="col">Fecha</th>
                            <th scope="col" class="ocultarEnCel">Hora</th>
                            <th scope="col">#Recibo - Tienda</th>
                            <th scope="col" class="ocultarEnCel">Supervisor</th>
                            <th scope="col" class="ocultarEnCel">Monto</th>
                            <th scope="col" class="ocultarEnCel">Periodo</th>
                            <th scope="col" class="ocultarEnCel">Entregado A</th>
                            <th scope="col" class="ocultarEnCel">Estatus</th>
                            <th scope="col" class="mostrarEnCel">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT a.id, fecha, hora, idTienda, idSupervisor, idSupervisorEdo, idEntregado, monto, periodo, observacion, estatus, b.nombreCompleto AS tienda 
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

                            if ($row['idEntregado']) {

                                $query = "SELECT nombreCompleto AS entregado 
                                FROM trazabilidad_usuario 
                                WHERE id=? ";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i",  $row['idEntregado']);
                                $stmt->execute();
                                $result4 = $stmt->get_result();
                                $row4 = $result4->fetch_assoc();
                            }

                            $supervisor = $row['idSupervisor'] ? $row2['supervisor'] : '';
                            $supervisorEdo = $row['idSupervisorEdo'] ? $row3['supervisorEdo'] : '';
                            $entregado = $row['idEntregado'] ? $row4['entregado'] : '';

                            echo '<tr>
                                        <td>' . htmlspecialchars($row['fecha']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['hora']) . '</td>
                                        <td>' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['tienda']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($supervisor) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['monto']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['periodo']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($entregado) . '</td>
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