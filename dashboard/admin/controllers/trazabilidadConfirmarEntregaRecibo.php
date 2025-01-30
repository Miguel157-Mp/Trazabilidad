<?php
include("../../db/conexion.php");
session_start();

// Declarar mensajes de error y éxito
$msjExito = "Entrega confirmada con exito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idConglomerado = intval($_POST["id"]);

    //Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $idDirector = 4;
    $tipoId = "Conglomerado";

    if ($_SESSION['tipoUsuario'] == 'Tesoreria') {
        $estatus  = "Confirmado por Tesoreria";
        $notificacion = "Tesoreria ha confirmado una entrega";
    } else {
        $estatus  = "Confirmado por Director";
        $notificacion = "El Director ha confirmado una entrega";
    }

    //Actualizar conglomerado
    $query = "UPDATE trazabilidad_conglomerado SET estatus=? WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estatus, $idConglomerado);
    $stmt->execute();

    //Actualizar recibo
    $query = "UPDATE trazabilidad_recibo SET estatus=? WHERE idConglomerado = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estatus, $idConglomerado);
    $stmt->execute();

    //Obtener datos de supervisor a notificar
    $query = "SELECT idSupervisor FROM trazabilidad_conglomerado WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idConglomerado);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idSupervisor = $row['idSupervisor'];

    //Insertar notificacion
    $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisis", $fechaActual, $horaActual, $idSupervisor, $tipoId, $idConglomerado, $notificacion);
    $stmt->execute();

    if ($_SESSION['tipoUsuario'] == 'Tesoreria') {
        //Insertar notificacion a director 
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisis", $fechaActual, $horaActual, $idDirector, $tipoId, $idConglomerado, $notificacion);
        $stmt->execute();
    }

    //Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    $msjError = "Error de conexion ";
}

//Devolver mensaje de éxito o error
if ($msjError) {
    $resultado = json_encode(["msj" => $msjError, "estatus" => 0]);
} else {
    $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
}

echo $resultado;
