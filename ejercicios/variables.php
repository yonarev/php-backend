<?php
// http://localhost:8000/Documents/janvera/ARCHIVOSLAB/ESTUDIOS/BACK-END-capacitate/ejercicios/variables.php
    $edad;
    $edad=20;
    $nota[0]=10;
    $nota[1]= 20;
    $nota[2]= 20;
    $nota[2]= "no se";
    echo "la nota 0 es ". $nota[0];
    echo "<br>";
    echo "la edad es ". $edad;
    echo "<br>";
    $vector = new stdClass();
    $vector->elemento1 = 'valor1';
    $vector->elemento2 = 'valor2';
    $vector->elemento3 = 'valor3';
    echo $vector->elemento1; // salida: valor1
    echo "<br>";
    echo $vector->elemento2; // salida: valor2
    echo "<br>";
    echo $vector->elemento3; // salida: valor3
    echo "<br>";

?>
