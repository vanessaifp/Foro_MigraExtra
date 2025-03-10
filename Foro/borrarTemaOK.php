<?php
// Incluir el archivo de conexión a la base de datos
include("connect-db.php");

// Obtener el ID del tema a borrar desde el GET
$tema = $_GET['id_temaBorrar'];
// Preparar la consulta de borrado con un marcador de posición
$sql = "DELETE FROM temas WHERE temas.id_tema = :tema";
$consulta = $conn->prepare($sql);
// Vincular el valor del ID del tema al marcador de posición
$consulta->bindParam(':tema', $tema, PDO::PARAM_INT);
// Ejecutar la consulta preparada
$consulta->execute();

// Redirigir al usuario de vuelta a la página de foro
header("Location: foro.php");
exit();
?>
