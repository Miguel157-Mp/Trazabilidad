
<?php
// include("../../db/conexion.php");
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
include("../../db/conexion.php");
session_start();

// Declarar mensajes de error y éxito
$msjExito = "Recibo creado con éxito";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener datos del formulario
        $idTienda = $_POST["idTienda"];
        $materiales = $_POST["materiales"];
        $monto = $_POST["monto"];
        $fileTest = $_FILES["fileTest"];

        // Verificar si el archivo fue subido correctamente
        if ($fileTest['error'] === UPLOAD_ERR_OK) {
            // Leer el contenido del archivo
            $fileContent = file_get_contents($fileTest['tmp_name']);

            // Convertir el contenido a base64
            $fileBase64 = base64_encode($fileContent);
        } else {
            throw new Exception("Error al subir el archivo.");
        }

        // Otros datos
        $fechaActual = date('Y-m-d');

        // Insertar el recibo en la base de datos, incluyendo el archivo en base64
        $query = "INSERT INTO administracion (idTienda, materiales, monto, fileTest) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            throw new Exception('Error en la preparación: ' . htmlspecialchars($conn->error));
        }
        
        // Bind de parámetros (usar "s" para el archivo base64, que es una cadena)
        $stmt->bind_param("isis", $idTienda, $materiales, $monto, $fileBase64);
        
        if ($stmt->execute()) {
            // Devolver mensaje de éxito
            $resultado = json_encode(["msj" => $msjExito, "estatus" => 1]);
        } else {
            throw new Exception("Error al insertar: " . htmlspecialchars($stmt->error));
        }

    } catch (Exception $e) {
        // Devolver mensaje de error
        $resultado = json_encode(["msj" => $e->getMessage(), "estatus" => 0]);
    }

    // Cerrar declaración y conexión
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();

    // Asegúrate de establecer el tipo de contenido como JSON
    header('Content-Type: application/json');
    echo $resultado;
} else {
    $url = "../trazabilidadCrearRecibo.php";
    header("Location: $url");
}
