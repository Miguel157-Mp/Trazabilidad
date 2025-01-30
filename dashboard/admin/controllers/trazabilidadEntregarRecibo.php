<?php
include('../../db/conexion.php');
session_start();

//Declarar mensajes de error y éxito
$msjExito = 'Recibo entregado con exito';
$msjError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Obtener datos del form
    $recibos = $_POST['recibos'];
    $entregado = explode('-', $_POST['entregado']);
    $idEntregado  = $entregado[0];
    $tipoEntregado  = $entregado[1];
    $bs = $_POST['bs'];
    $usd = $_POST['usd'];
    $eur = $_POST['eur'];

    //Otros datos
    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');
    $idSupervisor = $_SESSION['idUser'];
    $estatus  = $tipoEntregado == 'Director' ? 'Enviado a Director' : 'En espera de autorización';
    $notificacion = $tipoEntregado == 'Director' ? 'Ha recibido un recibo' : 'Se requiere autorización';
    $tipoId = "Conglomerado";
    $idDirector = 4; //De momento solo recibe la notificacion el director

    //Crear conglomerado
    $query = 'INSERT INTO trazabilidad_conglomerado(fecha, hora, idEntregado, idSupervisor, bs, usd, eur, estatus ) VALUES (?,?,?,?,?,?,?,?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssiiiiis', $fechaActual, $horaActual, $idEntregado, $idSupervisor, $bs, $usd, $eur, $estatus);
    $stmt->execute();
    $idConglomerado = $conn->insert_id;

    //Actualizar recibos
    foreach ($recibos as $idRecibo) {
        $query = 'UPDATE trazabilidad_recibo SET estatus=?, idConglomerado =? WHERE id = ? ';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sii', $estatus, $idConglomerado, $idRecibo);
        $stmt->execute();
    }


    // Insertar notificacion
    $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisis", $fechaActual, $horaActual, $idDirector, $tipoId, $idConglomerado, $notificacion);
    $stmt->execute();

    //Cerrar conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    $msjError = 'Error de conexion ';
}

//Devolver mensaje de éxito o error
if ($msjError) {
    $resultado = json_encode(['msj' => $msjError, 'estatus' => 0]);
} else {
    $resultado = json_encode(['msj' => $msjExito, 'estatus' => 1]);
}

echo $resultado;
