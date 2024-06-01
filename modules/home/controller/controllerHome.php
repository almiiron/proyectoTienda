<?php
class ControllerHome{
    public function Home(){
        $view = './modules/home/views/home.php';
        require_once ('./modules/views/layouts/main.php');
    }
}
?>