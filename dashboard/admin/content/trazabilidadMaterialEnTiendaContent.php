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
                <table class="table " id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Numero</th>
                        <th scope="col">Requerimiento | Tienda</th>
                            <th scope="col">Materiales</th>
                            <th scope="col">fecha y hora</th>
                            <th scope="col">accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                     //   include("../../db/conexion.php");
                        $sql = "SELECT * FROM serviciosGeneralesDinero";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Determina el estilo de la fila basado en si está leído o no
                                $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : 'style="background-color: white;"';
                                echo '<tr ' . $rowStyle . ' id="row-' . $row["idDinero"] . '" onclick="markAsRead(' . $row["idDinero"] . ')">';
                                echo '<td>' . htmlspecialchars($row["idDinero"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td>' . htmlspecialchars($row["idSolicitud"]) . ' | ' . htmlspecialchars($row["nombreTienda"]) . '</td>'; // Imprimir nombreTienda
                                echo '<td>' . htmlspecialchars($row["materiales"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["fechaActual"]) . '</td>';
                                echo '<td><button class="btn btn-primary" onclick="markAsRead(' . $row["idDinero"] . '); event.stopPropagation();">Comprobado</button></td>';

                                // Llama a markAsRead y evita que se propague el evento al tr
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

    // Definición de la función markAsRead
    function markAsRead(id) {
    const button = $('#row-' + id + ' button');
    button.prop('disabled', true); // Deshabilitar el botón

    $.ajax({
        url: './scripts/comprobadoMaterialesDisponibles.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                $('#row-' + id).css('background-color', 'white');
            } else {
                alert(res.message); // Mostrar mensaje de error al usuario
            }
        },
        error: function(jqXHR, status, error) {
            console.error('Error al marcar como leído:', error);
            alert('Ocurrió un error, por favor intenta nuevamente.');
        },
        complete: function() {
            button.prop('disabled', false); // Habilitar el botón nuevamente
        }
    });
}
 
</script>