<?php
    include_once "registro.php";
    //  http://localhost:8080/dashboard/calificaciones/sesion.php
    session_start(); // Iniciar la sesión

    // Verificar si se solicitó borrar la sesión
    if (isset($_POST['borrar_sesion'])) {
        session_destroy(); // Destruir la sesión
        header("Location: sesion.php"); // Redirigir a la misma página
        exit();
    }

    // Verificar si hay datos en la sesión
    if (empty($_SESSION)) {
        echo "<h1>No hay datos en la sesión.</h1>";
        echo '<form method="post" action="">
                <button type="submit" name="borrar_sesion">Borrar Datos de la Sesión</button>
            </form>';
    } else {
        echo "<h1>Datos de la Sesión</h1>";
        echo "<p><strong>ID de Sesión:</strong> " . session_id() . "</p>";

        // Mostrar todos los datos de la sesión
        echo "<h2>Contenido de la sesión:</h2>";
        echo "<ul>";
        foreach ($_SESSION as $key => $value) {
            echo "<li><strong>$key:</strong> $value</li>";
        }
        echo "</ul>";

        // Formulario para cerrar y borrar la sesión
        echo '<form method="post" action="">
                <button type="submit" name="borrar_sesion">Cerrar Sesión</button>
            </form>';
        
            
    }
    echo '<p><a href="inicio.php">Volver al inicio</a></p>';
    echo '<p><a href="index.php">Volver al Indice</a></p>';
?>
