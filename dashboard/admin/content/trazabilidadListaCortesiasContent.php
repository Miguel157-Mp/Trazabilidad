<?php
include './modal/modalVerCortesia.php';
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
    <h1 class="h3 mb-2 text-gray-800">Cortesías</h1>
    <p class="mb-4">Historial</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
        </div>

        <div class="card-body">

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead class="thead-dark">
                        <th scope="col "> # </th>
                        <th scope="col "> Tienda</th>
                        <th scope="col " class="ocultarEnCel">Productos</th>
                        <th scope="col "> Nota de Entrega</th>
                        <th scope="col " class="ocultarEnCel">Monto</th>
                        <th scope="col " class="ocultarEnCel">Supervisor</th>
                        <th scope="col " class="ocultarEnCel" hidden>Fecha</th>
                        <th scope="col " class="ocultarEnCel" hidden>Estatus</th>
                        <th scope="col " class="ocultarEnCel text-center">Estatus</th>
                        <th scope="col " class="text-center ">Acción</th>
                    </thead>
                    <tbody>
                        <?php
                        $idUser = $_SESSION['idUser'];
                        $query = "SELECT a.id, fecha, hora, notaEntrega, estatus, productos, monto, b.nombreCompleto AS director, c.nombreCompleto AS supervisor, d.nombreCompleto AS tienda 
                                    FROM trazabilidad_cortesia a 
                                    JOIN trazabilidad_usuario b 
                                    JOIN trazabilidad_usuario c 
                                    JOIN trazabilidad_usuario d 
                                    WHERE a.idDirector=b.ID AND a.idSupervisor=c.ID AND a.idTienda=d.ID AND  a.idDirector = $idUser  
                                    ORDER BY a.id DESC;";

                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {

                            // Determinar la clase activa según el estatus
                            $estatus = htmlspecialchars($row['estatus']);
                            $activeClassStep1 = '';
                            $activeClassStep2 = '';
                            $activeClassStep3 = 'active';
                            $icono = '<i class="fas fa-clock ocultarPc" style = "color:#0D629A"></i>';

                            // Lógica para determinar las clases activas
                            if ($estatus === 'Procesado') {
                                $activeClassStep2 = 'active';
                                $icono = '<i class="fas fa-gift ocultarPc" style = "color:#0D629A"></i>';
                            } elseif ($estatus === 'Autorizado') {
                                $activeClassStep2 = 'active';
                                $activeClassStep1 = 'active';
                                $icono = '<i class="fas fa-solid fa-check-circle ocultarPc" style = "color:#0D629A"></i>';
                            }
                            echo '<tr>
                                        <td>' . $icono . ' ' . $row['id'] . '</td>
                                        <td>' . htmlspecialchars($row['tienda']) . '</td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['productos']) . '</td>
                                        <td>' . $row['notaEntrega'] . '</td>
                                        <td class="ocultarEnCel">' . number_format($row['monto'], 2, ',', '.') . ' Bs </td>
                                        <td class="ocultarEnCel">' . htmlspecialchars($row['supervisor']) . '</td>
                                        <td class="ocultarEnCel" hidden>' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                        <td class="ocultarEnCel" hidden>' . htmlspecialchars($row['estatus']) . '</td>
                                        <td class="ocultarEnCel">
                                            <div class="timeline justify-content-center" id="timeline-' . htmlspecialchars($row['id']) . '">
                                                <div class="step ' . $activeClassStep3 . ' " id="step2-' . htmlspecialchars($row['id']) . '">
                                                    <div class="circle"><i class="fas fa-clock"></i></div>
                                                    <div class="label"></div>
                                                </div>
                                                <div class="arrow"></div>
                                                <div class="step ' . $activeClassStep2 . ' " id="step2-' . htmlspecialchars($row['id']) . '">
                                                    <div class="circle"><i class="fas fa-solid fa-gift"></i></div>
                                                    <div class="label"></div>
                                                </div>
                                                <div class="arrow"></div>
                                                <div class="step ' . $activeClassStep1 . '" id="step1-' . htmlspecialchars($row['id']) . '">
                                                    <div class="circle"><i class="fas fa-check-circle"></i></div>
                                                    <div class="label"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td> <a class="btn btn-secondary" data-toggle="modal"  data-target="#verCortesiaModal" onclick="modalVerCortesia(' . htmlspecialchars($row['id']) . ')">Ver</a> </td>
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

<script src="./js/limpiarModal.js"></script>
<script src="./js/modalVerCortesia.js"></script>