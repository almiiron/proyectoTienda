<div class="container my-4">
    <div class="row justify-content-center">
        <div class="containerForm col-md-6 col-sm-12">
            <form action="procesarModificarProducto" method="post" class="form ajax-form">
                <div class="form-group mb-4">
                    <label for="nombreProducto">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombreProducto" name="nombreProducto"
                        placeholder="Nombre del Producto..." required oncopy="return false" onpaste="return false"
                        onkeypress="return sololetras(event)" value="<?php echo $datosProducto['nombre_producto']; ?>">
                </div>
                <div class="form-group mb-4">
                    <label for="categoriaProducto">Categoría del Producto</label>
                    <select class="form-control select-search w-50" id="IdCategoriaProductoModificar" name="IdCategoriaProducto"
                        required >
                        <?php foreach ($listaCategorias as $categoria): ?>
                            <?php if ($categoria['id_categoria'] == $datosProducto['id_categoria']): ?>
                                <option value="<?php echo $categoria['id_categoria']; ?>" selected>
                                    <?php echo $categoria['nombre_categoria']; ?>
                                </option>
                            <?php else: ?>
                                <option value="<?php echo $categoria['id_categoria']; ?>">
                                    <?php echo $categoria['nombre_categoria']; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="proveedorProducto">Proveedor del Producto</label>
                    <select class="form-control select-search w-50" id="IdProveedorProductoModificar" name="IdProveedorProducto"
                        required>
                        <?php foreach ($listaProveedores as $proveedor): ?>
                            <?php if ($proveedor['id_proveedor'] == $datosProducto['id_proveedor']): ?>
                                <option value="<?php echo $proveedor['id_proveedor']; ?>" selected>
                                    <?php echo $proveedor['nombre']; ?>
                                </option>
                            <?php else: ?>
                                <option value="<?php echo $proveedor['id_proveedor']; ?>">
                                    <?php echo $proveedor['nombre']; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="precioProducto">Precio del Producto</label>
                    <input type="text" class="form-control" id="precioProducto" name="precioProducto"
                        placeholder="Precio del Producto..." required oncopy="return false" onpaste="return false"
                        onkeypress="return solonumeros(event)" value="<?php echo $datosProducto['precio']; ?>">
                </div>
                <div class=" form-group mb-4">
                    <label for="stockProducto">Stock del Producto</label>
                    <input type="text" class="form-control" id="stockProducto" name="stockProducto"
                        placeholder="Stock del Producto..." required oncopy="return false" onpaste="return false"
                        onkeypress="return solonumeros(event)" value="<?php echo $datosProducto['stock']; ?>">
                </div>
                <input type="hidden" name="IdProducto" id="IdProducto"
                    value="<?php echo $datosProducto['id_producto']; ?>">
                <input type="hidden" name="metodo" id="metodo" value="procesarCargarProducto">
                <div class="row">
                        <div class="col-6 d-flex justify-content-center mb-2 mb-md-0">
                            <a href="/proyectoTienda/page/listarProductos/1" class="btn w-75">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Cancelar</button>
                            </a>
                        </div>
                        <div class="col-6 d-flex justify-content-center btn">
                            <button type="submit" class="btn btn-primary w-75" id="input-submit">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>