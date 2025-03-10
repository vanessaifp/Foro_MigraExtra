<?php
include("connect-db.php");
// Obtener el ID y el tema desde la URL
$id = $_GET['id'];
// echo $id;
$tema = $_GET['tema'];
session_start();
$usuarioActual = $_SESSION['id_usuario'];
//SOLO si existe variable de sesión creada desde compruebaUsuario.php se ejecuta la página
//si no se reenvia a index.php
if (isset($_SESSION['id_usuario'])) {
    include("header.php");
?>  
<?php 
    if ($usuarioActual == '1') {
    ?>
    <p>Eres <b>admin</b>, puedes editar o eliminar cualquier comentario</p>
    <?php }
    else { ?>    
    <p>Bienvenido/a <?php echo $_SESSION['usuario']; ?>.
    <p> Puedes comentar en este tema:<b> <?php echo $tema ?></b>.
    <p>Podrás modificar o eliminar tus comentarios, pero no los comentarios de otros usuarios.</p>
    <!-- <p>Eres <?php echo $usuarioActual; ?></p> -->
    <?php
    }
    // Evitar inyección SQL: Preparar la consulta con parámetros
    $sql = "SELECT * FROM comentarios 
        INNER JOIN temas ON comentarios.id_tema = temas.id_tema
        INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id_usuario
        WHERE comentarios.id_tema = :id
        ORDER BY id_comentario desc";
    try {
        $consulta = $conn->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT); // Asociar el parámetro :tema con $tema
        // Ejecutar consulta
        $consulta->execute();
        // Mostrar comentarios relacionados con el tema
        $comentarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='tabla_foro'>";
        echo "<thead><tr> 
        <th width='20%'>Fecha</th> 
        <th width='10%'>Usuario</th> 
        <th width='50%'>Comentario</th>
        <th width='10%'>Editar</th>
        <th width='10%'>Borrar</th> 
        </tr></thead>";
        echo "<tbody>";
        foreach ($comentarios as $row) {
            echo "<tr>";
            //echo '<td>' . $row['fecha_comentario'] . '</td>';
            echo '<td>' . date('d-m-Y H:i:s', strtotime($row['fecha_comentario'])) . '</td>';
            echo '<td>' . $row['usuario'] . '</td>';
            echo '<td>' . $row['comentario'] . '</td>';
            //Solo el creador del comentario puede modificarlo
            if ($row['id_usuario'] == $usuarioActual || $usuarioActual=='1') {
                echo '<td> <a href="actualizarComentario.php?id_comentario=' . $row['id_comentario'] . '&comentario=' . $row['comentario'] . '&tema=' . $row['tema'] . '&id_tema=' . $row['id_tema'] . '"><i class="fa-solid fa-pen"></i></td>';
                //Eliminar comentario. Solo el creador del tema puede borrarlo
                echo '<td> <a href="borrarComentario.php?id_comentario='.$row['id_comentario'].'&comentario='.$row['comentario'].'&tema='.$row['tema'].'&id_tema='.$row['id_tema'].'"><i class="fa-solid fa-trash"></i></a></td>';
            } else {
                //si no es el creado del comentario no permito modificarlo
                echo "<td>-</td><td>-</td>";
            }
        }
        echo "</tbody>";
        echo "</table>";
    } catch (PDOException $e) {
        // Manejar errores de la base de datos
        echo "Error al ejecutar la consulta: " . $e->getMessage();
    }
    ?>

    <!-- <p><a href="newcomentario.php?id_tema=<?php echo $id; ?>">Añadir un nuevo comentario</a></p> -->
    <p><a href="newcomentario.php?id_tema=<?php echo $id; ?>&id_usuario=<?php echo $_SESSION['id_usuario']; ?>&tema=<?php echo $tema; ?>">Añadir un nuevo comentario</a></p>


    <p><a href="foro.php">Ir al foro general</a></p>

    <!-- Enlace a cerrarsesion.php donde se destruye sesion existente y sus variables y redirecciona a pagina de inicio-->
    <!-- <p><a href="cerrarsesion.php">Cerrar Sesión</a></p> -->
    </body>

    </html>

<?php
    include('footer.php');
} else {
    header("Location: index.php");
}
?>