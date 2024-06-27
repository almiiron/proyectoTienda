<div class="container">

    <div class="row justify-content-between mb-5">

        <div class="col-12 col-lg-5 col-md-5 rounded shadow-sm mb-2 text-center"
            style="background-color: #2ecc71; color: #fff;">

            <div class="d-flex align-items-center justify-content-center">

                <div class="w-50 my-3">
                    <div class="fw-bold float-start w-100 ps-1 ms-3" style="font-size:1rem">
                        <?php echo $ingresosHoy['titulo']; ?>
                    </div>
                    <br>
                    <div class=" float-start w-100 ps-1 ms-3 my-1" style="font-size:1rem">
                        $&nbsp;
                        <?php echo $ingresosHoy['dato']; ?>
                    </div>
                </div>
                <div class="w-50 my-3 text-center">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <i class="bi bi-cash-coin w-25 opacity-50" style="font-size:3rem;"></i>
                </div>

            </div>

        </div>

        <div class="col-12 col-lg-5 col-md-5 rounded shadow-sm mb-2 text-center"
            style="background-color: #3498db; color: #fff; ">

            <div class="d-flex align-items-center justify-content-center">

                <div class="w-50 my-3">

                    <div class="fw-bold float-start w-100 ps-1 ms-3" style="font-size:1rem;">
                        <?php echo $cantidadProductosVendidosHoy['titulo']; ?>
                    </div>
                    <br>
                    <div class=" float-start w-100 ps-1 ms-3 my-1 d-flex justify-content-center align-items-center"
                        style="font-size:1rem">
                        <?php echo $cantidadProductosVendidosHoy['dato']; ?>
                    </div>
                </div>

                <div class="w-50 my-3 text-center">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <i class="bi bi-arrow-up-right opacity-50" style="font-size:3rem;"></i>
                </div>

            </div>

        </div>
        <div class="col-12 col-lg-5 col-md-5 rounded shadow-sm mb-2 text-center"
            style="background-color: #FF7B5F; color: #fff; ">

            <div class="d-flex align-items-center justify-content-center">

                <div class="w-50 my-3">

                    <div class="fw-bold float-start w-100 ps-1 ms-3" style="font-size:1rem">
                        <?php echo $cantidadClientesHoy['titulo']; ?>
                    </div>
                    <br>
                    <div class=" float-start w-100 ps-1 ms-3 my-1 d-flex justify-content-center align-items-center"
                        style="font-size:1rem">
                        <?php echo $cantidadClientesHoy['dato']; ?>
                    </div>
                </div>

                <div class="w-50 my-3 text-center">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <i class="bi bi-people opacity-50" style="font-size:3rem;"></i>
                </div>

            </div>
        </div>

        <div class="col-12 col-lg-5 col-md-5 rounded shadow-sm mb-2 text-center"
            style="background-color: #9b59b6; color: #fff; ">
            <div class="d-flex align-items-center justify-content-center">

                <div class="w-50 my-3">

                    <div class="fw-bold float-start w-100 ps-1 ms-3" style="font-size:1rem;">
                        <?php echo $promedioVentasHoy['titulo']; ?>
                    </div>
                    <br>
                    <div class=" float-start w-100 ps-1 ms-3 my-1 d-flex justify-content-center align-items-center"
                        style="font-size:1rem">
                        $&nbsp;
                        <?php echo $promedioVentasHoy['dato']; ?>
                    </div>
                </div>

                <div class="w-50 my-3 text-center">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <i class="bi bi-bar-chart-line opacity-50" style="font-size:3rem;"></i>
                </div>

            </div>

        </div>

    </div>




    <div class="row justify-content-between mb-5">
        <div class="col-12 col-lg-7 col-md-7 custom-bg-white rounded shadow-sm mb-1">

            <div id="div-productos-mas-vendidos-chart" class="d-flex justify-content-center align-items-center">
                <!-- <button id="generar-pdf" class="boton-imprimir"
                    onclick="imprimirEstadistica('productos-mas-vendidos-chart')">Imprimir o Generar PDF</button> -->
                <canvas id="productos-mas-vendidos-chart" style=" " class="p-3"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-md-4 custom-bg-white rounded shadow-sm mb-1">
            <div id="div-categorias-con-mas-ventas-chart" class="d-flex justify-content-center align-items-center">
                <!-- <button id="generar-pdf" class="boton-imprimir"
                    onclick="imprimirEstadistica('productos-mas-vendidos-chart')">Imprimir o Generar PDF</button> -->
                <!-- <br> -->
                <canvas id="categorias-con-mas-ventas-chart" style=" " class="p-3"></canvas>
            </div>
        </div>
    </div>

    <div class="row justify-content-between mb-5">

        <div class="col-12 col-lg-12 custom-bg-white rounded shadow-sm mb-1">

            <div class="d-flex justify-content-center align-items-center">

                <div id="div-total-ventas-cada-mes-del-año-chart" class="chart-container"
                    style="  height: 80vh; width: 80vw;">
                    <canvas id="total-ventas-cada-mes-del-año-chart" style=""></canvas>
                </div>

            </div>

        </div>

    </div>

    <div class="row justify-content-between mb-5">

        <div class="col-12 col-lg-5 col-md-5 custom-bg-white rounded shadow-sm mb-1">

            <div id="div-ingresos-ultimos-siete-dias-chart" class="chart-container" style="  ">
                <canvas id="ingresos-ultimos-siete-dias-chart" style=""></canvas>
            </div>

        </div>

        <div class="col-12 col-lg-5 col-md-5 custom-bg-white rounded shadow-sm mb-1">
            <div id="div-ingresos-ultimas-cuatro-semanas-chart" class="chart-container" style="  ">
                <canvas id="ingresos-ultimas-cuatro-semanas-chart" style=""></canvas>
            </div>
        </div>

    </div>

    <div class="row justify-content-between mb-5">
        <div class="col-12 col-lg-4 col-md-4 custom-bg-white rounded shadow-sm mb-1">
            4 columnas en pantallas grandes y medianas, y ancho completo en pantallas pequeñas
        </div>
        <div class="col-12 col-lg-7 col-md-7 custom-bg-white rounded shadow-sm mb-1">
            7 columnas en pantallas grandes y medianas, y ancho completo en pantallas pequeñas
        </div>
    </div>

</div>