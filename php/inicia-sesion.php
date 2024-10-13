<?php
// http://localhost:8080/dashboard/inicia-sesion.php
// Almacenar datos en la sesión
// $_SESSION['nombre'] = 'Juan';
// $_SESSION['edad'] = 30;

// Acceder a los datos de la sesión
    session_start();

    function inicia_sesion($clave,$valor){
        $_SESSION[$clave]=$valor;
    }
    // MUESTRA EL CONTENIDO DE LA SESION
    function presenta_sesion($clave){
        return $_SESSION[$clave];

    }
    // borra_sesion()
    function borra_sesion(){
        session_destroy();
        echo "se elimino la sesion";
    }
    function imprime_sesion(){
        print_r($_SESSION);
        echo "<br";
        // var_dump($_SESSION); 
    }
    // inicia_sesion("nombre","Juancho");
    $valor=presenta_sesion( "nombre" );
    echo "la clave nombre tiene un valor de: " .$valor . "<br>";
    imprime_sesion()
?>