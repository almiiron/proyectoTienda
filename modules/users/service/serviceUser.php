<?php
require_once ('./modules/users/model/classUser.php');
class ServiceUser
{
    private $modeloUser;
    public function __construct($conexion)
    {
        $this->modeloUser = new Users($conexion);
    }
    public function procesarIniciarSesion($user, $password)
    {
        $buscarUsuario = $this->buscarUser(null, null, $user, $password);
      
        // $estado = (!$buscarUsuario) ? False : True;
        return ['success' => $buscarUsuario];
    }

    public function procesarCerrarSesion(){
        session_destroy();
        header('location: /proyectoTienda/page/iniciarSesion');
        return 0;
    }

    public function buscarUser($id, $rol, $user, $password){
        $resultado = $this->modeloUser->buscarUser($id, $rol, $user, $password);
        return $resultado;
    }

    public function cargarUser($idRol, $user, $password){
        $resultado = $this->modeloUser->cargarUser($idRol, $user, $password);
        return $resultado;
    }

    public function listarRolesUsuarios(){
        $resultado = $this->modeloUser->listarRolesUsuarios();
        return $resultado;
    }

    public function ultimoIdUser(){
        $resultado = $this->modeloUser->ultimoIdUser();
        return $resultado;
    }

    public function cambiarEstadoUser($id, $nuevoEstado){
        $resultado = $this->modeloUser->cambiarEstadoUser($id, $nuevoEstado);
        return $resultado;
    }

    public function modificarRolUser($idUsuario, $idRol){
        $resultado = $this->modeloUser->modificarRolUser($idUsuario, $idRol);
        return $resultado;
    }

    public function obtenerDatosSimpleUser($idUsuario){
        $resultado = $this->modeloUser->obtenerDatosSimpleUser($idUsuario);
        return $resultado;
    }
}
?>