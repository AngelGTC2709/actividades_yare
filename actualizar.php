<?php
include 'conexion.php';

$id = $_POST['id'];
$nuevoNombre = $_POST['nombre'];
$nuevoApellidoP = $_POST['apellidoP'];
$nuevoApellidoM = $_POST['apellidoM'];
$nuevoCorreo = $_POST['correo'];
$nuevoPais = $_POST['pais'];

$sql = "UPDATE usuario SET nombre = :nombre, apellidoP = :apellidoP, apelllidoM = :apellidoM,
        correo = :correo, pais = :pais WHERE noUsuario = :id";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':nombre', $nuevoNombre);
$stmt->bindParam(':apellidoP', $nuevoApellidoP);
$stmt->bindParam(':apellidoM', $nuevoApellidoM);
$stmt->bindParam(':correo', $nuevoCorreo);
$stmt->bindParam(':pais', $nuevoPais);
$stmt->bindParam(':id', $id);

$stmt->execute();
echo "Usuario actualizado";
echo "<br><a href='leer.php'>Ver usuarios</a>";
?>
