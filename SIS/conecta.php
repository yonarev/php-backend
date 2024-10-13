<?php
    // Función para conectar a la base de datos
    //http://localhost:8080/dashboard/calificaciones/conecta.php
    function conectar_bd() {
        $servidor = "localhost";
        $baseDatos = "calificaciones"; // Nombre de la base de datos correcto
        $usuario = "root";
        $contrasena = "";
        try {
            $dsn = "mysql:host=$servidor;dbname=$baseDatos"; // Aquí debe usarse $baseDatos
            $conexion = new PDO($dsn, $usuario, $contrasena);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            echo "Fallo al conectar: " . $e->getMessage();
            exit;
        }
    }
?>
