<?php
// Set the new URL
$newURL = "https://www.joalca.com/trazabilidad";

// Send the redirect header
header('Location: ' . $newURL);

// Exit the script to prevent further output
exit();
