<?php
session_start(); 
$nombreUsuario = $_SESSION['nombreUsuario'];

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL
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
    p2.nombrePrioridad;";

$result = $conn->query($query);
?>
<style>
    table {
        border-collapse: collapse; /* Colapsa bordes */
        width: 100%; /* Ancho de la tabla */
    }
    tr {
        border-top: 1px solid black; /* Línea horizontal superior */
    }
    tr:first-child {
        border-top: none; /* Sin línea superior en el primer fila */
    }
    td {
        border-left: none; /* Sin borde izquierdo */
        border-right: none; /* Sin borde derecho */
    }
</style>
<div class="table-responsive">
<div id="reportContent">
    <h1>Reporte de Solicitudes</h1>
    <table id="dataTable" border="1" class="table" width="100%">
        <thead  class="thead-dark">
            <tr>
                <th scope="col-2">N° - Tienda</th>
                <th scope="col-4">Requerimiento</th>
                <th scope="col-1">Pri. Sugerida</th>
                <th scope="col-1">Prioridad</th>
                <th scope="col">Recorrido</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['idSolicitud']) . ' - ' . htmlspecialchars($row['nombreTienda']); ?></td>
        <td><?php echo htmlspecialchars($row['requerimiento']); ?></td>
        <td><?php echo htmlspecialchars($row['servicioGeneralPrioridad']); ?></td>
        <td>
            <div class="circle1" style="background-color: <?php echo $color; ?>; color: white;">
                <?php echo htmlspecialchars($row['nombrePrioridad']); ?>
            </div>
        </td>
        <td>
            <div class="timeline" id="timeline-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                <div class="step <?php echo $activeClassStep0; ?>" id="step0-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                    <div class="circle blue-circle"><i class="fas fa-solid fa-share"></i></div>
                    Enviado a S.G
                    <div class="date"><?php echo !empty($row['fecha']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fecha']))) : ''; ?></div>
                </div>
                <div class="line"></div>
                <div class="step <?php echo $activeClassStep1; ?>" id="step2-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                    <div class="circle"><i class="fas fa-check"></i></div>
                    Visto S.G
                    <div class="date"><?php echo !empty($row['fechaLeido']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaLeido']))) : ''; ?></div>
                </div>
                <div class="line"></div>
                <div class="step <?php echo $activeClassStep2; ?>" id="step1-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                    <div class="circle"><i class="fas fa-check"></i></div>
                    Leído Adm
                    <div class="date"><?php echo !empty($row['fechaActual']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaActual']))) : ''; ?></div>
                </div>
                <div class="line"></div>
                <div class="step <?php echo $activeClassStep6; ?>" id="step6-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                    <div class="circle"><i class="fas fa-box-open"></i></div>
                    Recibido Teso
                    <div class="date"><?php echo !empty($row['fechaTesoreria']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaTesoreria']))) : ''; ?></div>
                </div>
                <div class="line"></div>
                <div class="step <?php echo $activeClassStep7; ?>" id="step7-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                    <div class="circle"><i class="fas fa-box-open"></i></div>
                    Recibido S.G
                    <div class="date"><?php echo !empty($row['fechaDinero']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaDinero']))) : ''; ?></div>
                </div>
                <div class="line"></div>
                <div class="step <?php echo $activeClassStep8; ?>" id="step8-<?php echo htmlspecialchars($row['idSolicitud']); ?>">
                    <div class="circle"><i class="fas fa-solid fa-trophy"></i></div>
                    Finalizado
                    <div class="date"><?php echo !empty($row['fechaFinal']) ? htmlspecialchars(date('d/m/Y', strtotime($row['fechaFinal']))) : ''; ?></div>
                </div>
            </div>
        </td>
    </tr>
                </div>
<?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No hay resultados disponibles.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<button class="btn btn-success" id="downloadPdf">Descargar Reporte</button>

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

<?php
$conn->close(); // Cerrar conexión a la base de datos al final del script.
?>
