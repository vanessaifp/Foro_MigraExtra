<?php
//inicio sesión de nuevo, si estuviera abierta se mantiene dicha sesión
session_start();
$usuarioActual = $_SESSION['id_usuario'];

//SOLO si existe variable de sesión creada desde compruebaUsuario.php se ejecuta la página
//si no se reenvia a index.php
if (isset($_SESSION['id_usuario'])) { //si existe variable de sesión creo la página, sino reevio a index.php
    include('header.php');
    if ($usuarioActual == '1') { ?>
        <p>Eres <b>admin</b></p>
        <p>Puedes editar o eliminar cualquier tema y/o comentarios</p>
    <?php } else { ?>
        <p>Estás en el foro de <b>migración y legalización</b></p>
        <p>Al ser usuario registrado puedes añadir y consultar cualquier tema,</p>
        <p>No obstante, solo podrás modificar y/o eliminar aquellos que hayas creado tú.</p>

    <?php
    }
    include("connect-db.php");
    //creo la consulta unida con las tablas con las que tiene relaciones
    $sql = "SELECT * FROM temas inner join usuarios on temas.id_usuario = usuarios.id_usuario order by id_tema desc";
    $consulta = $conn->prepare($sql);
    //Ejecuto consulta
    $consulta->execute();
    //numero de filas
    $num_filas = $consulta->rowCount();
    //Obtengo un array que contiene todas las filas del resultado de la consulta, clave(columna),valor(celda)
    $temas_activos = $consulta->fetchAll();
    //tabla para mostras los temas creados
    echo "<table class='tabla_foro'>";
    echo "<thead><tr> <th  width='50%'>Tema</th> <th  width='10%'>Fecha</th> <th  width='10%'>Creador</th> <th width='10%'>Ver</th><th width='10%'>Modificar</th width='10%'><th>Borrar</th></tr></thead>";
    echo "<tbody>";
    //recorro los resultados
    foreach ($temas_activos as $row) {
        $usuarioCreadorTema = $row['id_usuario'];
        echo "<tr>";
        echo '<td>' . $row['tema'] . '</td>';
        echo '<td>' . date('d-m-Y', strtotime($row['fecha'])) . '</td>';
        echo '<td>' . $row['usuario'] . '</td>';
        //Todos los usuarios ven los temas
        echo '<td><a href="tema.php?id='.$row['id_tema'].'&tema='.$row['tema'].'&usuario='.$row['id_usuario'].'"><i class="fa-solid fa-eye"></i></td>';
        //Solo el usuario que crea el tema puedo modificarlo o eliminarlo
        if ($usuarioCreadorTema == $usuarioActual || $usuarioActual == '1') {
            //Actualizar tema
            echo '<td><a href="actualizarTema.php?id_tema=' . $row['id_tema'] . '&tema=' . $row['tema'] . '"><i class="fa-solid fa-pen"></i></a></td>';
            //Eliminar tema, paso por URL el Id del tema y el nombre del tema
            echo '<td> <a href="borrarTema.php?id_tema=' . $row['id_tema'] . '&tema=' . $row['tema'] . '"><i class="fa-solid fa-trash"></i></a></td>';
        } else {
            //Si no es usuario creador, en las celdas solo aparece "-"
            echo "<td>-</td><td>-</td>";
        }
        echo "</tr>";
    }
    //En el pie de tabla, muestro el nº de temas activos
    echo "<tfoot><tr><td colspan='6'>El número de temas activos es: " . $num_filas . "</td></tr></tfoot>";
    echo "</tbody>";
    echo "</table>";
    ?><br>
    <p><a href="newtema.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>">Añadir un nuevo tema</a></p>
    <!-- Enlace a cerrarsesion.php donde se destruye sesion existente y sus variables y redirecciona a pagina de inicio-->
    <!-- <p><a href="cerrarsesion.php">Cerrar Sesión</a></p> -->
    </body>

<?php

    include('footer.php');
} else {
    header("Location: index.php");
}
?>

</html>