<?php
    include_once 'conecta.php';
    include_once 'registro.php';
    session_start();

    if (!isset($_SESSION['tipo_usu']) || $_SESSION['tipo_usu'] != 'Profesor') {
        header('Location: inicio.php');
        exit;
    }

    $conexion = conectar_bd();
    $id_pro_ram = $_SESSION['id_usu'];
    $id_ram = '';
    $nombre_ram = '';

    // Manejo de acciones del formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $accion = $_POST['accion'] ?? '';
        $id_ram = $_POST['id_ram'] ?? '';
        $nombre_ram = trim($_POST['nombre_ram']) ?? '';

        if ($accion == 'crear' && !empty($nombre_ram)) {
            try {
                $query = "INSERT INTO ramos (id_pro_ram, nombre_ram) VALUES (:id_pro_ram, :nombre_ram)";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':id_pro_ram', $id_pro_ram);
                $stmt->bindParam(':nombre_ram', $nombre_ram);
                $stmt->execute();
                // Redirigir para evitar el reenvío del formulario
                header('Location: ramos.php');
                exit;
            } catch (PDOException $e) {
                echo "<script>alert('Error al crear ramo: " . $e->getMessage() . "');</script>";
            }
        }

        if ($accion == 'actualizar' && !empty($nombre_ram) && !empty($id_ram)) {
            try {
                $query = "UPDATE ramos SET nombre_ram = :nombre_ram WHERE id_ram = :id_ram";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':nombre_ram', $nombre_ram);
                $stmt->bindParam(':id_ram', $id_ram);
                $stmt->execute();
                // Redirigir para evitar el reenvío del formulario
                header('Location: ramos.php');
                exit;
            } catch (PDOException $e) {
                echo "<script>alert('Error al actualizar ramo: " . $e->getMessage() . "');</script>";
            }
        }

        if ($accion == 'eliminar' && !empty($id_ram)) {
            try {
                $query = "DELETE FROM ramos WHERE id_ram = :id_ram";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':id_ram', $id_ram);
                $stmt->execute();
                // Redirigir para evitar el reenvío del formulario
                header('Location: ramos.php');
                exit;
            } catch (PDOException $e) {
                echo "<script>alert('Error al eliminar ramo: " . $e->getMessage() . "');</script>";
            }
        }
    }

    // Función para obtener ramos existentes
    function obtenerRamos($conexion) {
        try {
            $query = "SELECT id_ram, nombre_ram FROM ramos";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener ramos: " . $e->getMessage();
            return [];
        }
    }

    // Obtener la lista de ramos después de cada acción
    $ramos = obtenerRamos($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ramos</title>
    <link rel="stylesheet" href="./ramos.css">
    <script>
        function resetForm() {
            document.getElementById('nombre_ram').value = '';
            document.getElementById('nombre_ram').focus();
        }
    </script>
</head>
<body>
    <div class="header-ramos">
        <div class="logo">
            <img src="./logo.png" alt="Logo del Sistema">
        </div>
        <h1 class="titulo">Administración de Ramos</h1>
    </div>
    <form id="formRamo" method="POST" action="ramos.php">
        <h2><?php echo $id_ram ? "Modificar Ramo" : "Crear Nuevo Ramo"; ?></h2>
        <input type="hidden" name="accion" value="<?php echo $id_ram ? 'actualizar' : 'crear'; ?>">
        <input type="hidden" name="id_ram" value="<?php echo $id_ram; ?>">
        <label for="nombre_ram">Nombre del Ramo:</label>
        <input type="text" name="nombre_ram" id="nombre_ram" value="<?php echo htmlspecialchars($nombre_ram); ?>" required>
        <button type="submit"><?php echo $id_ram ? "Grabar Cambios" : "Grabar Nuevo Ramo"; ?></button>
    </form>
    <h2>Ramos Existentes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($ramos as $ramo): ?>
            <tr>
                <td><?php echo htmlspecialchars($ramo['id_ram']); ?></td>
                <td><?php echo htmlspecialchars($ramo['nombre_ram']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_ram" value="<?php echo $ramo['id_ram']; ?>">
                        <input type="hidden" name="nombre_ram" value="<?php echo htmlspecialchars($ramo['nombre_ram']); ?>">
                        <input type="hidden" name="accion" value="modificar">
                        <button type="submit">Modificar</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_ram" value="<?php echo $ramo['id_ram']; ?>">
                        <input  type="hidden" name="accion" value="eliminar">
                        <button type="submit" class="btn-eliminar"  onclick="return confirm('¿Estás seguro de que deseas eliminar este ramo?');">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>