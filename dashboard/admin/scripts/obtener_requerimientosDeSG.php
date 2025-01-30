<?php
include("../../db/conexion.php"); // Asegúrate de incluir tu conexión a la base de datos

if (isset($_POST['idTienda'])) {
    $idTienda = $_POST['idTienda'];

    $query = "SELECT idSolicitud, materiales FROM administracion WHERE idTienda = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idTienda);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $requerimientos = [];

        while ($row = $result->fetch_assoc()) {
            $requerimientos[] = $row;
        }

        echo json_encode($requerimientos);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(['error' => 'No se recibió el idTienda']);
}