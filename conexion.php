<?php

$host = "sql308.infinityfree.com";
$db   = "if0_43168135_ferreteria";
$user = "if0_43168135";
$pass = "krwaSNEiOieaYO";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Error de conexión a la base de datos: ' . $e->getMessage());
    http_response_code(500);
    if (APP_DEBUG) {
        echo '<pre>Error de conexión: '
            . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            . '</pre>';
    } else {
        echo 'No se pudo conectar con la base de datos.';
    }
    exit();
}
?>