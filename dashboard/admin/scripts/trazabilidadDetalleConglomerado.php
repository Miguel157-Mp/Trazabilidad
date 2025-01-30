<?php

include("../../db/conexion.php");

$id = $_GET['id'];

$query = "SELECT fecha, hora, b.nombreCompleto As entregado, c.nombreCompleto AS supervisor, bs, usd, eur, estatus
            FROM trazabilidad_conglomerado a 
            JOIN trazabilidad_usuario b ON  a.idEntregado=b.id
            JOIN trazabilidad_usuario c ON  a.idSupervisor=c.id
            WHERE a.id=?;";

$stmt = $conn->prepare($query);
$stmt->bind_param("i",  $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$conglomerado = array(
    "fecha" => $row['fecha'],
    "hora" => $row['hora'],
    "entregado" => $row['entregado'],
    "supervisor" => $row['supervisor'],
    "bs" => $row['bs'],
    "usd" => $row['usd'],
    "eur" => $row['eur'],
    "estatus" => $row['estatus'],
);

// Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

$json = json_encode($conglomerado);
header('Content-Type: application/json');
echo $json;
