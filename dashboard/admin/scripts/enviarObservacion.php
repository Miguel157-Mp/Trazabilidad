<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que las variables estén definidas
    if (isset($_POST['idFinalizado'], $_POST['materiales'], $_POST['nombreTienda'])) {
        $id = $_POST['idFinalizado'];
       
        $materiales = $_POST['materiales'];
       
        $nombreTienda = $_POST['nombreTienda'];
        $pregunta1 = $_POST['pregunta1'];
        $pregunta2 = $_POST['pregunta2'];
        $pregunta3 = $_POST['pregunta3'];
        $motivoNo = $_POST['motivoNo'];

        // Prepara la consulta SQL
        $sql = "INSERT INTO observaciones (idFinalizado, materiales, nombreTienda,pregunta1,pregunta2,pregunta3, motivoNo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("issssss", $id,  $materiales, $nombreTienda, $pregunta1, $pregunta2, $pregunta3, $motivoNo);

        if ($stmt->execute()) {
            echo "Observación, materiales y nombre de tienda guardados exitosamente.";
        } else {
            echo "Error al guardar: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        echo "Faltan parámetros necesarios.";
    }
} else {
    echo "Método no permitido.";
}

$conn->close();
?>