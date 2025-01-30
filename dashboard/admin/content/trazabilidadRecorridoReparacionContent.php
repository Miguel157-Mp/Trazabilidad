<?php

session_start();
$nombreUsuario = $_SESSION['nombreUsuario'];
$tipoUsuario = $_SESSION['tipoUsuario'];
//echo $nombreUsuario;
//echo $tipoUsuario;
?>
<!-- Div principal -->
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .timeline {
        display: flex;
        align-items: center;
        /* Centrar verticalmente */
    }

    .step {
        text-align: center;
        cursor: pointer;
        position: relative;
        /* Para posicionar la línea */
    }

    .line {
        width: 100px;
        /* Ajusta el ancho según sea necesario */
        /* height: 3px; Altura de la línea */
        background-color: gray;
        /* Color de la línea */
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
    }
    .circle1 {
  width: 58px;
  height: 58px;
  border-radius: 50%;
  border: 1px solid gray;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 10px; /* Espaciado alrededor del texto */
    padding: 10px; 
    font-size: 13px;
}


    .blue-circle {
        background-color: #0D629A;
        /* Fondo azul */
        border-color: #0D629A;
        /* Borde azul */
    }

    .label {
        margin-top: 5px;
    }

    .arrow {
        width: 40px;
        height: 5px;
        background-color: gray;
        /* Color de la flecha */
    }

    .step.active .circle {
        background-color: #0D629A;
        /* Fondo al activar */
        border-color: #0D629A;
        /* Borde al activar */
    }

    .step.active .circle i {
        color: white;
        /* Ícono en blanco al activar */
    }
    
