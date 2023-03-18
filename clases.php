<?php 

function condb (){
        $serv="localhost";
        $usr="root";
        $pss="";
        $bd="alumni";
        $c=mysqli_connect($serv, $usr, $pss, $bd);
        return $c;
}

#region clase Usuario
class Usuario {

#region atributos
    private $id;
    private $nombre;
    private $apellido;
    private $rol; // 1 para administrador 2 para profesor 3 para alumno
    private $contraseña;
    private $email;
    private $dni;
    private $estado; // 1 activo 2 inactivo 3 suspendido
#endregion

#region constructor
    public function __construct($id,$nombre,$apellido,$rol,$contraseña,$email,$dni,$estado){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->rol = $rol;
        $this->contraseña = $contraseña;
        $this->email = $email;
        $this->dni = $dni;
        $this->estado = $estado;
    }
#endregion

#region gets
    public function getAllByName(){
        $data = array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'rol' => $this-> rol,
            'contraseña' => $this->contraseña,
            'email' => $this->email,
            'dni' => $this->dni,
            'estado' => $this->estado
        );
        return $data;
    }

    public function getAllByNumber(){
        $data = array($this->id,$this->nombre,$this->apellido,$this-> rol,$this->contraseña,$this->email,$this->dni,$this->estado);
        return $data;
    }
#endregion

#region sets
    public function setAll($id, $nombre, $apellido, $rol, $contraseña, $email, $dni, $estado){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->rol = $rol;
        $this->contraseña = $contraseña;
        $this->email = $email;
        $this->dni = $dni;
        $this->estado = $estado;
    }
#endregion

#region crearUsuario
    public function crearUsuario(){
        $con = condb();
        $text = "";

        mysqli_query($con,"insert into usuarios (nombre,apellido,rol,contraseña,email,dni,idEstado) values ('$this->nombre','$this->apellido',$this->rol,'$this->contraseña','$this->email',$this->dni,$this->estado);");

        (mysqli_affected_rows($con) > 0) ? $text = "Nuevo usuario agregado al sistema" : $text =" No se pudo generar un nuevo usuario";

        return $text;
    }
#endregion

#region modificarUsuario
    public function modificarUsuario(){
        $con = condb();
        $texto = "";

        mysqli_query($con,"update usuarios set nombre = '$this->nombre', apellido = '$this->apellido' , rol = '$this->rol', contraseña = '$this->contraseña', email = '$this->email', dni = $this->dni , idEstado = $this->estado where id = $this->id;");

        (mysqli_affected_rows($con) > 0) ? $texto = 'Usuario modificado correctamente' : $texto = 'No se pudo modificar al usuario correctamente';

        return $texto;
    }
#endregion

#region eliminarUsuario
    public static function eliminarUsuario($id){
        $con = condb();
        $text = "" ;

        mysqli_query($con,"delete from usuarios where id = $id");

        (mysqli_affected_rows($con) > 0) ? $text = 'Usuario eliminado permanentemente' : $text = 'No se pudo eliminar al usuario correctamente';

        return $text;
    }
#endregion

#region VerificarUsuario
    public static function VerificarUsuario($dni,$contraseña){
        $con = condb();
        
        if ($dni != "" && $contraseña != ""){
            $usu = mysqli_query($con , "select dni from usuarios where dni = $dni");
            if(mysqli_affected_rows($con)>0){
                $contra = mysqli_query($con, " select contraseña from usuarios where dni = $dni");
                $contra = mysqli_fetch_assoc($contra);
                if($contra['contraseña'] === $contraseña){
                    $data = mysqli_query($con,"select * from usuarios where dni = '$dni' ");
                    $info = mysqli_fetch_assoc($data);
                    session_start();
                    $_SESSION['id'] = $info['id'];
                    $_SESSION['nombre'] = $info['nombre'];
                    $_SESSION['apellido'] = $info['apellido'];
                    $_SESSION['rol'] = $info['rol'];
                    $_SESSION['email'] = $info['email'];
                    $_SESSION['dni'] = $dni;
                    $_SESSION['estado'] = $info['estado'];
                    header("location: panel.php");
                }else{
                    echo "Contraseña invalida";
                }
            }else{
                echo "DNI invalido";
            }
        }
    }
