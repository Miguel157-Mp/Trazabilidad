<?php
include("../../db/conexion.php");

$user  = $_POST['user'];
$pass  = $_POST['pass'];
$pass = md5($pass);

$query = "SELECT id, nombreCompleto, rol FROM trazabilidad_usuario WHERE user= ? AND pass= ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    session_start();
    $_SESSION['nombreUsuario'] = $row['nombreCompleto'];
    $_SESSION['tipoUsuario'] = $row['rol'];
    $_SESSION['idUser'] = $row['id'];
    $_SESSION['sesionTrue'] = true;

    $resultado = json_encode(array('estatus' => 1, 'mjs' => "Inicio de session exitoso", 'rol' => $row['rol']));
} else {
    $resultado = json_encode(array('estatus' => 2, 'mjs' => "Usuario o clave erroneos"));
}

// Cerrar conexión a la base de datos
$stmt->close();
$conn->close();

echo $resultado;
