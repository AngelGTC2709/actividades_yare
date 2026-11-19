<?php
if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: GET, POST');
    exit('Método no permitido.');
}
session_start();
if (!isset($_SESSION['token_usuarios'])) {
    $_SESSION['token_usuarios'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? null;
    if (!is_string($token) || !hash_equals($_SESSION['token_usuarios'], $token)) {
        http_response_code(403);
        exit('La sesión del formulario no es válida o ha caducado. Regresa a eliminar e inténtalo de nuevo.');
    }
    $valorId = $_POST['id'] ?? null;
    $id = is_string($valorId) ? filter_var($valorId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) : false;
    if ($id === false) {
        http_response_code(400);
        exit('El número de usuario no es válido. <a href="eliminar.php">Volver a eliminar</a>');
    }
    require 'conexion.php';
    try {
        $stmt = $conexion->prepare('DELETE FROM usuario WHERE noUsuario = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $estado = $stmt->rowCount() === 0 ? 'no_encontrado' : 'eliminado';
    } catch (PDOException $e) {
        error_log('No se pudo eliminar el usuario: ' . $e->getMessage());
        $estado = (string) $e->getCode() === '23000' ? 'relacionado' : 'error';
    }
    header('Location: eliminar.php?estado=' . $estado, true, 303);
    exit;
}

$valorId = $_GET['id'] ?? null;
$id = $valorId === null ? null : (is_string($valorId) ? filter_var($valorId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) : false);
if ($id === false) {
    http_response_code(400);
    exit('El número de usuario no es válido. <a href="eliminar.php">Volver a eliminar</a>');
}
$avisos = [
    'eliminado' => ['success', 'Usuario eliminado correctamente.'],
    'no_encontrado' => ['danger', 'El usuario no existe.'],
    'relacionado' => ['danger', 'No se pudo eliminar: el usuario tiene registros relacionados.'],
    'error' => ['danger', 'No se pudo eliminar el usuario. Inténtalo de nuevo más tarde.'],
];
$estado = $_GET['estado'] ?? '';
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
    <title>Eliminar usuario - Ferretería A</title>
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
            <a class="btn btn-light btn-sm" href="index.html">Inicio</a>
            <a class="btn btn-light btn-sm" href="contacto.html">Registrar usuario</a>
            <a class="btn btn-light btn-sm" href="leer.php">Consultar usuarios</a>
            <a class="btn btn-light btn-sm" href="editar.php">Editar usuario</a>
            <a class="btn btn-light btn-sm" href="eliminar.php">Eliminar usuario</a>
        </nav>
    </header>
    <main class="container my-4">
        <h2>Eliminar usuario</h2>
        <?php if (is_string($estado) && isset($avisos[$estado])) { ?>
            <div class="alert alert-<?= $avisos[$estado][0] ?>" role="status"><?= escapar($avisos[$estado][1]) ?></div>
        <?php } ?>
        <p>Introduce el número del usuario que deseas eliminar. Esta acción no se puede deshacer.</p>
        <form action="eliminar.php" method="POST" class="row g-3" onsubmit="return confirm('¿Eliminar este usuario?');">
            <input type="hidden" name="token" value="<?= escapar($_SESSION['token_usuarios']) ?>">
            <div class="col-md-6">
                <label for="id" class="form-label">Número de usuario</label>
                <input class="form-control" type="number" id="id" name="id" min="1" value="<?= $id === null ? '' : escapar((string) $id) ?>" required>
            </div>
            <div class="col-12">
                <button class="btn btn-danger" type="submit">Eliminar usuario</button>
                <a class="btn btn-outline-primary" href="leer.php">Consultar usuarios</a>
            </div>
        </form>
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
