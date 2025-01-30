<?php
include './modal/modalVerConglomerado.php';
include './modal/modalVerRecibo.php';
include './modal/modalVerCortesia.php';
include './modal/modalVerProyeccion.php';
?>

<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Notificaciones</h1>
    <p class="mb-4">Ver notificaciones</p>

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
                            <th scope="col">Fecha</th>
                            <th scope="col" class="ocultarEnCel">Hora</th>
                            <th scope="col">Notificación</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idUser = $_SESSION['idUser'];
                        $query = "SELECT id, fecha, hora, notificacion, tipoId, idAsociado, leido
                                    FROM trazabilidad_notificaciones 
                                    WHERE idUser = ?
                                    ORDER BY fecha DESC, hora DESC;";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i",  $idUser);



                        if ($stmt->execute()) {

                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $class = $row['leido'] ? '' : 'class="table-info"';
                                if ($row['tipoId'] == "Cortesía") {
                                    $funcionBoton = ' data-target="#verCortesiaModal" onclick="modalVerCortesia(' . htmlspecialchars($row['idAsociado']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                } else if ($row['tipoId'] == "Recibo") {
                                    $funcionBoton = 'data-target="#verReciboModal" onclick="modalVerRecibo(' . htmlspecialchars($row['idAsociado']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                } else if ($row['tipoId'] == "Conglomerado") {
                                    $funcionBoton = 'data-target="#verConglomeradoModal" onclick="modalVerConglomerado(' . htmlspecialchars($row['idAsociado']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                } else if ($row['tipoId'] == "Proyección") {
                                    $funcionBoton = 'data-target="#verProyeccionModal" onclick="modalVerProyeccion(' . htmlspecialchars($row['idAsociado']) . ', ' . htmlspecialchars($row['id']) . ')"';
                                }

                                echo '<tr id="tr' . htmlspecialchars($row['id']) . '" ' . $class . ' >
                                        <td>' . htmlspecialchars($row['fecha']) . ' <span class="mostrarEnCel"> ' . htmlspecialchars($row['hora']) . ' </span> </td>
                                        <td class ="ocultarEnCel">' . htmlspecialchars($row['hora']) . '</td>
                                        <td>' . htmlspecialchars($row['notificacion']) . '</td>
                                        <td> <a class="btn btn-secondary" data-toggle="modal"  ' . $funcionBoton . '  >Ver</a> </td>
                                    </tr>';
                            }
                            $stmt->close();
                        } else {
                            echo "Error preparando la consulta: " . $conn->error;
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

<script src="./js/limpiarModal.js"></script>
<script src="./js/modalVerConglomerado.js"></script>
<script src="./js/modalVerRecibo.js"></script>
<script src="./js/modalVerCortesia.js"></script>
<script src="./js/modalVerProyeccion.js"></script>