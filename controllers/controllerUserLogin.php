<?php
require_once ('./services/serviceUserLogin.php');
class ControllerUserLogin
{
    private $serviceLogin;
    public function __construct($conexion)
    {
        $this->serviceLogin = new ServiceUserLogin($conexion);
    }
    public function iniciarSesion()
    {
        require_once ('./views/layouts/header.php');
        require_once ('./views/login/iniciarSesion.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarIniciarSesion($user, $password)
    {
        $resultado = $this->serviceLogin->procesarIniciarSesion($user, $password);
        if ($resultado['success']) {
            // session_start();
            $_SESSION['user'] = $user; // Almacena el usuario en la sesión
            $_SESSION['logged_in'] = true; // Marca como iniciado sesión
        }

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function procesarCerrarSesion(){
        $resultado = $this->serviceLogin->procesarCerrarSesion();
        return $resultado;
    }
}
?>