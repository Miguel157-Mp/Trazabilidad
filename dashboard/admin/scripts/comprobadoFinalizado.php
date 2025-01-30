<?php
include("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); // Asegúrate de que 'id' se envía correctamente en el POST
    $fechaLeido = date('Y-m-d H:i:s');

    $sql = "UPDATE finalizado SET leido = 1, fechaLeido = ? WHERE idFinalizado = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la declaración fue exitosa
    if ($stmt) {
        // Cambiar $idFinalizado por $id
        $stmt->bind_param("si", $fechaLeido, $id); // 's' para string (fechaLeido) y 'i' para entero (idFinalizado)
    
        if ($stmt->execute()) {
            echo "Estado actualizado correctamente.";
        } else {
            echo "Error al actualizar el estado: " . $stmt->error;
        }
    
        $stmt->close(); // Cerrar la declaración
    } else {
        echo "Error al preparar la declaración: " . $conn->error;
    }
}
$conn->close();
?>