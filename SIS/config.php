<?php
    // Definir constantes para el entorno
    define('ENVIRONMENT', 'development'); // Cambia a 'production' cuando estés en producción

    // Configuraciones de base de datos
    define('DB_SERVER', 'localhost');
    define('DB_NAME', 'calificaciones');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    // Ruta para el archivo de log de errores
    define('ERROR_LOG_PATH', './log_de_errores.log'); // Cambia la ruta a donde quieres almacenar los logs

    // Configuración del manejo de errores
    if (ENVIRONMENT === 'development') {
        // Mostrar errores en pantalla para depuración
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        // No mostrar errores en producción
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(E_ALL);
        
        // Configurar log personalizado
        ini_set('log_errors', 1);
        ini_set('error_log', ERROR_LOG_PATH);
    }
?>
