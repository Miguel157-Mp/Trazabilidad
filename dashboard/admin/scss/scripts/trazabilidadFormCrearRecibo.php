
<?php
include("../../db/conexion.php");
session_start();

//Declarar mensajes de error y éxito
$msjExito = "Recibo creado con éxito";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        //Obtener datos del form
        $idSupervisor = $_POST["idSupervisor"];
        $bs = $_POST["bs"];
        $usd = $_POST["usd"];
        $eur = $_POST["eur"];
        $periodo = $_POST["periodo"];

        //Otros datos
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');
        $idTienda = $_SESSION['idUser'];
        $estatus  = "Enviado a Supervisor";
        $notificacion = "Se ha creado un recibo";

        //Insertar recibo
        $query = "INSERT INTO trazabilidad_recibo (fecha, hora, idTienda, idSupervisor, bs, usd, eur, periodo, estatus) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiiiiiss", $fechaActual, $horaActual, $idTienda, $idSupervisor, $bs, $usd, $eur, $periodo, $estatus);
        $stmt->execute();
        $idRecibo = $conn->insert_id; //id del recibo que se acaba de crear

        //Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, idRecibo, notificacion ) VALUES (?,?,?,?,?) ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiis", $fechaActual, $horaActual, $idSupervisor, $idRecibo, $notificacion);
        $stmt->execute();

        //Cerrar conexión a la base de datos
        $stmt->close();
        $conn->close();

        //Devolver mensaje de éxito 
        $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
    } catch (Exception $e) {

        //Devolver mensaje de error
        $resultado = json_encode(["msj" => $e, "estatus" => 0]);
    }

    echo $resultado;
} else {

    $url = "../trazabilidadCrearRecibo.php";
    header("Location: $url");
}
