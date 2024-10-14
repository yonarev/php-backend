<?php
// libreria.php

function tiempo_sesion($tiempo) {
    // Iniciar la sesión si no se ha iniciado
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verificar si la variable de tiempo de inicio de sesión existe
    if (!isset($_SESSION['tiempo'])) {
        $_SESSION['tiempo'] = time(); // Guardar el tiempo de inicio de sesión
    }

    // Calcular el tiempo transcurrido
    $tiempo_transcurrido = time() - $_SESSION['tiempo'];

    // Si ha pasado el tiempo especificado, destruir la sesión
    if ($tiempo_transcurrido > $tiempo) {
        session_unset(); // Limpiar las variables de sesión
        session_destroy(); // Destruir la sesión
        header("Location: inicio.php"); // Redirigir a la página de inicio o login
        exit();
    }
}
?>
