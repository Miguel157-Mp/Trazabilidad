<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Cotizaciones</h1>
    <p class="mb-4"></p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
        </div>

        <div class="card-body">

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Numero Orden</th>
                            <th scope="col">Materiales</th>

                            <th scope="col">Monto</th>
                            <th scope="col">Requerimiento | Tienda</th>
                            <th scope="col">Prioridad</th>
                            <th scope="col">Fecha</th>
                            <th scope="col" class="text-center">Presupuesto</th>
                            <th scope="col" class="text-center">Enviar a Tesoreria</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //   include("../../db/conexion.php");
                        $sql = "SELECT 
    a.idAdministracion, 
    a.idSolicitud, 
    a.materiales, 
    a.monto, 
    a.email, 
    a.filetest, 
    a.leido, 
    a.idTienda, 
    a.fechaActual, 
    t.nombreTienda,
    p.nombrePrioridad
FROM 
    administracion a
JOIN 
    tienda t ON a.idTienda = t.idTienda
JOIN 
    solicitud s ON a.idSolicitud = s.idSolicitud
JOIN 
    prioridad p ON s.idPrioridad = p.idPrioridad;";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : '';
                                echo '<tr ' . $rowStyle . ' id="row-' . $row["idAdministracion"] . '" onclick="markAsRead(' . $row["idAdministracion"] . ')">';
                                echo '<td>' . htmlspecialchars($row["idAdministracion"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["materiales"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["monto"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["idSolicitud"]) . ' | ' . htmlspecialchars($row["nombreTienda"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td>' . htmlspecialchars($row["nombrePrioridad"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td>' . htmlspecialchars($row["fechaActual"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td><button class="btn btn-primary" onclick="verDetalle(\'' . addslashes($row["filetest"]) . '\')">Ver</button></td>';
                                $idSolicitud = $row["idSolicitud"];

                                // Consulta para verificar si el idSolicitud ya existe
                                $query = "SELECT COUNT(*) FROM serviciosGenerales WHERE idSolicitud = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $idSolicitud);
                                $stmt->execute();
                                $stmt->bind_result($count);
                                $stmt->fetch();
                                $stmt->close();

                                // Verificamos si ya existe el idSolicitud
                                if ($count > 0) {
                                    // Si existe, deshabilitamos el botón
                                    echo '<td><button class="btn btn-secondary enviar-button" hidden data-materiales="' . htmlspecialchars($row["materiales"]) . '" data-monto="' . htmlspecialchars($row["monto"]) . '" data-solicitud="' . htmlspecialchars($row["idSolicitud"]) . '" data-nombre-tienda="' . htmlspecialchars($row["nombreTienda"]) . '">Enviar</button></td>';

                                } else {
                                    echo '<td><button class="btn btn-secondary enviar-button" data-materiales="' . htmlspecialchars($row["materiales"]) . '" data-monto="' . htmlspecialchars($row["monto"]) . '" data-solicitud="' . htmlspecialchars($row["idSolicitud"]) . '" data-nombre-tienda="' . htmlspecialchars($row["nombreTienda"]) . '">Enviar</button></td>';
                                }
                                echo '</tr>';
                            }
                        }
                        //    include("../../db/conexion.php");
                        //    $sql = "SELECT a.idAdministracion, a.materiales, a.monto, a.email, a.filetest, a.leido, a.idTienda, t.nombreTienda 
                        //    FROM administracion a JOIN tienda t ON a.idTienda = t.idTienda";
                        //    $result = $conn->query($sql);
                        
                        //    if ($result->num_rows > 0) {
                        //        while ($row = $result->fetch_assoc()) {
                        //            $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : '';
                        //            echo '<tr ' . $rowStyle . ' id="row-' . $row["idAdministracion"] . '" onclick="markAsRead(' . $row["idAdministracion"] . ')">';
                        //            echo '<td>' . htmlspecialchars($row["materiales"]) . '</td>';
                        //            echo '<td>' . htmlspecialchars($row["monto"]) . '</td>';
                        //            echo '<td>' . htmlspecialchars($row["nombreTienda"]) . '</td>'; // Imprimir nombreTienda
                        //            echo '<td><button class="btn btn-primary" onclick="verDetalle(\'' . addslashes($row["filetest"]) . '\', \'' . $row["filetest"] . '\')">Ver</button></td>';
                        //            echo '</tr>';
                        //        }
                        //    }
                        
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
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Detalle de la Imagen</h5>
                <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Imagen subida" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<script>
    /*funcion para enviar directo a tesoreria */
    $(document).ready(function () {
        // Event delegation for dynamically added buttons
        $(document).on('click', '.enviar-button', function () {
            // Get data from the clicked button's data attributes
            var materiales = $(this).data('materiales');
            var monto = $(this).data('monto');
            var solicitud = $(this).data('solicitud');
            var nombreTienda = $(this).data('nombre-tienda');

            // alert("ID Solicitud: " + solicitud); 

            // Send data via AJAX
            $.ajax({
                url: './scripts/materialesDisponibles.php',
                type: 'POST',
                data: {
                    materiales: materiales,
                    monto: monto,
                    solicitud: solicitud,
                    nombreTienda: nombreTienda
                },
                success: function (response) {
                    // Handle success response
                    console.log('Data sent successfully:', response);
                    alert('Datos enviados correctamente.');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error('Error sending data:', error);
                    alert('Error al enviar los datos.');
                }
            });
        });
    });
    // Definición de la función markAsRead
    function markAsRead(id) {
        $.ajax({
            url: './scripts/leidoModalImagen.php', // Cambia esto a tu archivo PHP para marcar como leído
            type: 'POST',
            data: { id: id },
            success: function (response) {
                console.log(response);
                $('#row-' + id).css('background-color', 'white'); // Cambia el color de fondo
            },
            error: function (jqXHR, status, error) {
                console.error('Error al marcar como leído:', error);
            }
        });
    }

    // Definición de la función verDetalle (ajusta según sea necesario)
    function verDetalle(fileTest) {
        document.getElementById('modalImage').src = 'data:image' + fileTest; // Ajusta el tipo MIME según corresponda
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }


</script>