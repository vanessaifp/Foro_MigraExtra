<?php
    session_start();
    //incluyo la cabecera y la conexión a la BBDD
    include("header.php");
    include("connect-db.php");
    //obtengo los datos enviados por URL con GET
    $temaBorrar = $_GET['tema'];
    $id_temaBorrar = $_GET['id_tema'];

?>
<p>Hola <?php echo $_SESSION['usuario'] ?></p>
<!-- Informo al usuario del tema quese va a borrar que ha sido enviado por URL -->
<p>Se va a borrar el tema:<b> <?php echo $temaBorrar ?></b>, ¿Estas seguro?</p>
<!-- Si esta conforme redirecciono a la página donde se ejercura la consulta de borrado enviandole por URL el ID del tema -->
<p><button id="btn_logar" onclick="location.href = 'borrarTemaOk.php?id_temaBorrar=<?php echo $id_temaBorrar ?>'">Si, quiero borrarlo</button>
<!-- En caso contrario redirecciono a la página de foro general -->
<button id="btn_logar" onclick="location.href = 'foro.php'">No, volver al foro general</button></p>
<?php
include ('footer.php');
?>
</body>
</html>