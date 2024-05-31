<?php
class Users
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarUser($id, $rol, $user, $password)
    {
        $query = "SELECT * FROM usuarios WHERE ";
        if (!empty($id) && !empty($user) && !empty($password)) {
            $query .= "id_usuario = '$id' AND nombre_usuario = '$user' AND password = '$password';";
            //si no esta vacio los tres campos
        } else if (!empty($id) && !empty($user)) {
            $query .= "id_usuario = '$id' AND nombre_usuario = '$user';";
            //para buscar si existe un usuario especifico
        } else if (!empty($user) && !empty($password)) {
            $query .= "nombre_usuario = '$user' AND password = '$password';";
            //para buscar si existe un usuario con password, usado para el login 
        } else if (!empty($user)) {
            $query .= "nombre_usuario = '$user';";
            //para buscar si ya existe el nombre de usuario
        }else if(!empty($id) && !empty($rol)){
            $query.= "id_usuario = '$id' AND id_rol_usuario = '$rol';";
        }
        $resultado = $this->conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            $estado = True;
        } else {
            $estado = False;
        }
        return $estado;
    }

    public function cargarUser($idRol, $user, $password)
    {
        $query = "INSERT INTO usuarios (id_rol_usuario, nombre_usuario, password, estado) 
        VALUES ('$idRol','$user','$password','Activo')";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function listarRolesUsuarios()
    {
        $query = "SELECT id_rol_usuario, rol, estado FROM roles_usuarios";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $rolesUsuarios = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $rolesUsuarios[] = $row; // Agrega el resultado al array
        }
        return $rolesUsuarios;
    }

    public function ultimoIdUser()
    {
        $query = "SELECT MAX(id_usuario) as id_usuario FROM usuarios";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_usuario
        $id_usuario = $fila['id_usuario'];    // Devolver el valor de id_usuario
        return $id_usuario;
    }

    public function cambiarEstadoUser($id, $nuevoEstado)
    {
        $query = "UPDATE usuarios SET estado='$nuevoEstado' WHERE id_usuario = '$id';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $resultado = ($sql) ? True : False;
        return $resultado;
    }

    
    public function modificarRolUser($idUsuario, $idRol)
    {
        $query = "UPDATE usuarios SET id_rol_usuario='$idRol' WHERE id_usuario = '$idUsuario';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $resultado = ($sql) ? True : False;
        return $resultado;
    }

    public function obtenerDatosSimpleUser($idUsuario)
    {
        $query = "SELECT * FROM usuarios WHERE id_usuario = '$idUsuario';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $user = $resultado->fetch_assoc();      // Extraer el valor de id_usuario
        return $user;
    }
}
?>