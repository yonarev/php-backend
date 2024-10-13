<?php
    // Incluir archivos de funciones y configuración
    include 'config.php';
    include 'funciones.php';

    // Datos de conexión (pueden obtenerse de un archivo de configuración, variables de entorno, etc.)
    $servidor = "localhost";
    $baseDatos = "mi_base_de_datos";
    $usuario = "mi_usuario";
    $contrasena = "mi_contrasena";

    // Conectar a la base de datos
    $conexion = conectar_bd($servidor, $baseDatos, $usuario, $contrasena);

    // Preparar y ejecutar la consulta
    $consulta = $conexion->prepare("SELECT * FROM usuarios");
    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar los resultados
    mostrarResultados($resultados);
    ?>