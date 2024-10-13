<?php
    // dashboard/basedatos/config.php
    // Función para conectar a la base de datos
    //http://localhost:8080/dashboard/basedatos-test-v3/conecta-seguro-v3.php
    function conectar_bd() {
        $servidor = "localhost";
        $baseDatos = "anima";
        $usuario = "root";
        $contrasena = "";
        try {
            $nombrebd="anima";
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