<div class="containerForm">
    <form action="procesarCargarProducto" method="post" class="form">
        <div class="form-group mb-4">
            <label for="nombreProducto">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto"
                placeholder="Nombre del Producto..." required oncopy="return false" onpaste="return false"
                onkeypress="return sololetras(event)">
        </div>
        <div class="form-group mb-4">
            <label for="categoriaProducto">Categoría del Producto</label>
            <select class="form-control select-search" id="IdCategoriaProducto" name="IdCategoriaProducto" required>
                <option value="">Selecciona una categoría...</option>
                <?php foreach ($listaCategorias as $categoria): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre_categoria']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- <input type="text" class="form-control search-input" placeholder="Buscar categoría..."> -->
        </div>

        <div class="form-group mb-4">
            <label for="proveedorProducto">Proveedor del Producto</label>
            <select class="form-control select-search" id="IdProveedorProducto" name="IdProveedorProducto" required>
                <option value="">Selecciona un proveedor...</option>
                <?php foreach ($listaProveedores as $proveedor): ?>
                    <option value="<?php echo $proveedor['id_proveedor']; ?>"><?php echo $proveedor['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- <input type="text" class="form-control search-input" placeholder="Buscar proveedor..."> -->
        </div>

        <div class="form-group mb-4">
            <label for="precioProducto">Precio del Producto</label>
            <input type="text" class="form-control" id="precioProducto" name="precioProducto"
                placeholder="Precio del Producto..." required oncopy="return false" onpaste="return false"
                onkeypress="return solonumeros(event)">
        </div>
        <div class="form-group mb-4">
            <label for="stockProducto">Stock del Producto</label>
            <input type="text" class="form-control" id="stockProducto" name="stockProducto"
                placeholder="Stock del Producto..." required oncopy="return false" onpaste="return false"
                onkeypress="return solonumeros(event)">
        </div>

        <input type="hidden" name="metodo" id="metodo" value="procesarCargarProducto">
        <input type="submit" class="btn btn-primary col-12" id="input-submit" value="Guardar">
    </form>
</div>