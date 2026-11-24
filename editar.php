<?php
session_start();
$valorId = $_GET['id'] ?? null;
$id = $valorId === null ? null : (is_string($valorId) ? filter_var($valorId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) : false);
if ($id === false) {
    http_response_code(400);
    exit('El número de usuario no es válido. <a href="editar.php">Volver a editar</a>');
}
if (!isset($_SESSION['token_usuarios'])) {
    $_SESSION['token_usuarios'] = bin2hex(random_bytes(32));
}
$usuario = null;
$error = null;
if ($id !== null) {
    require 'conexion.php';
    try {
        $stmt = $conexion->prepare('SELECT noUsuario, nombre, apellidoP, apelllidoM AS apellidoM, correo, pais FROM usuario WHERE noUsuario = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('No se pudo cargar el usuario: ' . $e->getMessage());
        http_response_code(500);
        exit('No se pudo cargar el usuario. <a href="editar.php">Volver a editar</a>');
    }
    if ($usuario === false) {
        http_response_code(404);
        exit('El usuario no existe. <a href="editar.php">Volver a editar</a>');
    }
    $error = $_SESSION['error_editar_usuario'] ?? null;
    unset($_SESSION['error_editar_usuario']);
    if ($error !== null && $error['id'] === $id) {
        $usuario = array_merge($usuario, $error['datos']);
    } else {
        $error = null;
    }
}
function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario - Ferretería A</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-1"><img src="image/Gemini_Generated_Image_ny2ygany2ygany2y-removebg-preview.png" alt="Logo" class="logo"></div>
                <div class="col-11"><h1>Fereteria A</h1></div>
            </div>
        </div>
        <img src="image/6d629f593d9b985ba4139c0b96dd9da2.jpg" alt="Fondo de la ferretería" class="fondo_encabezado">
        <nav class="container text-center py-3" aria-label="Navegación principal">
            <a class="btn btn-sm" href="index.html">Inicio</a>
            <a class="btn btn-sm" href="contacto.html">Registrar usuario</a>
            <a class="btn btn-sm" href="leer.php">Consultar usuarios</a>
            <a class="btn btn-sm" href="editar.php">Editar usuario</a>
            <a class="btn btn-sm" href="eliminar.php">Eliminar usuario</a>
        </nav>
    </header>
    <main class="container my-4">
        <h2>Editar usuario</h2>
        <?php if (isset($_GET['estado']) && $_GET['estado'] === 'actualizado') { ?>
            <div class="alert alert-success" role="status">Usuario actualizado correctamente.</div>
        <?php } elseif (isset($_GET['estado']) && $_GET['estado'] === 'no_encontrado') { ?>
            <div class="alert alert-danger" role="alert">El usuario ya no existe.</div>
        <?php } ?>
        <form action="editar.php" method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="buscar-id" class="form-label">Número de usuario</label>
                <input class="form-control" type="number" id="buscar-id" name="id" min="1" value="<?= $id === null ? '' : escapar((string) $id) ?>" required>
            </div>
            <div class="col-12">
                <button class="btn" type="submit">Buscar usuario</button>
            </div>
        </form>
        <?php if ($error !== null) { ?>
            <div class="alert alert-danger" role="alert"><?= escapar($error['mensaje']) ?></div>
        <?php } ?>
        <?php if ($usuario !== null) { ?>
        <form action="actualizar.php" method="POST" class="row g-3">
            <input type="hidden" name="id" value="<?= escapar((string) $id) ?>">
            <input type="hidden" name="token" value="<?= escapar($_SESSION['token_usuarios']) ?>">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input class="form-control" type="text" id="nombre" name="nombre" maxlength="30" value="<?= escapar((string) $usuario['nombre']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="apellidoP" class="form-label">Apellido paterno</label>
                <input class="form-control" type="text" id="apellidoP" name="apellidoP" maxlength="30" value="<?= escapar((string) $usuario['apellidoP']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="apellidoM" class="form-label">Apellido materno</label>
                <input class="form-control" type="text" id="apellidoM" name="apellidoM" maxlength="30" value="<?= escapar((string) ($usuario['apellidoM'] ?? '')) ?>">
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input class="form-control" type="email" id="correo" name="correo" maxlength="50" value="<?= escapar((string) $usuario['correo']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="pais" class="form-label">País</label>
                <input class="form-control" type="text" id="pais" name="pais" maxlength="50" value="<?= escapar((string) $usuario['pais']) ?>" required>
            </div>
            <div class="col-12">
                <button class="btn" type="submit">Guardar cambios</button>
                <a class="btn " href="editar.php">Cancelar</a>
            </div>
        </form>
        <?php } ?>
    </main>
    <footer class="pie">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-9">
                    <h2>Sitio desarrollado por Angel Gabriel Tepetzinta Cruz Derechos reservados 2026</h2>
                    <a href="docs/politicaPrivacidad.pdf" target="_blank" rel="noopener">Política de Privacidad</a>
                    <a href="docs/avisoLegal.pdf" target="_blank" rel="noopener">Aviso Legal</a>
                </div>
                <div class="col-1"><a href="https://wa.me/1234567890" target="_blank" rel="noopener"><img src="image/cosmos_1355080033-removebg-preview.png" alt="WhatsApp" class="logos"></a></div>
                <div class="col-1"><a href="https://www.instagram.com" target="_blank" rel="noopener"><img src="image/cosmos_1522768451-removebg-preview.png" alt="Instagram" class="logos"></a></div>
                <div class="col-1"><a href="https://www.facebook.com" target="_blank" rel="noopener"><img src="image/cosmos_836917702-removebg-preview.png" alt="Facebook" class="logos"></a></div>
            </div>
        </div>
    </footer>
</body>
</html>
