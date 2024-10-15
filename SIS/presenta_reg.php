<?php
// http://localhost:8080/dashboard/presenta_reg.php

// Incluir archivo de conexión
include 'conecta.php';

// Conectar a la base de datos
$conexion = conectar_bd();

// Consultar los registros de la tabla logs junto con los correos de la tabla usuarios
$query = "SELECT l.id_log, l.id_usu, l.tipo_log, l.fecha_log, l.hora_ini_log, l.reg_log, u.correo
          FROM logs l
          JOIN usuarios u ON l.id_usu = u.id_usu
          ORDER BY l.fecha_log DESC, l.hora_ini_log DESC"; // Ordenar por fecha y hora

$stmt = $conexion->prepare($query);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Logs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Registros de Logs</h1>
    <?php
        echo '<button><a href="index.php">Volver al Indice</a></button>';
    ?>

    <table>
        <thead>
            <tr>
                <th>ID Log</th>
                <th>ID Usuario</th>
                <th>Usuario (Correo)</th>
                <th>Tipo de Log</th>
                <th>Fecha</th>
                <th>Hora de Inicio</th>
                <th>Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['id_log']); ?></td>
                <td><?php echo htmlspecialchars($log['id_usu']); ?></td>
                <td><?php echo htmlspecialchars($log['correo']); ?></td>
                <td><?php echo htmlspecialchars($log['tipo_log']); ?></td>
                <td><?php echo htmlspecialchars($log['fecha_log']); ?></td>
                <td><?php echo htmlspecialchars($log['hora_ini_log']); ?></td>
                <td><?php echo htmlspecialchars($log['reg_log']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
