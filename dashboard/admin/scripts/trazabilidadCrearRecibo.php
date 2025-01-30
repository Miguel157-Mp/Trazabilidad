
<?php
include("../../db/conexion.php");
session_start();

// Declarar mensajes de error y éxito
$msjExito = "Recibo creado con éxito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idSupervisor = $_POST["idSupervisor"];
    $monto = $_POST["monto"];
    $periodo = $_POST["periodo"];

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $idTienda = $_SESSION['idUser'];
    $estatus  = "Entregado a Supervisor";
    $notificacion = "Se ha creado un recibo";

    // Insertar regalo
    $query = "INSERT INTO trazabilidad_recibo (fecha, hora, idTienda, idSupervisor, monto, periodo, estatus) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiisss", $fechaActual, $horaActual, $idTienda, $idSupervisor, $monto, $periodo, $estatus);
    if (!$stmt->execute()) {
        $msjError = "Error al crear recibo ";
    } else {
        $idRecibo = $conn->insert_id;

        // Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idRegalo, notificacion ) VALUES (?,?,?,?,?) ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiis", $fechaActual, $horaActual, $idSupervisor, $idRecibo, $notificacion);
        if (!$stmt->execute()) {
            $msjError = "Error al crear la notificación ";
        }
    }

    // Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();

    // Devolver mensaje de éxito o error
    if ($msjError) {
        $url = "../trazabilidadCrearRecibo.php?msjError=$msjError";
    } else if ($msjExito) {
        $url = "../trazabilidadCrearRecibo.php?msjExito=$msjExito";
    }
} else {

    $url = "../trazabilidadCrearRecibo.php";
}

header("Location: $url");
