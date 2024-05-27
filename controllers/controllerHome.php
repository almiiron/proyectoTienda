<?php
class ControllerHome{
    public function Home(){
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once('./views/home.php');
        require_once ('./views/layouts/footer.php');
    }
}
?>