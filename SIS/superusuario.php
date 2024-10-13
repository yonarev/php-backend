<?php
//http://localhost:8080/dashboard/calificaciones/superusuario.php
// Incluimos el archivo de conexión a la base de datos
include 'conecta.php';

// Conectamos a la base de datos
$conexion = conectar_bd();

// Verificamos si ya existe un superusuario en la base de datos
try {
    $query = "SELECT COUNT(*) as total FROM usuarios WHERE tipo_usu = 'Superusuario'";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['total'] > 0) {
        echo "Ya existe un superusuario en el sistema. No se puede crear otro.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error al verificar superusuario: " . $e->getMessage();
    exit;
}

// Procesar el formulario de creación del superusuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO usuarios (tipo_usu, nombre, apellidos, correo, psw) VALUES ('Superusuario', :nombre, :apellidos, :correo, :psw)";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':psw', $psw);
        $stmt->execute();
        echo "Superusuario creado correctamente.";
        exit;
    } catch (PDOException $e) {
        echo "Error al crear superusuario: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Superusuario</title>
</head>
<body>
    <h1>Crear Superusuario</h1>
    
    <form method="POST" action="superusuario.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" required><br>

        <label for="psw">Contraseña:</label>
        <input type="password" name="psw" required><br>

        <button type="submit">Crear Superusuario</button>
    </form>
</body>
</html>
