<?php
include("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $sql = "UPDATE serviciosGenerales SET leido = 1 WHERE idServicioGeneral = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar']);
    }
    
    $stmt->close();
}

$conn->close();
?>