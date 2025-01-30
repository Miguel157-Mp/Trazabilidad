<?php

include("../../db/conexion.php");
session_start();
$idUser = $_SESSION['idUser'];

$query = "SELECT COUNT(*) AS total_notificaciones FROM trazabilidad_notificaciones WHERE idUser=? AND leido=0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i",  $idUser);

if ($stmt->execute()) {

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $resultado =  json_encode(["total_notificaciones" => $row['total_notificaciones'], "estatus" => 0]);
} else {

    $resultado = json_encode(["error" => 'Datos no encontrados', "estatus" => 0]);
}

//Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

echo $resultado;
