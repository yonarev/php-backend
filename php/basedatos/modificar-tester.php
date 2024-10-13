<?php
    // FORMULARIO PARA MODIFICACION DE LOS DATOS PROVENIENTES DE  guardar-modificacion.php <-- despliega-tabla-v3.php
    // http://localhost:8080/dashboard/basedatos/modificar-tester.php
    include './conecta-seguro.php';
    // Conectar a la base de datos
    $conexion = conectar_bd();

    // Verificar si se recibió el ID
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        // Obtener los datos del tester
        $sql = "SELECT nombre, correo FROM testers WHERE id = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $tester = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$tester) {
            echo "Tester no encontrado.";
            exit();
        }
    } else {
        echo "ID no válido.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Tester</title>
</head>
<body>
    <h1>Modificar Tester</h1>
    <form action="guardar-modificacion.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($tester['nombre']); ?>" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($tester['correo']); ?>" required>
        <br>
        <input type="submit" value="Guardar Cambios">
    </form>
    <a href="./despliega-tabla-v3.php">Volver al listado</a>
</body>
</html>