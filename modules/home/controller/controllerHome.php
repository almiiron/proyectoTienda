<?php
class ControllerHome{
    public function Home(){
        require_once ('./modules/views/layouts/header.php');
        require_once ('./modules/views/layouts/navBar.php');
        require_once('./modules/home/views/home.php');
        require_once ('./modules/views/layouts/footer.php');
    }
}
?>