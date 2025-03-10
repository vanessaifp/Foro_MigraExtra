<?php
// Inicio la sesión, si estuviera iniciada, se mantiene
session_start();

// Destruyo todas las variables de sesión creadas
session_unset();

// Destruyo la sesión creada
session_destroy();

// Vuelvo al inicio
header("Location: index.php");
exit();
?>