<?php
//<!-- http://localhost:8080/dashboard/index.php -->
include_once "libreria.php";

// Iniciar sesión al principio del archivo
session_start(); 

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['tipo_usu'])) {
    header('Location: inicio.php'); // Redirigir al inicio si no está autenticado
    exit; // Asegúrate de salir después de la redirección
}
// Función para cerrar la sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header('Location: inicio.php');
    exit();
}
// Llamar a la función para verificar el tiempo de sesión (en segundos)
tiempo_sesion(300); // 300 segundos = 5 minutos
// tiempo_sesion(50); // 50 segundos 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Calificaciones</title>
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="./index.ico" type="image/x-icon">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./logo.png" alt="Logo del Sistema">
        </div>
        <nav class="menu">
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <!-- SOLO EL SUPERUSUARIO CREA ADMINISTRADORES -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Superusuario'): ?>
                    <li><a href="administra.php">Administrar</a></li>
                <?php endif; ?>
                <!-- SOLO EL ADMINISTRADOR CREA PROFESORES -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Administrador'): ?>
                    <li><a href="profesores.php">Profesores</a></li>
                <?php endif; ?>
                 <!-- SOLO PROFESOR CREA Y EDITA RAMOS -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Profesor'): ?>
                    <li><a href="ramos.php">Ramos</a></li>
                <?php endif; ?>
                <!-- SOLO PROFESOR CREA Y EDITA ALUMNOS -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Profesor'): ?>
                    <li><a href="alumnos.php">Alumnos</a></li>
                <?php endif; ?>
                <!-- EL ALUMNOS SOLO PUEDE VER SU REGISTRO -->
                <!-- <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Alumno'): ?>
                    <li><a href="alumnos.php">Alumnos</a></li>
                <?php endif; ?> -->
                <!-- <li><a href="profesores.php">Profesores</a></li> -->
                <!-- <li><a href="alumnos.php">Alumnos</a></li> -->

                <!-- SI ES PROFESOR INGRESA EDITA CALIFICACIONES -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Profesor'): ?>
                    <li><a href="calificaciones.php">Calificaciones</a></li>
                <?php endif; ?>
                <!-- TODOS PUEDEN VER CALIFICACIONES -->
                <li><a href="ver_calificaciones.php">Ver Calificaciones</a></li>
                <!-- <li><a href="calificaciones.php">Calificaciones</a></li> -->
                <li><a href="registro.php">Registro</a></li>
                <!-- SOLO EL SUPERUSUARIO VE SESION -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Superusuario'): ?>
                    <li><a href="sesion.php">Sesion</a></li>
                <?php endif; ?>
                <!-- SOLO SUPERUSUARIO VE EL REGISTRO -->
                <?php if (isset($_SESSION['tipo_usu']) && $_SESSION['tipo_usu'] == 'Superusuario'): ?>
                    <li><a href="presenta_reg.php">Registros</a></li>
                <?php endif; ?>
                <li><a href="ayuda.php">Ayuda en línea</a></li>
                <!-- Botón para cerrar sesión -->
                <form method="post" action="">
                    <button type="submit" name="cerrar_sesion">Cerrar Sesión</button>
                </form>
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
