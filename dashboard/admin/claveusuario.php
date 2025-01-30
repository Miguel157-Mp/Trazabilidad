<?php

include("../db/conexion.php");


$id = $_POST['id'];
$nuevaClave = $_POST['claveUser'];
$confirmarClave = $_POST['confirmarClaveUsuario'];

// Obtener los valores de los campos del formulario

if ($nuevaClave !== $confirmarClave) {
    echo '<script>
alert("Las claves no coinciden");
window.history.back();
</script>';
    exit;
}

$nuevaClave = md5($nuevaClave);


$sql = "UPDATE trazabilidad_usuario SET pass='$nuevaClave' WHERE id='$id' ";

//echo $sql;



if ($stmt = mysqli_query($conn, $sql)) {
    echo '<script>alert("Contraseña actualizada correctamente");
    window.history.back();</script>';
} else {
    echo '<script>alert("Error al actualizar la contraseña");</script>';
}


// Cerrar la conexión a la base de datos

mysqli_close($conn);



