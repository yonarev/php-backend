<?php
    //  http://localhost:8080/dashboard/alumnos.php 

    // Incluimos el archivo de conexión a la base de datos y el registro de logs
    include_once 'conecta.php'; 
    include_once 'registro.php';
    
    // Verificamos si el usuario tiene permisos de profesor antes de mostrar el contenido
    session_start();
    if (!isset($_SESSION['tipo_usu']) || $_SESSION['tipo_usu'] != 'Profesor') {
        echo "No tienes permisos para acceder a esta página.";
        exit;
    }

    // Conectamos a la base de datos
    $conexion = conectar_bd();
    $id_activo = id_sesion();
    $id_tipo = tipo_sesion();

    // Inicializamos las variables para el formulario
    $id_usu = $nombre = $apellidos = $correo = '';

    // Cargar datos si se solicita modificar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'modificar') {
        $id_usu = $_POST['id_usu'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
    }

    // Crear un nuevo alumno
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'crear') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        try {
            $query = "INSERT INTO usuarios (tipo_usu, nombre, apellidos, correo, psw) VALUES ('Alumno', :nombre, :apellidos, :correo, :psw)";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':psw', $psw);
            $stmt->execute();
            echo "Alumno creado correctamente.";

            // Registro de log
            $reg_log = "Ingresó el alumno con correo: " . $correo;
            registrar("usuarios", $id_activo, 'Alumno', $reg_log);

            // Reiniciar los campos del formulario
            $id_usu = $nombre = $apellidos = $correo = '';
            echo "<script>resetForm();</script>";
        } catch (PDOException $e) {
            echo "Error al crear alumno: " . $e->getMessage();
        }
    }
    // Actualizar datos de un alumno
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
        $id_usu = $_POST['id_usu'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $psw = $_POST['psw'];

        try {
            // Verificamos si se ha proporcionado una nueva contraseña
            if (!empty($psw)) {
                $psw = password_hash($psw, PASSWORD_DEFAULT);
                $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo, psw = :psw WHERE id_usu = :id_usu AND tipo_usu = 'Alumno'";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':psw', $psw);
            } else {
                // Si no se ha cambiado la contraseña, omitimos ese campo
                $query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, correo = :correo WHERE id_usu = :id_usu AND tipo_usu = 'Alumno'";
                $stmt = $conexion->prepare($query);
            }
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':id_usu', $id_usu);
            $stmt->execute();

            echo "Alumno actualizado correctamente.";

            // Registro de log
            $reg_log ="Se actualizó el alumno con ID: " . strval($id_usu) . " Nombre y apellido: " . $nombre . " " . $apellidos . " Correo: " . $correo;
            registrar("usuarios", $id_activo, 'Profesor', $reg_log);

            // Reiniciar los campos del formulario
            $id_usu = $nombre = $apellidos = $correo = '';
            echo "<script>resetForm();</script>";
        } catch (PDOException $e) {
            echo "Error al actualizar alumno: " . $e->getMessage();
        }
    }

    // Eliminar un alumno
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $id_usu = $_POST['id_usu'];
        
        // Mensaje de depuración
        echo "Intentando eliminar el alumno con id: " . $id_usu;
    
        try {
            // Eliminar el alumno de la base de datos
            $query = "DELETE FROM usuarios WHERE id_usu = :id_usu AND tipo_usu = 'Alumno'";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id_usu', $id_usu);
    
            // Para verificar si el alumno es eliminado correctamente
            if ($stmt->execute()) {
                echo "Alumno eliminado correctamente.";
            } else {
                echo "Error al ejecutar la eliminación.";
            }
    
            // Registro de log
            $reg_log = "Eliminó el alumno con id: " . $id_usu;
            registrar("usuarios", $id_activo, 'Alumno', $reg_log);
            
        } catch (PDOException $e) {
            echo "Error al eliminar alumno: " . $e->getMessage();
        }
    }
    
    // Función para obtener alumnos existentes
    function obtenerAlumnos($conexion) {
        try {
            $query = "SELECT id_usu, nombre, apellidos, correo FROM usuarios WHERE tipo_usu = 'Alumno'";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener alumnos: " . $e->getMessage();
            return [];
        }
    }

    // Obtener la lista de alumnos después de cada acción
    $alumnos = obtenerAlumnos($conexion);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administración de Alumnos</title>
        <link rel="stylesheet" href="./alumnos.css"> <!-- Archivo CSS adaptable -->
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
        <div class="header-alumnos">
            <div class="logo">
                <a href="index.php">
                    <img src="./logo.png" alt="Logo del Sistema">
                </a>
            </div>    
            <h1>Administración de Alumnos</h1>
        </div>

        <form method="POST" action="alumnos.php">
            <h2><?php echo $id_usu ? "Modificar Alumno" : "Crear Nuevo Alumno"; ?></h2>
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

            <button class="btn_modifica" type="submit"><?php echo $id_usu ? "Grabar Cambios" : "Grabar Nuevo Alumno"; ?></button>
        </form>

        <h2>Alumnos Existentes</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($alumnos as $alu): ?>
                <tr>
                    <td><?php echo htmlspecialchars($alu['id_usu']); ?></td>
                    <td><?php echo htmlspecialchars($alu['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($alu['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($alu['correo']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_usu" value="<?php echo $alu['id_usu']; ?>">
                            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($alu['nombre']); ?>">
                            <input type="hidden" name="apellidos" value="<?php echo htmlspecialchars($alu['apellidos']); ?>">
                            <input type="hidden" name="correo" value="<?php echo htmlspecialchars($alu['correo']); ?>">
                            <input type="hidden" name="accion" value="modificar">
                            <button type="submit">Modificar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_usu" value="<?php echo $alu['id_usu']; ?>">
                            <input type="hidden" name="accion" value="eliminar">
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este alumno?');">Eliminar</button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>
