<?php
require_once ('./modules/views/layouts/header.php');
require_once ('./modules/views/layouts/navBar.php');

?>

<!-- del loader mientras carga la pagina -->
<div class="overlay d-flex justify-content-center align-items-center">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
</div>


<!-- aca muestro todo mi contenido -->
<div class="col py-3 content custom-bg-light w-100" style="height:101%;">

    <!-- aca muestro los tabs de navegacion -->
    <div id="tabs" class="w-100" style="background-color: transparent; border:none;">
        <ul class="pb-1 rounded custom-bg-white">

            <li>
                <button class="btn custom-bg-primary rounded-1" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" onclick="redireccionar('noAction')">
                    <!-- <i class="fs-4 bi bi-funnel-fill text-white"></i> -->
                    <i class="fs-4 bi bi-list text-white"></i>
                </button>
            </li>

            <li>
                <button class="btn btn-success rounded-1" onclick="redireccionar('home')">
                    <i class="fs-4 bi-house"></i>
                </button>
            </li>

        </ul>
    </div>

    <!-- incluyo el buscador -->
    <?php
    require_once ('./modules/views/layouts/buscador.php');
    ?>
    <br>

    <!-- si es que existe la variable vista, la incluyo -->
    <?php
    if (isset($view)) {
        require_once ($view);
    }
    ?>
</div>
<?php
require_once ('./modules/views/layouts/footer.php');

?>