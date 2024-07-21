<!-- Modal -->


<div class="container my-4">
    <div class="row justify-content-center">
        <div class="containerForm col-md-6 col-sm-12">
            <h5 class="modal-title text-center">Modificar gasto</h5>

            <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarModificarGasto" method="post"
                class="form ajax-form">
                <div class="modal-body">

                    <div class="form-group mb-4">
                        <label for="categoriaGastoModificar" class="col-6"> Categoria del gasto</label>
                        <select class="form-control col-6 w-50" id="categoriaGastoModificar"
                            name="categoriaGastoModificar" required>
                            <option value="" disabled selected>Selecciona una categoria...</option>
                            <?php foreach ($listarCategoriasGastos as $categoriaGasto):
                                if ($categoriaGasto['id_categoria_gasto'] == $listarUnGasto['id_categoria_gasto']) {
                                    ?>
                                    <option value="<?php echo $categoriaGasto['id_categoria_gasto']; ?>" selected>
                                        <?php echo $categoriaGasto['nombre_categoria_gasto']; ?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?php echo $categoriaGasto['id_categoria_gasto']; ?>">
                                        <?php echo $categoriaGasto['nombre_categoria_gasto']; ?>
                                    </option>
                                    <?php
                                }
                            endforeach; ?>
                        </select>

                    </div>

                    <div class="form-group mb-4">
                        <label for="descripcionGastoModificar">Descripción del gasto</label>
                        <input type="text" class="form-control" id="descripcionGastoModificar"
                            name="descripcionGastoModificar" placeholder="Descripción del gasto..." required
                            oncopy="return false" onpaste="return false" onkeypress="return validaambos(event)"
                            value="<?php echo $listarUnGasto['descripcion']; ?>">
                    </div>

                    <hr class="border-top border-dark">

                    <div class="form-group mb-4">
                        <label for="empleadoGastoModificar" class="col-6">Empleado</label>
                        <select class="form-control col-6 w-50" id="empleadoGastoModificar"
                            name="empleadoGastoModificar" required>
                            <option value="" disabled selected>Selecciona un empleado...</option>
                            <?php foreach ($listaEmpleados as $empleado):
                                if ($empleado['id_empleado'] == $listarUnGasto['id_empleado']) { ?>
                                    <option value="<?php echo $empleado['id_empleado']; ?>" selected>
                                        <?php echo $empleado['nombre'];
                                        echo ' ';
                                        echo $empleado['apellido']; ?>
                                    </option>
                                    <?php
                                } else { ?>
                                    <option value="<?php echo $empleado['id_empleado']; ?>">
                                        <?php echo $empleado['nombre'];
                                        echo ' ';
                                        echo $empleado['apellido']; ?>
                                    </option>
                                <?php }endforeach; ?>
                        </select>
                    </div>

                    <hr class="border-top border-dark">

                    <div class="form-group mb-4">
                        <label for="metodoPagoGastoModificar" class="col-6">Metodo de pago</label>
                        <select class="form-control col-6 w-50" id="metodoPagoGastoModificar"
                            name="metodoPagoGastoModificar" required>
                            <option value="" disabled selected> Seleccione metodo pago...</option>
                            <?php foreach ($listaMetodosPagos as $metodoPago):
                                if ($metodoPago['id_medio_pago'] == $listarUnGasto['id_metodo_pago']) { ?>
                                    <option value="<?php echo $metodoPago['id_medio_pago']; ?>" selected>
                                        <?php
                                        echo $metodoPago['descripcion'];
                                        ?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?php echo $metodoPago['id_medio_pago']; ?>">
                                        <?php
                                        echo $metodoPago['descripcion'];
                                        ?>
                                    </option>
                                <?php }endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="precioTotalGastoModificar">Precio total del gasto</label>
                        <input type="text" class="form-control " id="precioTotalGastoModificar"
                            name="precioTotalGastoModificar" placeholder="Precio total del gasto..." required
                            oncopy="return false" onpaste="return false" onkeypress="return solonumeros(event)"
                            value="<?php echo $listarUnGasto['precio_total']; ?>">
                    </div>

                    <hr class="border-top border-dark">
                    <div class="form-group mb-4">
                        <label for="date">Fecha</label>
                        <br>
                        <div class="d-flex justify-content-between align-items-center">

                            <input type="date" id="date" name="date" class="p-1" required
                                value="<?php echo $listarUnGasto['fecha'] ?>">
                            <button type="button" class="btn" id="currentDate">
                                <i class="fs-5 bi bi-check-square-fill text-secondary"></i>
                            </button>
                            <span>Fecha actual</span>
                        </div>
                        <input type="hidden" id="hiddenDate" name="hiddenDate">

                    </div>
                    <div class="form-group mb-4">
                        <label for="time">Hora</label>
                        <br>
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="time" id="time" name="time" class="p-1" required
                                value="<?php echo $listarUnGasto['hora'] ?>">
                            <div id="validationServerUsernameFeedback" class="invalid-feedback ms-2">
                                Seleccione una hora actual o anterior.
                            </div>
                            <button type="button" class="btn" id="currentTime">
                                <i class="fs-5 bi bi-check-square-fill text-secondary"></i>
                            </button>
                            <span>Hora actual</span>
                        </div>
                        <input type="hidden" id="hiddenTime" name="hiddenTime">
                    </div>
                    <hr class="border-top border-dark">
                    <div class="form-group mb-4">
                        <label for="comentarioGastoModificar">Comentario (opcional)</label>
                        <input type="text" class="form-control" id="comentarioGastoModificar"
                            name="comentarioGastoModificar" placeholder="Comentario (opcional)..." oncopy="return false"
                            onpaste="return false" onkeypress="return validaambos(event)"
                            value="<?php echo $listarUnGasto['comentario']; ?>">
                    </div>


                </div>
                <div class="row">
                    <div class="col-6 d-flex justify-content-center btn">

                        <button type="button" class="btn btn-danger w-75" data-bs-dismiss="modal" onclick="redireccionar('listarGastos/1');">Cancelar</button>


                    </div>
                    <input type="hidden" name="idGastoModificar" value="<?php echo $id; ?>">
                    <div class="col-6 d-flex justify-content-center btn">
                        <button type="submit" class="btn btn-primary w-75" id="input-submit">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>