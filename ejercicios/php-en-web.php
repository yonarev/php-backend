
<!DOCTYPE html>
<!-- http://localhost:8000/Documents/janvera/ARCHIVOSLAB/ESTUDIOS/BACK-END-capacitate/ejercicios/php-en-web.php -->
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
    <div>
        <?php 
            include "./variables.php";
            echo "edad en variables es ". $edad;
            echo "<br>";
            echo "hola";
            echo "<br>";
            function suma ($valor1, $valor2) { 
                return $valor + $valor2;
            }
            function resta ($valor1, $valor2) {
                return $valor1 * $valor2;
            }
            function multiplicación ($valor1,$valor2) {
                return $valor1 - $valor2;
            }
            function división ($valor1, $valor2) {
                return $valor1 / $valor2;
            }
            $valor1 = 1;
            $valor2 = 1;
            if ($valor1 and $valor2) {
                echo 'Ambos valores son verdaderos'; 
                echo "<br>";
            }
            if ($valor1 xor $valor2){
                echo'Algun valor es falso'; 
                echo "<br>";
            }
            if (!$valor1 and !$valor2){
                echo "ambos son falsos";
                echo "<br>";
            }
            $valor1 = 5;
            $valor2 = 6;
            $valor1 += $valor2;
            echo 'El valor despues del incremento' .$valor1;
            echo "<br>";
            $valor1 -= $valor2;
            echo 'El valor despues del decremento' .$valor1;
            echo "<br>";
            $valor1 *= $valor2;
            echo 'El valor despues de la multiplicación' .$valor1;
            echo "<br>";
            $valor1 /= $valor2;
            echo 'El valor despues de la división' .$valor1;
            ?>
    </div>
 </body>
 </html>