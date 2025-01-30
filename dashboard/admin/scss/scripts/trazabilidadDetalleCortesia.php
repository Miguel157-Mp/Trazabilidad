<?php

include("../../db/conexion.php");

$id = $_GET['id'];

$query = "SELECT fecha, hora, notaEntrega, estatus, b.nombreCompleto AS director, c.nombreCompleto AS supervisor, d.nombreCompleto AS tienda 
            FROM trazabilidad_cortesia a 
            JOIN trazabilidad_usuario b 
            JOIN trazabilidad_usuario c 
            JOIN trazabilidad_usuario d 
            WHERE a.id=? AND a.idDirector=b.ID AND a.idSupervisor=c.ID AND a.idTienda=d.ID ORDER BY a.id DESC;";
$stmt = $conn->prepare($query);
$stmt->bind_param("i",  $id);

if ($stmt->execute()) {

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $cortesia = array(
        "fecha" => $row['fecha'],
        "hora" => $row['hora'],
        "director" => $row['director'],
        "supervisor" => $row['supervisor'],
        "tienda" => $row['tienda'],
        "notaEntrega" => $row['notaEntrega'],
        "estatus" => $row['estatus'],
    );
} else {
    echo 'datos no encontrados';
}

// Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

$json = json_encode($cortesia);
header('Content-Type: application/json');
echo $json;
