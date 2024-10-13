<?php
    //GUARDA LOS CAMBIOS PROVENIENTES DE despliega-tabla-v3.php
    // http://localhost:8080/dashboard/basedatos/guardar-modificacion-v3.php
    include './conecta-seguro-v3.php';

    // Conectar a la base de datos
    $conexion = conectar_bd();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener y sanitizar los datos del formulario
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);

        // Validar que los datos sean válidos
        if ($id === false || empty($nombre) || empty($correo)) {
            header("Location: error-v3.php?mensaje=Datos inválidos.");
            exit();
        }

        // Consulta para actualizar el registro
        $sql = "UPDATE testers SET nombre = :nombre, correo = :correo WHERE id = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":correo", $correo);
        $consulta->bindParam(":id", $id);

        try {
            // Ejecutar la consulta
            $consulta->execute();
            // Redirigir al listado después de la modificación
            header("Location: ./despliega-tabla-v3.php");
            exit();
        } catch (PDOException $e) {
            // Manejo de errores
            header("Location: error-v3.php?mensaje=Error al modificar el registro.");
            exit();
        }
    } else {
        // Manejo si no es un POST
        header("Location: error-v3.php?mensaje=Acceso no permitido.");
        exit();
    }
?>