<?php
session_start();
$claveactual = $_POST["claveactual"];
$clavenueva = $_POST["clavenueva"];

$nombreUsuario = $_SESSION['nombreUsuario'];

$claveactual=md5($claveactual);
$clavenueva=md5($clavenueva);
include("../db/conexion.php");

$queryselect = "SELECT claveUser 
FROM loginusuario where nombreUser='" . $nombreUsuario . "' ";
//echo "useriao: ".$query."   ";
if ($resultado1 = mysqli_query($conn, $queryselect)) {
    /* obtener el array asociativo */
    while ($row = mysqli_fetch_assoc($resultado1)) {
        $claveUser = $row['claveUser'];
    }
    //echo "cable actual: ".$claveactual." clave nueva: ".$clavenueva." clave bd: ".$claveUser;
    if ($claveUser == $claveactual) {
        $queryupdate = "UPDATE loginusuario SET claveUser = '" . $clavenueva . "' WHERE nombreUser = '" . $nombreUsuario . "'";
        if ($resultado2 = mysqli_query($conn, $queryupdate)) {
            $resultado = json_encode(array('estatus' => 1, 'mjs' => "Clave actualizada"));
            echo $resultado;
        }
    } else {
        $resultado = json_encode(array('estatus' => 2, 'mjs' => "Su clave actual no corresponde"));
        echo $resultado;
    }
}
