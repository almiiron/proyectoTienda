<?php
// echo $mensaje;
if ($estadoConsulta) {
    ?>
    <div class="alerta" style="background-color: rgba(0, 138, 253, 0.227);">
        <img src="/proyectoTienda/views/layouts/img/icons8-comprobado-260.png" alt="">
        <p class="mensaje-alerta" style="color:blue;"><?php echo $mensaje; ?></p>
        <div class="buttons-alerta">
            <a href="/proyectoTienda/page/mostrarCargarCategoria">
                <button type="button">Volver</button>
            </a>
            <a href="/proyectoTienda/page/home">
                <button type="button">Inicio</button>
            </a>
        </div>
        <?php
} else {
    ?>
        <div class="alerta" style=" background-color: rgba(255, 0, 0, 0.227);">
            <img src="/proyectoTienda/views/layouts/img/icons8-error-100.png" alt="">
            <p class="mensaje-alerta" style="color:red;"><?php echo $mensaje; ?></p>
            <div class="buttons-alerta">
                <a href="/proyectoTienda/page/mostrarCargarCategoria">
                    <button type="button">Volver</button>
                </a>
                <a href="/proyectoTienda/page/home">
                    <button type="button">Inicio</button>
                </a>
            </div>
        </div>

    </div>
    <?php
}
?>
</div>