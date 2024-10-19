<?php
//url scrip no borrar http://localhost:8080/dashboard/edita_super.php

// Incluimos el archivo de conexión a la base de datos
include 'conecta.php';

// Conectamos a la base de datos
$conexion = conectar_bd();

// Verificamos si ya existe un superusuario en la base de datos
try {
    $query = "SELECT * FROM usuarios WHERE tipo_usu = 'Superusuario'";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $superusuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al verificar superusuario: " . $e->getMessage();
    exit;
}

// Procesar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'], $_POST['apellidos'], $_POST['correo'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    
    // Verificar si se proporciona una nueva contraseña
    if (!empty($_POST['psw'])) {
        $nuevo_psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);
    } else {
        $nuevo_psw = $superusuario['psw']; // Mantener la contraseña existente
    }

    try {
        $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo, psw = :psw WHERE tipo_usu = 'Superusuario'";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':psw', $nuevo_psw);
        $stmt->execute();
        
        echo "Datos del superusuario actualizados correctamente.";
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar los datos: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./edita_super.css">
</head>
<body>
    <h1>Actualizar Datos de Superusuario</h1>
    
    <?php if ($superusuario): ?>
        <form method="POST" action="edita_super.php">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($superusuario['nombre']); ?>" required><br>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" value="<?php echo htmlspecialchars($superusuario['apellidos']); ?>" required><br>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" value="<?php echo htmlspecialchars($superusuario['correo']); ?>" required><br>

            <label for="psw">Nueva Contraseña:</label>
            <input type="password" name="psw"><br>
            <small>(Dejar en blanco si no deseas cambiar la contraseña)</small><br>

            <button type="submit">Actualizar Datos</button>
        </form>
    <?php else: ?>
        <p>No hay un superusuario registrado en el sistema.</p>
    <?php endif; ?>
</body>
</html>