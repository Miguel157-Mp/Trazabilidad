<?php
include("../../db/conexion.php");

// Declarar mensajes de error y éxito
$msjExito = "Recibo confirmado con exito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idRecibo = intval($_POST["id"]);

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $estatus  = "Confirmado por Supervisor";
    $notificacion = "Un supervisor ha confirmado un recibo";
    $tipoId = "Recibo";

    // Actualizar recibo
    $query = "UPDATE trazabilidad_recibo SET estatus=? WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estatus, $idRecibo);
    if (!$stmt->execute()) {
        $msjError = "Error al confirmar recibo ";
    }

    //Obtener datos tienda a notificar
    $query = "SELECT idTienda FROM trazabilidad_recibo WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idRecibo);
    if (!$stmt->execute()) {
        $msjError = "Error al confirmar el recibo ";
    } else {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $idTienda = $row['idTienda'];
    }

    // Insertar notificacion
    $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisis", $fechaActual, $horaActual, $idTienda, $tipoId, $idRecibo, $notificacion);
    $stmt->execute();

    // Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    $msjError = "Error de conexion ";
}

// Devolver mensaje de éxito o error
if ($msjError) {
    $resultado = json_encode(["msj" => $msjError, "estatus" => 0]);
} else {
    $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
}

echo $resultado;
