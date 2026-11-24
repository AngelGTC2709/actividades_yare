<?php
include 'conexion.php'; // Reutilizamos el puente

// 1. Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellidoP = $_POST['apellidoP'];
$apellidoM = $_POST['apellidoM'];
$correo = $_POST['correo'];
$pais = $_POST['pais'];

// 2. Preparar la consulta SQL (El Escudo)
$sql = "INSERT INTO usuario (nombre, apellidoP, apelllidoM, correo, pais)
        VALUES (:nombre, :apellidoP, :apellidoM, :correo, :pais)";
$stmt = $conexion->prepare($sql);

// 3. Vincular los datos (Binding)
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':apellidoP', $apellidoP);
$stmt->bindParam(':apellidoM', $apellidoM);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':pais', $pais);

// 4. Ejecutar
$stmt->execute();
echo "Usuario registrado con éxito";
echo "<br><a href='leer.php'>Ver usuarios</a>";
?>
