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
        try {
            $consulta->execute();
            header("Location: exito.php?mensaje=Registro insertado correctamente.");
            exit();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Error de clave duplicada
                $duplicado = $e->errorInfo[2];
                if (strpos($duplicado, 'nombre') !== false) {
                    // Error de nombre duplicado
                    header("Location: error.php?mensaje=El nombre ya existe. Por favor, ingresa un nombre diferente.");
                } elseif (strpos($duplicado, 'correo') !== false) {
                    // Error de correo duplicado
                    header("Location: error.php?mensaje=El correo ya existe. Por favor, ingresa un correo diferente.");
                } else {
                    // Otro tipo de error de clave duplicada
                    header("Location: error.php?mensaje=Error de clave duplicada.");
                }
            } else {
                // Otro tipo de error
                header("Location: error.php?mensaje=Error al insertar el registro.");
            }
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