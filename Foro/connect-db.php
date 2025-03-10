<?php
//Esta página php, permite conectarnos a la base de datos.
//Parámetros para la conexion a la base de datos.
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'foro';
// Conexión a la base de datos con bloque try/catch
try {
	//nueva conexión a una base de datos MySQL utilizando PDO (PHP Data Objects)
	$conn = new PDO('mysql:host=' . $server . ';dbname=' . $db, $user, $pass);
}
//En caso de excepción la mostramos.
catch (PDOException $ex) {
	echo $ex->getMessage();
	exit;
}
