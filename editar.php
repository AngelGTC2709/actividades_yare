<?php
include 'conexion.php';

$id = $_GET['id']; // Recibimos el ID desde la URL

$sql = "SELECT * FROM usuario WHERE noUsuario = :id";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// FETCH (sin "All") porque solo buscamos a una persona
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <nav class="container text-center py-3">
            <a class="btn btn-sm" href="index.html">Inicio</a>
            <a class="btn btn-sm" href="contacto.html">Registrar usuario</a>
            <a class="btn btn-sm" href="leer.php">Consultar usuarios</a>
        </nav>
    </header>

    <main class="container my-4">
        <h2>Editar usuario</h2>
        <!-- Formulario pre-llenado -->
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['noUsuario']; ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>

            <label>Apellido Paterno:</label>
            <input type="text" name="apellidoP" value="<?php echo $usuario['apellidoP']; ?>" required>

            <label>Apellido Materno:</label>
            <input type="text" name="apellidoM" value="<?php echo $usuario['apelllidoM']; ?>">

            <label>Correo:</label>
            <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required>

            <label>País:</label>
            <input type="text" name="pais" value="<?php echo $usuario['pais']; ?>" required>

            <button type="submit">Guardar cambios</button>
        </form>
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
</body>
</html>
