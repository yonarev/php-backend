<?php
    // http://localhost:8080/dashboard/basedatos/ingreso-tester.php
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
        // Validar y sanitizar los datos del formulario
        $nombre = htmlspecialchars(strip_tags($_POST["nombre"]), ENT_QUOTES, 'UTF-8');
        $correo = htmlspecialchars(strip_tags($_POST["correo"]), ENT_QUOTES, 'UTF-8');
        // $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        // $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);

        // Verificar si los campos están vacíos
        if (empty($nombre) || empty($correo)) {
            header("Location: error-v2.php?mensaje=Por favor, completa todos los campos.");
            exit();
        }

        // Verificar si el correo es válido
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            header("Location: error-v2.php?mensaje=Correo inválido. Por favor, ingresa un correo válido.");
            exit();
        }

        // Preparar la consulta INSERT
        $sql = "INSERT INTO testers (nombre, correo) VALUES (:nombre, :correo)";
        $consulta = $conexion->prepare($sql);

        // Asignar valores a los parámetros de la consulta
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":correo", $correo);

        // Ejecutar la consulta
        try {
            $consulta->execute();
            //daba solo un mensaje
            // header("Location: exito-v2.php?mensaje=Registro insertado correctamente.");
            // Redirigir a despliega-tabla.php
            header("Location: ./despliega-tabla.php");
        exit();
            exit();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Error de clave duplicada
                $duplicado = $e->errorInfo[2];
                if (strpos($duplicado, 'nombre') !== false) {
                    header("Location: error-v2.php?mensaje=El nombre ya existe. Por favor, ingresa un nombre diferente.");
                } elseif (strpos($duplicado, 'correo') !== false) {
                    header("Location: error-v2.php?mensaje=El correo ya existe. Por favor, ingresa un correo diferente.");
                } else {
                    header("Location: error-v2.php?mensaje=Error de clave duplicada.");
                }
            } else {
                // Otro tipo de error
                header("Location: error-v2.php?mensaje=Error al insertar el registro.");
            }
            exit();
        }
    }
?>
