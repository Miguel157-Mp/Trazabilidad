<?php
include('../../db/conexion.php');

// Declarar mensajes de error y éxito
$msjExito = 'Recibo redirigido con exito';
$msjError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idRecibo = intval($_POST['id']);
    $entregado = explode('-', $_POST['redirigir']);
    $idEntregado  = $entregado[0];
    $tipoEntregado  = $entregado[1];

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $idNotificacion =  4;
    $estatus  = $tipoEntregado == 'Director' ? 'Enviado a Director' : 'Redirigido a Tesoreria';
    $notificacion = 'Se ha redirigido un recibo';
    $tipoId = "Recibo";

    //Obtener datos supervisor a notificar
    $query = "SELECT idSupervisor FROM trazabilidad_recibo WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idRecibo);
    if (!$stmt->execute()) {
        $msjError = "Error al redirigir el recibo ";
    } else {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $idSupervisor = $row['idSupervisor'];
    }

    // Actualizar recibo
    $query = 'UPDATE trazabilidad_recibo SET estatus=?, idEntregado =? WHERE id = ? ';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $estatus, $idEntregado, $idRecibo);
    $stmt->execute();

    // Insertar notificacion
    $query = 'INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssiis', $fechaActual, $horaActual, $idSupervisor, $idRecibo, $notificacion);
    $stmt->execute();

    if ($tipoEntregado == 'Tesoreria') {
        // Insertar notificacion
        $query = 'INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssisis', $fechaActual, $horaActual, $idEntregado, $tipoId, $idRecibo, $notificacion);
        $stmt->execute();
    }

    // Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    $msjError = 'Error de conexion ';
}

// Devolver mensaje de éxito o error
if ($msjError) {
    $resultado = json_encode(['msj' => $msjError, 'estatus' => 0]);
} else {
    $resultado = json_encode(['msj' => $msjExito, 'estatus' => 1]);
}

echo $resultado;
