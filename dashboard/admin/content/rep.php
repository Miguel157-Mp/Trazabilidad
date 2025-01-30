<!-- Div principal -->
 <style>
 body {
    font-family: Arial, sans-serif;
}

.timeline {
    display: flex;
    align-items: center;
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
    width: 40px;
    height: 5px;
    background-color: gray; /* Color de la flecha */
}

.step.active .circle {
    background-color: #0D629A; /* Fondo al activar */
    border-color: #0D629A;    /* Borde al activar */
}

.step.active .circle i {
    color: white; /* Ícono en blanco al activar */
}
 </style>
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
                <table class="table ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Numero - Tienda </th>
                           
                            <th scope="col">Recorrido</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
include("../../db/conexion.php");

// Consulta SQL
// $sql = "SELECT a.idAdministracion, a.leido AS leido_administracion, a.fechaActual, 
//                s.idSolicitud, s.nombreTienda, s.leido AS leido_solicitud
//         FROM administracion a 
//         JOIN solicitud s ON a.idTienda = s.idTienda";
$sql = "SELECT a.idAdministracion, a.leido AS leido_administracion, a.fechaActual, 
               s.idSolicitud, s.nombreTienda, s.leido AS leido_solicitud,
               f.leido AS leido_finalizado
        FROM administracion a 
        JOIN solicitud s ON a.idTienda = s.idTienda
        LEFT JOIN finalizado f ON a.idTienda = f.idTienda";
$result = $conn->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Determina la clase activa para cada paso según su estado
        $activeClassStep1 = ($row['leido_solicitud'] == 1) ? 'active' : '';
        $activeClassStep2 = ($row['leido_administracion'] == 1) ? 'active' : '';
        $activeClassStep6 = ($row['leido_finalizado'] == 1) ? 'active' : '';

        // Imprimir la fila con el recorrido de trazabilidad
        echo '<tr>
            <td>' . htmlspecialchars($row['idSolicitud']) . ' - ' . htmlspecialchars($row['nombreTienda']) . '</td>
            <td>
                <div class="timeline" id="timeline-' . htmlspecialchars($row['idSolicitud']) . '">
                    <div class="step ' . $activeClassStep2 . '" id="step2-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle"><i class="fas fa-check-circle"></i></div>
                     Aprobado
                    </div>
                    <div class="arrow"></div>
                    <div class="step ' . $activeClassStep1 . '" id="step1-' . htmlspecialchars($row['idAdministracion']) . '">
                        <div class="circle"><i class="fas fa-paper-plane"></i></div>
                        En proceso
                    </div>
                    <div class="arrow"></div>
                    <div class="step ' . $activeClassStep6 . '" id="step6-' . htmlspecialchars($row['idAdministracion']) . '">
                        <div class="circle"><i class="fas fa-box-open"></i></div>
                       Finalizado
                    </div>
                </div>
            </td>
        </tr>';
    }
} else {
    echo "<tr><td colspan='2'>No hay resultados.</td></tr>";
}

$conn->close();
?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
<!-- Modal de Satisfacción -->
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
        <button class="btn btn-primary" id="btn-satisfaccion-si">Sí</button>
        <button class="btn btn-danger" id="btn-satisfaccion-no">No</button>
        <input type="text" id="observacion" placeholder="Escriba su observación" style="display:none;" class="form-control mt-2">
        <button class="btn btn-primary" type="submit" name="enviar" id="enviar" style="display:none;">Enviar</button>

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

    

</script>