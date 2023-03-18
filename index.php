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
    
    </main>
    <footer>

    </footer>
</body>

</html>