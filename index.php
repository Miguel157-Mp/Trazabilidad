<?php

session_start();

// Set the new URL

$newURL = $_SESSION['sesionTrue'] ? "https://www.joalca.com/trazabilidad/dashboard/admin/trazabilidadNotificaciones.php" : "https://www.joalca.com/trazabilidad/dashboard/admin/login.php";

// Send the redirect header
header('Location: ' . $newURL);

// Exit the script to prevent further output
exit();
