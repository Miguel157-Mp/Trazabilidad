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
    <h1 class="h3 mb-2 text-gray-800">Cortesias</h1>
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
                        <th scope="col ">#Cortesía - Tienda</th>
                        <th scope="col " class="ocultarEnCel">Supervisor</th>
                        <th scope="col ">Nota de Entrega</th>
                        <th scope="col " class="ocultarEnCel">Director</th>
                        <th scope="col " class="ocultarEnCel">Fecha</th>
                        <th scope="col " class="ocultarEnCel text-center">Estatus</th>
                        <th scope="col " class="text-center mostrarEnCel">Acción</th>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT a.id, fecha, hora, notaEntrega, estatus, b.nombreCompleto AS director, c.nombreCompleto AS supervisor, d.nombreCompleto AS tienda 
                                    FROM trazabilidad_cortesia a 
                                    JOIN trazabilidad_usuario b 
                                    JOIN trazabilidad_usuario c 
                                    JOIN trazabilidad_usuario d 
                                    WHERE a.idDirector=b.ID AND a.idSupervisor=c.ID AND a.idTienda=d.ID ORDER BY a.id DESC;";

                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            // Determinar la clase activa según el estatus
                            $estatus = htmlspecialchars($row['estatus']);
                            $activeClassStep1 = '';
                            $activeClassStep2 = '';


                            // Lógica para determinar las clases activas
                            if ($estatus === 'Procesado') {
                                $activeClassStep2 = 'active';
                            } elseif ($estatus === 'Autorizado') {
                                $activeClassStep2 = 'active';
                                $activeClassStep1 = 'active';
                            }
                            echo '<tr>
                                        <td>' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['tienda']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['supervisor']) . '</td>
                                        <td >' . htmlspecialchars($row['notaEntrega']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['director']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                               
                                        <td class="mostrarEnCel"> <a class="btn btn-secondary" data-toggle="modal"  data-target="#verCortesiaModal" onclick="modalVerCortesia(' . htmlspecialchars($row['id']) . ')">Ver</a> </td>
                               
                                    <td class="ocultarEnCel">
                                        <div class="ocultarEnCel" style="text-align:rigth;">' . htmlspecialchars($estatus) . '</div>
                                        <div class="timeline" id="timeline-' . htmlspecialchars($row['id']) . '">
                                            <div class="step ' . $activeClassStep2 . ' " id="step2-' . htmlspecialchars($row['id']) . '">
                                                <div class="circle"><i class="fas fa-check-circle"></i></div>
                                                <div class="label"></div>
                                            </div>
                                            <div class="arrow"></div>
                                            <div class="step ' . $activeClassStep1 . '" id="step1-' . htmlspecialchars($row['id']) . '">
                                                <div class="circle"><i class="fas fa-paper-plane"></i></div>
                                                <div class="label"></div>
                                            </div>
                                        
                                        
                                    </td>
                                        </tr>';
                            echo '<tr class="ocultarPc">
                                        <td   colspan="4" >
                                        <div class="" >' . htmlspecialchars($estatus) . '</div>
                                        <div class="timeline" id="timeline-' . htmlspecialchars($row['id']) . '">
                                        <div class="step ' . $activeClassStep2 . '" id="step2-' . htmlspecialchars($row['id']) . '">
                                        <div class="circle"><i class="fas fa-check-circle"></i></div>
                                        <div class="label"></div>
                                        </div>
                                        <div class="arrow"></div>
                                        <div class="step ' . $activeClassStep1 . '" id="step1-' . htmlspecialchars($row['id']) . '">
                                        <div class="circle"><i class="fas fa-paper-plane"></i></div>
                                        <div class="label"></div>
                                        </div>
                                        </div>
                                        </td>
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
</script>