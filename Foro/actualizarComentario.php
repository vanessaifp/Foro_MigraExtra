<?php
// Iniciar sesión
session_start();
//Obtengo variables pasadas por url
$comentarioActualizar = $_GET['id_comentario'];
$comentarioAntiguo = $_GET['comentario'];
$id = $_GET['id_tema'];
$tema = $_GET['tema'];

// Verificar si se ha enviado el formulario de esta misma página
if (isset($_POST['submit'])) {
    // Conectar a la base de datos
    include('connect-db.php');
    // Obtener los datos del formulario
    $nuevoComentario = htmlspecialchars($_POST['nuevoComentario']);
    // Verificar si se ingresó el comentario
    if (empty($nuevoComentario)) {
        $error = 'ERROR: Por favor, ingresa un nuevo comentario.';
        renderForm($nuevoComentario, $error);
    } else {
    $fecha_actual = date("Y-m-d H:i:s");
    // Preparar la consulta SQL
    $sql = $conn->prepare("UPDATE comentarios SET comentario = :nuevoComentario, fecha_comentario = :fecha_actual WHERE comentarios.id_comentario = $comentarioActualizar");
    // Vincular los parámetros de la consulta
    $sql->bindParam(':nuevoComentario', $nuevoComentario, PDO::PARAM_STR);
    $sql->bindParam(':fecha_actual', $fecha_actual, PDO::PARAM_STR);
    // Ejecutar la consulta
    $sql->execute();
    // Redirigir a la página de foro
    header("Location: tema.php?id=" . $id . "&tema=" . $tema);
    exit(); // Salgo del script después de redirigir
    }
    //}
} else {
    // Si el formulario no se ha enviado, mostrar el formulario vacío
    renderForm('', '');
}
// Función para renderizar el formulario
function renderForm($nuevoComentario, $error)
{
    //compruebo variable de sesio nsi no se reenvia a index.php
if (isset($_SESSION['id_usuario'])) {
    include('header.php');
?>


    <p>Inserta en el campo la modificación del comentario realizado.</p>
    <?php
    if ($error != '') {
        echo '<div style="padding:4px; border:1px solid red;color:red;">' . $error . '</div>';
    }
    ?>
    <form action="" method="post">
        <div>
            <strong>Nuevo comentario: *</strong><br><textarea cols="100%" rows="10" name="nuevoComentario"><?php echo htmlspecialchars($_GET['comentario'] ?? '', ENT_QUOTES); ?></textarea>
            </textarea><br>
            <p>* Requerido</p>
            <input type="submit" name="submit" value="Actualizar">
        </div>
    </form>
    </body>

    </html>
<?php
    include('footer.php');
}
    else  {
        header ("location: index.php");
    }

}
?>