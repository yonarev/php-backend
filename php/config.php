<?php
    // Función para conectar a la base de datos
    function conectar_bd($servidor, $nombrebd, $usuario, $contrasena) {
        try {
            $dsn = "mysql:host=$servidor;dbname=$nombrebd";
            $conexion = new PDO($dsn, $usuario, $contrasena);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            echo "Fallo al conectar: " . $e->getMessage();
            exit;
        }
    }
?>