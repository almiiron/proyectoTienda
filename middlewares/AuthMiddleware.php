<?php
class AuthMiddleware
{
    public static function check($method)
    {
        // Permitir el acceso a las pantallas de inicio de sesión
        if ($method == 'iniciarSesion' || $method == 'procesarIniciarSesion') {
            // Si el usuario ya está autenticado, redirigir a la página de inicio
            if (!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                header('Location: /proyectoTienda/page/home');
                exit();
            }
            return; // Permitir el acceso a la pantalla de inicio de sesión
        }

        // Verificar si el usuario está autenticado
        if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /proyectoTienda/page/iniciarSesion'); // Redirigir a la página de inicio de sesión si no está autenticado
            exit();
        }
    }
}

?>
