<html>
<head>
    <title>Borrar Comentario</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    session_start();
    include("header.php");
    include('connect-db.php');
    $comentarioBorrar = $_GET['comentario'];
    $id_comentarioBorrar = $_GET['id_comentario'];
    $id_tema = $_GET['id_tema'];
    $tema = $_GET['tema'];
    ?>
    <p>Hola <?php echo $_SESSION['usuario']; ?></p>
    <p>Se va a borrar el comentario: <b><?php echo $comentarioBorrar; ?></b>, ¿Estas seguro?</p>
    <p>
        <button id="btn_logar" onclick="location.href = 'borrarComentarioOk.php?id_ComentarioBorrar=<?php echo $id_comentarioBorrar ?>&tema=<?php echo $tema ?>&id=<?php echo $id_tema ?>'">Sí, quiero borrarlo</button>
        <button id="btn_logar" onclick="location.href = 'tema.php?id=<?php echo $id_tema ?>&tema=<?php echo $tema ?>'">No, volver al tema</button>
    </p>
    <?php
    include('footer.php');
    ?>
</body>
</html>
