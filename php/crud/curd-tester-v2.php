<?php
    // http://localhost:8080/dashboard/crud/crud-tester-2.php
// Conexión a la base de datos
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

// Mostrar errores
function mostrar_error($mensaje) {
    echo "<div style='color: red;'><strong>Error:</strong> $mensaje</div>";
}

// Crear un nuevo registro
function crear_registro($nombre, $correo) {
    $conexion = conectar_bd();
    $sql = "INSERT INTO testers (nombre, correo) VALUES (:nombre, :correo)";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":correo", $correo);
    $consulta->execute();
    header("Location: crud-tester-2.php");
    exit();
}

// Leer todos los registros
function leer_registros() {
    $conexion = conectar_bd();
    $sql = "SELECT id, nombre, correo FROM testers";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

// Leer un registro por ID
function leer_registro_por_id($id) {
    $conexion = conectar_bd();
    $sql = "SELECT id, nombre, correo FROM testers WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(':id', $id);
    $consulta->execute();
    return $consulta->fetch(PDO::FETCH_ASSOC);
}

// Actualizar un registro
function actualizar_registro($id, $nombre, $correo) {
    $conexion = conectar_bd();
    $sql = "UPDATE testers SET nombre = :nombre, correo = :correo WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":correo", $correo);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    header("Location: crud-tester-2.php");
    exit();
}

// Eliminar un registro
function eliminar_registro($id) {
    $conexion = conectar_bd();
    $sql = "DELETE FROM testers WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    echo json_encode(['success' => true]);
    exit();
}

// Comprobar si existe un nombre o correo
function existe_nombre_correo($nombre, $correo, $id = null) {
    $conexion = conectar_bd();
    $sql_nombre = "SELECT COUNT(*) FROM testers WHERE nombre = :nombre" . ($id ? " AND id != :id" : "");
    $sql_correo = "SELECT COUNT(*) FROM testers WHERE correo = :correo" . ($id ? " AND id != :id" : "");
    
    // Comprobar duplicado en nombre
    $consulta_nombre = $conexion->prepare($sql_nombre);
    $consulta_nombre->bindParam(":nombre", $nombre);
    if ($id) $consulta_nombre->bindParam(":id", $id);
    $consulta_nombre->execute();
    $nombre_existe = $consulta_nombre->fetchColumn() > 0;

    // Comprobar duplicado en correo
    $consulta_correo = $conexion->prepare($sql_correo);
    $consulta_correo->bindParam(":correo", $correo);
    if ($id) $consulta_correo->bindParam(":id", $id);
    $consulta_correo->execute();
    $correo_existe = $consulta_correo->fetchColumn() > 0;

    return ['nombre' => $nombre_existe, 'correo' => $correo_existe];
}

// Procesar el formulario
function procesar_formulario() {
    global $error, $registro_actual;
    $conexion = conectar_bd();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['eliminar'])) {
            eliminar_registro(intval($_POST['id']));
        } else {
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
            
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $id = intval($_POST['id']);
                $existe = existe_nombre_correo($nombre, $correo, $id);
                
                if ($existe['nombre']) {
                    $error = "El nombre '$nombre' ya está en uso por otro registro.";
                } elseif ($existe['correo']) {
                    $error = "El correo '$correo' ya está en uso por otro registro.";
                } else {
                    actualizar_registro($id, $nombre, $correo);
                }
            } else {
                $existe = existe_nombre_correo($nombre, $correo);
                
                if ($existe['nombre']) {
                    $error = "El nombre '$nombre' ya está en uso.";
                } elseif ($existe['correo']) {
                    $error = "El correo '$correo' ya está en uso.";
                } else {
                    crear_registro($nombre, $correo);
                }
            }
        }
    }

    if (isset($_GET['modificar'])) {
        $registro_actual = leer_registro_por_id(intval($_GET['modificar']));
    }
}

// Ejecutar la acción correspondiente
$resultados = leer_registros();
$error = "";
$registro_actual = ["id" => "", "nombre" => "", "correo" => ""];
procesar_formulario();

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD Testers</title>
        <script>
            function eliminarRegistro(id) {
                if (confirm('¿Estás seguro de eliminar este registro?')) {
                    fetch('crud-tester-2.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + id + '&eliminar=1'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Eliminar la fila correspondiente de la tabla
                            const fila = document.getElementById('fila-' + id);
                            if (fila) {
                                fila.remove();
                            }
                        } else {
                            alert('Error al eliminar el registro.');
                        }
                    });
                }
            }
        </script>
    </head>
    <body>
        <h1>Formulario de Registro</h1>
        <?php if (!empty($error)) mostrar_error($error); ?>
        <form method="post" action="crud-tester-2.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro_actual['id']); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro_actual['nombre']); ?>" required>
            

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($registro_actual['correo']); ?>" required>
            

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
                <tr id="fila-<?php echo htmlspecialchars($fila['id']); ?>">
                    <td><?php echo htmlspecialchars($fila['id']); ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                    <td>
                        <form action="crud-tester-2.php" method="get" style="display:inline;">
                            <input type="hidden" name="modificar" value="<?php echo htmlspecialchars($fila['id']); ?>">
                            <button type="submit">Modificar</button>
                        </form>
                    </td>
                    <td>
                        <button onclick="eliminarRegistro(<?php echo htmlspecialchars($fila['id']); ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>