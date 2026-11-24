<?php
include 'conexion.php';

$id = $_GET['id']; // Obtenido del enlace de la tabla

$sql = "DELETE FROM usuario WHERE noUsuario = :id";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $id);

$stmt->execute();
echo "Usuario eliminado permanentemente";
echo "<br><a href='leer.php'>Ver usuarios</a>";
?>
