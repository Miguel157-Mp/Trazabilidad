
<?php
include("../../db/conexion.php");
session_start();

//Declarar mensajes de error y éxito
$msjExito = "Solicitud creada con éxito";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener datos del form
        $idTienda = $_POST["idTienda"];
        $requerimiento = $_POST["requerimiento"];
        $nombreTienda = $_POST["nombreTienda"];
        $prioridad = $_POST["prioridad"];
    // echo $prioridad;
        // Otros datos
        $fechaActual = date('Y-m-d');

        // Insertar recibo
        $query = "INSERT INTO solicitud (fecha, idTienda, requerimiento,nombreTienda,idPrioridad) VALUES (?, ?, ?,?,?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            throw new Exception('Error en la preparación: ' . htmlspecialchars($conn->error));
        }
        
        $stmt->bind_param("sissi", $fechaActual, $idTienda, $requerimiento, $nombreTienda,$prioridad);
        
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
