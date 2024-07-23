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
    let interesElement = document.getElementById('interesVenta');
    let interes = interesElement ? parseFloat(interesElement.value) || 0 : 0; // Verificar si existe el elemento y establecer interés en 0 si no

    //console.log(interes);

    let subtotal = productosSeleccionados.reduce((sum, producto) => sum + producto.precio * producto.cantidad, 0);
    let total = subtotal + (subtotal * interes); // Puedes agregar impuestos o descuentos aquí si es necesario

    // Formatear subtotal y total con comas y puntos
    let subtotalFormateado = subtotal.toLocaleString('es-AR', { minimumFractionDigits: 2 });
    let totalFormateado = total.toLocaleString('es-AR', { minimumFractionDigits: 2 });

    // Actualizar los elementos del DOM con los valores calculados
    document.getElementById('spanSubtotal').textContent = subtotalFormateado;
    document.getElementById('spanTotal').textContent = totalFormateado;

    document.getElementById('inputSubtotal').value = subtotal;
    document.getElementById('inputTotal').value = total;
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

//////////////////////////////////////////////////////////////

// para cuando cargo una venta, mientras se escribe en el buscador se actualiza la tabla que muestra todos los productos //
if (window.location.href.indexOf('mostrarCargarVenta') !== -1 || window.location.href.indexOf('mostrarCargarCompra') !== -1) { //llamo a la funcion si estoy en la pestaña que corresponde
    filtrarTablaVentaCompra();
}
function filtrarTablaVentaCompra() {
    document.getElementById('searchInputVentaCompra').addEventListener('input', function () {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#productTableVentaCompra tbody tr');

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
}

// para cuando cargo una venta, mientras se escribe en el buscador se actualiza la tabla que muestra todos los productos //

// para ver detalle venta en mi listar-ventas //
// document.addEventListener("DOMContentLoaded", function () {
//     // Controlador de eventos para cerrar los detalles de venta
//     document.addEventListener("click", function (event) {
//         var target = event.target;
//         // Si se hace clic fuera de la fila de venta abierta o fuera de la tabla de detalle de venta abierta, cierra el detalle de venta
//         if (!target.closest('.details-row') && !target.closest('.details-content')) {
//             closeAllDetails();
//         }
//     });
// });

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
    detailsRows.forEach(function (row) {
        if (row.id !== 'details-' + indexToKeepOpen) { // Si el id del detalle de venta no coincide con el índice a mantener abierto
            row.classList.add('hidden-row');
        }
    });
}

// ocultar loader despues de haber cargado toda la pagina //
function ocultarLoader() {
    let loader = document.querySelector('.overlay');
    // agrego un retraso de 500 milisegundos
    setTimeout(function () {
        loader.classList.add('d-none');
    }, 500);
}

// para pasar todos los precios con formato //
// Verifica si existe un elemento con la clase 'todosPreciosFormateados'
// if (document.querySelector('.todosPreciosFormateados') !== null) {
// Selecciona todos los elementos con la clase 'todosPreciosFormateados'
let elementos = document.querySelectorAll('.todosPreciosFormateados');

if (elementos.length > 0) {
    // Itera sobre cada elemento y formatea su contenido
    elementos.forEach(function (elemento) {
        // Elimina el símbolo de dólar y los espacios en blanco del contenido del elemento
        let contenido = elemento.textContent.replace(/[^\d.-]/g, '');
        let precio = parseFloat(contenido);

        if (!isNaN(precio)) {
            let precioFormateado = "$ " + precio.toLocaleString('es-AR', { minimumFractionDigits: 2 });
            elemento.textContent = precioFormateado;
        } else {
            console.log('No se pudo convertir el precio para el elemento:', elemento);
        }
    });
} else {
    // console.log('No hay elementos con la clase todosPreciosFormateados');
}
// }




// para compras //      // para compras //      // para compras //      // para compras //        // para compras //

function agregarProductoCompra(id, nombre, precio, stock) {
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
        max: Infinity,
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

// para compras //      // para compras //      // para compras //      // para compras //        // para compras //


// para la fecha en cargar gasto //     // para la fecha en cargar gasto //     // para la fecha en cargar gasto //

// Función para obtener la fecha y hora actuales
function getCurrentDateAndTime() {
    const now = new Date();
    // Obtiene la fecha actual en formato YYYY-MM-DD
    const today = now.toISOString().split('T')[0];
    // Obtiene la hora actual en formato HH:MM
    const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);
    return { today, currentTime };
}

// Maneja el evento de cambiar la fecha al presionar el botón de fecha actual
function handleCurrentDateChange() {
    const { today } = getCurrentDateAndTime();
    const dateInput = document.getElementById('date');
    const currentDateButton = document.getElementById('currentDate');
    const icon = currentDateButton.querySelector('i');
    const hiddenDateInput = document.getElementById('hiddenDate');

    // Remueve las clases de animación
    currentDateButton.classList.remove('animate__animated', 'animate__bounceIn');
    icon.classList.remove('animate__animated', 'animate__bounceIn');

    // Alterna el estado activo del botón y el input
    if (currentDateButton.classList.contains('active')) {
        currentDateButton.classList.remove('active');
        dateInput.disabled = false;
        icon.className = 'fs-5 bi bi-check-square-fill text-secondary';
        hiddenDateInput.value = ''; // Limpia el input oculto cuando está activo
    } else {
        currentDateButton.classList.add('active');
        dateInput.value = today;
        dateInput.disabled = true;
        icon.className = 'fs-5 bi bi-check-square-fill text-success';
        hiddenDateInput.value = today; // Establece el valor del input oculto cuando está inactivo
    }

    // Agrega las clases de animación después de un breve retraso
    setTimeout(() => {
        currentDateButton.classList.add('animate__animated', 'animate__bounceIn');
        icon.classList.add('animate__animated', 'animate__bounceIn');
    }, 10);

    validateDate();
    checkTime();
}

// Maneja el evento de cambiar la hora al presionar el botón de hora actual
function handleCurrentTimeChange() {
    const { currentTime } = getCurrentDateAndTime();
    const timeInput = document.getElementById('time');
    const currentTimeButton = document.getElementById('currentTime');
    const icon = currentTimeButton.querySelector('i');
    const hiddenTimeInput = document.getElementById('hiddenTime');

    // Remueve las clases de animación
    currentTimeButton.classList.remove('animate__animated', 'animate__bounceIn');
    icon.classList.remove('animate__animated', 'animate__bounceIn');

    // Alterna el estado activo del botón y el input
    if (currentTimeButton.classList.contains('active')) {
        currentTimeButton.classList.remove('active');
        timeInput.disabled = false;
        icon.className = 'fs-5 bi bi-check-square-fill text-secondary';
        hiddenTimeInput.value = ''; // Limpia el input oculto cuando está activo
    } else {
        currentTimeButton.classList.add('active');
        timeInput.value = currentTime;
        timeInput.disabled = true;
        timeInput.classList.remove('is-invalid');
        icon.className = 'fs-5 bi bi-check-square-fill text-success';
        hiddenTimeInput.value = currentTime; // Establece el valor del input oculto cuando está inactivo
    }

    // Agrega las clases de animación después de un breve retraso
    setTimeout(() => {
        currentTimeButton.classList.add('animate__animated', 'animate__bounceIn');
        icon.classList.add('animate__animated', 'animate__bounceIn');
    }, 10);

    checkTime();
}

// Valida que la fecha seleccionada no sea futura
function validateDate() {
    const dateInput = document.getElementById('date');
    const selectedDate = dateInput.value;
    const { today } = getCurrentDateAndTime();

    if (selectedDate > today) {
        dateInput.value = today;
        alert('No se puede seleccionar una fecha futura.');
    }
}

// Revisa la hora para asegurarse de que sea válida en el contexto de la fecha seleccionada
function checkTime() {
    const timeInput = document.getElementById('time');
    const time = timeInput.value;
    const { currentTime } = getCurrentDateAndTime();
    const currentDateButton = document.getElementById('currentDate');
    const dateInput = document.getElementById('date');
    const { today } = getCurrentDateAndTime();
    const inputSubmit = document.getElementById('input-submit');

    if ((currentDateButton.classList.contains('active') || dateInput.value === today) && time !== '' && time > currentTime) {
        timeInput.classList.add('is-invalid');
        inputSubmit.disabled = true;
    } else {
        timeInput.classList.remove('is-invalid');
        inputSubmit.disabled = false;
    }
}

// Maneja el cambio de hora del input
function handleTimeChange() {
    checkTime();
}

// Configura los event listeners para los botones y los inputs
function setupEventListeners() {
    document.getElementById('currentDate').addEventListener('click', handleCurrentDateChange);
    document.getElementById('currentTime').addEventListener('click', handleCurrentTimeChange);
    document.getElementById('date').addEventListener('change', () => {
        validateDate();
        checkTime();
    });
    document.getElementById('time').addEventListener('change', handleTimeChange);
}

// Inicializa la configuración en la página 'listarGastos'
function initialize() {
    const { today } = getCurrentDateAndTime();
    document.getElementById('date').setAttribute('max', today);
    setupEventListeners();
}

// Inicializar el script solo en la página 'listarGastos'
if (window.location.href.indexOf('listarGastos') !== -1 || window.location.href.indexOf('mostrarModificarGasto') !== -1 ) {
    initialize();
}

// para la fecha en cargar gasto //     // para la fecha en cargar gasto //     // para la fecha en cargar gasto //




// para el boton de ver detalle de gasto //     // para el boton de ver detalle de gasto //     // para el boton de ver detalle de gasto //
document.querySelectorAll('#buttonDetalleGasto').forEach(button => {
    button.addEventListener('click', (event) => {
        const row = event.target.closest('tr');
        mostrarDetalleGasto(row);
    });
});

function mostrarDetalleGasto(row) {
    document.getElementById('modal-id-gasto').textContent = row.dataset.idGasto;
    document.getElementById('modal-id-empleado').textContent = row.dataset.idEmpleado;
    document.getElementById('modal-nombre-empleado').textContent = row.dataset.nombreEmpleado;
    document.getElementById('modal-apellido-empleado').textContent = row.dataset.apellidoEmpleado;
    document.getElementById('modal-metodo-pago').textContent = row.dataset.metodoPago;
    document.getElementById('modal-categoria-gasto').textContent = row.dataset.categoriaGasto;
    document.getElementById('modal-descripcion-gasto').textContent = row.dataset.descripcionGasto;
    document.getElementById('modal-fecha').textContent = row.dataset.fecha;
    document.getElementById('modal-hora').textContent = row.dataset.hora;
    document.getElementById('modal-precio-total').textContent = row.dataset.precioTotal;
    document.getElementById('modal-comentario').textContent = row.dataset.comentario;
    document.getElementById('modal-estado').textContent = row.dataset.estado;
}
// para el boton de ver detalle de gasto //     // para el boton de ver detalle de gasto //     // para el boton de ver detalle de gasto //

