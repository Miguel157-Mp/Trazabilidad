<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Entregar Recibos</h1>
    <p class="mb-4">Recibos confirmados</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Seleccione los recibos que desee entregar</h6>
        </div>

        <div class="card-body">


            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#Recibo - Tienda</th>
                            <th scope="col">Monto</th>
                            <th scope="col " class="ocultarEnCel">Periodo</th>
                            <th scope="col" class="text-center">Fecha</th>
                            <th scope="col" class="ocultarEnCel text-center">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idSupervisor = $_SESSION['idUser'];
                        $query = "SELECT a.id, fecha, hora, idTienda, bs, usd, eur, periodo, estatus, b.nombreCompleto AS tienda 
                                    FROM trazabilidad_recibo a 
                                    JOIN trazabilidad_usuario b ON  a.idTienda=b.id
                                    WHERE estatus= 'Confirmado por Supervisor' AND idSupervisor = ? 
                                    ORDER BY a.id DESC;";

                        if ($stmt = $conn->prepare($query)) {
                            $stmt->bind_param("i", $idSupervisor);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {

                                echo '<tr>
                                        <td> <input class="mr-1 checkbox-recibo" type="checkbox" value="' . htmlspecialchars($row['id']) . '" data-bs="' . htmlspecialchars($row['bs']) . '" data-usd="' . htmlspecialchars($row['usd']) . '" data-eur="' . htmlspecialchars($row['eur']) . '">' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['tienda']) . '</td>
                                        <td> 
                                            <li> Bs ' . htmlspecialchars(number_format($row['bs'], 0, '', ' ')) . '</li> 
                                            <li> USD ' . htmlspecialchars(number_format($row['usd'], 0, '', ' ')) . '</li>
                                            <li> EUR ' . htmlspecialchars(number_format($row['eur'], 0, '', ' ')) . '</li>
                                        </td>
                                        <td class ="ocultarEnCel">' . htmlspecialchars($row['periodo']) . '</td>
                                        <td class="text-center">' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                        <td id= "tdStatus' . htmlspecialchars($row['id']) . '" class="ocultarEnCel text-center">' . htmlspecialchars($row['estatus']) . '</td>
                                    </tr>';
                            }
                        } else {
                            echo "Error preparando la consulta: " . $conn->error;
                        }

                        ?>
                    </tbody>
                </table>
                <button class="btn btn-secondary" onclick="$('.checkbox-recibo').prop('checked', true); $('#btnMostrarModal').prop('disabled', false);">Seleccionar Todos</button>
                <button id="btnMostrarModal" class="btn btn-primary" data-toggle="modal" data-target="#entregarModal" onclick="modalEntregarRecibo()" disabled>Entregar</button>

            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

</div>

<!-- Modal -->
<div class="modal fade" id="entregarModal" tabindex="-1" role="dialog" aria-labelledby="entregarModalLabel" aria-hidden="true">
    <div style="max-width: 800px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="entregarModalLabel">Confirmar Entrega</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col-5 col-md-3"> <b>Total Recibos</b></div>
                        <div id="modalTotalRecibos" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col-5 col-md-3"> <b> Total Monto</b> </div>
                        <div class="col col-md-8 campoModal font-weight-bold"> Bs <span id="modalTotalBs"></span>, $ <span id="modalTotalUsd"></span>, € <span id="modalTotalEur"></span> </div>
                    </div>
                    <hr>

                    <!-- Formulario -->
                    <form id="formEntregarRecibo" onsubmit="formEntregarRecibo()">
                        <div class="form-group row">
                            <label for="entregado" class="col-md-3 col-form-label">Entregar a</label>
                            <div class="col-md-8">
                                <select class="form-select form-control" id="entregado" name="entregado" aria-label="Floating label select example" required>
                                    <option value="">--</option>
                                    <option value="4-Director">Director Prueba</option>
                                    <?php
                                    $query = "SELECT id, rol, nombreCompleto FROM trazabilidad_usuario WHERE rol = 'Tesoreria' ORDER BY nombreCompleto;";
                                    $stmt = $conn->prepare($query);

                                    if ($stmt->execute()) {

                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '-' . $row['rol'] . '">' . $row['nombreCompleto'] . '</option>';
                                        }
                                    }
                                    $stmt->close();
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-user btn-block">Entregar</button>
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
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //Detectar cuando se cierra el modal para limpiar el form
        $('.modal').on('hidden.bs.modal', function() {
            $(".ocultar").attr("hidden", true);
            $("#formEntregarRecibo button[type='submit']").prop('disabled', false);
            $("#formEntregarRecibo")[0].reset();
            $("#msjExito").children("span").text('');
            $("#msjError").children("span").text('');

        });

        $(document).ready(function() {
            $('.checkbox-recibo').change(function() {
                const cantCheckboxesSeleccionados = $('.checkbox-recibo:checked').length;
                if (cantCheckboxesSeleccionados) {
                    $("#btnMostrarModal").prop('disabled', false);
                } else {
                    $("#btnMostrarModal").prop('disabled', true);
                }
            });
        });
    })

    function modalEntregarRecibo() {

        const checkboxesSeleccionados = $('.checkbox-recibo:checked');
        const totalRecibos = checkboxesSeleccionados.length;
        let totalMontoBs = 0;
        let totalMontoUsd = 0;
        let totalMontoEur = 0;

        checkboxesSeleccionados.each(function() {
            totalMontoBs += $(this).data('bs');
            totalMontoUsd += $(this).data('usd');
            totalMontoEur += $(this).data('eur');
        });

        $('#modalTotalRecibos').text(totalRecibos);
        $('#modalTotalBs').text(totalMontoBs);
        $('#modalTotalUsd').text(totalMontoUsd);
        $('#modalTotalEur').text(totalMontoEur);

    }

    function formEntregarRecibo() {

        event.preventDefault();

        const checkboxesSeleccionados = $('.checkbox-recibo:checked');
        let recibos = [];
        checkboxesSeleccionados.each(function() {
            recibos.push($(this).val());
        });
        const entregado = $("#entregado").val();
        const bs = $('#modalTotalBs').text();
        const usd = $('#modalTotalUsd').text();
        const eur = $('#modalTotalEur').text();

        formdata = {
            recibos: recibos,
            entregado: entregado,
            bs: bs,
            usd: usd,
            eur: eur,
        };

        $.ajax({
            url: './scripts/trazabilidadEntregarRecibo.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {

                $("#msj").removeAttr("hidden");
                $("#formEntregarRecibo button[type='submit']").prop('disabled', true);

                if (response.estatus) {
                    $("#msjExito").children("span").text(response.msj);
                    $("#msjExito").removeAttr("hidden");
                    checkboxesSeleccionados.each(function() {
                        const tdStatus = `#tdStatus${$(this).val()}`;
                        $(tdStatus).text("Entregado").css("color", "blue");
                        $(this).remove();
                    });

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