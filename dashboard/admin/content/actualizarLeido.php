<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// // Configuración de conexión
// $servername="localhost";

// $username="joalcaco_userapp";

// $password="sl?qY)!DyBGTmyG#w=";

// $dbname="joalcaco_appbd";


// // Crear conexión
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Verificar conexión
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }

include("../../db/conexion.php");


// Obtener el idSolicitud enviado por POST
$idSolicitud = $_POST['idSolicitud'];
$fechaLeido = date('Y-m-d H:i:s');
// Actualizar el estado 'leido' en la base de datos
$sql = "UPDATE solicitud SET leido = 1, fechaLeido = ? WHERE idSolicitud = ?";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la declaración fue exitosa
if ($stmt) {
    $stmt->bind_param("si", $fechaLeido, $idSolicitud); // 's' para string (fechaLeido) y 'i' para entero (idSolicitud)

    if ($stmt->execute()) {
        echo "Estado actualizado correctamente.";
    } else {
        echo "Error al actualizar el estado: " . $stmt->error;
    }

    // Cerrar la declaración
} else {
    echo "Error al preparar la declaración: " . $conn->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>