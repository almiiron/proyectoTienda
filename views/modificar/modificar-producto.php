<div class="containerForm">
    <form action="procesarModificarProducto" method="post" class="form ajax-form">
        <div class="form-group mb-4">
            <label for="nombreProducto">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto"
                placeholder="Nombre del Producto..." required oncopy="return false" onpaste="return false"
                onkeypress="return sololetras(event)" value="<?php echo $datosProducto['nombre_producto']; ?>">
        </div>
        <div class="form-group mb-4">
            <label for="categoriaProducto">Categoría del Producto</label>
            <select class="form-control select-search" id="IdCategoriaProducto" name="IdCategoriaProducto" required>
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
            <select class="form-control select-search" id="IdProveedorProducto" name="IdProveedorProducto" required>
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
        <input type="hidden" name="IdProducto" id="IdProducto" value="<?php echo $datosProducto['id_producto']; ?>">
        <input type="hidden" name="metodo" id="metodo" value="procesarCargarProducto">
        <input type="submit" class="btn btn-primary col-12" id="input-submit" value="Guardar">
    </form>
</div>