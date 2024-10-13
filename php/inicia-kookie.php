<?php
    // http://localhost:8080/dashboard/inicia-kookie.php
    function crea_kookie($clave,$valor,$tiempo){
        setcookie($clave, $valor, time() + $tiempo);
        echo "se creo la kookie: Clave: ".$clave." Valor: ".$valor;
        echo "<br>";
    }
    function borra_kookie($clave){
        setcookie($clave, "", 1);
    }
    function modifica_kookie($clave,$valor){
        setcookie($clave,$valor); 
    }
    
    //presenta la kookie
    if (isset($_COOKIE["nombre"])) {
        $usuario = $_COOKIE["nombre"];
        echo "Bienvenido, " . $usuario;
        echo "<br>";

    } else {
        echo "No se encontró la cookie 'nombre'";
        echo "<br>";
        //expira en 60 seg
        crea_kookie("nombre","jorge vera",60);
    }
?>