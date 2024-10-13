<?php
    // http://localhost:8080/dashboard/basedatos/presenta-mascotas.php
    include './config.php';

    // Datos de conexión
    $servidor = "localhost";
    $baseDatos = "anima";
    $usuario = "root";
    $contrasena = "";

    // Conectar a la base de datos
    $conexion = conectar_bd($servidor, $baseDatos, $usuario, $contrasena);

    // Realizar la consulta SELECT
    $sql = "SELECT * FROM mascotas";
    $consulta = $conexion->query($sql);

    // Mostrar las mascotas en una página web
    echo "<h1>Listado de Mascotas</h1>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Código</th><th>ID Amo</th><th>Código Amo</th><th>Nombre</th><th>Edad</th><th>Dirección</th><th>Ciudad</th><th>Región</th><th>Bitácora</th><th>Detalles</th><th>Foto Perfil</th><th>Fotos</th><th>Adicional</th></tr>";

    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $fila['id_mascota'] . "</td>";
        echo "<td>" . $fila['cod_mascota'] . "</td>";
        echo "<td>" . $fila['id_amo'] . "</td>";
        echo "<td>" . $fila['cod_amo'] . "</td>";
        echo "<td>" . $fila['nombre'] . "</td>";
        echo "<td>" . $fila['edad'] . "</td>";
        echo "<td>" . $fila['direccion'] . "</td>";
        echo "<td>" . $fila['ciudad'] . "</td>";
        echo "<td>" . $fila['region'] . "</td>";
        echo "<td>" . $fila['bitacora'] . "</td>";
        echo "<td>" . $fila['detalles'] . "</td>";
        echo "<td>" . $fila['foto_perfil'] . "</td>";
        echo "<td>" . $fila['fotos'] . "</td>";
        echo "<td>" . $fila['adicional'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    // Cerrar la conexión
    $conexion = null;
?>