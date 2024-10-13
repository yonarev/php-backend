<?php
    // http://localhost:8080/dashboard/calificaciones/administra.php
    // Incluimos el archivo de conexión a la base de datos
    include_once 'conecta.php';
    include_once 'registro.php';
    // Verificamos si el usuario tiene permisos de superusuario antes de mostrar el contenido
    session_start();
    if (!isset($_SESSION['tipo_usu']) || $_SESSION['tipo_usu'] != 'Superusuario') {
        echo "No tienes permisos para acceder a esta página.";
        exit;
    }

    // Conectamos a la base de datos
    $conexion = conectar_bd();

    // Inicializamos las variables para el formulario
    $id_usu = $nombre = $apellidos = $correo = '';
    $id_activo=id_sesion();
    $id_tipo=tipo_sesion();
    // Cargar datos si se solicita modificar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'modificar') {
        $id_usu = $_POST['id_usu'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
    }

    // Crear un nuevo administrador
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'crear') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO usuarios (tipo_usu, nombre, apellidos, correo, psw) VALUES ('Administrador', :nombre, :apellidos, :correo, :psw)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':psw', $psw);
            $stmt->execute();
            echo "Administrador creado correctamente.";
            //registro
            $reg_log="Ingresó el administrador con correo: ". $correo;
            registrar("usuarios", $id_activo, $id_tipo, $reg_log);
            // Reiniciar los campos del formulario
            $id_usu = $nombre = $apellidos = $correo = '';
            //cerrar conexion
            echo "<script>resetForm();</script>"; // Llamar a resetForm para limpiar el formulario
        } catch (PDOException $e) {
            echo "Error al crear administrador: " . $e->getMessage();
        }
    }

    // Actualizar un administrador
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
        $id_usu = $_POST['id_usu'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $psw = isset($_POST['psw']) ? password_hash($_POST['psw'], PASSWORD_DEFAULT) : null;

        try {
            // Comprobar si se quiere actualizar la contraseña
            if ($psw) {
                $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo, psw = :psw WHERE id_usu = :id_usu AND tipo_usu = 'Administrador'";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':psw', $psw);
            } else {
                $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo WHERE id_usu = :id_usu AND tipo_usu = 'Administrador'";
                $stmt = $conexion->prepare($query);
            }

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':id_usu', $id_usu);
            $stmt->execute();
            echo "Administrador actualizado correctamente.";
             //registro
             $reg_log="se actualizo el administrador con id: ". strval($id_usu) ." Nombre y apellido: ". $nombre . " " . $apellidos . " Correo: " . $correo;
             registrar("usuarios", $id_activo, $id_tipo, $reg_log);
            // Reiniciar los campos del formulario
            $id_usu = $nombre = $apellidos = $correo = '';
            echo "<script>resetForm();</script>"; // Llamar a resetForm para limpiar el formulario
        } catch (PDOException $e) {
            echo "Error al actualizar administrador: " . $e->getMessage();
        }
    }

    // Eliminar un administrador
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $id_usu = $_POST['id_usu'];

        try {
            $query = "DELETE FROM usuarios WHERE id_usu = :id_usu AND tipo_usu = 'Administrador'";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id_usu', $id_usu);
            $stmt->execute();
            echo "Administrador eliminado correctamente.";
            //registro
            $reg_log="se elimino el administrador con id: ". strval($id_usu);
            registrar("usuarios", $id_activo, $id_tipo, $reg_log);
        } catch (PDOException $e) {
            echo "Error al eliminar administrador: " . $e->getMessage();
        }
    }

    // Función para obtener administradores existentes
    function obtenerAdministradores($conexion) {
        try {
            $query = "SELECT id_usu, nombre, apellidos, correo FROM usuarios WHERE tipo_usu = 'Administrador'";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener administradores: " . $e->getMessage();
            return [];
        }
    }

    // Obtener la lista de administradores después de cada acción
    $administradores = obtenerAdministradores($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Administradores</title>
    <link rel="stylesheet" href="administra.css"> <!-- Archivo CSS adaptable -->
    <script>
        // Función para limpiar el formulario y enfocar el campo nombre
        function resetForm() {
            document.getElementById('nombre').value = '';
            document.getElementById('apellidos').value = '';
            document.getElementById('correo').value = '';
            document.getElementById('psw').value = '';
            document.getElementById('nombre').focus();
        }
    </script>
</head>
<body>
    <h1>Administración de Administradores</h1>

    <form method="POST" action="administra.php">
        <h2><?php echo $id_usu ? "Modificar Administrador" : "Crear Nuevo Administrador"; ?></h2>
        <input type="hidden" name="accion" value="<?php echo $id_usu ? 'actualizar' : 'crear'; ?>">
        <input type="hidden" name="id_usu" value="<?php echo $id_usu; ?>">
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>" required>
        
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
        
        <label for="psw">Contraseña:</label>
        <input type="password" name="psw" id="psw" placeholder="Dejar en blanco si no desea cambiarla">
        
        <button class="btn_modifica" type="submit"><?php echo $id_usu ? "Grabar Cambios" : "Grabar Nuevo Administrador"; ?></button>
    </form>

    <h2>Administradores Existentes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($administradores as $admin): ?>
        <tr>
            <td><?php echo htmlspecialchars($admin['id_usu']); ?></td>
            <td><?php echo htmlspecialchars($admin['nombre']); ?></td>
            <td><?php echo htmlspecialchars($admin['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($admin['correo']); ?></td>
            <td>
                <!-- Botón para cargar datos en el formulario -->
                <form method="POST" action="administra.php" style="display:inline;">
                    <input type="hidden" name="accion" value="modificar">
                    <input type="hidden" name="id_usu" value="<?php echo htmlspecialchars($admin['id_usu']); ?>">
                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($admin['nombre']); ?>">
                    <input type="hidden" name="apellidos" value="<?php echo htmlspecialchars($admin['apellidos']); ?>">
                    <input type="hidden" name="correo" value="<?php echo htmlspecialchars($admin['correo']); ?>">
                    <button class="btn_modifica" type="submit">Modificar</button>
                </form>
                <!-- Formulario para eliminar -->
                <form method="POST" action="administra.php" style="display:inline;">
                    <input class="btn-eliminar" type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id_usu" value="<?php echo htmlspecialchars($admin['id_usu']); ?>">
                    <button class="btn-eliminar" type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este administrador?');">Eliminar</button>
                </form>
            </td>
        </tr> 
        <?php endforeach; ?>
    </table>
</body>
</html>
