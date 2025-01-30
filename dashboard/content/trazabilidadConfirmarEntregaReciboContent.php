<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Confirmar Entrega</h1>
    <p class="mb-4">Procesar conglomerados</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Conglomerados entregados</h6>
        </div>

        <div class="card-body">

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#Conglomerado - Supervisor</th>
                            <th scope="col">Monto</th>
                            <th scope="col" class="ocultarEnCel">Fecha</th>
                            <th scope="col" class="ocultarEnCel">Por entregar A</th>
                            <th scope="col" class="ocultarEnCel text-center">Estatus</th>
                            <th scope="col" class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idEntregado = $_SESSION['idUser'];
                        $queryDirector = "SELECT a.id, fecha, hora, b.nombreCompleto As entregado, c.nombreCompleto AS supervisor, bs, usd, eur, estatus
                                            FROM trazabilidad_conglomerado a 
                                            JOIN trazabilidad_usuario b ON  a.idEntregado=b.id
                                            JOIN trazabilidad_usuario c ON  a.idSupervisor=c.id
                                            WHERE a.estatus='Enviado a Director' OR a.estatus='En espera de autorización'
                                            ORDER BY a.id DESC;";

                        $queryTesoreria = "SELECT a.id, fecha, hora, b.nombreCompleto As entregado, c.nombreCompleto AS supervisor, bs, usd, eur, estatus
                                            FROM trazabilidad_conglomerado a 
                                            JOIN trazabilidad_usuario b ON  a.idEntregado=b.id
                                            JOIN trazabilidad_usuario c ON  a.idSupervisor=c.id
                                            WHERE estatus='Redirigido a Tesoreria' OR estatus='Autorizado por Director'
                                            ORDER BY a.id DESC;";

                        $query = $_SESSION['tipoUsuario'] == 'Director' ? $queryDirector : $queryTesoreria;

                        if ($stmt = $conn->prepare($query)) {
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {

                                $btnConfirmar = '<a id= "btnConfirmar' . htmlspecialchars($row['id']) . '" class="btn btn-secondary" data-toggle="modal" data-target="#confirmarModal" onclick="modalConfirmarEntregaRecibo(' . htmlspecialchars($row['id']) . ')">Confirmar</a>';
                                $btnAutorizar = '<a id= "btnAutorizar' . htmlspecialchars($row['id']) . '" class="btn btn-secondary" data-toggle="modal" data-target="#autorizarModal" onclick="modalAutorizarEntregaRecibo(' . htmlspecialchars($row['id']) . ')">Autorizar</a>';
                                $boton = $row['estatus'] == 'En espera de autorización' ?  $btnAutorizar : $btnConfirmar;
                                $botonRedirigir = $_SESSION['tipoUsuario'] == 'Director' ? '<a id= "btnRedirigir' . htmlspecialchars($row['id']) . '" class="btn btn-warning mt-1" data-toggle="modal" data-target="#redirigirModal" onclick="modalRedirigirEntregaRecibo(' . htmlspecialchars($row['id']) . ')">Redirigir</a>' : '';

                                echo '<tr>
                                        <td>' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['supervisor']) . '</td>
                                        <td> 
                                            <li> Bs ' . htmlspecialchars(number_format($row['bs'], 0, '', ' ')) . '</li> 
                                            <li> USD ' . htmlspecialchars(number_format($row['usd'], 0, '', ' ')) . '</li>
                                            <li> EUR ' . htmlspecialchars(number_format($row['eur'], 0, '', ' ')) . '</li>
                                        </td>
                                        <td>' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['entregado']) . '</td>
                                        <td id= "tdStatus' . htmlspecialchars($row['id']) . '" class="ocultarEnCel text-center">' . htmlspecialchars($row['estatus']) . '</td>
                                        <td class="text-center">' . $boton . ' ' . $botonRedirigir . '</td>
                                    </tr>';
                            }
                        } else {
                            echo "Error preparando la consulta: " . $conn->error;
                        }

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

