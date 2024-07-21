<div class="container w-100">
    <div class="row justify-content-center w-100">
        <div class="containerForm col-md-12 col-sm-12 custom-bg-tertiary-alternative">
            <!-- <h5 class="modal-title">Nueva Venta</h5> -->
            <!-- <br> -->
            <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarCargarCompra" method="post"
                class="form ajax-form-cargarCompra">
                <div class="d-flex justify-content-between">
                    <div class="containerProducts  rounded custom-bg-white ">
                        <div class="w-100 py-1">
                            <input class="form-control me-2 shadow-sm mb-4" type="search" placeholder="Buscar"
                                aria-label="Search" id="searchInputVentaCompra">
                            <div style="height:550px;" class="table-responsive">
                                <table class="table table-striped " id="productTableVentaCompra">
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
                                                Precio Compra</th>
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
                                                    <td class="text-center todosPreciosFormateados">
                                                        <?= "$ " . $producto['precio_compra']; ?>
                                                    </td>
                                                    <td class="text-center"><?= $producto['stock']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-primary ms-1 text-center w-100"
                                                            onclick="agregarProductoCompra('<?= $producto['id_producto']; ?>', '<?= $producto['nombre_producto']; ?>', '<?= $producto['precio_compra']; ?>', '<?= $producto['stock']; ?>')"
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
                            <div class="table-responsive" style="height:40%">
                                <h5 class="text-center fw-bold">Productos Seleccionados</h5>
                                <table class="table" id="tablaProductos">
                                    <thead>
                                        <tr>
                                            <th class="text-body-secondary">#</th>
                                            <th class="text-body-secondary">Producto</th>
                                            <th class="text-body-secondary">Cantidad</th>
                                            <th class="text-body-secondary">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaProductos">
                                    </tbody>
                                </table>
                            </div>
                            <hr class="border-top border-dark">
                            <div class="h-50 d-flex flex-column">
                                <div class="w-100 mb-2">
                                    <select class="form-control col-12 mb-2" id="IdProveedorCompra" name="IdProveedorCompra"
                                        required style="width: 100% !important;">
                                        <option value="" disabled selected>Seleccione un Proveedor...</option>
                                        <?php foreach ($mostrarTodosProveedores as $proveedor): ?>
                                            <option value="<?php echo $proveedor['id_proveedor']; ?>">
                                                <?php echo $proveedor['nombre']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <select class="form-control col-12 mt-2" id="IdEmpleadoCompra" name="IdEmpleadoCompra"
                                        required style="width: 100% !important;">
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
                                    <select class="form-control col-12 mb-2" id="IdMetodoPagoCompra"
                                        name="IdMetodoPagoCompra" required style="width: 100% !important;">
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
                                        <div class="form-group d-flex align-items-center mb-1">
                                            <label for="subtotal"
                                                class="text-start me-2  fs-5 text-body-secondary">Subtotal</label>
                                            <span class="ms-auto fs-5 text-body-secondary">$</span>
                                            <span id="spanSubtotal" class="ms-2 me-2  fs-5 text-body-secondary">0</span>
                                            <input type="hidden" id="inputSubtotal" name="subTotalCompra">
                                        </div>
                                        <div class="form-group d-flex align-items-center">
                                            <label for="total" class="text-start me-2 fs-4 fw-bold">Total</label>
                                            <span class="ms-auto  fs-4 fw-bold">$</span>
                                            <span id="spanTotal" class="ms-2 me-2 fs-4 fw-bold">0</span>
                                            <input type="hidden" id="inputTotal" name="totalCompra">
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-1 d-flex flex-column">
                                        <button type="button" class="btn btn-outline-danger w-100 "
                                            onclick="removeTab(3, 'mostrarCargarCompra')">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-outline-success w-100 my-1 " id="input-submit">
                                            Guardar
                                        </button>
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