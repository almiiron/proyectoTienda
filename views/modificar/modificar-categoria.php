<div class="container my-4">
    <div class="row justify-content-center">
        <div class="containerForm col-md-6 col-sm-12">
            <form action="procesarModificarCategoria" method="post" class="form ajax-form">
                <div class="form-group mb-4">
                    <label for="nombreCategoria">Nombre de la Categoria</label>
                    <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria"
                        placeholder="Nombre de la Categoria..." required oncopy="return false" onpaste="return false"
                        onkeypress="return sololetras(event)"
                        value="<?php echo $buscarCategoria['nombre_categoria']; ?>">
                </div>
                <input type="hidden" name="id" id="id" value="<?php echo $buscarCategoria['id_categoria']; ?>">
                <input type="hidden" name="metodo" id="metodo" value="procesarModificarCategoria">
                <div class="row">
                        <div class="col-6 d-flex justify-content-center mb-2 mb-md-0">
                            <a href="/proyectoTienda/page/listarCategorias/1" class="btn w-75">
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