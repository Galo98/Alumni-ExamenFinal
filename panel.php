<?php 
    require "clases.php";

    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['estado'] === '0'){
        die("No tenes credenciales para ingresar a este sitio. Intenta <a href='index.php'> registrate</a>.");
    }


    

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/panel.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>Alumni</title>
</head>

<body>
    <header>
            <div class="header-div">
                <nav class="header_div-nav">
                    <a href="panel.php" class="header_div_nav-item">Home</a>
                    <?php 
                        switch($_SESSION['rol']){
                            case 1: // admin?>
                                <a href="#Usuarios" class="header_div_nav-item">Usuarios</a>
                                <a href="#" class="header_div_nav-item">Materias</a>
                            <?php
                                break;
                            case 2: // profe ?>
                                <a href="#" class="header_div_nav-item">Notas</a>
                            <?php
                                break;
                            case 3: //alumno ?>
                                <a href="#" class="header_div_nav-item">Notas</a>
                            <?php
                                break;
                        }
                    ?>
                    <a href="index.php?close=true" class="header_div_nav-item">Log Out</a>
                </nav>
            </div>
    </header>
    <main>
        <?php 
        switch($_SESSION['rol']){
            case 1: // admin?>
                <section id="Usuarios" class="divUsuarios">
                    <p class="titulos" >Administracion de usuarios</p>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>USUARIO</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>DNI</th>
                    <th>EMAIL</th>
                    <th>CONTRASEÑA</th>
                    <th>ROL</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Usuario::buscarUsuarios();
                    ?>
                    </tbody>
                    </table>
                </section>
            <?php
                break;
            case 2: // profe ?>

            <?php
                break;
            case 3: //alumno ?>

            <?php
                break;
        }
        if(isset($_GET['pan']) && $_GET['pan'] == '1' || isset($_POST['pan']) && $_POST['pan'] == '1'){
        ?>
        <section class="cajaSpot">
            <a class="cajaSpot-cierre" href="panel.php"></a>
                <?php if(isset($_GET['acc'])){
                    switch($_GET['acc']){
                        case 1: ?>
                            <div class="cajaSpot_cierre-modificar"> <?php
                                $id = $_GET['id'];
                                Usuario::formModificarUsuario($id); ?>
                            </div> <?php
                        break;
                        case 2: ?>
                            <div class="cajaSpot_cierre-eliminar"> <?php
                                $id = $_GET['id'];
                                $con = condb();
                                $info = mysqli_query($con, " select usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.usuario, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id) where usuarios.id = $id;");
                                $data = mysqli_fetch_assoc($info); ?>
                                <p>Esta a punto de <b class="bold red">ELIMINAR</b> de forma <b class="bold red">PERMANENTE</b> al siguiente usuario.</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                            <p><b class="bold">Nombre: </b><?php echo $data['nombre'];?></p>
                                            <p><b class="bold">Apellido: </b><?php echo $data['apellido'];?></p>
                                            <p><b class="bold">DNI: </b><?php echo $data['dni'];?></p>
                                            <p><b class="bold">Usuario: </b><?php echo $data['usuario'];?></p>
                                            <p><b class="bold">Email: </b><?php echo $data['email'];?></p>
                                            <p><b class="bold">Rol: </b><?php echo $data['nombreRol'];?></p>
                                            <p><b class="bold">Estado: </b><?php echo $data['nombreEstado'];?></p>
                                        </div>
                                        <div class="cajaSpot_cierre_eliminar_info-mensaje">
                                            <p>¿Está seguro que desea eliminar de forma permanente a <b class="bold"><?php echo $data['nombre']?></b> ?</p>
                                            <p>Tenga en cuenta que puede cancelar el acceso al usuario cambiando el estado del usuario por <b class="bold red">suspendido</b> o <b class="bold red">inactivo</b>.</p>
                                        </div>
                                    </div>
                                    <form class="cajaSpot_cierre_eliminar_info-opciones" method="POST" action="panel.php">
                                        <label for="confirmar">
                                            <input type="checkbox" name="confirmar" id="confirmar" value="2" required>
                                            Deseo eliminar a <b class="bold"><?php echo $data['nombre']?></b> de todas formas.
                                        </label>
                                        <input type="hidden" name="pan" value="1"> 
                                        <input type="hidden" name="id" value ="<?php echo $data['id'] ?>">
                                        <div>
                                            <button type="submit" class="btn-no">Eliminar Permanentemente</button>
                                            <a href="panel.php" class="btn-ok ancora">Cancelar</a>
                                        </div>
                                    </form>
                            </div><?php 
                        break; } ?>
                <?php }
                if(isset($_POST['confirmar'])){ ?>
                <div class="cajaSpot_cierre-notif"><?php
                        switch($_POST['confirmar']){
                            case 1: // modificar
                                $mods = new Usuario($_POST['id'],$_POST['nombre'],$_POST['apellido'],$_POST['usuario'],$_POST['rol'],$_POST['contraseña'],$_POST['email'],$_POST['dni'],$_POST['estado'],);
                                $texto = $mods->modificarUsuario();
                                echo $texto;
                                echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 2: // eliminar
                                $id = $_POST['id'];
                                if($id == "1"){
                                    echo "<b class='bold red'>¡¡ATENCIÓN!!</b> No se puede eliminar a este usuario del sistema";
                                    echo "<a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                                }else{
                                    $texto = Usuario::eliminarUsuario($id);
                                    echo $texto;
                                    echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                                }
                            break;
                        }?>
                </div>
                <?php } ?>
        </section>
        <?php } ?>
    </main>
    <footer>

    </footer>
</body>

</html>

<?php 

?>