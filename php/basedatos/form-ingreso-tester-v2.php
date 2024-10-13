<!-- //v2 llama a archivo ingreso-tester-v2.php
// http://localhost:8080/dashboard/basedatos/form-ingreso-tester-v2.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <script>
       document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("name").focus();
            document.getElementById("name").select();
        });
    </script>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form method="post" action="ingreso-tester.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="name" name="nombre" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
