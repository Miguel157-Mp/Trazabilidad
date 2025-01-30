<?php
include("../../db/conexion.php");

$id = $_POST['id'];

$query = "UPDATE trazabilidad_notificaciones SET leido=1 WHERE id=? AND leido=0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i",  $id);

if ($stmt->execute()) {

    $resultado =  json_encode(["estatus" => 1]);
} else {

    $resultado = json_encode(["estatus" => 0]);
}

// Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

echo $resultado;