#endregion

#region buscarUsuario
    public static function buscarRol($rol){
        $con = condb();
        
        $data = mysqli_query($con, "select * from usuarios where rol = $rol;");

        return $data;
    }
#endregion

#region listarUsuarios
    public static function listarUsuarios(){
        $con = condb();

        $data = mysqli_query($con,"select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from usuarios inner join roles on usuarios.rol = roles.id inner join estados on usuarios.idEstado = estados.id order by id;");
        
        while ($info = mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?php echo $info['id']; ?></td>
                <td><?php echo $info['nombre']; ?></td>
                <td><?php echo $info['apellido']; ?></td>
                <td><?php echo $info['dni']; ?></td>
                <td><?php echo $info['email']; ?></td>
                <td><?php echo $info['contraseña']; ?></td>
                <td><?php echo $info['nombreRol']; ?></td>
                <td><?php echo $info['nombreEstado']; ?></td>
                <td>
                    <p class="acciones">
                        <a class="modificar" href="panel.php?pan=1 & acc=1 & id=<?php echo $info['id']; ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a class="eliminar" href="panel.php?pan=1 & acc=2 & id=<?php echo $info['id']; ?>">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </p>
                </td>
            </tr>
<?php   }
    }
#endregion

#region formModificarUsuario
    public static function formModificarUsuario($id){
        $con = condb();

        $data = mysqli_query($con,"select * from usuarios where id = $id;");

        $info = mysqli_fetch_assoc($data);

        ?>

        <form class="formPanel" method="POST" action="panel.php">
            <div class="formPanel-inputs">
                <label for="id">ID<input type="text" class="inputPanel corto" name="id"  id="id" readonly value="<?php echo $info['id']; ?>"></label>
                <label for="nombre">NOMBRE<input type="text" class="inputPanel" name="nombre" onkeyup="this.value = this.value.toUpperCase();" id="nombre" value="<?php echo $info['nombre']; ?>"></label>
                <label for="apellido">APELLIDO<input type="text" class="inputPanel" name="apellido" onkeyup="this.value = this.value.toUpperCase();" id="apellido" value="<?php echo $info['apellido']; ?>"></label>
                <label for="rol">ROL
                    <select class="inputPanel" name="rol" id="rol">
                        <?php switch($info['rol']){
                            case 1: ?>
                            <option value="1">Administrador</option>
                            <option value="2">Profesor</option>
                            <option value="3">Alumno</option>
                                <?php break;
                            case 2: ?>
                            <option value="2">Profesor</option>
                            <option value="1">Administrador</option>
                            <option value="3">Alumno</option>
                            <?php break;
                            case 3: ?>
                            <option value="3">Alumno</option>
                            <option value="1">Administrador</option>
                            <option value="2">Profesor</option>
                            <?php break;
                        }?>
                        
                    </select>
                </label>
                <label for="contraseña">CONTRASEÑA<input type="text" class="inputPanel" name="contraseña" id="contraseña" value="<?php echo $info['contraseña']; ?>"></label>
                <label for="email">EMAIL<input type="text" class="inputPanel" name="email" onkeyup="this.value = this.value.toUpperCase();" id="email" value="<?php echo $info['email']; ?>"></label>
                <label for="dni">DNI<input type="text" class="inputPanel medio" name="dni" id="dni" value="<?php echo $info['dni']; ?>"></label>
                <label for="estado">ESTADO
                    <select class="inputPanel" name="estado" id="estado"><?php
                    switch($info['idEstado']){
                        case 1: ?>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        <option value="3">Suspendido</option>
                            <?php break;
                        case 2: ?>
                        <option value="2">Inactivo</option>
                        <option value="1">Activo</option>
                        <option value="3">Suspendido</option>
                        <?php break;
                        case 3: ?>
                        <option value="3">Suspendido</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        <?php break;
                        }?>
                    </select>
                </label>
            </div >
            <div>
                <label for="confirmar_cambios"><input type="checkbox" name="confirmar" id="confirmar_cambios" value="1" required> Confirmar cambios</label>
                <input type="hidden" name="pan" value="1"> 
                <button type="submit" class="btn-ok">Modificar</button>
                <a href="panel.php#Usuarios" class="btn-no ancora">Cancelar</a>
            </div>
        </form>

    <?php }

    #endregion

}
#endregion

