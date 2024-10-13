<!DOCTYPE html>
<!-- error-v2.php -->
<html>
<head>
    <title>Error de Registro</title>
</head>
<body>
    <h1>Error de Registro</h1>
    <p>
        <?php 
            if (isset($_GET['mensaje'])) {
                echo htmlspecialchars($_GET['mensaje']);
            } 
        ?>
    </p>
    <a href="./form-ingreso-tester-v2.php">Volver al formulario</a>
</body>
</html>