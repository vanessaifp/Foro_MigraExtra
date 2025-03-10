<?php
//conexión a la base de datos
include("connect-db.php");

// Obtener los temas y comentarios desde la base de datos
$query = "SELECT * FROM temas";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Comentarios del Foro</title>
</head>

<body>
    <header>
        <h1>FORO MIGRAEXTRA - Comentarios</h1>
    </header>
    
    <div class="principal">
        <h2>Comentarios por Tema</h2>

        <?php
        // Verifica si hay temas disponibles
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='tema'>";
                echo "<h3>" . htmlspecialchars($row['tema']) . "</h3>"; // Título del tema
                echo "<p><strong>Fecha:</strong> " . htmlspecialchars($row['fecha']) . "</p>"; // Fecha del tema

                // Consulta los comentarios para este tema
                $comentariosQuery = "SELECT * FROM comentarios WHERE id_tema = " . $row['id_tema'];
                $comentariosResult = $conn->query($comentariosQuery);

                // Verifica si hay comentarios
                if ($comentariosResult->rowCount() > 0) {
                    echo "<table class='tabla_foro'>";
                    echo "<thead><tr><th>Comentario</th><th>Fecha</th></tr></thead>";
                    echo "<tbody>";
                    while ($comentario = $comentariosResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($comentario['comentario']) . "</td>";
                        echo "<td>" . htmlspecialchars($comentario['fecha']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>No hay comentarios para este tema.</p>";
                }
                echo "</div>"; // Cierre de div para el tema
            }
        } else {
            echo "<p>No hay temas disponibles.</p>"; // Si no hay temas
        }
        ?>
        
        <!-- Botón para regresar al foro -->
        <button onclick="location.href = 'index.php'">Regresar al incio</button>
    </div>

    <?php
    include('footer.php');
    ?>
</body>

</html>
