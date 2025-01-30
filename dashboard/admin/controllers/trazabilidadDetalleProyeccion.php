<?php

include("../../db/conexion.php");

$id = $_GET['id'];

$query = "SELECT fecha, hora, usd, observacion
            FROM trazabilidad_proyeccion 
            WHERE id=?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i",  $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


$proyeccion = array(
    "fecha" => $row['fecha'],
    "hora" => $row['hora'],
    "usd" => $row['usd'],
    "observacion" => $row['observacion']
);

// Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

$json = json_encode($proyeccion);
header('Content-Type: application/json');
echo $json;
