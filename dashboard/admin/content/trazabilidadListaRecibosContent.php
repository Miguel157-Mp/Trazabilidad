<?php
include './modal/modalVerRecibo.php';
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
        }

        .step.active .circle {
            background-color: #0D629A;
            border-color: #0D629A;
        }

        .step.active .circle i {
            color: white;
        }
    </style>
    <h1 class="h3 mb-2 text-gray-800">Recibos</h1>
    <p class="mb-4">Historial</p>
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
                            <th scope="col ">#</th>
                            <th scope="col">Tienda</th>
                            <th scope="col">Monto</th>
                            <th scope="col" class="ocultarEnCel">Periodo</th>
                            <th scope="col " class="ocultarEnCel" hidden>Fecha</th>
                            <th scope="col " class="ocultarEnCel" hidden>Estatus</th>
                            <th scope="col" class="ocultarEnCel">Supervisor</th>
                            <th scope="col" class="ocultarEnCel">Entregado A</th>
                            <th scope="col" class="ocultarEnCel text-center">Estatus</th>
                            <th scope="col" class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idUser = $_SESSION['idUser'];
                        $rolUser = $_SESSION['tipoUsuario'];
                        if ($rolUser == 'Tesoreria') {
                            $query = "SELECT a.id, a.fecha, a.hora, idTienda, a.idSupervisor, a.idSupervisorEdo, idConglomerado, a.bs, a.usd, a.eur, periodo, a.estatus, b.nombreCompleto AS tienda
                                FROM trazabilidad_recibo a 
                                JOIN trazabilidad_usuario b ON a.idTienda=b.id 
                                ORDER BY a.id DESC";
                        } else {
                            $query = "SELECT a.id, a.fecha, a.hora, idTienda, a.idSupervisor, a.idSupervisorEdo, idConglomerado, a.bs, a.usd, a.eur, periodo, a.estatus, b.nombreCompleto AS tienda, idEntregado
                                FROM trazabilidad_recibo a 
                                JOIN trazabilidad_usuario b ON a.idTienda=b.id 
                                JOIN trazabilidad_conglomerado c ON a.idConglomerado = c.id
                                WHERE idEntregado = $idUser
                                ORDER BY a.id DESC;";
                        }
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            // Obtener supervisores
                            if ($row['idSupervisor']) {
                                $query = "SELECT nombreCompleto AS supervisor FROM trazabilidad_usuario WHERE id=?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $row['idSupervisor']);
                                $stmt->execute();
                                $result2 = $stmt->get_result();
                                $row2 = $result2->fetch_assoc();
                            }
                            if ($row['idSupervisorEdo']) {
                                $query = "SELECT nombreCompleto AS supervisorEdo FROM trazabilidad_usuario WHERE id=?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $row['idSupervisorEdo']);
                                $stmt->execute();
                                $result3 = $stmt->get_result();
                                $row3 = $result3->fetch_assoc();
                            }
                            //Obtener entregado
                            if ($row['idConglomerado']) {

                                $query = "SELECT b.nombreCompleto AS entregado 
                                            FROM trazabilidad_conglomerado a, trazabilidad_usuario b 
                                            WHERE a.id=? AND a.idEntregado = b.id";

                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i",  $row['idConglomerado']);
                                $stmt->execute();
                                $result4 = $stmt->get_result();
                                $row4 = $result4->fetch_assoc();
                            }

                            // Asignar supervisores y entregado
                            $supervisor = $row['idSupervisor'] ? htmlspecialchars($row2['supervisor']) : '';
                            $supervisorEdo = $row['idSupervisorEdo'] ? htmlspecialchars($row3['supervisorEdo']) : '';
                            $entregado = $row['idConglomerado'] ? $row4['entregado'] : '';

                            // Determinar la clase activa según el estatus
                            $estatus = htmlspecialchars($row['estatus']);
                            $activeClassStep1 = 'active';
                            $activeClassStep2 = '';
                            $activeClassStep3 = '';
                            $activeClassStep4 = '';
                            $activeClassStep5 = '';
                            $activeClassStep6 = '';
                            $icono = '<i class="fas fa-store ocultarPc" style = "color:#0D629A"></i>';
                            $iconoPaso4 = $iconoPaso5 = $iconoPaso6 = '<i class="fas fa-user-tie ">';
                            $hidden = $hidden6 = 'hidden';

                            //Lógica para determinar las clases activas
                            if ($estatus == 'Confirmado por Supervisor') {
                                //Paso 2
                                $activeClassStep2 = 'active';
                                $icono = '<i class="fas fa-user-check ocultarPc" style = "color:#0D629A"></i>';
                            } else if ($estatus == 'En espera de autorización' || $estatus == 'Enviado a Director') {
                                //Paso 3
                                $activeClassStep2 = 'active';
                                $activeClassStep3 = 'active';
                                $icono = '<i class="fas fa-clock ocultarPc" style = "color:#0D629A"></i>';
                            } elseif ($estatus == 'Confirmado por Director' || $estatus == 'Autorizado por Director' || $estatus == 'Redirigido a Tesorería' || $estatus == 'Redirigido a Director' || $estatus == 'Redirigido a Director (T)') {
                                //Paso 4  
                                $activeClassStep2 = 'active';
                                $activeClassStep3 = 'active';
                                $activeClassStep4 = 'active';
                                if ($estatus == 'Confirmado por Director') {
                                    $icono = '<i class="fas fa-solid fa-user-tie ocultarPc" style = "color:#0D629A"></i>';
                                } else if ($estatus == 'Autorizado por Director') {
                                    $icono = '<i class="fas fa-check ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-check">';
                                    $iconoPaso5 = '<i class="fas fa-arrow-right ">';
                                    $iconoPaso6 = '<i class="fas fa-file-invoice-dollar ">';
                                    $hidden = '';
                                    $hidden6 = '';
                                } else if ($estatus == 'Redirigido a Director (T)') {
                                    $icono = '<i class="fas fa-arrow-right ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-arrow-right">';
                                    $hidden = '';
                                } else {
                                    $icono = '<i class="fas fa-arrow-right ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-arrow-right">';
                                    $hidden = '';
                                    if ($estatus == 'Redirigido a Tesorería') {
                                        $iconoPaso5 = '<i class="fas fa-file-invoice-dollar ">';
                                    }
                                }
                            } else if ($estatus == 'Confirmado por Director (R)' || $estatus == 'Confirmado por Director (T)' || $estatus == 'Confirmado por Tesorería (R)' || $estatus == 'Redirigido a Director (A)' || $estatus == 'Redirigido a Director (T)' || $estatus == 'Confirmado por Tesorería') {

                                //Paso 5
                                $activeClassStep2 = 'active';
                                $activeClassStep3 = 'active';
                                $activeClassStep4 = 'active';
                                $activeClassStep5 = 'active';
                                if ($estatus == 'Confirmado por Director (R)') {
                                    $icono = '<i class="fas fa-solid fa-user-tie ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-arrow-right">';
                                    $hidden = '';
                                } else if ($estatus == 'Confirmado por Director (T)') {
                                    $icono = '<i class="fas fa-solid fa-user-tie ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-arrow-right">';
                                    $hidden = '';
                                } else if ($estatus == 'Confirmado por Tesorería (R)') {
                                    $icono = '<i class="fas fa-file-invoice-dollar ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-arrow-right">';
                                    $iconoPaso5 = '<i class="fas fa-file-invoice-dollar ">';
                                    $hidden = '';
                                } else if ($estatus == 'Redirigido a Director (A)') {
                                    $icono = '<i class="fas fa-arrow-right ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso5 = '<i class="fas fa-arrow-right">';
                                    $hidden = '';
                                    $hidden6 = '';
                                } else {
                                    $icono = '<i class="fas fa-file-invoice-dollar ocultarPc" style = "color:#0D629A"></i>';
                                    $iconoPaso4 = '<i class="fas fa-check">';
                                    $iconoPaso5 = '<i class="fas fa-file-invoice-dollar">';
                                    $hidden = '';
                                }
                            } else if ($estatus == 'Confirmado por Director (A)') {
                                $activeClassStep2 = 'active';
                                $activeClassStep3 = 'active';
                                $activeClassStep4 = 'active';
                                $activeClassStep5 = 'active';
                                $activeClassStep6 = 'active';
                                $icono = '<i class="fas fa-solid fa-user-tie ocultarPc" style = "color:#0D629A"></i>';
                                $iconoPaso4 = '<i class="fas fa-check">';
                                $iconoPaso5 = '<i class="fas fa-arrow-right">';
                                $hidden = '';
                                $hidden6 = '';
                            }

                            echo '<tr>
                                    <td>' . $icono . ' ' . $row['id'] . '</td>
                                    <td>' . htmlspecialchars($row['tienda']) . '</td>
                                    <td class="monto"> 
                                        <li> Bs ' . htmlspecialchars(number_format($row['bs'], 0, '', ' ')) . '</li> 
                                        <li> USD ' . htmlspecialchars(number_format($row['usd'], 0, '', ' ')) . '</li>
                                        <li> EUR ' . htmlspecialchars(number_format($row['eur'], 0, '', ' ')) . '</li>
                                    </td>
                                    <td class="ocultarEnCel">' . htmlspecialchars($row['periodo']) . '</td>
                                    <td class="ocultarEnCel" hidden>' . htmlspecialchars($row['fecha']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                    <td class="ocultarEnCel" hidden>' . htmlspecialchars($row['estatus']) . ' ' . htmlspecialchars($row['hora']) . '</td>
                                    <td class="ocultarEnCel">' . htmlspecialchars($supervisor) . '</td>
                                    <td class="ocultarEnCel">' . htmlspecialchars($entregado) . ' </td>
                                    <td class="ocultarEnCel">
                                        <div class="timeline justify-content-center" >
                                            <div class="step ' . $activeClassStep1 . '">
                                                <div class="circle"><i class="fas fa-store"></i></div>
                                                <div class="label"></div>
                                            </div>
                                            <div class="arrow"></div>
                                            <div class="step ' . $activeClassStep2 . '">
                                                <div class="circle"><i class="fas fa-user-check "></i></div>
                                                <div class="label"></div>
                                            </div>
                                            <div class="arrow"></div>
                                            <div class="step ' . $activeClassStep3 . '">
                                                <div class="circle"><i class="fas fa-clock "></i></div>
                                                <div class="label"></div>
                                            </div>
                                            <div class="arrow"></div>
                                            <div class="step ' . $activeClassStep4 .  '">
                                                <div class="circle">' . $iconoPaso4 . '</i></div>
                                                <div class="label"></div>
                                            </div> 
                                            <div class="arrow" ' . $hidden . '></div>
                                            <div class="step ' . $activeClassStep5 . '" ' . $hidden . '>
                                                <div class="circle">' . $iconoPaso5 . '</i></div>
                                                <div class="label"></div>
                                            </div>
                                            <div class="arrow" ' . $hidden6 . '></div>
                                            <div class="step ' . $activeClassStep6 . '" ' . $hidden6 . '>
                                                <div class="circle">' . $iconoPaso6 . '</i></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td> 
                                        <a class="btn btn-secondary" data-toggle="modal" data-target="#verReciboModal" onclick="modalVerRecibo(' . htmlspecialchars($row['id']) . ')">Ver</a> 
                                    </td>
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
<script src="./js/modalVerRecibo.js"></script>