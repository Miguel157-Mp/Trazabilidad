<?php
include "./modal/modalVerConglomerado.php";
include "./modal/modalVerProyeccion.php";
include "./modal/modalVerEntrega.php";
?>

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
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
            <a class="btn btn-primary" data-toggle="modal" data-target="#añadirEntregaModal"> <i class="fas fa-solid fa-plus"></i> Añadir Entrega</a>
        </div>

        <div class="card-body">

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table " id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Proyectado</th>
                            <th scope="col">Entregado</th>
                            <th scope="col">Observación</th>
                            <th scope="col" class="ocultarEnCel">Conglomerado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT id, fecha, hora, observacion, CONCAT( usd, '$ ') AS proyectado , '' AS entregado, 'Proyección' AS tipo
                                  FROM trazabilidad_proyeccion
                                  UNION ALL
                                  SELECT id, fecha, hora, '' AS observacion, '' AS proyectado, CONCAT(bs, 'Bs  ', usd, '$  ', eur, '€')  AS entregado, 'Conglomerado' AS tipo
                                  FROM trazabilidad_conglomerado 
                                  WHERE estatus = 'Confirmado por Tesoreria' OR estatus = 'Redirigido a Tesoreria' OR estatus = 'En espera de autorización'
                                  UNION ALL 
                                  SELECT id, fecha, hora, observacion, '' AS proyectado, CONCAT( usd, '$ ') AS entregado, 'Entrega' AS tipo 
                                  FROM trazabilidad_entrega
                                  ORDER BY fecha, hora;";

                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {

                            if ($row['tipo'] == "Entrega") {
                                $boton = '<a class="btn btn-secondary" data-toggle="modal" data-target="#verConglomeradoModal" onclick="modalVerConglomerado(' . htmlspecialchars($row['id']) . ')" > Ver </a>';
                            } else if ($row['tipo'] == "Conglomerado") {
                                $boton = '<a class="btn btn-secondary" data-toggle="modal" data-target="#verConglomeradoModal" onclick="modalVerConglomerado(' . htmlspecialchars($row['id']) . ')" > Ver </a>';
                            } else if ($row['tipo'] == "Proyección") {
                                $boton = '<a class="btn btn-secondary" data-toggle="modal" data-target="#verProyeccionModal" onclick="modalVerProyeccion(' . htmlspecialchars($row['id']) . ')" > Ver </a>';
                            }

                            echo '<tr>
                                    <td>' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                    <td>' . htmlspecialchars($row['proyectado']) . '</td>
                                    <td>' . htmlspecialchars($row['entregado']) . '</td>
                                    <td class="ocultarEnCel">' . htmlspecialchars($row['observacion']) . '</td>
                                    <td>' . $boton . ' </td>
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

<!-- Modal Añadir Entrega -->
<div class="modal fade" id="añadirEntregaModal" tabindex="-1" role="dialog" aria-labelledby="añadirEntregaModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="añadirEntregaModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario -->
                <form id="formCrearProyeccion" onsubmit="agregarEntrega()">

                    <div class="form-group row">
                        <label for="usd" class="col-sm-2 col-form-label">Monto</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="usd" name="usd" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="observacion" class="col-sm-2 col-form-label">Observación</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="observacion" name="observacion" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-user btn-block">Crear</button>
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
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function agregarEntrega() {
        event.preventDefault();
        const usd = $('#usd').val();
        const observacion = $('#observacion').val();
        formdata = {
            usd: usd,
            observacion: observacion
        };

        $.ajax({
            url: './controllers/trazabilidadFormAgregarEntrega.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                $("#msj").removeAttr("hidden");
                if (response.estatus) {
                    $("#msjExito").children("span").text(response.msj);
                    $("#msjExito").removeAttr("hidden");
                    $("#formCrearProyeccion")[0].reset();
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

<script src="./js/modalVerConglomerado.js"></script>
<script src="./js/modalVerProyeccion.js"></script>
<script src="./js/modalVerEntrega.js"></script>