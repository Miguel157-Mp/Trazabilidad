
<?php
include("../../db/conexion.php");
session_start();

//Declarar mensajes de error y éxito
$msjExito = "Proyección creada con éxito";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        //Obtener datos del form
        $usd = $_POST["usd"];
        $observacion = $_POST["observacion"];

        //Otros datos
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');
        $notificacion = "Se ha creado una proyección";
        $idDirector = 4;
        $tipoId = "Proyección";

        //Insertar proyeccion
        $query = "INSERT INTO trazabilidad_proyeccion (fecha, hora, usd, observacion) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $fechaActual, $horaActual, $usd, $observacion);
        $stmt->execute();
        $idProyeccion = $conn->insert_id; //id del recibo que se acaba de crear

        //Insertar notificacion
        $query = "INSERT INTO trazabilidad_notificaciones (fecha, hora, idUser, tipoId, idAsociado, notificacion ) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisis", $fechaActual, $horaActual, $idDirector, $tipoId, $idProyeccion, $notificacion);
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
