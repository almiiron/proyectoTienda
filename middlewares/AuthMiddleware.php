<?php
class AuthMiddleware
{
    public static function check($method)
    {
        if ($method == 'iniciarSesion' || $method == 'procesarIniciarSesion') {
            return; // No realizar la verificación si el método actual es 'login'
        }

        // Verificar si el usuario está autenticado
        // session_start();
        if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /proyectoTienda/page/iniciarSesion'); // Redirigir a la página de login si no está autenticado
            exit();
        }
    }
}
?>