</style>
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Recorrido de reparaciones</h1>
    <p class="mb-4">Tienda</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
        </div>

        <div class="card-body">

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table"  id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Numero - Tienda </th>
                            <th scope="col">Requerimiento </th>
                            <th scope="col">Prioridad Sugerida</th>
                            <th scope="col">Prioridad </th>


                            <th scope="col">Recorrido</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($tipoUsuario == 'Tienda' ) {
                            // include("../../db/conexion.php");
                        
      
                            $query = "SELECT 
                            s.idSolicitud, 
                            s.idPrioridad,
                            p.nombrePrioridad,  
                            MAX(s.fecha) AS fecha, 
                            MAX(s.fechaLeido) AS fechaLeido, 
                            s.nombreTienda,
                            s.requerimiento,
                            p2.nombrePrioridad AS servicioGeneralPrioridad,
                            MAX(a.fechaActual) AS fechaActual,
                            MAX(f.fechaActual) AS fechaFinal,
                            MAX(x.fechaActual) AS fechaDinero,
                            MAX(d.fechaActual) AS fechaTesoreria,
                            s.leido AS leido_solicitud,
                            d.leido AS leido_servicioGeneral,
                            a.leido AS leido_administracion,
                            x.leido AS leido_Dinero,
                            f.leido AS leido_finalizado
                        FROM 
                            solicitud s
                        LEFT JOIN 
                            administracion a ON s.idSolicitud = a.idSolicitud
                        LEFT JOIN 
                            finalizado f ON s.idSolicitud = f.idSolicitud
                        LEFT JOIN 
                            serviciosGenerales d ON s.idSolicitud = d.idSolicitud
                        LEFT JOIN 
                            serviciosGeneralesDinero x ON s.idSolicitud = x.idSolicitud
                        LEFT JOIN 
                            prioridad p ON s.idPrioridad = p.idPrioridad  -- Unión con la tabla prioridad
                        LEFT JOIN 
                            prioridad p2 ON s.prioridadSugerida = p2.idPrioridad  -- Corrección aquí
                        WHERE 
                            s.nombreTienda = '$nombreUsuario'
                        GROUP BY 
                            s.idSolicitud, 
                            s.idPrioridad,  -- Asegúrate de incluir todos los campos no agregados
                            p.nombrePrioridad, 
                            p2.nombrePrioridad;";

                            // En caso de que no se aplique el filtro por nombreTienda:
                        } elseif($tipoUsuario == 'servicioG'){
                            $query = "SELECT 
                            s.idSolicitud, 
                            s.idPrioridad,
                            p.nombrePrioridad,  
                            MAX(s.fecha) AS fecha, 
                            MAX(s.fechaLeido) AS fechaLeido, 
                            s.nombreTienda,
                            s.requerimiento,
                            p2.nombrePrioridad AS servicioGeneralPrioridad,
                            MAX(a.fechaActual) AS fechaActual,
                            MAX(f.fechaActual) AS fechaFinal,
                            MAX(x.fechaActual) AS fechaDinero,
                            MAX(d.fechaActual) AS fechaTesoreria,
                            s.leido AS leido_solicitud,
                            d.leido AS leido_servicioGeneral,
                            a.leido AS leido_administracion,
                            x.leido AS leido_Dinero,
                            f.leido AS leido_finalizado
                        FROM 
                            solicitud s
                        LEFT JOIN 
                            administracion a ON s.idSolicitud = a.idSolicitud
                        LEFT JOIN 
                            finalizado f ON s.idSolicitud = f.idSolicitud
                        LEFT JOIN 
                            serviciosGenerales d ON s.idSolicitud = d.idSolicitud
                        LEFT JOIN 
                            serviciosGeneralesDinero x ON s.idSolicitud = x.idSolicitud
                        LEFT JOIN 
                            prioridad p ON s.idPrioridad = p.idPrioridad  
                        LEFT JOIN 
                            prioridad p2 ON s.prioridadSugerida = p2.idPrioridad  
                        GROUP BY 
                            s.idSolicitud, 
                            s.idPrioridad,  
                            p.nombrePrioridad, 
                            p2.nombrePrioridad;"; // Agregar p.nombrePrioridad al GROUP BY
                        }
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Determina la clase activa para cada paso según su estado
                                $activeClassStep0 = 'active'; // Siempre activo en azul
                                $activeClassStep1 = ($row['leido_solicitud'] == 1) ? 'active' : '';
                                $activeClassStep2 = ($row['leido_administracion'] == 1) ? 'active' : '';
                                $activeClassStep6 = ($row['leido_servicioGeneral'] == 1) ? 'active' : '';
                                $activeClassStep7 = ($row['leido_Dinero'] == 1) ? 'active' : '';
                                $activeClassStep8 = ($row['leido_finalizado'] == 1) ? 'active' : '';
                                $prioridad = $row['nombrePrioridad'];
                                switch ($prioridad) {
                                    case 'Critico':
                                        $color = '#D20103';

                                        break;
                                    case 'Alto':
                                        $color = '#FE9900';
                                        break;
                                    case 'Medio':
                                        $color = '#1CB529';
                                        break;
                                    case 'Bajo':
                                        $color = 'gray';
                                        break;
                                    default:
                                        $color = 'blue'; // Color por defecto si no coincide
                                }
                                // Imprimir la fila con el recorrido de trazabilidad
                                echo '<tr>
            <td>' . htmlspecialchars($row['idSolicitud']) . ' - ' . htmlspecialchars($row['nombreTienda']) . '</td>
            <td>' . htmlspecialchars($row['idSolicitud']) . ' - ' . htmlspecialchars($row['requerimiento']) . '</td>
            <td>' . htmlspecialchars($row['servicioGeneralPrioridad']) . '</td>
           
     <td>   <div class="circle1 " style="background-color:' . $color . '; color: white;  ">' . htmlspecialchars($row['']) . ' ' . htmlspecialchars($row['nombrePrioridad']) . '</div></td>
            <td>
                <div class="timeline" id="timeline-' . htmlspecialchars($row['idSolicitud']) . '">
                    <div class="step ' . $activeClassStep0 . '" id="step0-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle blue-circle"><i class="fas fa-solid fa-share"></i></div> <!-- Siempre azul -->
                        enviado a S.G
                        <div class="date">' . (!empty($row['fecha']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fecha']))) : '') . '</div>
                    </div>
                    <div class="line"></div> <!-- Línea entre pasos -->
                    <div class="step ' . $activeClassStep1 . '" id="step2-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle"><i class="fas fa-check"></i></div>
                        Visto S.G
                        <div class="date">' . (!empty($row['fechaLeido']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaLeido']))) : '') . '</div>
                    </div>
                    <div class="line"></div> <!-- Línea entre pasos -->
                    <div class="step ' . $activeClassStep2 . '" id="step1-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle"><i class="fas fa-check"></i></div>
                        Leido Adm
                        <div class="date">' . (!empty($row['fechaActual']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaActual']))) : '') . '</div>
                    </div>
                    <div class="line"></div> <!-- Línea entre pasos -->
                    <div class="step ' . $activeClassStep6 . '" id="step6-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle"><i class="fas fa-box-open"></i></div>
                        recibido Teso 
                        <div class="date">' . (!empty($row['fechaTesoreria']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaTesoreria']))) : '') . '</div>
                    </div>
                    <div class="line"></div> <!-- Línea entre pasos -->
                    <div class="step ' . $activeClassStep7 . '" id="step7-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle"><i class="fas fa-box-open"></i></div>
                        recibido S.G 
                        <div class="date">' . (!empty($row['fechaDinero']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaDinero']))) : '') . '</div>
                    </div>
                    <div class="line"></div> <!-- Línea entre pasos -->
                    <div class="step ' . $activeClassStep8 . '" id="step8-' . htmlspecialchars($row['idSolicitud']) . '">
                        <div class="circle"><i class="fas fa-solid fa-trophy"></i></div>
                        finalizado
                        <div class="date">' . (!empty($row['fechaFinal']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaFinal']))) : '') . '</div>
                    </div>
                </div>
            </td>
        </tr>';
                            }
                        } else {
                            echo "No se encontraron resultados";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-success" id="downloadPdf">Descargar Reporte</button>
        </div>
    </div>
    <!-- Modal de Satisfacción -->
    <!-- Modal de Satisfacción -->
    <div class="modal fade" id="satisfaccionModal" tabindex="-1" aria-labelledby="satisfaccionModalLabel"
        aria-hidden="true">
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
                    <input type="text" id="observacion" placeholder="Escriba su observación" style="display:none;"
                        class="form-control mt-2">
                    <button class="btn btn-primary" type="submit" name="enviar" id="enviar"
                        style="display:none;">Enviar</button>

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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
// Función para generar el PDF
document.getElementById('downloadPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    doc.setFontSize(18);
    doc.text("Reporte de Solicitudes", 14, 20);

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

    doc.save("reporte_solicitudes.pdf");
});


</script>