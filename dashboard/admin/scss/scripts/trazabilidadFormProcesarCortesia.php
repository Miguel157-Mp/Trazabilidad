
<?php
include("../../db/conexion.php");

// Declarar mensajes de error y éxito
$msjExito = "Cortesía procesada con exito";
$msjError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idCortesia = intval($_POST["id"]);
    $notaEntrega = $_POST["notaEntrega"];

    //Verificar que la nota de entrega sea única
    $query = "SELECT id FROM trazabilidad_cortesia WHERE notaEntrega=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $notaEntrega);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {

        // Otros datos
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');
        $estatus  = "Procesado";
        $notificacion = "Se ha entregado un cortesia";

        // Actualizar cortesia
        $query = "UPDATE trazabilidad_cortesia SET notaEntrega=?, estatus=? WHERE id = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $notaEntrega, $estatus, $idCortesia);
        $stmt->execute();

        //Obtener datos de supervisor y director a notificar
        $query = "SELECT idDirector, idSupervisor FROM trazabilidad_cortesia WHERE id = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idCortesia);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $idDirector = $row['idDirector'];
        $idSupervisor = $row['idSupervisor'];

        // Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idCortesia, notificacion ) VALUES (?,?,?,?,?), (?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiisssiis", $fechaActual, $horaActual,  $idDirector, $idCortesia, $notificacion, $fechaActual, $horaActual,  $idSupervisor, $idCortesia, $notificacion);
        $stmt->execute();
    } else {
        $stmt->bind_result($id);
        $stmt->fetch();
        $msjError = "Esta nota de entrega está registrada en la cortesía " . $id;
    }

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
