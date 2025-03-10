<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/c613dc78b8.js" crossorigin="anonymous"></script>
    <title>Bienvenida</title>
</head>

<body>
    <header>
    <h1>FORO DE MIGRAEXTRA</h1>
    </header>

    <div class="cabecera">
        <p>Eres usuario registrado</p>
        <!-- Doy la bienvenida al usuario con su nombre de usuario gracias a la vble de sesion -->
        <p>Has accedido como: <?php echo $_SESSION['usuario']; ?></p>
        <!-- Enlace a cerrarsesion.php donde se destruye sesion existente y sus variables y redirecciona a pagina de inicio -->
        <p><a href="cerrarsesion.php">Cerrar sesión</a></p>
    </div>