#region clase Materia
class Materia{

    #region atributos
    private $id;
    private $materia;
    private $profesor;
    private $carrera;
    #endregion

    #region constructor
    public function __construct($id,$materia,$profesor,$carrera){
        $this->id = $id;
        $this->materia = $materia;
        $this->profesor = $profesor;
        $this->carrera = $carrera;
    }
    #endregion

    #region crearMateria
    public function crearMateria(){
        $con = condb();
        $text = "";

        mysqli_query($con, "insert into materias (materia,profesor,carrera) values ('$this->materia', $this->profesor, $this->carrera)");

        (mysqli_affected_rows($con) > 0) ? $text = "Nueva materia agregada al sistema" : $text =" No se pudo generar una nueva materia";

        return $text;
    }
    #endregion

    #region modificarMateria
    public function modificarMateria(){
        $con = condb();
        $texto = "";
        mysqli_query($con, "update materias set materia = '$this->materia', profesor = $this->profesor, carrera = $this->carrera where id = $this->id");

        (mysqli_affected_rows($con) > 0) ? $texto = "Materia modificada correctamente" : $texto = "No se pudo modificar la materia";

        return $texto;
    }
    #endregion

    #region eliminarMateria
    public static function eliminarMateria($id){
        $con = condb();
        $text = "";

        mysqli_query($con, "delete from materias where id = $id;");

        (mysqli_affected_rows($con) > 0) ? $text = "Materia eliminada correctamente" : $text = "No se pudo eliminar la materia";

        return $text;
    }
    #endregion

    #region listarMaterias
    public static function listarMaterias(){
        $con = condb();

        $data = mysqli_query($con,"select materias.id, materias.materia, usuarios.nombre, usuarios.apellido, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id);");
        
        if(mysqli_affected_rows($con) == 0){
            echo "<tr><td><b class='bold red'>No hay materias registradas en el sistema</b></td></tr>";
        }else{
            while ($info = mysqli_fetch_assoc($data)){ ?>
                <tr>
                    <td><?php echo $info['id']; ?></td>
                    <td><?php echo $info['materia']; ?></td>
                    <td><?php echo $info['nombre'] ." " .$info['apellido']; ?></td>
                    <td><?php echo $info['nombreCarrera']; ?></td>
                    <td>
                        <p class="acciones">
                            <a class="modificar" href="panel.php?pan=1 & acc=5 & id=<?php echo $info['id']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="eliminar" href="panel.php?pan=1 & acc=6 & id=<?php echo $info['id']; ?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </p>
                    </td>
                </tr>
            <?php   }
        }
    }
    #endregion

    #region buscarMateria
    public static function buscarMateria($id){
        $con = condb();
        
        $info = mysqli_query($con, "select materias.id, materias.materia, materias.profesor, materias.carrera, usuarios.nombre, usuarios.apellido, usuarios.dni, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id) where materias.id = $id;");

        $data = mysqli_fetch_assoc($info);

        return $data;
    }
    #endregion

}
#endregion

#region clase Carrera
class Carrera{

    #region atributos
    private $id;
    private $carrera;
    private $dias;
    private $turno;
    #endregion

    #region constructor
    public function __construct($id,$carrera,$dias,$turno){
        $this->id = $id;
        $this->carrera = $carrera;
        $this->dias = $dias;
        $this->turno = $turno;
    }
    #endregion

    #region setAll
    public function setAll($carrera,$dias,$turno){
        $this->carrera = $carrera;
        $this->dias = $dias;
        $this->turno = $turno;
    }
    #endregion

