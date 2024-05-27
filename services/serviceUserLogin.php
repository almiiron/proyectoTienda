<?php
require_once ('./models/classUserLogin.php');
class ServiceUserLogin
{
    private $modeloUserLogin;
    public function __construct($conexion)
    {
        $this->modeloUserLogin = new userLogin($conexion);
    }
    public function procesarIniciarSesion($user, $password)
    {
        $buscarUsuario = $this->modeloUserLogin->buscarUser(null, $user, $password);
      
        // $estado = (!$buscarUsuario) ? False : True;
        return ['success' => $buscarUsuario];
    }

    public function procesarCerrarSesion(){
        session_destroy();
        header('location: /proyectoTienda/page/iniciarSesion');
        return 0;
    }
}
?>