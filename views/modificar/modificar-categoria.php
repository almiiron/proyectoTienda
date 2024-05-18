<div class="containerForm">
    <form action="procesarModificarCategoria" method="post" class="form ajax-form">
        <div class="form-group mb-4">
            <label for="nombreCategoria">Nombre de la Categoria</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria"
                placeholder="Nombre de la Categoria..." required oncopy="return false" onpaste="return false"
                onkeypress="return sololetras(event)"  value="<?php echo $buscarCategoria['nombre_categoria']; ?>">
        </div>
        <input type="hidden" name="id" id="id" value="<?php echo $buscarCategoria['id_categoria']; ?>">
        <input type="hidden" name="metodo" id="metodo" value="procesarModificarCategoria">
        <input type="submit" class="btn btn-primary col-12" id="input-submit" value="Guardar">
    </form>
</div>