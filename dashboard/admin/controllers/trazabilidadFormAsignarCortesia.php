
<?php
include("../../db/conexion.php");
session_start();

// Declarar mensajes de error y éxito
$msjExito = "Cortesía asignada con éxito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idDirector = $_POST["idDirector"];
    $idTienda = $_POST["idTienda"];

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $idSupervisor = $_SESSION['idUser'];
    $estatus  = "Pendiente";
    $notificacion = "Se ha otorgado una cortesía";
    $tipoId = "Cortesía";

    // Insertar cortesía
    $query = "INSERT INTO trazabilidad_cortesia (fecha, hora, idDirector, idSupervisor, idTienda, estatus) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiiis", $fechaActual, $horaActual, $idDirector, $idSupervisor, $idTienda, $estatus);
    if (!$stmt->execute()) {
        $msjError = "Error al otorgar cortesía ";
    } else {
        $idCortesia = $conn->insert_id;

        // Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisis", $fechaActual, $horaActual, $idTienda, $tipoId, $idCortesia, $notificacion);
        $stmt->execute();
    }

    // Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();

    // Devolver mensaje de éxito o error
    if ($msjError) {
        $url = "../trazabilidadAsignarCortesia.php?msjError=$msjError";
    } else if ($msjExito) {
        $url = "../trazabilidadAsignarCortesia.php?msjExito=$msjExito";
    }
} else {

    $url = "../trazabilidadAsignarCortesia.php";
}

header("Location: $url");