    #region getAll
    public function getAll(){
        $data = array(
            'id' => $this->id,
            'carrera' => $this->carrera,
            'dias' => $this->dias,
            'turno' => $this->turno
        );

        return $data;
    }
    #endregion
    
    #region crearCarrera
    public function crearCarrera(){
        $con = condb();
        $text = "";

        mysqli_query($con, "insert into carreras (nombreCarrera,diasCursada,turno) values ('$this->carrera','$this->dias','$this->turno');");

        (mysqli_affected_rows($con) > 0) ? $text = "Nueva carrera agregada al sistema" : $text = "No se pudo agregar una nueva carrera al sistema";

        return $text;
    }
    #endregion

    #region modificarCarrera
    public function modificarCarrera(){
        $con = condb();
        $text = "";

        mysqli_query($con, "update carreras set nombreCarrera = '$this->carrera', diasCursada = '$this->dias', turno = '$this->turno' where id = $this->id;");
        
        (mysqli_affected_rows($con) > 0) ? $text = "Carrera modificada correctamente" : $text = "No se pudo modificar la carrera";

        return $text;
    }
    #endregion

    #region eliminarCarrera
    public static function eliminarCarrera($id){
        $con = condb();
        $text = "" ;

        mysqli_query($con,"delete from carreras where id = $id");

        (mysqli_affected_rows($con) > 0) ? $text = "Carrera Eliminada permanentemente" : $text = "No se pudo eliminar la carrera. Por favor corrobore que esta carrera no tenga materias asignadas.";  

        return $text;
    }
    #endregion

    #region listarCarreras
    public static function listarCarreras(){
        $con = condb();

        $data = mysqli_query($con,"select * from carreras;");
        
        if(mysqli_affected_rows($con) == 0){
            echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></tr></td>";
        }else{
            while ($info = mysqli_fetch_assoc($data)){ ?>
                <tr>
                    <td><?php echo $info['id']; ?></td>
                    <td><?php echo $info['nombreCarrera']; ?></td>
                    <td><?php echo $info['diasCursada']; ?></td>
                    <td><?php echo $info['turno']; ?></td>
                    <td>
                        <p class="acciones">
                            <a class="modificar" href="panel.php?pan=1 & acc=8 & id=<?php echo $info['id']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="eliminar" href="panel.php?pan=1 & acc=9 & id=<?php echo $info['id']; ?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </p>
                    </td>
                </tr>
            <?php   }
        }
    }
    #endregion

    #region buscarCarreras
    public static function buscarCarreras(){
        $con = condb();

        $data = mysqli_query($con, "select * from carreras;");

        return $data;
    }
    #endregion

    #region buscarCarrera
    public static function buscarCarrera($id){
        $con = condb();

        $data = mysqli_query($con, "select * from carreras where id = $id");

        return $data;
    }
    #endregion

}
#endregion

#region clase Notas
class Notas{

    #region atributos
    private $usuario;
    private $carrera;
    private $nota = "null";
    private $parcial1;
    private $parcial2;
    private $final;
    #endregion

    #region constructor
    public function __construct($usu,$car){
        $this->usuario = $usu;
        $this->carrera = $car;
    }
    #endregion

    #region setNotas
    public function setNotas($p1,$p2,$f){
        $this->parcial1 = $p1;
        $this->parcial2 = $p2;
        $this->final = $f;
    }
    #endregion

    #region crearNota
    public function asignarCarrera(){
        $con = condb();
        $text = "";
        $a = mysqli_fetch_assoc(mysqli_query($con,"select count(id) from materias where carrera = $this->carrera;"));
        $totalMaterias = $a['count(id)'];
        $contador = 0;
        $agregar = array();

        $materias = mysqli_query($con,"select id from materias where carrera = $this->carrera");

        while($cargar = mysqli_fetch_assoc($materias)){
            if($contador == $totalMaterias - 1){
                $dato = "(" .$this->usuario ."," .$cargar['id'] ."," .$this->nota ."," .$this->nota ."," .$this->nota .")";
                array_push($agregar,$dato);
            }else {
                $dato = "(" .$this->usuario ."," .$cargar['id'] ."," .$this->nota ."," .$this->nota ."," .$this->nota ."),";
                array_push($agregar,$dato);
            }
            $contador ++;
        }

        $valores = implode($agregar);

        mysqli_query($con,"insert into notas (idUsuario,idMateria,notaParcial1,notaParcial2,notaFinal) values $valores");

        (mysqli_affected_rows($con) >0) ? $text = "Carrera asignada correctamente" : $text = "No se pudo asignar la carrera correctamente";

        return $text;
    }
    #endregion

