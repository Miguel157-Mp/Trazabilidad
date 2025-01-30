<?php
include("../../db/conexion.php"); // Asegúrate de incluir tu conexión a la base de datos

if (isset($_POST['idTienda'])) {
    $idTienda = $_POST['idTienda'];

   // $query = "SELECT idSolicitud, requerimiento FROM solicitud WHERE idTienda = ?";
   $query = " SELECT s.idSolicitud, s.requerimiento 
    FROM solicitud s
    LEFT JOIN finalizado f ON s.idSolicitud = f.idSolicitud
    WHERE s.idTienda = ? 
    AND f.idSolicitud IS NULL
"; 
   $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idTienda); // Suponiendo que idTienda es un entero

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $requerimientos = array();
        
        while ($row = $result->fetch_assoc()) {
            $requerimientos[] = $row;
        }

        echo json_encode($requerimientos); // Devolver los resultados como JSON
    }
}
?>