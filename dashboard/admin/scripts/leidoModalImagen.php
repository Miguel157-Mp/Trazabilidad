<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Configuración de conexión
// $servername="localhost";

// $username="joalcaco_userapp";

// $password="sl?qY)!DyBGTmyG#w=";

// $dbname="joalcaco_appbd";

include("../../db/conexion.php");
// Crear conexión
//$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }

// Obtener el idSolicitud enviado por POST
$idAdministracion = $_POST['id'];

// Actualizar el estado 'leido' en la base de datos
$sql = "UPDATE administracion SET leido = 1 WHERE idAdministracion = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idAdministracion); // Asumiendo que idSolicitud es un entero

if ($stmt->execute()) {
    echo "Estado actualizado correctamente.";
} else {
    echo "Error al actualizar el estado: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>