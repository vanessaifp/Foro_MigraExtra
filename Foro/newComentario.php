<?php
// Iniciar sesión
session_start();
//Obtengo variables de sesion
$id_tema = $_GET['id_tema'];
$id_usuario = $_GET['id_usuario'];
$tema = $_GET['tema'];
// Verificar si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Conectar a la base de datos
    include('connect-db.php');
    // Obtener los datos del formulario
    $nuevoComentario = htmlspecialchars($_POST['nuevoComentario']);
    // Verificar si se ingresó el comentario nuevo
    if (empty($nuevoComentario) || $nuevoComentario == "") {
        $error = 'ERROR: Por favor, ingresa un comentario.';
        renderForm($nuevoComentario, $error);
    } else {
        // Obtener la fecha actual
        $fecha_actual = date("Y-m-d H:i:s");
        // Preparar la consulta SQL
        $sql = $conn->prepare("INSERT INTO comentarios (comentario, fecha_comentario, id_tema, id_usuario) VALUES (:nuevoComentario, :fecha_actual, :id_tema, :id_usuario)");
        // Vincular los parámetros de la consulta
        $sql->bindParam(':nuevoComentario', $nuevoComentario, PDO::PARAM_STR);
        $sql->bindParam(':fecha_actual', $fecha_actual, PDO::PARAM_STR);
        $sql->bindParam(':id_tema', $id_tema, PDO::PARAM_INT);
        $sql->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        // Ejecutar la consulta
        $sql->execute();
        // Redirigir a la página del tema, pasando datos por url
        header("Location: tema.php?id=$id_tema&tema=$tema&id_usuario=$id_usuario");
        exit(); // Salir del script después de redirigir
    }
} else {
    // Si el comentario no se ha enviado, mostrar el formulario vacío
    renderForm('', '');
}
// Función para renderizar el formulario
function renderForm($nombre, $error)
{
    if (isset($_SESSION['id_usuario'])) {
        include("header.php");
?>

        <p>Inserta el nuevo comentario para el tema: <?php echo $_GET['tema'] ?></p>
        <?php
        //muestro error si existe
        if ($error != '') {
            echo '<div style="padding:4px; border:1px solid red;color:red;">' . $error . '</div>';
        }
        ?>
        <!-- Formulario para el comentario nuevo -->
        <form action="" method="post">

            <strong>Nuevo comentario: *</strong><br><textarea cols="100%" rows="10" name="nuevoComentario" value=""></textarea><br>
            <p>* Requerido</p>
            <input type="submit" name="submit" value="Enviar comentario">

        </form>
        <a href="foro.php">Volver sin comentar</a>
        </body>

        </html>
<?php
        //Si no hay variable de sesion de usuario redirecciono a la pagina inicial
    } else {
        header("Location: index.php");
    }
}
?>