<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <script>
        function enviar() {
            alert("Gracias por tu mensaje.");
        }
    </script>
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
        <img src="image/6d629f593d9b985ba4139c0b96dd9da2.jpg" alt="fondo" class="fondo_encabezado">
    </header>

    <form id="formularioContacto" action="https://formsubmit.co/gaancruz19@gmail.com" method="POST"  class="container text-center" ">
        <div class="row">
            <div class="col-12">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" >
            </div>
            <div class="col-12">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" name="pais" >
            </div>
            <div class="col-12">
                <label for="mail" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="mail" name="mail" >
            </div>
            <div class="col-12">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" ></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" onclick="enviar()">Enviar</button>
            </div>
        </div>
    </form>


    <footer class="pie">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col-9" >
                    <h2>Sitio desarrollado por Angel Gabriel Tepetzinta Cruz Derechos reservados 2026</h2>
                    <a href="docs/politicaPrivacidad.pdf" target="_blank">Política de Privacidad</a>
                    <a href="docs/avisoLegal.pdf" target="_blank">Aviso Legal</a>
                </div>
                <div class="col-1">
                    <a href="https://wa.me/1234567890" target="_blank">
                        <img src="image/cosmos_1355080033-removebg-preview.png" alt="whatsapp" class="logos">
                    </a>
                </div>
                <div class="col-1">
                    <a href="https://www.instagram.com" target="_blank">
                        <img src="image/cosmos_1522768451-removebg-preview.png" alt="instagram" class="logos">
                    </a>
                </div>
                <div class="col-1">
                    <a href="https://www.facebook.com" target="_blank">
                        <img src="image/cosmos_836917702-removebg-preview.png" alt="facebook" class="logos">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>