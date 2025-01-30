
<?php
include("../../db/conexion.php");

// Declarar mensajes de error y éxito
$msjExito = "Cortesía autorizada con exito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idCortesia = ($_POST["id"]);

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $estatus  = "Autorizado";
    $notificacion = "Se ha autorizado un cortesia";
    $tipoId = "Cortesía";

    // Actualizar cortesia
    $query = "UPDATE trazabilidad_cortesia SET estatus=? WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estatus, $idCortesia);
    if (!$stmt->execute()) {
        $msjError = "Error al autorizar el cortesia ";
    }

    //Obtener datos de supervisor a notificar
    $query = "SELECT idSupervisor FROM trazabilidad_cortesia WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idCortesia);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idSupervisor = $row['idSupervisor'];

    // Insertar notificacion
    $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisis", $fechaActual, $horaActual,  $idSupervisor, $tipoId, $idCortesia, $notificacion);
    $stmt->execute();

    // Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {

    $msjError = "Error de conexion ";
}

// Devolver mensaje de éxito o error
if ($msjError) {
    $resultado = json_encode(["msj" => $msjError, "estatus" => 0]);
} else {
    $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
}

echo $resultado;
