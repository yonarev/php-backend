<?php
    // http://localhost:8080/dashboard/basedatos/despliega-tabla-v2.php
    include './config.php';

    $servidor = "localhost";
    $baseDatos = "anima";
    $usuario = "root";
    $contrasena = "";

    // Conectar a la base de datos
    $conexion = conectar_bd($servidor, $baseDatos, $usuario, $contrasena);

    // Realizar la consulta para obtener los registros
    $sql = "SELECT id, nombre, correo FROM testers";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Listado de Testers</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <h1>Listado de Testers</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
            </tr>
            <?php foreach ($resultados as $fila): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['id']); ?></td>
                <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                <td><?php echo htmlspecialchars($fila['correo']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="./form-ingreso-tester-v2.php">Volver al formulario</a>
    </body>
</html>