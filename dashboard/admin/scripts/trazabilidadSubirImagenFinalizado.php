<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../db/conexion.php");

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idSolicitud']) && isset($data['imgPresupuesto'])) {
    $idSolicitud = $data['idSolicitud'];
    $imgPresupuesto = $data['imgPresupuesto'];

    // Convertir Base64 a binario
    $imgData = base64_decode($imgPresupuesto);

    // Prepara la consulta SQL
    $sql = "UPDATE finalizado SET imgPresupuesto = ? WHERE idSolicitud = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(['estatus' => false, 'msj' => 'Error en la preparación de la consulta: ' . htmlspecialchars($conn->error)]));
    }

    // Vincula los parámetros (s para string, i para integer)
    $stmt->bind_param("si", $imgData, $idSolicitud);

    // Ejecuta la declaración
    if ($stmt->execute()) {
        echo json_encode(['estatus' => true, 'msj' => 'Imagen subida exitosamente.']);
    } else {
        echo json_encode(['estatus' => false, 'msj' => 'Error al guardar: ' . htmlspecialchars($stmt->error)]);
    }

    // Cierra la declaración
    $stmt->close();
} else {
    echo json_encode(['estatus' => false, 'msj' => 'Faltan datos necesarios.']);
}

$conn->close();
?>