<?php
    // Incluimos el archivo de conexión a la base de datos y el registro de logs
    include_once 'conecta.php'; 
    include_once 'registro.php';

    // Verificamos si el usuario tiene permisos de superusuario antes de mostrar el contenido
    session_start();
    if (!isset($_SESSION['tipo_usu']) || $_SESSION['tipo_usu'] == 'Superusuario') {
        echo "No tienes permisos para acceder a esta página.";
        exit;
    }
    if (!isset($_SESSION['tipo_usu']) || $_SESSION['tipo_usu'] == 'Alumno') {
        echo "No tienes permisos para acceder a esta página.";
        exit;
    }

    // Conectamos a la base de datos
    $conexion = conectar_bd();

    // Inicializamos las variables para el formulario
    $id_usu = $nombre = $apellidos = $correo = '';
    $id_activo = id_sesion();
    $id_tipo = tipo_sesion();

    // Cargar datos si se solicita modificar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'modificar') {
        $id_usu = $_POST['id_usu'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
    }

    // Crear un nuevo profesor
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'crear') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO usuarios (tipo_usu, nombre, apellidos, correo, psw) VALUES ('Profesor', :nombre, :apellidos, :correo, :psw)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':psw', $psw);
            $stmt->execute();
            echo "Profesor creado correctamente.";

            // Registro de log
            $reg_log = "Ingresó el profesor con correo: " . $correo;
            registrar("usuarios", $id_activo, $id_tipo, $reg_log);

            // Reiniciar los campos del formulario
            $id_usu = $nombre = $apellidos = $correo = '';
            echo "<script>resetForm();</script>";
        } catch (PDOException $e) {
            echo "Error al crear profesor: " . $e->getMessage();
        }
    }

    // Actualizar un profesor
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
        $id_usu = $_POST['id_usu'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $psw = isset($_POST['psw']) ? password_hash($_POST['psw'], PASSWORD_DEFAULT) : null;

        try {
            if ($psw) {
                $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo, psw = :psw WHERE id_usu = :id_usu AND tipo_usu = 'Profesor'";
                $stmt->bindParam(':psw', $psw);
            } else {
                $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo WHERE id_usu = :id_usu AND tipo_usu = 'Profesor'";
            }
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':id_usu', $id_usu);
            $stmt->execute();
            echo "Profesor actualizado correctamente.";

            // Registro de log
            $reg_log = "Se actualizó el profesor con ID: " . strval($id_usu) . " Nombre y apellido: " . $nombre . " " . $apellidos . " Correo: " . $correo;
            registrar("usuarios", $id_activo, $id_tipo, $reg_log);

            // Reiniciar los campos del formulario
            $id_usu = $nombre = $apellidos = $correo = '';
            echo "<script>resetForm();</script>";
        } catch (PDOException $e) {
            echo "Error al actualizar profesor: " . $e->getMessage();
        }
    }

    // Eliminar un profesor
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $id_usu = $_POST['id_usu'];

        try {
            $query = "DELETE FROM usuarios WHERE id_usu = :id_usu AND tipo_usu = 'Profesor'";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id_usu', $id_usu);
            $stmt->execute();
            echo "Profesor eliminado correctamente.";

            // Registro de log
            $reg_log = "Se eliminó el profesor con ID: " . strval($id_usu);
            registrar("usuarios", $id_activo, $id_tipo, $reg_log);
        } catch (PDOException $e) {
            echo "Error al eliminar profesor: " . $e->getMessage();
        }
    }

    // Función para obtener profesores existentes
    function obtenerProfesores($conexion) {
        try {
            $query = "SELECT id_usu, nombre, apellidos, correo FROM usuarios WHERE tipo_usu = 'Profesor'";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener profesores: " . $e->getMessage();
            return [];
        }
    }

    // Obtener la lista de profesores después de cada acción
    $profesores = obtenerProfesores($conexion);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administración de Profesores</title>
        <link rel="stylesheet" href="./profesores.css"> <!-- Archivo CSS adaptable -->
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
        <div class="header-profesores">
            <div class="logo">
                <a href="index.php">
                    <img src="./logo.png" alt="Logo del Sistema">
                </a>
            </div>    
            <h1>Administración de Profesores</h1>
        </div>

        <form method="POST" action="profesores.php">
            <h2><?php echo $id_usu ? "Modificar Profesor" : "Crear Nuevo Profesor"; ?></h2>
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

            <button class="btn_modifica" type="submit"><?php echo $id_usu ? "Grabar Cambios" : "Grabar Nuevo Profesor"; ?></button>
        </form>

        <h2>Profesores Existentes</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($profesores as $prof): ?>
                <tr>
                    <td><?php echo htmlspecialchars($prof['id_usu']); ?></td>
                    <td><?php echo htmlspecialchars($prof['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($prof['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($prof['correo']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_usu" value="<?php echo $prof['id_usu']; ?>">
                            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($prof['nombre']); ?>">
                            <input type="hidden" name="apellidos" value="<?php echo htmlspecialchars($prof['apellidos']); ?>">
                            <input type="hidden" name="correo" value="<?php echo htmlspecialchars($prof['correo']); ?>">
                            <input type="hidden" name="accion" value="modificar">
                            <button type="submit">Modificar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_usu" value="<?php echo $prof['id_usu']; ?>">
                            <input type="hidden" name="accion" value="eliminar">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este profesor?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
    </table>
    </body>
</html>
