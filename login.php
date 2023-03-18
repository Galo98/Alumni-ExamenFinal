<?php 
    require "clases.php"
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>Alumni</title>
    <link rel="shortcut icon" type="image/x-icon" href="alumno.ico">
</head>

<body>
    <header>
        <div class="header-div">
            <nav class="header_div-nav">
                <div class="header_div-nav-box">
                <a href="index.php" class="header_div_nav-item">Inicio</a>
                <div class="header_div-nav-box">
            </nav>
        </div>
    </header>
    <main>
        <div class="contenedorLogin">
            <form class="contenedorLogin-form" method="POST">
                <label class="contenedorLogin_form-label" for="dni">
                    Ingrese su dni
                    <input class="contenedorLogin_form_label-input" type="number" name="dni" id="dni" placeholder="00000000" maxlength="8" required>
                </label>
                <label class="contenedorLogin_form-label" for="contra">
                    Ingrese su contraseña
                    <input class="contenedorLogin_form_label-input" type="password" name="contraseña" id="contra" placeholder="***********" required>
                </label>
                <div class="contenedorLogin_form-cajaBtn">
                    <button class="btn-ok" type="submit">Acceder</button>
                </div>
            </form>
            <div class="contenedorLogin-cajaMensaje">
                <p class="contenedorLogin_cajaMensaje-Texto">
                    <?php 
                        if( isset($_POST['dni']) )
                            Usuario::VerificarUsuario($_POST['dni'],$_POST['contraseña'])
                        
                    ?>
                </p>
            </div>
        </div>
    </main>
    <footer>
        <a class="titulos blanco" href="https://github.com/Galo98"><i class="fa-brands fa-github"></i></a>
        <p class="titulos blanco">Desarrollado por Galo Olguin</p>
        <a class="titulos blanco" href="https://www.linkedin.com/in/galo-olguin/"><i class="fa-brands fa-linkedin"></i></a>
    </footer>
</body>

</html>