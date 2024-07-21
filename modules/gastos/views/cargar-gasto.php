<!-- Modal -->
<div class="modal fade" id="cargarGasto" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo Gasto</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarCargarGasto" method="post"
                class="form ajax-form">
                <div class="modal-body">

                    <div class="form-group mb-4">
                        <label for="categoriaGasto" class="col-6"> Categoria del gasto</label>
                        <select class="form-control col-6 w-50" id="categoriaGasto" name="categoriaGasto" required>
                            <option value="" disabled selected>Selecciona una categoria...</option>
                            <?php foreach ($listarCategoriasGastos as $gasto): ?>
                                <option value="<?php echo $gasto['id_categoria_gasto']; ?>">
                                    <?php echo $gasto['nombre_categoria_gasto']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="form-group mb-4">
                        <label for="descripcionGasto">Descripción del gasto</label>
                        <input type="text" class="form-control" id="descripcionGasto" name="descripcionGasto"
                            placeholder="Descripción del gasto..." required oncopy="return false" onpaste="return false"
                            onkeypress="return validaambos(event)">
                    </div>

                    <hr class="border-top border-dark">

                    <div class="form-group mb-4">
                        <label for="empleadoGasto" class="col-6">Empleado</label>
                        <select class="form-control col-6 w-50" id="empleadoGasto" name="empleadoGasto" required>
                            <option value="" disabled selected>Selecciona un empleado...</option>
                            <?php foreach ($listaEmpleados as $empleado): ?>
                                <option value="<?php echo $empleado['id_empleado']; ?>">
                                    <?php echo $empleado['nombre'];
                                    echo ' ';
                                    echo $empleado['apellido']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="border-top border-dark">

                    <div class="form-group mb-4">
                        <label for="metodoPagoGasto" class="col-6">Metodo de pago</label>
                        <select class="form-control col-6 w-50" id="metodoPagoGasto" name="metodoPagoGasto" required>
                            <option value="" disabled selected> Seleccione metodo pago...</option>
                            <?php foreach ($listaMetodosPagos as $metodoPago): ?>
                                <option value="<?php echo $metodoPago['id_medio_pago']; ?>">
                                    <?php
                                    echo $metodoPago['descripcion'];
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="precioTotalGasto">Precio total del gasto</label>
                        <input type="text" class="form-control" id="precioTotalGasto" name="precioTotalGasto"
                            placeholder="Precio total del gasto..." required oncopy="return false"
                            onpaste="return false" onkeypress="return solonumeros(event)">
                    </div>

                    <hr class="border-top border-dark">
                    <div class="form-group mb-4">
                        <label for="date">Fecha</label>
                        <br>
                        <div class="d-flex justify-content-between align-items-center">

                            <input type="date" id="date" name="date" class="p-1" required>
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
                            <input type="time" id="time" name="time" class="p-1" required>
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
                        <label for="comentarioGasto">Comentario (opcional)</label>
                        <input type="text" class="form-control" id="comentarioGasto" name="comentarioGasto"
                            placeholder="Comentario (opcional)..." oncopy="return false" onpaste="return false"
                            onkeypress="return validaambos(event)">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="input-submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>