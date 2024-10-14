<?php
    // Función para registrar en la tabla log
    //  http://localhost:8080/dashboard/calificaciones/registro.php 

    function registrar($tabla, $id_usu, $tipo_log, $reg_log) {
        // Incluir archivo de conexión
        include_once 'conecta.php';

        // Conectar a la base de datos
        $conexion = conectar_bd();

        // Configurar la zona horaria para Chile
        date_default_timezone_set('America/Santiago'); // Cambiado a la zona horaria de Chile


        // Obtener la fecha y hora actual
        $fecha_log = date('Y-m-d');
        $hora_ini_log = date('H:i:s');

        //se agrega al registro cual es la tabla modificada 
        $reg_log = $reg_log . " - Modificada la tabla:" .  $tabla;
        // Preparar la consulta SQL
        $query = "INSERT INTO logs (id_usu, tipo_log, reg_log, fecha_log, hora_ini_log) 
                VALUES (:id_usu, :tipo_log, :reg_log, :fecha_log, :hora_ini_log)";

        try {
            // Preparar la sentencia
            $stmt = $conexion->prepare($query);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':id_usu', $id_usu);
            $stmt->bindParam(':tipo_log', $tipo_log);
            $stmt->bindParam(':reg_log', $reg_log);
            $stmt->bindParam(':fecha_log', $fecha_log);
            $stmt->bindParam(':hora_ini_log', $hora_ini_log);

            // Ejecutar la consulta
            $stmt->execute();

            echo "Registro en log completado correctamente.";
        } catch (PDOException $e) {
            echo "Error al registrar en log: " . $e->getMessage();
        }
    }
    // Función para obtener el ID del usuario desde la sesión activa
    function id_sesion() {
        // Iniciar la sesión si aún no se ha iniciado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el ID del usuario está disponible en la sesión
        if (isset($_SESSION['id_usu'])) {
            return $_SESSION['id_usu']; // Retornar el ID del usuario
        } else {
            return null; // Retornar null si no está disponible
        }
    }
    // Función para obtener el tipo de usuario desde la sesión activa
    function tipo_sesion() {
        // Iniciar la sesión si aún no se ha iniciado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el tipo de usuario está disponible en la sesión
        if (isset($_SESSION['tipo_usu'])) {
            return $_SESSION['tipo_usu']; // Retornar el tipo de usuario
        } else {
            return null; // Retornar null si no está disponible
        }
    }


?>
