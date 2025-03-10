<?php
// Iniciar sesión
session_start();

// Verificar si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Conectar a la base de datos
    include('connect-db.php');

    // Obtener los datos del formulario
    $nuevoTema = htmlspecialchars($_POST['nuevoTema']);
    // Verificar si se ingresó el tema
    if (empty($nuevoTema)) {
        $error = 'ERROR: Por favor, ingresa un tema.';
        //Renderizo el formulario, con el error
        renderForm($nuevoTema, $error);
    } else {
        // Obtener el ID de usuario de la sesión o de la URL
        $id_usuario = $_SESSION['id_usuario'] ?? $_GET['id_usuario'] ?? null;
        // Obtener la fecha actual
        $fecha_actual = date("Y-m-d");
        // Preparar la consulta SQL
        $sql = $conn->prepare("INSERT INTO temas (tema, fecha, id_usuario) VALUES (:nuevoTema, :fecha_actual, :id_usuario)");
        // Vincular los parámetros de la consulta
        $sql->bindParam(':nuevoTema', $nuevoTema, PDO::PARAM_STR);
        $sql->bindParam(':fecha_actual', $fecha_actual, PDO::PARAM_STR);
        $sql->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        // Ejecutar la consulta
        $sql->execute();
        // Redirigir a la página de foro
        header("Location: foro.php");
        exit(); // Salir del script después de redirigir
    }
} else {
    // Si el formulario no se ha enviado, mostrar el formulario vacío
    renderForm('', '');
}

// Función para renderizar el formulario
function renderForm($nuevoTema, $error)
{  //SOLO si existe variable de sesión creada desde compruebaUsuario.php se ejecuta la página
    //si no se reenvia a index.php
    if (isset($_SESSION['id_usuario'])) { //si existe variable de sesión creo la página, sino reevio a index.php
        include('header.php');
?>

        <p>Inserta en el campo el nuevo tema que quieres crear</p>
        <?php
        if ($error != '') {
            echo '<div style="padding:4px; border:1px solid red;color:red;">' . $error . '</div>';
        }
        ?>
        <form action="" method="post">
            <div>
                <b>Nuevo Tema: *</b> <input type="text" name="nuevoTema" value="" style="width: 400px"><br>
                <p>* Requerido</p>
                <input type="submit" name="submit" value="Agregar tema">
                <br><br>
                <a href="foro.php">Volver sin añadir nuevo tema</a>
            </div>
        </form>
        </body>

        </html>
<?php
        include('footer.php');
    } else {
        header("Location: index.php");
    }
}
?>