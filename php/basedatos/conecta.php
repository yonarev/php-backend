<?php
        // http://localhost:8080/dashboard/basedatos/conecta.php
        // Incluir archivos de funciones y configuración
        include './config.php';
        // Datos de conexión (pueden obtenerse de un archivo de configuración, variables de entorno, etc.)
        $servidor = "localhost";
        $baseDatos = "anima";
        $usuario = "root";
        $contrasena = "";
        // Conectar a la base de datos
        $conexion = conectar_bd($servidor, $baseDatos, $usuario, $contrasena);
        if ($conexion) {
            echo "Conexión establecida con éxito.";
        } else {
            echo "No se pudo establecer la conexión.";
            exit;
        }
        // var_dump($conexion);
        echo "<br>";
        // echo $conexion; //da error
        echo "<br>";
        // Preparar y ejecutar la consulta
        // $consulta = $conexion->prepare("SELECT * FROM mascotas");
        // $consulta->execute();
        // $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($resultados);
        // Mostrar los resultados
        // Cerrar la conexión
        $conexion = null;
    ?>