<?php
//  http://localhost:8080/dashboard/calificaciones/inicio.php 
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
            } else {
                // Redirige según el tipo de usuario
                switch ($usuario['tipo_usu']) {
                    case 'Administrador':
                        header('Location: administra.php');
                        break;
                    case 'Profesor':
                        header('Location: profesor.php');
                        break;
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

    <style>
        /* Estilos sencillos para una página adaptable */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            display: flex;
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1,h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .logo {
            text-align: center; /* Centrar el contenido dentro de la sección */
        }
        .logo img {
            width: 80px;
            margin: 0 auto; /* Centrar la imagen horizontalmente */
        }
    </style>
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
