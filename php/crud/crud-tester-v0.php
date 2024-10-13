<?php
// http://localhost:8080/dashboard/crud/crud-tester-v0.php
function conectar_bd() {
    $servidor = "localhost";
    $baseDatos = "anima";
    $usuario = "root";
    $contrasena = "";
    try {
        $nombrebd = "anima";
        $dsn = "mysql:host=$servidor;dbname=$nombrebd";
        $conexion = new PDO($dsn, $usuario, $contrasena);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        echo "Fallo al conectar: " . $e->getMessage();
        exit;
    }
}

// Función para mostrar errores
function mostrar_error($mensaje) {
    echo "<div style='color: red;'><strong>Error:</strong> $mensaje</div>";
}

$conexion = conectar_bd();
$error = "";

// Eliminar registros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM testers WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    header("Location: crud-tester.php");
    exit();
}

// Procesar el formulario para insertar o modificar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['correo'])) {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Si el campo ID está presente, es una actualización
        $id = intval($_POST['id']);

        // Verificar si el nombre o el correo ya existen en otro registro
        $sql_nombre = "SELECT COUNT(*) FROM testers WHERE nombre = :nombre AND id != :id";
        $sql_correo = "SELECT COUNT(*) FROM testers WHERE correo = :correo AND id != :id";

        // Comprobar duplicado en nombre
        $consulta_nombre = $conexion->prepare($sql_nombre);
        $consulta_nombre->bindParam(":nombre", $nombre);
        $consulta_nombre->bindParam(":id", $id);
        $consulta_nombre->execute();
        $nombre_existe = $consulta_nombre->fetchColumn() > 0;

        // Comprobar duplicado en correo
        $consulta_correo = $conexion->prepare($sql_correo);
        $consulta_correo->bindParam(":correo", $correo);
        $consulta_correo->bindParam(":id", $id);
        $consulta_correo->execute();
        $correo_existe = $consulta_correo->fetchColumn() > 0;

        if ($nombre_existe) {
            $error = "El nombre '$nombre' ya está en uso por otro registro.";
        } elseif ($correo_existe) {
            $error = "El correo '$correo' ya está en uso por otro registro.";
        } else {
            // Realizar la actualización
            $sql = "UPDATE testers SET nombre = :nombre, correo = :correo WHERE id = :id";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":correo", $correo);
            $consulta->bindParam(":id", $id);
            $consulta->execute();
            header("Location: crud-tester.php");
            exit();
        }
    } else {
        // Si no hay ID, es un nuevo registro
        $sql_nombre = "SELECT COUNT(*) FROM testers WHERE nombre = :nombre";
        $sql_correo = "SELECT COUNT(*) FROM testers WHERE correo = :correo";
        
        // Comprobar duplicado en nombre
        $consulta_nombre = $conexion->prepare($sql_nombre);
        $consulta_nombre->bindParam(":nombre", $nombre);
        $consulta_nombre->execute();
        $nombre_existe = $consulta_nombre->fetchColumn() > 0;

        // Comprobar duplicado en correo
        $consulta_correo = $conexion->prepare($sql_correo);
        $consulta_correo->bindParam(":correo", $correo);
        $consulta_correo->execute();
        $correo_existe = $consulta_correo->fetchColumn() > 0;

        if ($nombre_existe) {
            $error = "El nombre '$nombre' ya está en uso.";
        } elseif ($correo_existe) {
            $error = "El correo '$correo' ya está en uso.";
        } else {
            // Insertar el nuevo registro
            $sql = "INSERT INTO testers (nombre, correo) VALUES (:nombre, :correo)";
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":correo", $correo);
            $consulta->execute();
            header("Location: crud-tester.php");
            exit();
        }
    }
}

// Consultar los registros para mostrarlos en la tabla
$sql = "SELECT id, nombre, correo FROM testers";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

$registro_actual = ["id" => "", "nombre" => "", "correo" => ""];

// Cargar los datos del registro a modificar
if (isset($_GET['modificar'])) {
    $id_modificar = intval($_GET['modificar']);
    $sql = "SELECT id, nombre, correo FROM testers WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id_modificar);
    $consulta->execute();
    $registro_actual = $consulta->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Testers</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <?php if (!empty($error)) mostrar_error($error); ?>
    <form method="post" action="crud-tester.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro_actual['id']); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro_actual['nombre']); ?>" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($registro_actual['correo']); ?>" required>
        <br>
        <input type="submit" value="<?php echo $registro_actual['id'] ? 'Modificar' : 'Registrar'; ?>">
    </form>

    <h1>Listado de Testers</h1>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Modificar</th>
        <th>Eliminar</th>
    </tr>
    <?php foreach ($resultados as $fila): ?>
    <tr>
        <td><?php echo htmlspecialchars($fila['id']); ?></td>
        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
        <td><?php echo htmlspecialchars($fila['correo']); ?></td>
        <td>
            <form method="get" action="crud-tester.php">
                <input type="hidden" name="modificar" value="<?php echo htmlspecialchars($fila['id']); ?>">
                <button type="submit">Modificar</button> <!-- Botón para modificar -->
            </form>
        </td>
        <td>
            <form method="post" action="crud-tester.php" onsubmit="return confirm('¿Estás seguro de eliminar este registro?');">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id']); ?>">
                <input type="hidden" name="eliminar" value="1">
                <button type="submit">Eliminar</button> <!-- Botón para eliminar -->
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
