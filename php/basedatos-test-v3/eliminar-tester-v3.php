<?php
// eliminar-tester-v3.php
    // Incluir el archivo de conexión a la base de datos
    include './conecta-seguro-v3.php';
    
    // Conectar a la base de datos
    $conexion = conectar_bd();

    // Verificar si se ha enviado el ID del tester a eliminar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Preparar la consulta DELETE
        $sql = "DELETE FROM testers WHERE id = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta y verificar si se eliminó correctamente
        try {
            $consulta->execute();
            header("Location: despliega-tabla-v3.php?mensaje=Registro eliminado correctamente");
            exit();
        } catch (PDOException $e) {
            header("Location: despliega-tabla-v3.php?mensaje=Error al eliminar el registro");
            exit();
        }
    } else {
        header("Location: despliega-tabla-v3.php?mensaje=ID no válido");
        exit();
    }
?>
