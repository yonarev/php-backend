<!DOCTYPE html>
<!-- exito-v3.php -->
<html>
<head>
    <title>Registro Exitoso</title>
</head>
<body>
    <h1>Registro Exitoso</h1>
    <p>
        <?php 
            if (isset($_GET['mensaje'])) {
                echo htmlspecialchars($_GET['mensaje']);
            } 
        ?>
    </p>
    <a href="./form-ingreso-tester-v3.php">Volver al formulario</a>
</body>
</html>