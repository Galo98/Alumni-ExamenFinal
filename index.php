<?php 

    session_start();
    
    (isset($_GET['close']) && $_GET['close'] === 'true') ? session_destroy() : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
                    </div>
                    <div class="header_div-nav-box">
                        <a href="login.php" class="header_div_nav-item">Ingresar</a>
                    </div>
                </nav>
            </div>
    </header>
    <main>
        <section class="presentacion">
            <p>Sistema de gestion de alumnos para el final de Algoritmos y estructura de datos 2 I.S.F.D y T N° 24 DR. Bernardo Houssay | Bernal.</p>
            <p>CONSIGNA:</p>
            <p>- Crear un sistema para una institución educativa que me permita ver, cargar y modificar las notas de los alumnos, y me permita cargar la nota final solamente cuando el alumno tenga los dos parciales aprobados. </p>
            <p>- Debe tener altas bajas y modificaciones de alumnos, ademas de las notas..</p> 
            <p>- Puede haber una o más materias (plus si tengo ABM materias).</p> 
            <p>- Usuario profesor (ABM notas) y administrador (ABM alumnos, materias)</p> 
            <p>- Pueden usar POO o programación estructurada, lo que les resulte más cómodo.</p>
            <p class="titulos">Ingreso al sistema Usuario: 1234 Contraseña: 1234</p>
        </section>
    </main>
    <footer>
        <a class="titulos blanco" href="https://github.com/Galo98"><i class="fa-brands fa-github"></i></a>
        <p class="titulos blanco">Desarrollado por Galo Olguin</p>
        <a class="titulos blanco" href="https://www.linkedin.com/in/galo-olguin/"><i class="fa-brands fa-linkedin"></i></a>
    </footer>
</body>

</html>