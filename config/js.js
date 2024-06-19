document.addEventListener("DOMContentLoaded", function () {
    // Escuchar el evento 'show.bs.dropdown' cuando se abre el dropdown
    document.querySelectorAll(".dropdown").forEach(function (dropdown) {
        dropdown.addEventListener("show.bs.dropdown", function () {
            var flecha = this.querySelector('[data-flecha]');
            if (flecha) {
                flecha.classList.add("imgNavBarActivo");
            }
        });

        // Escuchar el evento 'hide.bs.dropdown' cuando se cierra el dropdown
        dropdown.addEventListener("hide.bs.dropdown", function () {
            var flecha = this.querySelector('[data-flecha]');
            if (flecha) {
                flecha.classList.remove("imgNavBarActivo");
            }
        });
    });
});


// validaar que solo ingrese letras
function sololetras(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    letras = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚäëïöüÿÄËÏÖÜŸ"
    especiales = "8-10-13-37-38-46-164";
    teclado_especial = false;
    for (var i in especiales) {
        if (key == especiales[i]) {
            teclado_especial = true; break;
        }
    }
    if (letras.indexOf(teclado) == -1 && !teclado_especial) {
        {
            return false;
        }
    }
}
// validar que solo ingrese numeros
function solonumeros(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    letras = " 1234567890"
    especiales = "8-13-37-38-46-164";
    teclado_especial = false;
    for (var i in especiales) {
        if (key == especiales[i]) {
            teclado_especial = true; break;
        }
    }
    if (letras.indexOf(teclado) == -1 && !teclado_especial) {
        {
            return false;
        }
    }
}

//validar letras y numeros
function validaambos(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    letras = " 1234567890abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚäëïöüÿÄËÏÖÜŸ"
    especiales = "8-10-13-37-38-46-164";
    teclado_especial = false;
    for (var i in especiales) {
        if (key == especiales[i]) {
            teclado_especial = true; break;
        }
    }
    if (letras.indexOf(teclado) == -1 && !teclado_especial) {
        {
            return false;
        }
    }
}
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

let productosSeleccionados = [];

function actualizarTotales() {
    let subtotal = productosSeleccionados.reduce((sum, producto) => sum + producto.precio * producto.cantidad, 0);
    let total = subtotal; // Puedes agregar impuestos o descuentos aquí si es necesario

    // Formatear subtotal y total con comas y puntos
    let subtotalFormateado = subtotal.toLocaleString('es-AR', { minimumFractionDigits: 2 });
    let totalFormateado = total.toLocaleString('es-AR', { minimumFractionDigits: 2 });

    // document.getElementById('inputSubtotal').value = subtotalFormateado;
    // document.getElementById('inputTotal').value = totalFormateado;

    document.getElementById('spanSubtotal').textContent = subtotalFormateado;
    document.getElementById('spanTotal').textContent = totalFormateado;

    document.getElementById('inputSubtotal').value = subtotal;
    document.getElementById('inputTotal').value = total;

    // document.getElementById('spanSubtotal').textContent = subtotal;
    // document.getElementById('spanTotal').textContent = total;
}
function agregarProducto(id, nombre, precio, stock) {
    // Verificar si el producto ya está en la lista
    if (productosSeleccionados.some(producto => producto.id === id)) {
        console.log('El producto ya está cargado.');
        return; // No hacemos nada si el producto ya está en la lista
    }

    const contadorProductos = productosSeleccionados.length + 1;
    const tablaProductos = document.querySelector('#tablaProductos tbody');

    if (!tablaProductos) {
        console.error('No se pudo encontrar el elemento tbody de #tablaProductos.');
        return;
    }

    const fila = document.createElement('tr');
    fila.innerHTML = `
        <td>${contadorProductos}</td>
        <td>${nombre}</td>
        <td>
            <input id="inputCantidad${contadorProductos}" type="text" value="1" name="cantidad">
            <input type="hidden" name="productos[${contadorProductos}][id]" value="${id}">
            <input type="hidden" name="productos[${contadorProductos}][nombre]" value="${nombre}">
            <input type="hidden" name="productos[${contadorProductos}][precio]" value="${precio}">
            <input type="hidden" id="hiddenCantidad${contadorProductos}" name="productos[${contadorProductos}][cantidad]" value="1">
        </td>
        <td>
            <button type="button" class="btn btn-outline-danger" onclick="eliminarProducto(this, '${id}')">Eliminar</button>
        </td>
    `;

    tablaProductos.appendChild(fila);

    // Inicializar TouchSpin en el nuevo input
    $(`#inputCantidad${contadorProductos}`).TouchSpin({
        min: 1,
        max: stock, // Opcional: puedes establecer el stock como máximo
        step: 1,
        buttondown_class: "btn btn-outline-secondary",
        buttonup_class: "btn btn-outline-secondary"
    }).on('change', function () {
        const cantidad = this.value;
        const indice = productosSeleccionados.findIndex(producto => producto.id === id);
        document.getElementById(`hiddenCantidad${contadorProductos}`).value = cantidad;
        productosSeleccionados[indice].cantidad = parseInt(cantidad, 10);
        actualizarTotales();
    });

    productosSeleccionados.push({ id, nombre, precio, stock, cantidad: 1 });
    actualizarTotales();
}


function eliminarProducto(button, id) {
    const indice = productosSeleccionados.findIndex(producto => producto.id === id);
    productosSeleccionados.splice(indice, 1);

    const fila = button.parentNode.parentNode;
    fila.remove();

    // Actualizar los números de las filas
    const filas = document.querySelectorAll('#tablaProductos tbody tr');
    filas.forEach((fila, index) => {
        fila.cells[0].textContent = index + 1;
    });

    actualizarTotales();
}


// para cuando cargo una venta, mientras se escribe en el buscador se actualiza la tabla que muestra todos los productos //
document.getElementById('searchInputVenta').addEventListener('input', function () {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('#productTableVenta tbody tr');

    rows.forEach(row => {
        let idProducto = row.cells[0].textContent.toLowerCase();
        let nombreProducto = row.cells[1].textContent.toLowerCase();
        let precio = row.cells[2].textContent.toLowerCase();
        let stock = row.cells[3].textContent.toLowerCase();

        if (idProducto.includes(searchValue) || nombreProducto.includes(searchValue) || precio.includes(searchValue) || stock.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
// para cuando cargo una venta, mientras se escribe en el buscador se actualiza la tabla que muestra todos los productos //

// para ver detalle venta en mi listar-ventas //
document.addEventListener("DOMContentLoaded", function() {
    // Controlador de eventos para cerrar los detalles de venta
    document.addEventListener("click", function(event) {
        var target = event.target;
        // Si se hace clic fuera de la fila de venta abierta o fuera de la tabla de detalle de venta abierta, cierra el detalle de venta
        if (!target.closest('.details-row') && !target.closest('.details-content')) {
            closeAllDetails();
        }
    });
});

function toggleDetails(index) {
    var detailsRow = document.getElementById('details-' + index);
    if (detailsRow.classList.contains('hidden-row')) {
        closeAllDetails(index); // Cerrar todos los detalles de venta excepto el de este índice
        detailsRow.classList.remove('hidden-row');
    } else {
        detailsRow.classList.add('hidden-row');
    }
}

function closeAllDetails(indexToKeepOpen) {
    var detailsRows = document.querySelectorAll('.details-row');
    detailsRows.forEach(function(row) {
        if (row.id !== 'details-' + indexToKeepOpen) { // Si el id del detalle de venta no coincide con el índice a mantener abierto
            row.classList.add('hidden-row');
        }
    });
}

// para ver detalle venta en mi listar-ventas //