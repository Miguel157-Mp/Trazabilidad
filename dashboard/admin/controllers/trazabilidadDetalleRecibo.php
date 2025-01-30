<?php

include("../../db/conexion.php");

$id = $_GET['id'];

$query = "SELECT fecha, hora, idTienda, idSupervisor, idSupervisorEdo, idConglomerado, bs, usd, eur, periodo, estatus, b.nombreCompleto AS tienda 
            FROM trazabilidad_recibo a 
            JOIN trazabilidad_usuario b ON  a.idTienda=b.id
            WHERE a.id=? 
            ORDER BY a.id DESC;";

$stmt = $conn->prepare($query);
$stmt->bind_param("i",  $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['idSupervisor']) {

    $query = "SELECT nombreCompleto AS supervisor 
            FROM trazabilidad_usuario 
            WHERE id=? ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $row['idSupervisor']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row2 = $result->fetch_assoc();
}

if ($row['idSupervisorEdo']) {

    $query = "SELECT nombreCompleto AS supervisorEdo 
            FROM trazabilidad_usuario 
            WHERE id=? ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $row['idSupervisorEdo']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row3 = $result->fetch_assoc();
}

if ($row['idConglomerado']) {

    $query = "SELECT b.nombreCompleto AS entregado 
            FROM trazabilidad_conglomerado a, trazabilidad_usuario b 
            WHERE a.id=? AND a.idEntregado = b.id";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $row['idConglomerado']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row4 = $result->fetch_assoc();
}

$supervisor = $row['idSupervisor'] ? $row2['supervisor'] : '';
$supervisorEdo = $row['idSupervisorEdo'] ? $row3['supervisorEdo'] : '';
$entregado = $row['idConglomerado'] ? $row4['entregado'] : '';
$idConglomerado = $row['idConglomerado'] ?  $row['idConglomerado'] : '';


$recibo = array(
    "fecha" => $row['fecha'],
    "hora" => $row['hora'],
    "bs" => $row['bs'],
    "usd" => $row['usd'],
    "eur" => $row['eur'],
    "periodo" => $row['periodo'],
    "estatus" => $row['estatus'],
    "tienda" => $row['tienda'],
    "supervisor" => $supervisor,
    "supervisorEdo" => $supervisorEdo,
    "entregado" => $entregado,
    "idConglomerado" => $idConglomerado
);


// Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

$json = json_encode($recibo);
header('Content-Type: application/json');
echo $json;
