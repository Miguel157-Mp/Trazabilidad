
<?php
include("../../db/conexion.php");

// Obtener los datos JSON enviados
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron los datos correctamente
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['estatus' => false, 'msj' => 'Error en formato JSON']);
    exit;
}

// Extraer los valores
$idTienda = $data['idTienda'];
$materiales = $data['materiales'];
$monto = $data['monto'];
$fileTest = $data['fileTest'];
$idSolicitud= $data['idSolicitud'];
 // Otros datos
 $fechaActual = date('Y-m-d H:i:s');

// Validar los datos (ejemplo)
if (empty($idTienda) || empty($materiales) || !is_numeric($monto) || empty($fileTest)) {
    echo json_encode(['estatus' => false, 'msj' => 'Datos incompletos o inválidos']);
    exit;
}

// Preparar la consulta SQL para insertar en la base de datos
$sql = "INSERT INTO administracion (idTienda, materiales, monto, fileTest, fechaActual,idSolicitud) VALUES (?, ?, ?, ?, ?,?)";
$stmt = $conn->prepare($sql);

// Cambiar "ssis" a "ssds" si monto es decimal
$stmt->bind_param("ssdsss", $idTienda, $materiales, $monto, $fileTest, $fechaActual, $idSolicitud);

if ($stmt->execute()) {
    echo json_encode(['estatus' => true, 'msj' => 'Requerimiento enviado correctamente']);
} else {
    echo json_encode(['estatus' => false, 'msj' => 'Error al insertar datos: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
// session_start();

// //Declarar mensajes de error y éxito
// $msjExito = "Recibo creado con éxito";

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     try {
//         // Obtener datos del form
//         $idTienda = $_POST["idTienda"];
 
//         $materiales = $_POST["materiales"];
//         $monto = $_POST["monto"];
//         $fileTest = $_FILES["fileTest"];

//         // Otros datos
//         $fechaActual = date('Y-m-d');

//         // Insertar recibo
//         $query = "INSERT INTO administracion (idTienda, materiales,monto,fileTest) VALUES (?, ?,?,?)";
//         $stmt = $conn->prepare($query);
        
//         if ($stmt === false) {
//             throw new Exception('Error en la preparación: ' . htmlspecialchars($conn->error));
//         }
        
//         $stmt->bind_param("isis", $idTienda, $materiales, $monto, $fileTest);
        
//         if ($stmt->execute()) {
//             // Devolver mensaje de éxito 
//             $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
//         } else {
//             throw new Exception("Error al insertar: " . htmlspecialchars($stmt->error));
//         }

//     } catch (Exception $e) {
//         // Devolver mensaje de error
//         $resultado = json_encode(["msj" => $e->getMessage(), "estatus" => 0]);
//     }

//     // Cerrar declaración y conexión
//     if (isset($stmt)) {
//         $stmt->close();
//     }
//     $conn->close();

//     // Asegúrate de establecer el tipo de contenido como JSON
//     header('Content-Type: application/json');
//     echo $resultado;
// } else {

//     $url = "../trazabilidadCrearRecibo.php";
//     header("Location: $url");
// }
