
<?php
include("../../db/conexion.php");
session_start();

// Declarar mensajes de error y éxito
$msjExito = "Cortesía asignada con éxito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idDirector = $_POST["idDirector"];
    $beneficiario = $_POST["beneficiario"];
    $idTienda = $_POST["idTienda"];
    $productosAsignados = $_POST["productosAsignados"];

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $idSupervisor = $_SESSION['idUser'];
    $estatus  = "Pendiente";
    $notificacion = "Se ha otorgado una cortesía";

    // Insertar cortesía
    $query = "INSERT INTO trazabilidad_cortesia ( fecha, hora, idDirector, idSupervisor, idTienda, beneficiario,  productosAsignados, estatus) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiiisss", $fechaActual, $horaActual, $idDirector, $idSupervisor, $idTienda, $beneficiario, $productosAsignados,  $estatus);
    if (!$stmt->execute()) {
        $msjError = "Error al otorgar cortesía ";
    } else {
        $idCortesia = $conn->insert_id;

        // Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idCortesia, notificacion ) VALUES (?,?,?,?,?),(?,?,?,?,?) ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiisssiis", $fechaActual, $horaActual, $idTienda, $idCortesia, $notificacion, $fechaActual, $horaActual, $idDirector, $idCortesia, $notificacion);
        if (!$stmt->execute()) {
            $msjError = "Error al crear la notificación ";
        }
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
