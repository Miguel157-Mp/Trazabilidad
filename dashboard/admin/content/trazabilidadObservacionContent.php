<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Observaciones</h1>
    <p class="mb-4">Ver Observaciones</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
        </div>

        <div class="card-body">


            <!-- Tabla -->
            <div class="table-responsive">
                <!-- Botón para abrir el modal -->
<button type="button"  class="btn btn-info" onclick="$('#cuestionario').modal('show');">Mostrar Cuestionario</button>
                <table class="table" id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Reparacion</th>
                            <th scope="col">Tienda</th>
                            <th scope="col">Pregunta 1</th>
                            <th scope="col">Pregunta 2</th>
                            <th scope="col">Pregunta 3</th>
                            <th scope="col">Motivo</th>

                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // include("../../db/conexion.php");
                        
                        $sql = "SELECT idObservaciones, idFinalizado, observacion, materiales, nombreTienda, leido, pregunta1, pregunta2, pregunta3, motivoNo FROM observaciones";
                        $result = $conn->query($sql);

                        // Verificar si hay resultados y llenarlos en la tabla
                        if ($result->num_rows > 0) {
                            // Salida de cada fila
                            while ($row = $result->fetch_assoc()) {
                                $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : '';
                                echo '<tr ' . $rowStyle . ' id="row-' . $row["idObservaciones"] . '" onclick="markAsRead(' . $row["idObservaciones"] . ')">';
                                echo '<td>' . htmlspecialchars($row["materiales"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["nombreTienda"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["pregunta1"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["pregunta2"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["pregunta3"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["motivoNo"]) . '</td>';
                                echo '<td><button class="btn btn-primary">Leído</button></td>';
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
            <button id="downloadPdf" class="btn btn-success">Descargar Reporte</button>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<!-- modal de preguntas -->
 
<div class="modal fade" id="cuestionario" tabindex="-1" role="dialog" aria-labelledby="cuestionario1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Satisfacción del Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>pregunta 1</p>
                <p>¿Qué le pareció el trabajo realizado por el personal de Servicio General?</p>
                <p>pregunta 2</p>
                <p>¿Cómo evaluaría al personal de Servicio General que trabajó durante la actividad?</p>
                <p>pregunta 3</p>
                <p>¿Cree usted que deberían mejorar en algo referente al desarrollo del trabajo o personal?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
    function markAsRead(idObservaciones) {
        console.log("Enviando idObservaciones:", idObservaciones); // Para verificar qué ID se está enviando
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./scripts/leidoObservacion.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Cambiar el color de fondo a blanco después de marcar como leído
                    document.getElementById('row-' + idObservaciones).style.backgroundColor = '';
                } else {
                    console.error("Error al marcar como leído:", xhr.statusText);
                }
            }
        };

        xhr.send("idObservaciones=" + encodeURIComponent(idObservaciones));
    }

document.getElementById('downloadPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    doc.setFontSize(18);
    doc.text("Reporte de Evaluación", 14, 20);

    const table = document.getElementById("dataTable");
    const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.innerText);
    const data = Array.from(table.querySelectorAll("tbody tr")).map(tr => 
        Array.from(tr.querySelectorAll("td")).map(td => td.innerText)
    );

    doc.autoTable({ 
        head: [headers],
        body: data,
        startY: 30,
    });

    doc.save("reporte_Evaluacion.pdf");
});

</script>