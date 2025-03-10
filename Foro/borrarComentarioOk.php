<?php
// Incluir el archivo de conexión a la base de datos
include("connect-db.php");

// Obtener los parámetros de la URL
$comentario = $_GET['id_ComentarioBorrar'];
$tema = $_GET['tema'];
$id = $_GET['id'];

// Preparar la consulta de borrado con un marcador de posición
$sql = "DELETE FROM comentarios WHERE comentarios.id_comentario = :comentario";
$consulta = $conn->prepare($sql);

// Vincular el valor del ID del comentario al marcador de posición
$consulta->bindParam(':comentario', $comentario, PDO::PARAM_INT);

// Ejecutar la consulta preparada
$consulta->execute();

// Redirigir al usuario de vuelta al tema donde se encontraba el comentario
header("Location: tema.php?id=" . $id . "&tema=" . $tema);
exit();
?>
