<?php
    // http://localhost:8080/dashboard/basedatos/form-ingreso-tester.php
    // Incluir el archivo de conexión a la base de datos
    include './config.php';

    // Datos de conexión
    $servidor = "localhost";
    $baseDatos = "anima";
    $usuario = "root";
    $contrasena = "";

    // Conectar a la base de datos
    $conexion = conectar_bd($servidor, $baseDatos, $usuario, $contrasena);

    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];

        // Preparar la consulta INSERT
        $sql = "INSERT INTO testers (nombre, correo) VALUES (:nombre, :correo)";
        $consulta = $conexion->prepare($sql);

        // Asignar valores a los parámetros de la consulta
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":correo", $correo);

        // Ejecutar la consulta
        if ($consulta->execute()) {
            header("Location: exito.php?mensaje=Registro insertado correctamente.");
            exit();
        } else {
            header("Location: error.php?mensaje=Error al insertar el registro.");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>


        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>


        <input type="submit" value="Registrar">
    </form>
</body>
</html>