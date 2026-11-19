<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.html#registro');
    exit;
}

$campos = ['nombre', 'apellidoP', 'apellidoM', 'correo', 'pais'];
$usuario = [];
foreach ($campos as $campo) {
    $valor = $_POST[$campo] ?? '';
    if (!is_string($valor)) {
        header('Location: contacto.html?estado=datos#registro');
        exit;
    }
    $usuario[$campo] = trim($valor);
}

$longitudesMaximas = [
    'nombre' => 30,
    'apellidoP' => 30,
    'apellidoM' => 30,
    'correo' => 50,
    'pais' => 50,
];
foreach ($longitudesMaximas as $campo => $maximo) {
    if (mb_strlen($usuario[$campo], 'UTF-8') > $maximo) {
        header('Location: contacto.html?estado=datos#registro');
        exit;
    }
}

if (
    $usuario['nombre'] === ''
    || $usuario['apellidoP'] === ''
    || $usuario['correo'] === ''
    || $usuario['pais'] === ''
    || filter_var($usuario['correo'], FILTER_VALIDATE_EMAIL) === false
) {
    header('Location: contacto.html?estado=datos#registro');
    exit;
}

require 'conexion.php';

try {
    $sql = 'INSERT INTO usuario (nombre, apellidoP, apelllidoM, correo, pais)
            VALUES (:nombre, :apellidoP, :apellidoM, :correo, :pais)';
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':nombre' => $usuario['nombre'],
        ':apellidoP' => $usuario['apellidoP'],
        ':apellidoM' => $usuario['apellidoM'],
        ':correo' => $usuario['correo'],
        ':pais' => $usuario['pais'],
    ]);

    header('Location: leer.php?registro=exitoso');
    exit;
} catch (PDOException $e) {
    error_log('No se pudo registrar el usuario: ' . $e->getMessage());
    if (defined('APP_DEBUG') && APP_DEBUG) {
        http_response_code(500);
        echo '<!DOCTYPE html><html lang="es"><meta charset="UTF-8"><title>Error de registro</title>'
            . '<body><h1>Error al registrar usuario</h1><pre>'
            . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            . '</pre><p><a href="contacto.html">Volver al formulario</a></p></body></html>';
        exit;
    }
    header('Location: contacto.html?estado=error#registro');
    exit;
}