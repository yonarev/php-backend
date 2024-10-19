<?php
    //http://localhost:8080/dashboard/calificaciones/conecta.php
    // Incluir archivo de configuración
    include './config.php';
    
    // Función para conectar a la base de datos
    function conectar_bd() {
        try {
            // Crear el DSN para la conexión
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME;
            // Crear una nueva instancia de PDO
            $conexion = new PDO($dsn, DB_USER, DB_PASS);
            // Configurar el modo de error de PDO para excepciones
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Devolver la conexión
            return $conexion;
        } catch (PDOException $e) {
            // Manejo de errores basado en el entorno
            if (ENVIRONMENT === 'development') {
                // Mostrar el mensaje de error detallado en desarrollo
                trigger_error("Error de conexión: " . $e->getMessage(), E_USER_ERROR);
            } else {
                // Registrar el error en el log de errores en producción
                error_log("Error de conexión: " . $e->getMessage());
                exit('Error de conexión a la base de datos.');
            }
        }
    }
?>
