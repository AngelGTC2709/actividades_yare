<?php
require 'conexion.php';

$errorConsulta = false;
try {
    $stmt = $conexion->prepare(
        'SELECT noUsuario, nombre, apellidoP, apelllidoM AS apellidoM, correo, pais
         FROM usuario
         ORDER BY noUsuario DESC'
    );
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('No se pudo consultar la lista de usuarios: ' . $e->getMessage());
    if (defined('APP_DEBUG') && APP_DEBUG) {
        http_response_code(500);
        echo '<!DOCTYPE html><html lang="es"><meta charset="UTF-8"><title>Error de consulta</title>'
            . '<body><h1>Error al consultar usuarios</h1><pre>'
            . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            . '</pre><p><a href="contacto.html">Volver al registro</a></p></body></html>';
        exit;
    }
    http_response_code(500);
    $errorConsulta = true;
    $usuarios = [];
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
    <title>Consultar usuarios - Ferretería A</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-1">
                    <img src="image/Gemini_Generated_Image_ny2ygany2ygany2y-removebg-preview.png" alt="Logo" class="logo">
                </div>
                <div class="col-11">
                    <h1>Fereteria A</h1>
                </div>
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
        <h2>Usuarios registrados</h2>
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso') { ?>
            <div class="alert alert-success" role="status">Usuario registrado correctamente.</div>
        <?php } ?>
        <?php
        $avisos = [
            'actualizado' => ['success', 'Usuario actualizado correctamente.'],
            'eliminado' => ['success', 'Usuario eliminado correctamente.'],
            'no_encontrado' => ['danger', 'El usuario ya no existe.'],
            'relacionado' => ['danger', 'No se pudo eliminar: el usuario tiene registros relacionados.'],
            'error' => ['danger', 'No se pudo completar la operación. Inténtalo de nuevo más tarde.'],
        ];
        $estado = $_GET['estado'] ?? '';
        if (is_string($estado) && isset($avisos[$estado])) {
        ?>
            <div class="alert alert-<?= $avisos[$estado][0] ?>" role="status"><?= escapar($avisos[$estado][1]) ?></div>
        <?php } ?>
        <?php if ($errorConsulta) { ?>
            <div class="alert alert-danger" role="alert">No se pudo cargar la lista de usuarios. Inténtalo de nuevo más tarde.</div>
        <?php } elseif ($usuarios === []) { ?>
            <p>Aún no hay usuarios registrados.</p>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col">No. usuario</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido paterno</th>
                            <th scope="col">Apellido materno</th>
                            <th scope="col">Correo</th>
                            <th scope="col">País</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr>
                                <td><?= escapar((string) $usuario['noUsuario']) ?></td>
                                <td><?= escapar((string) $usuario['nombre']) ?></td>
                                <td><?= escapar((string) $usuario['apellidoP']) ?></td>
                                <td><?= escapar((string) ($usuario['apellidoM'] ?? '')) ?></td>
                                <td><?= escapar((string) $usuario['correo']) ?></td>
                                <td><?= escapar((string) $usuario['pais']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <a href="contacto.html" class="btn btn-primary">Registrar usuario</a>
    </main>

    <footer class="pie">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-9">
                    <h2>Sitio desarrollado por Angel Gabriel Tepetzinta Cruz Derechos reservados 2026</h2>
                    <a href="docs/politicaPrivacidad.pdf" target="_blank" rel="noopener">Política de Privacidad</a>
                    <a href="docs/avisoLegal.pdf" target="_blank" rel="noopener">Aviso Legal</a>
                </div>
                <div class="col-1">
                    <a href="https://wa.me/1234567890" target="_blank" rel="noopener">
                        <img src="image/cosmos_1355080033-removebg-preview.png" alt="WhatsApp" class="logos">
                    </a>
                </div>
                <div class="col-1">
                    <a href="https://www.instagram.com" target="_blank" rel="noopener">
                        <img src="image/cosmos_1522768451-removebg-preview.png" alt="Instagram" class="logos">
                    </a>
                </div>
                <div class="col-1">
                    <a href="https://www.facebook.com" target="_blank" rel="noopener">
                        <img src="image/cosmos_836917702-removebg-preview.png" alt="Facebook" class="logos">
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>