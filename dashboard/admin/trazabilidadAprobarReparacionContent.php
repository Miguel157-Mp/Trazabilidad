<?php
session_start(); 
$nombreUsuario = $_SESSION['nombreUsuario'];
//echo $nombreUsuario;
?>
<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Material en tienda</h1>
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
                            <th scope="col">Requerimiento | Tienda</th>
                            <th scope="col">Materiales</th>
                            <th scope="col">Fecha y hora</th>
                            <th scope="col">accion</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
// Incluye la conexión a la base de datos
// include("../../db/conexion.php");

// Prepara la consulta SQL
$sql = "SELECT f.*, t.nombreTienda, f.idSolicitud 
        FROM finalizado f
        JOIN tienda t ON f.idTienda = t.idTienda";

// Si el nombre de usuario no es 'tienda', añade una cláusula WHERE
if ($nombreUsuario !== 'tienda') {
    $sql .= " WHERE t.nombreTienda = ?";
}

// Prepara la declaración
$stmt = $conn->prepare($sql);

// Si el nombre de usuario no es 'tienda', vincula el parámetro
if ($nombreUsuario !== 'tienda') {
    $stmt->bind_param("s", $nombreUsuario);
}

// Ejecuta la consulta
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Determina el estilo de la fila basado en si está leído o no
        $rowStyle = ($row["leido"] == 0) ? 'style="background-color: lightblue;"' : 'style="background-color: white;"';
        echo '<tr ' . $rowStyle . ' id="row-' . $row["idFinalizado"] . '">';
        echo '<td>' . htmlspecialchars($row["idSolicitud"]) . ' | ' . htmlspecialchars($row["nombreTienda"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["materiales"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["fechaActual"]) . '</td>';
        
        // Texto y botones para finalizar la reparación
        echo '<td>
                <span id="finalizada-' . $row["idFinalizado"] . '" style="display: none;">Finalizada la reparación</span>
                <button class="btn btn-primary" style="display:none;" onclick="finalizarReparacion(' . $row["idFinalizado"] . ', true)">Sí</button>
                <button class="btn btn-danger" onclick="finalizarReparacion(' . $row["idFinalizado"] . ', false)">No</button>
                <input type="text" id="observacion-' . $row["idFinalizado"] . '" placeholder="Escriba su observación" style="display:none;" class="form-control mt-2">
                <button class="btn btn-success" id="enviar-' . $row["idFinalizado"] . '" style="display:none;" onclick="enviarObservacion(' . $row["idFinalizado"] . ')">Enviar</button>
              </td>';
        
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">No hay resultados disponibles.</td></tr>';
}

// Cierra la conexión a la base de datos
$stmt->close();
$conn->close();
?>
                </tbody>
                </table>
            </div>

        </div>
    </div>
<!-- Modal de Satisfacción -->
<div class="modal fade" id="satisfaccionModal" tabindex="-1" aria-labelledby="satisfaccionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="satisfaccionModalLabel">¿Está satisfecho con la reparación?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Por favor, indique si está satisfecho con la reparación.</p>
        <button class="btn btn-primary" style="display:none;" id="btn-satisfaccion-si" data-id="">Sí</button>
        <button class="btn btn-danger" id="btn-satisfaccion-no">No</button>
        <input type="text" id="observacion" placeholder="Escriba su observación" style="display:none;" class="form-control mt-2">
        <button class="btn btn-primary" type="button" name="enviar" id="enviar" style="display:none;">Enviar</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
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
 // Definición de la función markAsRead
function markAsRead(id) {
    $.ajax({
        url: './scripts/comprobadoFinalizado.php', // Cambia esto a tu archivo PHP para marcar como leído
        type: 'POST',
        data: { id: id },
        success: function(response) {
            console.log(response);
            $('#row-' + id).css('background-color', 'white'); // Cambiar color a blanco si es necesario
        },
        error: function(jqXHR, status, error) {
            console.error('Error al marcar como leído:', error);
        }
    });
}

let currentId; // Variable para almacenar el ID actual
let isObservacionVisible = false; // Variable para controlar la visibilidad del campo de observación

/*script para marcar leido o finalizado */
document.getElementById("btn-satisfaccion-si").addEventListener("click", function() {
    alert(data-id)
    const id = this.getAttribute("data-id");
    markAsRead(id); // Marca como leído
    finalizarReparacion(id, true); // Indica que está satisfecho
});

/*script para abrir observacion y boton de enviaar */
document.getElementById('btn-satisfaccion-no').onclick = function() {
            const observacionField = document.getElementById('observacion');
            const enviarField = document.getElementById('enviar');

            // Alternar la visibilidad del campo de observación
            if (isObservacionVisible) {
                observacionField.style.display = 'none'; // Ocultar campo de observación
                enviarField.style.display = 'none'; // Ocultar campo de envío
                isObservacionVisible = false; // Actualizar estado
            } else {
                observacionField.style.display = 'block'; // Mostrar campo de observación
                enviarField.style.display = 'block'; // Mostrar campo de envío
                isObservacionVisible = true; // Actualizar estado
            }
        };

function finalizarReparacion(id, isSatisfied) {
    const row = document.getElementById('row-' + id);
    
    if (isSatisfied) {
        markAsRead(id);
        row.style.backgroundColor = 'lightblue'; // Cambiar color de fondo a azul
        document.getElementById('finalizada-' + id).style.display = 'inline'; // Mostrar texto de finalización
        document.getElementById('observacion-' + id).style.display = 'none'; // Ocultar campo de observación
        document.getElementById('enviar-' + id).style.display = 'none'; // Ocultar botón de enviar
        document.getElementById('btn-satisfaccion-si').style.display = 'none';
        document.getElementById('btn-satisfaccion-no').style.display = 'none';
    } else {
        const observationField = document.getElementById('observacion-' + id);
        observationField.style.display = 'block'; // Mostrar campo de observación
        observationField.focus(); // Enfocar en el campo de observación
        
        // Mostrar el botón de enviar
        document.getElementById('enviar-' + id).style.display = 'block';
    }
}

/*funcion para enviar la observacion */
function enviarObservacion(id) {
    const observation = document.getElementById('observacion-' + id).value;
    
    // Obtener los materiales y el nombre de la tienda de la fila correspondiente
    const row = document.getElementById('row-' + id);
    const materialesCell = row.cells[1]; // Asumiendo que los materiales están en la segunda celda (índice 1)
    const nombreTiendaCell = row.cells[0]; // Asumiendo que el nombre de la tienda está en la primera celda (índice 0)

    const materiales = materialesCell.textContent; // Obtener el texto de los materiales
    const nombreTienda = nombreTiendaCell.textContent; // Obtener el texto del nombre de la tienda

    $.ajax({
        url: './scripts/enviarObservacion.php', // Cambia esto a tu archivo PHP para manejar la observación
        type: 'POST',
        data: { 
            id: id, 
            observation: observation, 
            materiales: materiales, 
            nombreTienda: nombreTienda // Enviar también el nombre de la tienda
        },
        success: function(response) {
            console.log("Observación, materiales y nombre de tienda enviados:", response);
        //    markAsRead(id); // Marca como leído después de enviar la observación
            document.getElementById('observacion-' + id).style.display = 'none'; // Ocultar campo de observación
        },
        error: function(jqXHR, status, error) {
            console.error('Error al enviar la observación:', error);
        }
    });
}
</script>