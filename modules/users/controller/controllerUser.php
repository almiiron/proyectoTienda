<?php
require_once ('./modules/users/service/serviceUser.php');
class ControllerUser
{
    private $serviceLogin;
    public function __construct($conexion)
    {
        $this->serviceLogin = new ServiceUser($conexion);
    }
    public function iniciarSesion()
    {
        require_once ('./modules/views/layouts/header.php');
        require_once ('./modules/users/views/iniciarSesion.php');
        require_once ('./modules/views/layouts/footer.php');
    }

    public function procesarIniciarSesion($user, $password)
    {
        $resultado = $this->serviceLogin->procesarIniciarSesion($user, $password);
        if ($resultado['success']) {
            // session_start();
            $_SESSION['user'] = $user; // Almacena el usuario en la sesión
            $_SESSION['logged_in'] = true; // Marca como iniciado sesión
            $_SESSION['show_notifications'] = true;
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