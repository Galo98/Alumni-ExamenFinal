<?php 

function condb (){
        $serv="localhost";
        $usr="root";
        $pss="";
        $bd="alumni";
        $c=mysqli_connect($serv, $usr, $pss, $bd);
        return $c;
}

class Usuario {

#region atributos
    private $id;
    private $nombre;
    private $apellido;
    private $usuario;
    private $rol; // 1 para administrador 2 para profesor 3 para alumno
    private $contraseña;
    private $email;
    private $dni;
    private $estado; // 1 activo 2 inactivo 3 suspendido
#endregion

#region constructor
    public function __construct($id,$nombre,$apellido,$usuario,$rol,$contraseña,$email,$dni,$estado){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->usuario = $usuario;
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
            'usuario' => $this->usuario,
            'rol' => $this-> rol,
            'contraseña' => $this->contraseña,
            'email' => $this->email,
            'dni' => $this->dni,
            'estado' => $this->estado
        );
        return $data;
    }

    public function getAllByNumber(){
        $data = array($this->id,$this->nombre,$this->apellido,$this->usuario,$this-> rol,$this->contraseña,$this->email,$this->dni,$this->estado);
        return $data;
    }
#endregion

#region sets
    public function setAll($id, $nombre, $apellido, $usuario, $rol, $contraseña, $email, $dni, $estado){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->usuario = $usuario;
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

        mysqli_query($con,"insert into usuarios (nombre,apellido,usuario,rol,contraseña,email,dni,estado) values ('$this->nombre','$this->apellido','$this->usuario',$this->rol,'$this->contraseña','$this->email',$this->dni,$this->estado);");

        (mysqli_affected_rows($con) >= 0) ? $text = "Usuario nuevo generado" : $text =" No se pudo generar un nuevo usuario";

        return $text;
    }
#endregion

#region modificarUsuario
    public function modificarUsuario(){
        $con = condb();
        $texto = "";

        mysqli_query($con,"update usuarios set nombre = '$this->nombre', apellido = '$this->apellido', usuario ='$this->usuario' , rol = '$this->rol', contraseña = '$this->contraseña', email = '$this->email', dni = $this->dni , idEstado = $this->estado where id = $this->id;");

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
                    $info = mysqli_query($con,"select * from usuarios where dni = '$dni' ");
                    $info = mysqli_fetch_assoc($info);
                    session_start();
                    $_SESSION['nombre'] = $info['nombre'];
                    $_SESSION['apellido'] = $info['apellido'];
                    $_SESSION['usuario'] = $info['usuario'];
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

#region buscarUsuarios
    public static function buscarUsuarios(){
        $con = condb();

        $data = mysqli_query($con,"select usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.usuario, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from usuarios inner join roles on usuarios.rol = roles.id inner join estados on usuarios.idEstado = estados.id;");
        
        while ($info = mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?php echo $info['id']; ?></td>
                <td><?php echo $info['usuario']; ?></td>
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
                <label for="id">ID<input type="text" class="inputPanel corto" name="id" id="id" readonly value="<?php echo $info['id']; ?>"></label>
                <label for="nombre">NOMBRE<input type="text" class="inputPanel" name="nombre" id="nombre" value="<?php echo $info['nombre']; ?>"></label>
                <label for="apellido">APELLIDO<input type="text" class="inputPanel" name="apellido" id="apellido" value="<?php echo $info['apellido']; ?>"></label>
                <label for="usuario">USUARIO<input type="text" class="inputPanel" name="usuario" id="usuario" value="<?php echo $info['usuario']; ?>"></label>
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
                <label for="email">EMAIL<input type="text" class="inputPanel" name="email" id="email" value="<?php echo $info['email']; ?>"></label>
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
                <a href="panel.php" class="btn-no ancora">Cancelar</a>
            </div>
        </form>

    <?php }

    #endregion

}


?>