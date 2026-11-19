<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Método no permitido.');
}
session_start();
$token = $_POST['token'] ?? null;
if (!is_string($token) || !isset($_SESSION['token_usuarios']) || !hash_equals($_SESSION['token_usuarios'], $token)) {
    http_response_code(403);
    exit('La sesión del formulario no es válida o ha caducado. Regresa a la lista e inténtalo de nuevo.');
}
$valorId = $_POST['id'] ?? null;
$id = is_string($valorId) ? filter_var($valorId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) : false;
if ($id === false) {
    http_response_code(400);
    exit('El número de usuario no es válido.');
}

$limites = ['nombre' => 30, 'apellidoP' => 30, 'apellidoM' => 30, 'correo' => 50, 'pais' => 50];
$usuario = [];
$valido = true;
foreach ($limites as $campo => $limite) {
    $valor = $_POST[$campo] ?? '';
    if (!is_string($valor) || !mb_check_encoding($valor, 'UTF-8')) {
        $valido = false;
        $valor = '';
    }
    $usuario[$campo] = trim($valor);
    if (mb_strlen($usuario[$campo], 'UTF-8') > $limite) {
        $valido = false;
    }
}
if ($usuario['nombre'] === '' || $usuario['apellidoP'] === '' || $usuario['pais'] === ''
    || filter_var($usuario['correo'], FILTER_VALIDATE_EMAIL) === false) {
    $valido = false;
}
if (!$valido) {
    $_SESSION['error_editar_usuario'] = ['id' => $id, 'datos' => $usuario, 'mensaje' => 'Revisa los campos obligatorios, el correo y la longitud de los datos.'];
    header('Location: editar.php?id=' . $id, true, 303);
    exit;
}
require 'conexion.php';
try {
    $stmt = $conexion->prepare('UPDATE usuario SET nombre = :nombre, apellidoP = :apellidoP, apelllidoM = :apellidoM, correo = :correo, pais = :pais WHERE noUsuario = :id');
    foreach ($usuario as $campo => $valor) {
        $stmt->bindValue(':' . $campo, $valor, PDO::PARAM_STR);
    }
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() === 0) {
        $consulta = $conexion->prepare('SELECT noUsuario FROM usuario WHERE noUsuario = :id');
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        if ($consulta->fetch(PDO::FETCH_ASSOC) === false) {
            header('Location: editar.php?estado=no_encontrado', true, 303);
            exit;
        }
    }
    header('Location: editar.php?id=' . $id . '&estado=actualizado', true, 303);
} catch (PDOException $e) {
    error_log('No se pudo actualizar el usuario: ' . $e->getMessage());
    $_SESSION['error_editar_usuario'] = ['id' => $id, 'datos' => $usuario, 'mensaje' => 'No se pudieron guardar los cambios. Inténtalo de nuevo más tarde.'];
    header('Location: editar.php?id=' . $id, true, 303);
}
exit;
