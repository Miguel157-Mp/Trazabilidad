<?php
include("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idObservaciones = intval($_POST['idObservaciones']);
    $fechaLeido = date('Y-m-d H:i:s');

    // Actualizar el estado a leído (1)
    $sql = "UPDATE observaciones SET leido = 1, fechaLeido = ? WHERE idObservaciones = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $fechaLeido, $idObservaciones); // Cambiado a "si"
        
        if ($stmt->execute()) {
            echo "Actualización exitosa";
        } else {
            echo "Error al actualizar: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error en la preparación: " . $conn->error;
    }
}

$conn->close();
?>