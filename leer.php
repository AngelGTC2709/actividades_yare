<?php
include 'conexion.php';

try {
    $sql = "SELECT noUsuario, nombre, apellidoP, apelllidoM, correo, pais
            FROM usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();


    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['xml'])) {

        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $raiz = $xml->createElement('usuarios');
        $xml->appendChild($raiz);

        foreach ($usuarios as $usuario) {
            $nodoUsuario = $xml->createElement('usuario');
            $raiz->appendChild($nodoUsuario);

            foreach ($usuario as $campo => $valor) {
                $nodoCampo = $xml->createElement($campo);
                $nodoCampo->appendChild(
                    $xml->createTextNode((string) $valor)
                );
                $nodoUsuario->appendChild($nodoCampo);
            }
        }

        header('Content-Type: application/xml; charset=UTF-8');
        header('Content-Disposition: attachment; filename="usuarios.xml"');
        echo $xml->saveXML();
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error al consultar la base de datos.";
    exit;
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
<>
    <header>
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-1"><img src="image/Gemini_Generated_Image_ny2ygany2ygany2y-removebg-preview.png" alt="Logo" class="logo"></div>
                <div class="col-11"><h1>Fereteria A</h1></div>
            </div>
        </div>
        <img src="image/6d629f593d9b985ba4139c0b96dd9da2.jpg" alt="Fondo de la ferretería" class="fondo_encabezado">
        <nav class="container text-center py-3">
            <a class="btn btn-sm" href="index.html">Inicio</a>
            <a class="btn btn-sm" href="contacto.html">Registrar usuario</a>
            <a class="btn btn-sm" href="leer.php">Consultar usuarios</a>
        </nav>
    </header>

    <main class="container my-4">
        <h2>Usuarios registrados</h2>
        <table border="1">
            <tr>
                <th>ID</th> <th>Nombre Completo</th> <th>Correo</th> <th>Acciones</th>
            </tr>
            <?php foreach ($usuarios as $user) { ?>
                <tr>
                    <td><?php echo $user['noUsuario']; ?></td>
                    <td><?php echo $user['nombre'] . ' ' . $user['apellidoP']; ?></td>
                    <td><?php echo $user['correo']; ?></td>
                    <td>
                        <!-- Enlaces para Editar y Eliminar -->
                        <a href="editar.php?id=<?php echo $user['noUsuario']; ?>">Editar</a>
                        <a href="eliminar.php?id=<?php echo $user['noUsuario']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>

    <footer class="pie">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-9">
                    <h2>Sitio desarrollado por Angel Gabriel Tepetzinta Cruz Derechos reservados 2026</h2>
                    <a href="docs/politicaPrivacidad.pdf" target="_blank">Política de Privacidad</a>
                    <a href="docs/avisoLegal.pdf" target="_blank">Aviso Legal</a>
                </div>
                <div class="col-1"><a href="https://wa.me/1234567890" target="_blank"><img src="image/cosmos_1355080033-removebg-preview.png" alt="WhatsApp" class="logos"></a></div>
                <div class="col-1"><a href="https://www.instagram.com" target="_blank"><img src="image/cosmos_1522768451-removebg-preview.png" alt="Instagram" class="logos"></a></div>
                <div class="col-1"><a href="https://www.facebook.com" target="_blank"><img src="image/cosmos_836917702-removebg-preview.png" alt="Facebook" class="logos"></a></div>
            </div>
        </div>
    </footer>
    <script>
        window.onload = function () {
            const enlace = document.createElement('a');
            enlace.href = 'leer.php?xml=1';
            enlace.download = 'usuarios.xml';
            enlace.click();
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>