<!-- Modal Confirmar Recibo -->
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
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisor" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalMontoBs" class="campoModal"></span>, $ <span id="modalMontoUsd" class="campoModal"></span>, € <span id="modalMontoEur" class="campoModal"></span> </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"> <b>Por entregar A</b></div>
                        <div id="modalEntregadoA" class="col col-md-8 campoModal"></div>
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
                <button id="btnConfirmarModal" class="btn btn-primary" type="button" onclick="confirmarEntregaRecibo()">Confirmar</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Autorizar Recibo-->
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
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalAutorizarFechaRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalAutorizarHoraRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalAutorizarSupervisor" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalAutorizarMontoBs" class="campoModal"></span>, $ <span id="modalAutorizarMontoUsd" class="campoModal"></span>, € <span id="modalAutorizarMontoEur" class="campoModal"></span> </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Por Entregar A</b></div>
                        <div id="modalAutorizarEntregadoA" class="col col-md-8 campoModal"></div>
                    </div>
                    <div id="modalAutorizarIdRecibo" hidden></div>

                    <!-- Mensajes de éxito o error -->
                    <div id="msjAutorizar" class="ocultar" hidden>
                        <hr class="sidebar-divider">
                        <span id="msjExitoAutorizar" class="ocultar" hidden>
                            <a href="#" class="btn btn-success btn-circle btn-sm"> <i class="fas fa-check"></i></a>
                            <span>Mensaje de Exito</span>
                        </span>
                        <span id="msjErrorAutorizar" class="ocultar" hidden>
                            <a href="#" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-info-circle"></i></a>
                            <span>Mensaje de Error</span>
                        </span>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button id="btnAutorizarModal" class="btn btn-primary" type="button" onclick="autorizarEntregaRecibo()">Autorizar</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Redirigir Recibo -->
