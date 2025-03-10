<?php
include('connect-db.php');

function renderForm($nuevoUsuario, $nuevoPw, $nuevoEmail, $error)
{
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <title>Nuevo Login</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body>
        <header>
            <h1>FORO DE MIGRACIÓN Y LEGALIZACIÓN</h1>
        </header>
        <?php if ($error != '') : ?>
            <div style="padding:4px; border:1px solid red;color:red;"><?php echo $error; ?></div>
        <?php endif; ?>
        <p>Inicia sesión</p>
        <p></p>

        <form action="" method="post">
            <table>
                <tr>
                    <th>USUARIO</th>
                    <th>CONTRASEÑA</th>
                    <th>EMAIL</th>
                </tr>
                <tr>
                    <td><input type="text" name="nuevoUsuario" id="NuevoUsuario" value="<?php echo htmlspecialchars($nuevoUsuario); ?>"></td>

                    <td><input type="password" name="nuevoPw" id="nuevoPw" value="<?php echo htmlspecialchars($nuevoPw); ?>"></td>
                    <td><input type="email" name="nuevoEmail" id="nuevoEmail" value="<?php echo htmlspecialchars($nuevoEmail); ?>"></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" value="Enviar" name="submit" id="btn_enviar"></td>
                </tr>
            </table>
        </form>
        <p><a href="index.php">Volver al inicio</a></p>
    </body>

    </html>
<?php
    include('footer.php');
}

if (isset($_POST['submit'])) { //verifico si el formulario ha sido enviado
    //Con htmlspecialchars() convierto caracteres especiales en entidades HTML. Es para prevenir ataques de inyección de código
    $nuevoUsuario = htmlspecialchars($_POST['nuevoUsuario']);
    $nuevoPw = htmlspecialchars($_POST['nuevoPw']);
    $nuevoEmail = htmlspecialchars($_POST['nuevoEmail']);
    //Si falta algun campo requerido
    if ($nuevoUsuario == '' || $nuevoPw == '' || $nuevoEmail == '') {
        $error = 'ERROR: Por favor, introduce todos los campos requeridos.';
        renderForm($nuevoUsuario, $nuevoPw, $nuevoEmail, $error);
         //Si no falta ninguno
         //comprobamos primero que no haya duplicados
    } elseif (compruebaDuplicado($conn, $nuevoUsuario, $nuevoEmail)) {
        $error = 'ERROR: usuario o email ya registrados.';
        renderForm("", "", "", $error);
    } else {
        //si no falta ningun campo y no hay duplicados realizo inserción del usuario en 
        //la tabla "usuarios" de la BBDD

        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Creo consulta de inserción datos
            $sql = $conn->prepare("INSERT INTO usuarios (usuario, pw, email) VALUES (:nuevoUsuario, :nuevoPw, :nuevoEmail)");
            $sql->bindParam(':nuevoUsuario', $nuevoUsuario, PDO::PARAM_STR);
            $sql->bindParam(':nuevoPw', $nuevoPw, PDO::PARAM_STR);
            $sql->bindParam(':nuevoEmail', $nuevoEmail, PDO::PARAM_STR);
            $sql->execute();
            //Envio mail a través de la funcion enviarEmail
            enviarEmail($nuevoEmail, $nuevoUsuario); // Pasar el nombre de usuario para personalizar el correo electrónico
            header("Location: altaok.html"); // Redirige al script de inicio de sesión
            exit(); // Asegura que el script termine después de la redirección
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
} else {
    renderForm('', '', '', ''); // Muestra el formulario por defecto
}
//Funcion de enviarEmail
function enviarEmail($mail, $username)
{
    $destinatario = "$mail";
    $asunto = "Usuario correctamente registrado";
    $mensaje = "Hola $username, <br><br>";
    $mensaje .= "Te has registrado correctamente en nuestro sitio. ¡Bienvenido!";

    // Establecemos otras cabecereas adicionales
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Cabeceras adicionales
    $headers .= "From: remitente@example.com" . "\r\n";

    // Envía el correo
    if (mail($destinatario, $asunto, $mensaje, $headers)) {
        echo "El correo se envió correctamente.";
    } else {
        echo "Error al enviar el correo.";
    }
}

//funcion para comprobar si el usuario o email están ya registrados
function compruebaDuplicado($conn, $nombreUsuario, $email)
{
 
    // Prepara la declaración SQL con marcadores de posición para las entradas de usuario y correo electrónico
    $sql = "SELECT * FROM usuarios WHERE usuario = :nombreUsuario OR email = :email";
    $consulta = $conn->prepare($sql);
    
    // Vincula los parámetros a la declaración preparada
    $consulta->bindParam(":nombreUsuario", $nombreUsuario, PDO::PARAM_STR);
    $consulta->bindParam(":email", $email, PDO::PARAM_STR);
    
    // Ejecuta la declaración preparada
    $consulta->execute();
    
    // Obtiene el número de filas devueltas, si da 1, ya hay un usuario con ese nombre de usuario o correo electrónico
    $num_filas = $consulta->rowCount();
   
    
    // Comprueba si el usuario existe
    if ($num_filas == 1) {
        return true;
    } else {
        return false;
    }
}


?>