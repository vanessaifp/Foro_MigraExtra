<?php
// Iniciar sesión
session_start();
//Obtengo variables pasadas por url
$temaActualizar = $_GET['id_tema'];
$temaAntiguo = $_GET['tema'];

// Verificar si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Conectar a la base de datos
    include('connect-db.php');

    // Obtener los datos del formulario
    $nuevoNombreTema = htmlspecialchars($_POST['nuevoNombreTema']);

    // Verificar si se ingresó el tema
    if (empty($nuevoNombreTema)) {
        $error = 'ERROR: Por favor, ingresa un nuevo nombre del tema.';
        renderForm($nuevoNombreTema, $error);
    } else {
        // Obtener el ID de usuario de la sesión o de la URL
        $id_usuario = $_SESSION['id_usuario'] ?? $_GET['id_usuario'] ?? null;

        // Verificar si se obtuvo el ID de usuario
        if ($id_usuario === null) {
            $error = 'ERROR: No se puede obtener el ID de usuario.';
            renderForm($nuevoTema, $error);
        } else {
            // Obtener la fecha actual
            $fecha_actual = date("Y-m-d");

            // Preparar la consulta SQL
            $sql = $conn->prepare("UPDATE temas SET tema = :nuevoNombreTema WHERE temas.id_tema = $temaActualizar");

            // Vincular los parámetros de la consulta
            $sql->bindParam(':nuevoNombreTema', $nuevoNombreTema, PDO::PARAM_STR); 

            // Ejecutar la consulta
            $sql->execute();

            // Redirigir a la página de foro
            header("Location: foro.php");
            exit(); // Salir del script después de redirigir
        }
    }
} else {
    // Si el formulario no se ha enviado, mostrar el formulario vacío
    renderForm('', '');
}

// Función para renderizar el formulario
function renderForm($nuevoNombreTema, $error)
{     //compruebo variable de sesio nsi no se reenvia a index.php
    if (isset($_SESSION['id_usuario'])) {
    include ('header.php');
?>


<p>Inserta en el campo el nuevo nombre del tema que quieres actualizar</p>
<?php
if ($error != '') {
    echo '<div style="padding:4px; border:1px solid red;color:red;">'.$error.'</div>';
}
?>
<form action="" method="post">
<div>
<strong>Nuevo Nombre: *</strong> <input type="text" name="nuevoNombreTema" value="<?php echo $_GET['tema'] ?>" style="width: 400px">
<br>
<p>* Requerido</p>
<input type="submit" name="submit" value="Actualizar">
<br>
<br>
<a href="foro.php">Volver sin actualizar</a>
</div>
</form>
</body>
</html>
<?php
include ('footer.php');
}
else  {
    header ("location: index.php");
}
}
?>