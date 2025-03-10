<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Formulario de inicio</title>
</head>

<body>
    <header>
        <h1>FORO MIGRAEXTRA</h1>
    </header>
    <div class="principal">
        <h2>Ingresa ahora</h2>
       
        <table>
            <tr>
                <th>USUARIO</th>
                <th>CONTRASEÑA</th>
            </tr>
            <!-- Creo formulario, con metodo post para envio de usuario y contraseña -->
            <form action="compruebausuario.php" method="post">
                <tr>
                    <td>
                        <!-- Campo para el usuario -->
                        <input type="text" name="usuario" id="usuario">
                    </td>
                    <td>
                        <!-- Campo para la contraseña -->
                        <input type="password" name="pw" id="pw">
                    </td>
                </tr>
                <tr>
                    <!-- Boton de envío -->
                    <td colspan="2"> 
                        <input type="submit" value="Acceder al foro" id="btn_submit">
                    </td>
                </tr>
            </form>
        </table>

        <!-- Botón de registro -->
        <button id="btn_logar" onclick="location.href = 'nuevousuario.php'">
            Registrarse
        </button>

        <!-- Botón para ir a mostrar comentarios -->
        <button id="btn_mostrar_comentarios" onclick="location.href = 'mostrarcomentarios.php'">
            Ver comentarios
        </button>
    </div>

    <?php
    include('footer.php');
    ?>
</body>

</html>
