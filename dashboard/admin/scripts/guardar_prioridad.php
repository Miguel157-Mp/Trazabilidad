<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Conexión a la base de datos
include("../../db/conexion.php"); // Asegúrate de incluir tu archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSolicitud = $_POST['idSolicitud'];
    $prioridadSugerida = $_POST['prioridadSugerida'];

    // Validar y sanitizar los datos
    $idSolicitud = intval($idSolicitud);
    $prioridadSugerida = intval($prioridadSugerida);

    // Consulta para actualizar la prioridad
    $sql = "UPDATE solicitud SET prioridadSugerida = ? WHERE idSolicitud = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $prioridadSugerida, $idSolicitud);

    if ($stmt->execute()) {
        echo "Prioridad actualizada correctamente.";
    } else {
        echo "Error al actualizar la prioridad: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>