<?php
include("connect-db.php");

// Recupero datos del formulario enviados con el metodo post
$usuario = $_POST['usuario'];
$pw = $_POST['pw'];

// Preparo consulta
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND pw = :pw";
$consulta = $conn->prepare($sql);

// Vinculo los parámetros de la consulta con los valores del formulario
$consulta->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$consulta->bindParam(':pw', $pw, PDO::PARAM_STR);



// Ejecuto consulta
$consulta->execute();

// Compruebo el numero de filas de la consulta, si me da = 1, entonces el usuario y contraseña son válidos
$num_filas = $consulta->rowCount();

// Verificar si se encontró un usuario con las datos enviados desde el formulario
if ($num_filas == 1) {
    //Inicio sesion
    session_start();
    //Creo variable de sesion
    $_SESSION['usuario'] = $usuario;
    echo $_SESSION['usuario'];
    echo "<br>";
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado como un array asociativo
    $id_usuario = $resultado['id_usuario']; // Obtiene el valor de 'id_usuario' del array
    echo $id_usuario;
    $_SESSION['id_usuario'] = $id_usuario; //igualo la id_usuario de la BBDD a la variable de sesion
    echo $_SESSION['id_usuario'];




    //Redirecciono a página de foro
    header("Location: foro.php");
} else {
    // Usuario y/o contraseña incorrectos

    echo "<p>Usuario y/o contraseña incorrectos. Intente nuevamente.</p>";
    echo "<br><a href='index.php' style='text-align:center;'>Volver</a>";;
}




// Cerrar la conexión
$conexion = null;
