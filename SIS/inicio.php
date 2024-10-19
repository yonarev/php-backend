<?php
//  http://localhost:8080/dashboard/inicio.php 
// Iniciamos la sesión para gestionar los inicios de sesión
session_start();
// Incluimos el archivo de conexión a la base de datos
include 'conecta.php';
// Conectamos a la base de datos
$conexion = conectar_bd();
// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $psw = $_POST['psw'];
    try {
        // Buscar al usuario en la base de datos
        $query = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos si el usuario existe y la contraseña es correcta
        if ($usuario && password_verify($psw, $usuario['psw'])) {
            // Guardamos la información del usuario en la sesión
            $_SESSION['id_usu'] = $usuario['id_usu'];
            $_SESSION['tipo_usu'] = $usuario['tipo_usu'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellidos'] = $usuario['apellidos'];

            // Redirigimos al usuario según su tipo
            if ($usuario['tipo_usu'] == 'Superusuario') {
                    header('Location: index.php'); // Redirigir a index.php para el superusuario
                } elseif ($usuario['tipo_usu'] == 'Administrador') {
                    header('Location: index.php'); // Redirigir a admin.php para el administrador
                } elseif ($usuario['tipo_usu'] == 'Profesor') {
                    header('Location: index.php'); // Redirigir a admin.php para el administrador
            } else {
                // Redirige según el tipo de usuario
                switch ($usuario['tipo_usu']) {
                    // case 'Administrador':
                    //     header('Location: index.php'); // Redirigir a index.php para el administrador
                    //     break;
                    // case 'Profesor':
                    //     header('Location: profesor.php');
                    //     break;
                    case 'Alumno':
                        header('Location: alumno.php');
                        break;
                    case 'Visita':
                        header('Location: visita.php');
                        break;
                    default:
                        echo "Error: tipo de usuario desconocido.";
                        exit;
                }
            }
            exit; // Asegúrate de salir después de la redirección
        } else {
            $error = "Correo o contraseña incorrectos."; // Mensaje de error
        }
    } catch (PDOException $e) {
        echo "Error en el inicio de sesión: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="shortcut icon" href="./inicio.ico" type="image/x-icon">
        <link rel="stylesheet" href="./inicio.css">
    </head>
    <body>
        <div class="login-container">
            <h1>Iniciar Sesión</h1>
            <h3>Sistema de Calificaciones</h3>
            <div class="logo">
                <img src="./logo.png" alt="Logo del Sistema">
            </div>
            <?php
            if (isset($error)) {
                echo "<p class='error'>$error</p>"; // Mostrar mensaje de error
            }
            ?>
            <form method="POST" action="inicio.php">
                <label for="correo">Correo electrónico:</label>
                <input type="email" name="correo" required>

                <label for="psw">Contraseña:</label>
                <input type="password" name="psw" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </body>
</html>
