
<?php
include("../../db/conexion.php");
session_start();

// Declarar mensajes de error y éxito
$msjExito = "Regalo asignado con éxito";
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
    $notificacion = "Se ha asignado un regalo";

    // Insertar regalo
    $query = "INSERT INTO trazabilidad_regalo ( fecha, hora, idDirector, idSupervisor, idTienda, beneficiario,  productosAsignados, estatus) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiiisss", $fechaActual, $horaActual, $idDirector, $idSupervisor, $idTienda, $beneficiario, $productosAsignados,  $estatus);
    if (!$stmt->execute()) {
        $msjError = "Error al asignar el regalo ";
    } else {
        $idRegalo = $conn->insert_id;

        // Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idRegalo, notificacion ) VALUES (?,?,?,?,?),(?,?,?,?,?) ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiisssiis", $fechaActual, $horaActual, $idTienda, $idRegalo, $notificacion, $fechaActual, $horaActual, $idDirector, $idRegalo, $notificacion);
        if (!$stmt->execute()) {
            $msjError = "Error al crear la notificación ";
        }
    }

    // Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();

    // Devolver mensaje de éxito o error
    if ($msjError) {
        $url = "../trazabilidadAsignarRegalo.php?msjError=$msjError";
    } else if ($msjExito) {
        $url = "../trazabilidadAsignarRegalo.php?msjExito=$msjExito";
    }
} else {

    $url = "../trazabilidadAsignarRegalo.php";
}

header("Location: $url");
