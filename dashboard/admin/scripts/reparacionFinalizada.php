
<?php
include("../../db/conexion.php");
session_start();

//Declarar mensajes de error y éxito
$msjExito = "Enviado finalizacion de la reparación";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener datos del form
        $materiales = $_POST["materiales"];
        $nombreTienda = $_POST["nombreTienda"];
        $idTienda = $_POST["idTiendaInput"];
        $idSolicitud = $_POST["idSolicitud"];

        // Otros datos
        $fechaActual = date('Y-m-d H:i:s'); 

        // Insertar recibo
        $query = "INSERT INTO finalizado (nombreTienda,materiales,fechaActual,idTienda,idSolicitud ) VALUES (?, ?, ?,?,?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            throw new Exception('Error en la preparación: ' . htmlspecialchars($conn->error));
        }
        
        $stmt->bind_param("sssss",  $nombreTienda,$materiales, $fechaActual,$idTienda,$idSolicitud);
        
        if ($stmt->execute()) {
            // Devolver mensaje de éxito 
            $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
        } else {
            throw new Exception("Error al insertar: " . htmlspecialchars($stmt->error));
        }

    } catch (Exception $e) {
        // Devolver mensaje de error
        $resultado = json_encode(["msj" => $e->getMessage(), "estatus" => 0]);
    }

    // Cerrar declaración y conexión
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();

    // Asegúrate de establecer el tipo de contenido como JSON
    header('Content-Type: application/json');
    echo $resultado;
} else {

    $url = "../trazabilidadCrearRecibo.php";
    header("Location: $url");
}
