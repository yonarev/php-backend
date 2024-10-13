<?php
    function mostrarResultados($resultados) {
        foreach ($resultados as $fila) {
                // Aquí puedes personalizar cómo quieres mostrar los datos
                echo "Nombre: " . $fila['nombre'] . "<br>";
                echo "Edad: " . $fila['edad'] . "<br>";
                // ... otros campos que quieras mostrar
                echo "<hr>"; // Separador entre registros
        }
    }
    
?>