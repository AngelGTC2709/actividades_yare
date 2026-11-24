<?php
// 1. Datos de conexión de MySQL (sustituir por los del hosting)
$host = "sql308.infinityfree.com";
$db   = "if0_43168135_ferreteria";
$user = "if0_43168135";
$pass = "krwaSNEiOieaYO";

// 2. Crear la conexión PDO y configurar el manejo de errores
try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
