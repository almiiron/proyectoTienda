<div class="container w-100">
    <div class="row justify-content-center w-100">
        <div class="containerForm col-md-12 col-sm-12 custom-bg-tertiary-alternative">
            <!-- <h5 class="modal-title">Nueva Venta</h5> -->
            <!-- <br> -->
            <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarCargarVenta" method="post"
                class="form ajax-form-mostrarVenta">
                <div class="d-flex justify-content-between">
                    <div class="containerProducts  rounded custom-bg-white ">
                        <div class="w-100 py-1">
                            <input class="form-control me-2 shadow-sm mb-4" type="search" placeholder="Buscar"
                                aria-label="Search" id="searchInputVenta">
                            <div style="height:520px;" class="table-responsive">
                                <table class="table table-striped " id="productTableVenta">
                                    <thead style="height:80px;">
                                        <tr>
                                            <th scope="col"
                                                class="custom-bg-secondary text-light text-center align-middle"
                                                style="border-top-left-radius: 5px;">
                                                ID Producto
                                            </th>
                                            <th class="custom-bg-secondary text-light text-center align-middle"
                                                scope="col">
                                                Nombre del Producto</th>

                                            <th class="custom-bg-secondary text-light text-center align-middle"
                                                scope="col">
                                                Precio</th>
                                            <th class="custom-bg-secondary text-light text-center align-middle"
                                                scope="col">
                                                Stock</th>
                                            <th class="custom-bg-secondary text-light text-center align-middle"
                                                scope="col" style="border-top-right-radius: 5px;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($mostrarTodosProductos): ?>
                                            <?php foreach ($mostrarTodosProductos as $producto): ?>
                                                <tr>
                                                    <td class="text-center"><?= $producto['id_producto']; ?></td>
                                                    <td class="text-center"><?= $producto['nombre_producto']; ?></td>
                                                    <td class="text-center"><?= "$ " . $producto['precio']; ?></td>
                                                    <td class="text-center"><?= $producto['stock']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-primary ms-1 text-center w-100"
                                                            onclick="agregarProducto('<?= $producto['id_producto']; ?>', '<?= $producto['nombre_producto']; ?>', '<?= $producto['precio']; ?>', '<?= $producto['stock']; ?>')"
                                                            style="height:40px; font-size: 15px;">Agregar</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center ">Nada que mostrar aquí.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="containerInfo rounded custom-bg-white p-3">
                        <div class="w-100  py-1 h-100">
                            <div id="productosSeleccionados"></div>
                            <div class="table-responsive" style="height:45%">
                                <h5 class="text-center">Productos Seleccionados</h5>
                                <table class="table" id="tablaProductos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaProductos">
                                    </tbody>
                                </table>
                            </div>
                            <hr class="border-top border-dark">
                            <div class="h-50 d-flex flex-column">
                                <div class="w-100 mb-2">
                                    <select class="form-control col-12 mb-2" id="IdClienteVenta" name="IdClienteVenta"
                                        required>
                                        <option value="" disabled selected>Seleccione un Cliente...</option>
                                        <?php foreach ($mostrarTodosClientes as $cliente): ?>
                                            <option value="<?php echo $cliente['id_cliente']; ?>">
                                                <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <select class="form-control col-12 mt-2" id="IdEmpleadoVenta" name="IdEmpleadoVenta"
                                        required>
                                        <option value="" disabled>Selecciona un Empleado...</option>
                                        <?php foreach ($mostrarTodosEmpleados as $empleado): ?>
                                            <?php if ($empleado['nombre_usuario'] === $_SESSION['user']): ?>
                                                <option value="<?php echo $empleado['id_empleado']; ?>" selected>
                                                    <?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="<?php echo $empleado['id_empleado']; ?>">
                                                    <?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="w-100 mb-2">
                                    <select class="form-control col-12 mb-2" id="IdMetodoPagoVenta" name="IdMetodoPagoVenta"
                                        required>
                                        <option value="" disabled selected>Seleccione Metodo de Pago...</option>
                                        <?php foreach ($mostrarTodosMetodosPagos as $metodoPago): ?>
                                            <option value="<?php echo $metodoPago['id_medio_pago']; ?>">
                                                <?php echo $metodoPago['descripcion']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <hr class="border-top border-dark">
                                <div
                                    class="custom-bg-light-alternative rounded shadow-custom p-2 border-secondary-subtle">
                                    <div>
                                        <div class="form-group d-flex align-items-center mb-2">
                                            <label for="subtotal" class="text-start me-2  fs-5">Subtotal</label>
                                            <span class="ms-auto fs-5 ">$</span>
                                            <span id="spanSubtotal" class="ms-2 me-2  fs-5 ">0</span>
                                            <input type="hidden" id="inputSubtotal" name="subTotalVenta">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="total" class="text-start me-2 fs-3">Total</label>
                                            <span class="ms-auto  fs-3 ">$</span>
                                            <span id="spanTotal" class="ms-2 me-2 fs-3 ">0</span>
                                            <input type="hidden" id="inputTotal" name="totalVenta">
                                        </div>
                                    </div>
                                    <div class="mb-2 mt-2 d-flex">
                                        <button type="button" class="btn btn-outline-danger w-50 me-2"
                                            onclick="removeTab(3, 'mostrarCargarVenta')">Cancelar</button>
                                        <button type="submit" class="btn btn-outline-success w-50 ms-2"
                                            id="input-submit">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>