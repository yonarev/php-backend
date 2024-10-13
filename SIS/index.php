<?php
//<!-- http://localhost:8080/dashboard/calificaciones/index.php -->
// Iniciar sesión al principio del archivo
session_start(); 

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['tipo_usu'])) {
    header('Location: inicio.php'); // Redirigir al inicio si no está autenticado
    exit; // Asegúrate de salir después de la redirección
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Calificaciones</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo del Sistema">
        </div>
        <nav class="menu">
            <ul>
                <li><a href="inicio.php">Inicio</a></li>

                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Superusuario'): ?>
                    <li><a href="administra.php">Administrar</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Administrador'): ?>
                    <li><a href="permisos.php">Permisos</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Profesor'): ?>
                    <li><a href="profesores.php">Profesores</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Alumno'): ?>
                    <li><a href="alumnos.php">Alumnos</a></li>
                <?php endif; ?>
                <!-- <li><a href="profesores.php">Profesores</a></li> -->
                <!-- <li><a href="alumnos.php">Alumnos</a></li> -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Profesor'): ?>
                    <li><a href="calificaciones.php">Calificaciones</a></li>
                <?php endif; ?>
                <li><a href="ver_calificaciones.php">Ver Calificaciones</a></li>
                <!-- <li><a href="calificaciones.php">Calificaciones</a></li> -->
                <li><a href="registro.php">Registro</a></li>
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Superusuario'): ?>
                    <li><a href="sesion.php">Sesion</a></li>
                <?php endif; ?>
                <li><a href="ayuda.php">Ayuda en línea</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Bienvenido al Sistema de Registro de Calificaciones</h1>
        <!-- Contenido dinámico según el tipo de usuario -->
    </main>

    <footer>
        <p>&copy; 2024 Sistema de Registro de Calificaciones. Todos los derechos reservados.</p>
        <p><a href="ayuda.php">Ayuda en línea</a></p>
    </footer>
</body>
</html>
