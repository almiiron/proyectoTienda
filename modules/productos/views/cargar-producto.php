<!-- Modal para cargar producto -->

<div class="modal fade" id="cargarProducto" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo Producto</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarCargarProducto" method="post"
                class="form ajax-form">
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="nombreProducto">Nombre del Producto</label>
                        <input type="text" class="form-control " id="nombreProducto" name="nombreProducto"
                            placeholder="Nombre del Producto..." required oncopy="return false" onpaste="return false"
                            onkeypress="return sololetras(event)">
                    </div>

                    <div class="form-group mb-4">
                        <label for="IdCategoriaProducto" class="col-6">Categoría del Producto</label>
                        <select class="form-control col-6 w-50" id="IdCategoriaProducto" name="IdCategoriaProducto"
                            required>
                            <option value="" disabled selected>Selecciona una categoría...</option>
                            <?php foreach ($listaCategorias as $categoria): ?>
                                <option value="<?php echo $categoria['id_categoria']; ?>">
                                    <?php echo $categoria['nombre_categoria']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="IdProveedorProducto" class="col-6">Proveedor del Producto</label>
                        <select class="form-control col-6 w-50" id="IdProveedorProducto" name="IdProveedorProducto"
                            required>
                            <option value="" disabled selected>Selecciona un proveedor...</option>
                            <?php foreach ($listaProveedores as $proveedor): ?>
                                <option value="<?php echo $proveedor['id_proveedor']; ?>">
                                    <?php echo $proveedor['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="precioProductoCompra">Precio del Producto para Compra</label>
                        <input type="text" class="form-control" id="precioProductoCompra" name="precioProductoCompra"
                            placeholder="Precio del Producto para Compra..." required oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)">
                    </div>

                    <div class="form-group mb-4">
                        <label for="precioProductoVenta">Precio del Producto para Venta</label>
                        <input type="text" class="form-control" id="precioProductoVenta" name="precioProductoVenta"
                            placeholder="Precio del Producto para Venta..." required oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)">
                    </div>

                    <div class="form-group mb-4">
                        <label for="stockProducto">Stock del Producto</label>
                        <input type="text" class="form-control" id="stockProducto" name="stockProducto"
                            placeholder="Stock del Producto..." required oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)">
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