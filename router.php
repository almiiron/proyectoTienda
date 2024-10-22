<?php
require_once (__DIR__ . '/middlewares/AuthMiddleware.php');
class Router
{
    private $controller;
    private $method;
    private $conexion;
    private $numPage;

    public function __construct($conexion, $numPage)
    {
        $this->conexion = $conexion;
        $this->numPage = $numPage;
        $this->matchRoute();
    }
    public function matchRoute()
    {
        $url = explode('/', URL);
        $this->controller = !empty($url[1]) ? 'page' : 'Page';
        $this->method = !empty($url[2]) ? $url[2] : 'home';
        // $this->numPage = !empty($url[3]) ? $url[3] : 'numPage';
        // echo $this->numPage;

        $this->controller = 'controller' . $this->controller;
        require_once (__DIR__ . '/modules/page/controller/' . $this->controller . '.php');

    }
    public function run()
    {
        AuthMiddleware::check($this->method);
        $controller = new $this->controller($this->conexion, NUM_PAGE); // Pasar NUM_PAGE al constructor del controlador
        $method = $this->method;

        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            $view = null;
            require_once './modules/views/layouts/main.php'; // si en la url hay algo que no corresponde a una vista del sistema, muestra error 404 pagina no encontrada
            // header("Location:home");
        }
    }
}
?>