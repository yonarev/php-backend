<?php
// http://localhost:8080/dashboard/basedatos/inserta-mascotas.php
// Incluir el archivo de conexión a la base de datos
include './config.php';

// Datos de conexión
$servidor = "localhost";
$baseDatos = "anima";
$usuario = "root";
$contrasena = "";
// Conectar a la base de datos
$conexion = conectar_bd($servidor, $baseDatos, $usuario, $contrasena);

// Array de datos a insertar
$datos = [
    [
        'cod_mascota' => 'MASC001',
        'id_amo' => 1,
        'cod_amo' => 'AMO001',
        'nombre' => 'Firulais',
        'edad' => 3,
        'direccion' => 'Calle Falsa 123',
        'ciudad' => 'Springfield',
        'region' => 'Oregon',
        'bitacora' => 'Vacunas al día',
        'detalles' => 'Muy juguetón',
        'foto_perfil' => 'firulais.jpg',
        'fotos' => 'firulais1.jpg,firulais2.jpg',
        'adicional' => 'Le gusta el pollo'
    ],
    [
        'cod_mascota' => 'MASC002',
        'id_amo' => 2,
        'cod_amo' => 'AMO002',
        'nombre' => 'Snoopy',
        'edad' => 5,
        'direccion' => 'Av. Siempre Viva 742',
        'ciudad' => 'Springfield',
        'region' => 'Oregon',
        'bitacora' => 'Última vacuna: 2022-05-15',
        'detalles' => 'Muy dormilón',
        'foto_perfil' => 'snoopy.jpg',
        'fotos' => 'snoopy1.jpg,snoopy2.jpg',
        'adicional' => 'Le gusta la miel'
    ],
    // ... agrega más conjuntos de datos según necesites
];

// Construir la consulta INSERT múltiple
$sql = "INSERT INTO mascotas (cod_mascota, id_amo, cod_amo, nombre, edad, direccion, ciudad, region, bitacora, detalles, foto_perfil, fotos, adicional) VALUES ";
$valores = [];
foreach ($datos as $fila) {
    $valores[] = "('{$fila['cod_mascota']}', {$fila['id_amo']}, '{$fila['cod_amo']}', '{$fila['nombre']}', {$fila['edad']}, '{$fila['direccion']}', '{$fila['ciudad']}', '{$fila['region']}', '{$fila['bitacora']}', '{$fila['detalles']}', '{$fila['foto_perfil']}', '{$fila['fotos']}', '{$fila['adicional']}')";
}
$sql .= implode(", ", $valores);

// Ejecutar la consulta
$conexion->exec($sql);

echo "Registros insertados correctamente.";

// Cerrar la conexión
$conexion = null;
?>