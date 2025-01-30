<?php
include('../../db/conexion.php');

// Declarar mensajes de error y éxito
$msjExito = 'Recibo redirigido con exito';
$msjError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $idConglomerado = intval($_POST['id']);
    $entregado = explode('-', $_POST['redirigir']);
    $idEntregado  = $entregado[0];
    $tipoEntregado  = $entregado[1];

    // Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $estatus  = $tipoEntregado == 'Director' ? 'Enviado a Director' : 'Redirigido a Tesoreria';
    $notificacion = 'Se ha redirigido un recibo';

    // Actualizar conglomerado
    $query = "UPDATE trazabilidad_conglomerado SET estatus=?, idEntregado =? WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $estatus, $idEntregado, $idConglomerado);
    $stmt->execute();

    // Actualizar recibo
    $query = 'UPDATE trazabilidad_recibo SET estatus=? WHERE idConglomerado = ? ';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $estatus, $idConglomerado);
    $stmt->execute();

    //Obtener datos de supervisor a notificar
    $query = "SELECT idSupervisor FROM trazabilidad_conglomerado WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idConglomerado);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idSupervisor = $row['idSupervisor'];

    // Insertar notificacion
    $query = 'INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idConglomerado, notificacion ) VALUES (?,?,?,?,?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssiis', $fechaActual, $horaActual, $idSupervisor, $idConglomerado, $notificacion);
    $stmt->execute();

    if ($tipoEntregado == 'Tesoreria') {
        // Insertar notificacion
        $query = 'INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idConglomerado, notificacion ) VALUES (?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssiis', $fechaActual, $horaActual, $idEntregado, $idConglomerado, $notificacion);
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
