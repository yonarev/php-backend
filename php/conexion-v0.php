<?php
function conectar_bd() {
    $servidor = "localhost";
    $nombrebd = "empresa";
    $usuario = "usuariobd";
    
    $contrasena = "contrasenabd";

    $conexion = mysql_connect($servidor, $usuario, $contrasena);
    mysql_select_db($nombrebd, $conexion);

    return $conexion;
}
?>