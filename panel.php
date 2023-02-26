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
                                <a href="#Carreras" class="header_div_nav-item">Carreras</a>
                                <a href="#Materias" class="header_div_nav-item">Materias</a>
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
    <main class="Panel">
        <?php 
        switch($_SESSION['rol']){
            case 1: // admin?>
                <section id="Usuarios" class="divUsuarios">
                    <div class="divUsuarios-cabecera">
                        <p class="titulos" >Administracion de usuarios</p>
                        <a href="panel.php?pan=1&acc=3" class="btn-ok ancora">Agregar nuevo usuario</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>MATERIA</th>
                    <th>PROFESOR</th>
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
                        Usuario::listarUsuarios();
                    ?>
                    </tbody>
                    </table>
                </section>
                <section id="Carreras" class="divCarreras">
                    <div class="divCarreras-cabecera">
                        <p class="titulos" >Administracion de carreras</p>
                        <a href="panel.php?pan=1&acc=7" class="btn-ok ancora">Agregar nueva carrera</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>CARRERA</th>
                    <th>DÍAS</th>
                    <th>TURNO</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Carrera::listarCarreras();
                    ?>
                    </tbody>
                    </table>
                </section>
                <section id="Materias" class="divMaterias">
                    <div class="divMaterias-cabecera">
                        <p class="titulos" >Administracion de materias</p>
                        <a href="panel.php?pan=1&acc=4" class="btn-ok ancora">Agregar nueva materia</a>
                    </div>
                    <table class="lista">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>MATERIA</th>
                    <th>PROFESOR</th>
                    <th>CARRERA</th>
                    <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        Materia::listarMaterias();
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
                        case 1: ?> // panel modificar usuario
                            <div class="cajaSpot_cierre-modificar"> <?php
                                $id = $_GET['id'];
                                Usuario::formModificarUsuario($id); ?>
                            </div> <?php
                        break;
                        case 2: ?> // panel eliminar usuario
                            <div class="cajaSpot_cierre-eliminar"> <?php
                                $id = $_GET['id'];
                                $con = condb();
                                $info = mysqli_query($con, " select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id) where usuarios.id = $id;");
                                $data = mysqli_fetch_assoc($info); ?>
                                <p>Esta a punto de <b class="bold red">ELIMINAR</b> de forma <b class="bold red">PERMANENTE</b> al siguiente usuario.</p>
                                    <div class="cajaSpot_cierre_eliminar-info">
                                        <div class="cajaSpot_cierre_eliminar_info-usuario">
                                            <p><b class="bold">Nombre: </b><?php echo $data['nombre'];?></p>
                                            <p><b class="bold">Apellido: </b><?php echo $data['apellido'];?></p>
                                            <p><b class="bold">DNI: </b><?php echo $data['dni'];?></p>
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
                        break; 
                        case 3: ?> // panel crear usuario
                            <div class="cajaSpot_cierre-crearUsuario">
                                <p>Agregar nuevo usuario</p>
                                <form class="formPanel" method="POST" action="panel.php">
                                    <div class="formPanel-inputs">
                                        <label for="nombre">NOMBRE<input type="text" class="inputPanel" name="nombre" id="nombre"></label>
                                        <label for="apellido">APELLIDO<input type="text" class="inputPanel" name="apellido" id="apellido"></label>
                                        <label for="dni">DNI<input type="text" class="inputPanel medio" name="dni" id="dni"></label>
                                        <label for="rol">ROL
                                            <select class="inputPanel" name="rol" id="rol">
                                                    <option value="3">Alumno</option>
                                                    <option value="2">Profesor</option>
                                                    <option value="1">Administrador</option>
                                            </select>
                                        </label>
                                        <label for="contraseña">CONTRASEÑA<input type="text" class="inputPanel" name="contraseña" id="contraseña"></label>
                                        <label for="email">EMAIL<input type="text" class="inputPanel" name="email" id="email"></label>
                                        <label for="estado">ESTADO
                                            <select class="inputPanel" name="estado" id="estado">
                                                <option value="1">Activo</option>
                                                <option value="2">Inactivo</option>
                                                <option value="3">Suspendido</option>
                                            </select>
                                        </label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="3" required> Agregar usuario</label>
                                        <input type="hidden" name="pan" value="1"> 
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="panel.php" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php break;
                        case 4:  // panel crear materia
                            $info = Usuario::buscarRol(2);
                            $info2 = Carrera::buscarCarreras();
                        ?>
                            <div class="cajaSpot-cierre-crearMateria">
                                <p>Agregar nueva materia</p>
                                <form class="formPanel" method="POST" action="panel.php">
                                    <div class="formPanel-inputs">
                                        <label for="materia">MATERIA<input type="text" class="inputPanel" name="materia" id="materia" required></label>
                                        <label for="profesor" required>PROFESOR
                                            <select class="inputPanel" name="profesor" id="profesor">
                                                <?php 
                                                    while($data = mysqli_fetch_assoc($info)){ ?>
                                                    <option value="<?php echo $data['id'];?>"><?php echo $data['nombre'] ." " .$data['apellido'] ." DNI: " .$data['dni'];?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </label>
                                        <label for="carrera" required>CARRERA
                                            <select class="inputPanel" name="carrera" id="carrera" required>
                                                <?php 
                                                    while($data2 = mysqli_fetch_assoc($info2)){ ?>
                                                    <option value="<?php echo $data2['id'];?>"><?php echo $data2['nombreCarrera']?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="4" required> Agregar nueva materia</label>
                                        <input type="hidden" name="pan" value="1"> 
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="panel.php" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php break;
                        case 5: // panel modificar materia
                        break;
                        case 6: // panel eliminar materia
                        break;
                        case 7: // panel crear carrera
                        ?>
                        <div class="cajaSpot-cierre-crearCarrera">
                                <p>Agregar nueva carrera</p>
                                <form class="formPanel" method="POST" action="panel.php">
                                    <div class="formPanel-inputs">
                                        <label for="carrera">CARRERA<input type="text" class="inputPanel" name="carrera" id="carrera" required></label>
                                        <label for="dias">DÍAS<input type="text" class="inputPanel" name="dias" id="dias" placeholder="Lunes a Viernes - Lunes ,Miercoles ,Viernes" required></label>
                                        <label for="turno">TURNO<input type="text" class="inputPanel" name="turno" id="turno" placeholder="Mañana ,Tarde ,Vespertino" required></label>
                                    </div >
                                    <div>
                                        <label for="agregar"><input type="checkbox" name="confirmar" id="agregar" value="7" required> Agregar nueva carrera</label>
                                        <input type="hidden" name="pan" value="1"> 
                                        <button type="submit" class="btn-ok">Agregar</button>
                                        <a href="panel.php" class="btn-no ancora">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        <?php 
                        break;
                        case 8: // panel modificar carrera
                        break;
                        case 9: //panel eliminar carrera
                        break;
                    }
                }
                if(isset($_POST['confirmar'])){ ?>
                <div class="cajaSpot_cierre-notif"><?php
                        switch($_POST['confirmar']){
                            case 1: // modificar usuario
                                $mods = new Usuario($_POST['id'],$_POST['nombre'],$_POST['apellido'],$_POST['rol'],$_POST['contraseña'],$_POST['email'],$_POST['dni'],$_POST['estado'],);
                                $texto = $mods->modificarUsuario();
                                echo $texto;
                                echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 2: // eliminar usuario
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
                            case 3: // agregar usuario
                                $nuevoUsuario = new Usuario(null,$_POST['nombre'],$_POST['apellido'],$_POST['rol'],$_POST['contraseña'],$_POST['email'],$_POST['dni'],$_POST['estado']);
                                $dni = $_POST['dni'];
                                $email = $_POST['email'];
                                $con = condb();

                                //verificacion de informacion con base de datos
                                mysqli_query($con,"select * from usuarios where dni = $dni;");
                                if(mysqli_affected_rows($con) == 0){
                                        mysqli_query($con,"select * from usuarios where email = '$email';");
                                        if(mysqli_affected_rows($con) == 0){
                                            $texto = $nuevoUsuario->crearUsuario();
                                            echo $texto;
                                            echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                                        }else{
                                            echo "<b class='bold red'>¡Error al crear usuario!<b > El <b class='bold red'>EMAIL<b > ya esta en el sistema";
                                            echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                                        }
                                }else{
                                    echo "<b class='bold red'>¡Error al crear usuario!<b > El <b class='bold red'>DNI<b > ya esta en el sistema";
                                    echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                                }
                            break;
                            case 4: // agregar materia
                                $materia = new Materia(null,$_POST['materia'],$_POST['profesor'],$_POST['carrera']);
                                $texto = $materia-> crearMateria();
                                echo $texto;
                                echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 5: // modificar materia
                            break;
                            case 6: // eliminar materia
                            break;
                            case 7: // agregar carrera
                                $carrera = new Carrera(null,$_POST['carrera'],$_POST['dias'],$_POST['turno']);
                                $texto = $carrera -> crearCarrera();
                                echo $texto;
                                echo " <a href='panel.php' class='btn-ok ancora'>Cerrar</a>";
                            break;
                            case 8: // modificar materia
                            break;
                            case 9: // eliminar materia
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