<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Presupuestos de Reparaciones</h1>
    <p class="mb-4">Aprobar</p>

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
                        <th scope="col">Numero</th>
                        <th scope="col">Requerimiento | Tienda</th>
                        <th scope="col">Materiales</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Prioridad</th>
                            <th scope="col">Fecha y hora</th>
                            <th scope="col" class="text-center">Presupuesto</th>
                            <th scope="col" class="text-center">Enviar a Serv. Generales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                     //   include("../../db/conexion.php");
                        $sql = "SELECT 
    sg.*, 
    p.nombrePrioridad
FROM 
    serviciosGenerales sg
JOIN 
    solicitud s ON sg.idSolicitud = s.idSolicitud
JOIN 
    prioridad p ON s.idPrioridad = p.idPrioridad;";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Determina el estilo de la fila basado en si está leído o no
                                $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : 'style="background-color: white;"';
                                echo '<tr ' . $rowStyle . ' id="row-' . $row["idServicioGeneral"] . '" onclick="markAsRead(' . $row["idServicioGeneral"] . ')">';
                                echo '<td>' . htmlspecialchars($row["idServicioGeneral"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td>' . htmlspecialchars($row["idSolicitud"]) . ' | ' . htmlspecialchars($row["nombreTienda"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td>' . htmlspecialchars($row["materiales"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["monto"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["nombrePrioridad"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["fechaActual"]) . '</td>';
                                echo '<td><button class="btn btn-primary" onclick="markAsRead(' . $row["idServicioGeneral"] . '); event.stopPropagation();">Leido</button></td>'; // Llama a markAsRead y evita que se propague el evento al tr
                                $idSolicitud = $row["idSolicitud"];

                              
                                $query = "SELECT COUNT(*) FROM serviciosGeneralesDinero WHERE idSolicitud = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $idSolicitud);
                                $stmt->execute();
                                $stmt->bind_result($count);
                                $stmt->fetch();
                                $stmt->close();

                                // Verificamos si ya existe el idSolicitud
                                if ($count > 0) {
                                    echo '<td><button class="btn btn-secondary enviar-button" hidden   data-materiales="' . htmlspecialchars($row["materiales"]) . '"  data-solicitud="' . htmlspecialchars($row["idSolicitud"]) . '" data-nombre-tienda="' . htmlspecialchars($row["nombreTienda"]) . '">Enviar</button></td>';
                                } else {
                                    echo '<td><button class="btn btn-secondary enviar-button"  data-materiales="' . htmlspecialchars($row["materiales"]) . '"  data-solicitud="' . htmlspecialchars($row["idSolicitud"]) . '" data-nombre-tienda="' . htmlspecialchars($row["nombreTienda"]) . '">Enviar</button></td>';
                                }
                                echo '</tr>';
                            }
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



<script>
  /*funcion para enviar directo a tesoreria */
  $(document).ready(function() {
    // Event delegation for dynamically added buttons
    $(document).on('click', '.enviar-button', function() {
        // Get data from the clicked button's data attributes
        var materiales = $(this).data('materiales');
        var solicitud = $(this).data('solicitud'); 
        var nombreTienda = $(this).data('nombre-tienda');

       // alert("ID Solicitud: " + solicitud); 

        // Send data via AJAX
        $.ajax({
            url: './scripts/dineroDisponibleASG.php',
            type: 'POST',
            data: {
                materiales: materiales,
                solicitud: solicitud, 
                nombreTienda: nombreTienda
            },
            success: function(response) {
                // Handle success response
                console.log('Data sent successfully:', response);
                alert('Enviado Correctamente a Servicios Generales.');
            },
            error: function(xhr, status, error) {
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
        url: './scripts/comprobadoMateriales.php', // Cambia esto a tu archivo PHP para marcar como leído
        type: 'POST',
        data: { id: id },
        success: function(response) {
            console.log(response);
            // Cambia el color de fondo a blanco
            $('#row-' + id).css('background-color', 'white');
        },
        error: function(jqXHR, status, error) {
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