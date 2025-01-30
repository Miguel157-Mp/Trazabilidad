<?php
$servername="localhost";

$username="vidapet1_appUser";

$password="&(z&L&3f6RZ9Jl5)*q";

$database="vidapet1_app";
    $conn = mysqli_connect($servername, $username, $password, $database); 
    // Check connection
    if (!$conn) {
        die('No pudo conectarse: ' . mysqli_connect_error());
    }else{
        //echo "Coneccion BD";
    }
    ?>