    #region listarNotas
    public static function listarNotas(){
        $con = condb();


        $data = mysqli_query($con,"select notas.idUsuario,notas.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,notas.notaParcial1,notas.notaParcial2,notas.notaFinal from (((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera );");

        if(mysqli_affected_rows($con) == 0){
            echo "<tr><td><b class='bold red'>No hay asignaturas registradas en el sistema</b></tr></td>";
        }else{
            while ($info = mysqli_fetch_assoc($data)){ 
                $nombre = $info['nombre'] ." " .$info['apellido'];?>
                <tr>
                    <td><?php echo $nombre ?></td>
                    <td><?php echo $info['materia']; ?></td>
                    <td><?php echo $info['nombreCarrera']; ?></td>
                    <td><?php echo $info['notaParcial1']?></td>
                    <td><?php echo $info['notaParcial2']?></td>
                    <td><?php echo $info['notaFinal']?></td>
                    <td>
                        <p class="acciones">
                            <a class="eliminar" href="panel.php?pan=1 & acc=11 & idU=<?php echo $info['idUsuario']; ?> & alumno=<?php echo $nombre ?> & carrera=<?php echo $info['nombreCarrera']; ?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </p>
                    </td>
                </tr>
            <?php   }
        }
    }
    #endregion

    #region eliminarNotas
    public function eliminarNotas(){
        $con = condb();
        $text = "";

        mysqli_query($con,"delete from notas where idUsuario = $this->usuario");

        (mysqli_affected_rows($con) >0) ? $text = "Asignatura eliminada correctamente." : $text = "No se pudo eliminar la asignatura correctamente.";

        return $text;
    }
    #endregion

    #region listarNotasEditables
    public static function listarNotasEditables($id){
        $con = condb();

        $data = mysqli_query($con,"select notas.idUsuario,notas.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,notas.notaParcial1,notas.notaParcial2,notas.notaFinal from (((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera) where materias.profesor = $id;");

        

        if(mysqli_affected_rows($con) == 0){
            echo "<tr><td><b class='bold red'>No hay carreras registradas en el sistema</b></tr></td>";
        }else{
            while ($info = mysqli_fetch_assoc($data)){ 
                $nombre = $info['nombre'] ." " .$info['apellido']?>
                <tr>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $info['nombreCarrera']; ?></td>
                    <td><?php echo $info['materia']; ?></td>
                    <td><?php echo $info['notaParcial1']; ?></td>
                    <td><?php echo $info['notaParcial2']; ?></td>
                    <td><?php echo $info['notaFinal']; ?></td>
                    <td>
                        <p class="acciones">
                            <a class="modificar" href="panel.php?pan=1 & acc=12 & alumno=<?php echo $info['idUsuario']; ?> & idmateria=<?php echo $info['idMateria']; ?> & nombre=<?php echo $nombre; ?> & materia=<?php echo $info['materia'] ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </p>
                    </td>
                </tr>
            <?php   }
        }
    }
    #endregion

    #region modificarNotas
    public function modificarNotas(){
        $con = condb();
        $text = "";

        mysqli_query($con,"update notas set notaParcial1 = $this->parcial1, notaParcial2 = $this->parcial2 , notaFinal = $this->final where idUsuario = $this->usuario and idMateria = $this->carrera;");

        (mysqli_affected_rows($con) >0) ? $text = "Nota/s modificadas correctamente" : $text = "No se pudo modificar las notas correctamente";

        return $text;
    }
    #endregion

}
#endregion

?>