<div class="modal fade" id="redirigirModal" tabindex="-1" role="dialog" aria-labelledby="redirigirModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="redirigirModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalRedirigirFechaRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalRedirigirHoraRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalRedirigirSupervisor" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalRedirigirMontoBs" class="campoModal"></span>, $ <span id="modalRedirigirMontoUsd" class="campoModal"></span>, € <span id="modalRedirigirMontoEur" class="campoModal"></span> </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Por entregar A</b></div>
                        <div id="modalRedirigirEntregadoA" class="col col-md-8 campoModal"></div>
                    </div>
                    <div id="modalRedirigirIdRecibo" hidden></div>

                    <hr class="sidebar-divider">

                    <!-- Formulario -->
                    <form id="formRedirigirRecibo" onsubmit="formRedirigirRecibo()">

                        <div class="form-group row">
                            <label for="redirigir" class="col-md-3 col-form-label">Redirigir a</label>
                            <div class="col-md-8">
                                <select class="form-select form-control" id="redirigir" name="redirigir" aria-label="Floating label select example" required>
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
                                <button type="submit" class="btn btn-warning btn-user btn-block">Redirigir</button>
                            </div>
                        </div>

                        <!-- Mensajes de éxito o error -->
                        <div id="msjRedirigir" class="ocultar" hidden>
                            <hr class="sidebar-divider">
                            <span id="msjExitoRedirigir" class="ocultar" hidden>
                                <a href="#" class="btn btn-success btn-circle btn-sm"> <i class="fas fa-check"></i></a>
                                <span>Mensaje de Exito</span>
                            </span>
                            <span id="msjErrorRedirigir" class="ocultar" hidden>
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
        $('.modal').on('hidden.bs.modal', function() {
            $(".ocultar").attr("hidden", true);
            $("#btnConfirmarModal").prop('disabled', false);
            $("#btnAutorizarModal").prop('disabled', false);
            $("#formRedirigirRecibo button[type='submit']").prop('disabled', false);
            $("#msjError").children("span").text('');
            $("#msjExito").children("span").text('');
            $("#msjErrorAutorizar").children("span").text('');
            $("#msjExitoAutorizar").children("span").text('');
            $("#msjErrorRedirigir").children("span").text('');
            $("#msjExitoRedirigir").children("span").text('');
            $(".campoModal").text('');

        });
    })

    function modalConfirmarEntregaRecibo(id) {

        const url = `./controllers/trazabilidadDetalleConglomerado.php?id=${id}`;

        fetch(url)
            .then(response => response.json())
            .then(conglomerado => {

                $("#confirmarModalLabel").text(`Recibo Nº ${id} - ${conglomerado.estatus}`);
                $("#modalIdRecibo").text(id);
                $("#modalFechaRecibo").text(conglomerado.fecha);
                $("#modalHoraRecibo").text(conglomerado.hora);
                $("#modalMontoBs").text(conglomerado.bs);
                $("#modalMontoUsd").text(conglomerado.usd);
                $("#modalMontoEur").text(conglomerado.eur);
                $("#modalSupervisor").text(conglomerado.supervisor);
                $("#modalEntregadoA").text(conglomerado.entregado);


            })
            .catch(error => console.error('Error:', error));
    }

    function confirmarEntregaRecibo() {

        const id = $("#modalIdRecibo").text()

        formdata = {
            id: id,
        };

        $.ajax({
            url: './controllers/trazabilidadConfirmarEntregaRecibo.php',
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
                    $(`#btnRedirigir${id}`).prop('hidden', true);
                    $(`#btnConfirmar${id}`).prop('hidden', true);
                    $(`#btnAutorizar${id}`).prop('hidden', true);

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

    function modalAutorizarEntregaRecibo(id) {

        const url = `./controllers/trazabilidadDetalleConglomerado.php?id=${id}`;

        fetch(url)
            .then(response => response.json())
            .then(conglomerado => {

                $("#autorizarModalLabel").text(`Recibo Nº ${id} - ${conglomerado.estatus}`);
                $("#modalAutorizarIdRecibo").text(id);
                $("#modalAutorizarFechaRecibo").text(conglomerado.fecha);
                $("#modalAutorizarHoraRecibo").text(conglomerado.hora);
                $("#modalAutorizarSupervisor").text(conglomerado.supervisor);
                $("#modalAutorizarMontoBs").text(conglomerado.bs);
                $("#modalAutorizarMontoUsd").text(conglomerado.usd);
                $("#modalAutorizarMontoEur").text(conglomerado.eur);
                $("#modalAutorizarEntregadoA").text(conglomerado.entregado);

            })
            .catch(error => console.error('Error:', error));
    }

    function autorizarEntregaRecibo() {

        const id = $("#modalAutorizarIdRecibo").text()

        formdata = {
            id: id,
        };

        $.ajax({
            url: './controllers/trazabilidadAutorizarEntregaRecibo.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {

                $("#msjAutorizar").removeAttr("hidden");
                $("#btnAutorizarModal").prop('disabled', true);

                if (response.estatus) {
                    $("#msjExitoAutorizar").children("span").text(response.msj);
                    $("#msjExitoAutorizar").removeAttr("hidden");
                    const tdStatus = `#tdStatus${id}`;
                    $(tdStatus).text("Autorizado").css("color", "blue");
                    $(`#btnRedirigir${id}`).prop('hidden', true);
                    $(`#btnConfirmar${id}`).prop('hidden', true);
                    $(`#btnAutorizar${id}`).prop('hidden', true);

                } else {
                    $("#msjErrorAutorizar").children("span").text(response.msj);
                    $("#msjErrorAutorizar").removeAttr("hidden");
                }
            },
            error: function(jqXHR, status, error) {
                $("#msjAutorizar").removeAttr("hidden");
                $("#msjErrorAutorizar").children("span").text('Error en conexion');
                $("#msjErrorAutorizar").removeAttr("hidden");
                console.error(jqXHR, status, error);
            }
        });
    }

    function modalRedirigirEntregaRecibo(id) {

        const url = `./controllers/trazabilidadDetalleConglomerado.php?id=${id}`;

        fetch(url)
            .then(response => response.json())
            .then(conglomerado => {

                $("#redirigirModalLabel").text(`Recibo Nº ${id} - ${conglomerado.estatus}`);
                $("#modalRedirigirIdRecibo").text(id);
                $("#modalRedirigirFechaRecibo").text(conglomerado.fecha);
                $("#modalRedirigirHoraRecibo").text(conglomerado.hora);
                $("#modalRedirigirSupervisor").text(conglomerado.supervisor);
                $("#modalRedirigirMontoBs").text(conglomerado.bs);
                $("#modalRedirigirMontoUsd").text(conglomerado.usd);
                $("#modalRedirigirMontoEur").text(conglomerado.eur);
                $("#modalRedirigirEntregadoA").text(conglomerado.entregado);

            })
            .catch(error => console.error('Error:', error));
    }

    function formRedirigirRecibo() {

        event.preventDefault();

        const id = $("#modalRedirigirIdRecibo").text();
        const redirigir = $("#redirigir").val();

        formdata = {
            id: id,
            redirigir: redirigir
        };

        $.ajax({
            url: './controllers/trazabilidadFormRedirigirRecibo.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {

                $("#msjRedirigir").removeAttr("hidden");
                $("#formRedirigirRecibo button[type='submit']").prop('disabled', true);

                if (response.estatus) {
                    $("#msjExitoRedirigir").children("span").text(response.msj);
                    $("#msjExitoRedirigir").removeAttr("hidden");
                    const tdStatus = `#tdStatus${id}`;
                    $(tdStatus).text("Redirigido").css("color", "#f6c23e");
                    $(`#btnRedirigir${id}`).prop('hidden', true);
                    $(`#btnConfirmar${id}`).prop('hidden', true);
                    $(`#btnAutorizar${id}`).prop('hidden', true);


                } else {
                    $("#msjErrorRedirigir").children("span").text(response.msj);
                    $("#msjErrorRedirigir").removeAttr("hidden");
                }
            },
            error: function(jqXHR, status, error) {
                $("#msjRedirigir").removeAttr("hidden");
                $("#msjErrorRedirigir").children("span").text('Error en conexion');
                $("#msjErrorRedirigir").removeAttr("hidden");
                console.error(jqXHR, status, error);
            }
        });
    }
</script>