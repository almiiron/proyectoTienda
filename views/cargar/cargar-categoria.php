<div class="containerForm">
    <form action="procesarCargarCategoria" method="post" class="form">
        <div class="form-group mb-4">
            <label for="nombreCategoria">Nombre de la Categoria</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria"
                placeholder="Nombre de la Categoria..." required oncopy="return false" onpaste="return false"
                onkeypress="return sololetras(event)">
        </div>
        <input type="hidden" name="metodo" id="metodo" value="procesarCargarCategoria">
        <input type="submit" class="btn btn-primary col-12" id="input-submit" value="Guardar">
    </form>
</div>