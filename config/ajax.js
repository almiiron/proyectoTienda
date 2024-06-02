$(document).ready(function () {
    // Captura el evento de envío del formulario
    $('form.ajax-form').submit(function (e) {
        e.preventDefault(); // Evita que se envíe el formulario de manera predeterminada.

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        // Llama a la función para enviar el formulario de forma asíncrona.
        enviarFormulario(url, formData, function (response) {
            if (response.success) {
                swal({
                    title: 'Éxito',
                    text: response.message || 'La operación se realizó correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result) {
                        location.reload(); // Recarga la página después de cerrar el Sweet Alert
                    }
                });
            } else {
                swal({
                    title: 'Error',
                    text: response.message || 'Hubo un error al procesar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});

// Función para enviar el formulario de forma asíncrona utilizando AJAX.
function enviarFormulario(url, formData, successCallback) {
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: successCallback,
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


// funcion generica para eliminar elementos 
function cambiarEstado(id, estadoActual) {
    // Mostrar confirmación antes de eliminar
    swal({
        title: '¿Está seguro?',
        text: '¿Realmente desea cambiar el estado?',
        icon: 'warning',
        buttons: ['Cancelar', 'Cambiar'],
        dangerMode: true,
    }).then(function (confirmDelete) {
        if (confirmDelete) {
            var metodo = $('#metodoEstado').val();
            var url = 'http://localhost/proyectoTienda/page/procesarCambiarEstado' + metodo; // Concatenando la variable método a la URL

            console.log('URL:', url);
            var formData = {
                id: id,
                metodo: metodo,
                estadoActual: estadoActual
            };

            $.ajax({
                type: 'POST',
                url: url, // Utilizando la URL dinámica
                data: formData,
                success: function (response) {
                    console.log('Respuesta del servidor:', response);
                    if (response.success) {
                        swal({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(function () {
                            // Recargar la página después de cerrar la alerta
                            location.reload();
                        });
                    } else {
                        swal({
                            title: '¡No se pudo cambiar el estado del elemento!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(function () {
                            // Recargar la página después de cerrar la alerta
                            location.reload();
                        });
                    }
                },
                error: function () {
                    console.error('Hubo un error al procesar la solicitud.');
                    swal({
                        title: '¡Error de servidor!',
                        text: 'Hubo un problema al comunicarse con el servidor.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });
}

$(document).ready(function () {
    $('.button-estado').click(function (e) {
        e.preventDefault();
        var id = $(this).closest('form').find('input[name="idEstado"]').val();
        var estadoActual = $(this).closest('form').find('input[name="estadoActual"]').val();
        cambiarEstado(id, estadoActual);
    });
});




function mostrar(value) {
    console.log(value)
}

function enviarFiltros(url, datos) {
    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function (response) {
            // Manejar la respuesta del servidor si es necesario
            console.log('datos enviados')
        },
        error: function (xhr, status, error) {
            // Manejar errores si es necesario
            console.log('datos no enviados')
        }
    });
}


$(document).ready(function () {
    // Función para filtrar opciones en los select
    $('#input-busqueda').click(function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var url = form.attr('action');
        var filtro = $(this).val();
        console.log(filtro);
        enviarFiltros(url, filtro);
    });
});

$(document).ready(function () {
    //los select con buscador, para que se carguen los select al abrir el modal
    $("#IdProveedorProducto").select2({
        dropdownParent: $("#cargarProducto")

    });
    $("#IdCategoriaProducto").select2({
        dropdownParent: $("#cargarProducto")
    });
    $("#IdProveedorProductoModificar").select2();
    $("#IdCategoriaProductoModificar").select2();
    ////////////////////////////////////////////
    $("#IdRolUsuario").select2({
        dropdownParent: $("#cargarEmpleado")
    });
    $("#IdRolUsuarioModificar").select2();
});

$(document).ready(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
});

$(document).ready(function () {
    $('#buttonIniciarSesion').click(function (e) {
        e.preventDefault();
        var alertLogin = document.getElementById('alert-login');
        var form = $(this).closest('form');
        var url = form.attr('action');
        var formData = form.serialize();
        var user = $(this).closest('form').find('input[name="user"]').val();
        var password = $(this).closest('form').find('input[name="password"]').val();
        console.log(user);
        console.log(password);
        console.log(url);
        console.log(formData);

        // Llama a la función para enviar el formulario de forma asíncrona.
        enviarFormulario(url, formData, function (response) {
            if (response.success) {
                location.href = "http://localhost/proyectoTienda/page/home";
            } else {
                alertLogin.classList.remove('invalid-feedback');
            }
        });
    });
});
function addClassAlertLogin() {
    var alertLogin = document.getElementById('alert-login');
    alertLogin.classList.add('invalid-feedback');
}
$(function () {
    var tabCounter = 2; // Define un contador de pestañas
    var tabs = $("#tabs").tabs(); // Inicializa las pestañas utilizando jQuery UI

    // Función para restaurar pestañas desde localStorage
    function restoreTabs() {
        var savedTabs = JSON.parse(localStorage.getItem("tabs") || "[]"); // Obtiene las pestañas guardadas o un array vacío si no hay ninguna
        savedTabs.forEach(function (tab) {
            addTab(tab.url, tab.name, tab.icon, false); // Agrega cada pestaña guardada, pasando también el icono
        });
        highlightCurrentTab(); // Resaltar la pestaña actual después de restaurar
    }

    // Función para agregar una nueva pestaña
    function addTab(url, name, icon, save = true) {
        var existingTab = $(".tab-" + name); // Busca si ya existe una pestaña con la clase 'tab-name'

        if (existingTab.length > 0) {
            // Si ya existe, redirecciona a la URL de la nueva pestaña
            redireccionar(url);
            return;
        }

        var label = name || "Tab " + tabCounter,
            id = "tabs-" + tabCounter,
            li = $("<li class='d-flex align-items-center justify-content-center '></li>");

        // Crea el botón con redireccionamiento
        var button = $("<button class='btn btn-secondary tab-" + name + " d-flex align-items-center justify-content-center'></button>") // Agrega la clase 'tab-name' al botón
            .text(label)
            .attr("onclick", "redireccionar('" + url + "')")
            .append('&nbsp;&nbsp;<i class="fs-4 ' + icon + '"></i>');

        // Crea el icono de cierre
        var closeIcon = $("<span class='cursor-pointer ui-icon ui-icon-close' role='presentation' onclick='removeTab(" + tabCounter + ", \"" + url + "\")'></span>");

        // Agrega el botón y el icono de cierre al elemento li
        li.append(button).append(closeIcon);

        // Agrega el elemento li a la navegación de pestañas
        tabs.find(".ui-tabs-nav").append(li);

        // Refresca el widget de pestañas para reconocer la nueva pestaña
        tabs.tabs("refresh");
        tabCounter++;

        if (save) {
            saveTab(url, name, icon); // Guarda la pestaña, pasando también el icono
            redireccionar(url); // Redirecciona a la URL de la nueva pestaña
        }
    }

    // Función para guardar una pestaña en localStorage
    function saveTab(url, name, icon) {
        var savedTabs = JSON.parse(localStorage.getItem("tabs") || "[]"); // Obtiene las pestañas guardadas o un array vacío si no hay ninguna
        savedTabs.push({ url: url, name: name, icon: icon }); // Guarda la pestaña con la URL, nombre e icono
        localStorage.setItem("tabs", JSON.stringify(savedTabs)); // Almacena las pestañas en localStorage
    }

    // Función para eliminar una pestaña
    function removeTab(tabId, url) {
        // Elimina la pestaña
        $("#tabs-" + tabId).remove();

        // Elimina el botón de la pestaña correspondiente
        tabs.find(".ui-tabs-nav li").eq(tabId - 1).remove();

        // Refresca el widget de pestañas
        tabs.tabs("refresh");

        // Elimina la pestaña de localStorage
        var savedTabs = JSON.parse(localStorage.getItem("tabs") || "[]");
        savedTabs = savedTabs.filter(tab => tab.url !== url);
        localStorage.setItem("tabs", JSON.stringify(savedTabs));

        // Si hay pestañas restantes, redirecciona a la última pestaña abierta
        if ($("#tabs .ui-tabs-nav li").length > 0) {
            var lastTab = $("#tabs .ui-tabs-nav li:last-child button");
            redireccionar(lastTab.attr("onclick").match(/'([^']+)'/)[1]);
        } else {
            // Si no quedan pestañas, redirecciona a la página de inicio
            redireccionar('home');
        }
    }

    // Función para redireccionar a una URL y resaltar la pestaña actual
    function redireccionar(url) {
        location.href = 'http://localhost/proyectoTienda/page/' + url;
        highlightCurrentTab();
    }

    // Función para resaltar la pestaña actual
    function highlightCurrentTab() {
        var currentUrl = window.location.href;
        $("#tabs .ui-tabs-nav button").each(function () {
            var buttonUrl = $(this).attr("onclick").match(/'([^']+)'/)[1];
            if (currentUrl.includes(buttonUrl)) {
                $(this).removeClass("btn-secondary").addClass("btn-primary");
            } else {
                $(this).removeClass("btn-primary").addClass("btn-secondary");
            }
        });
    }

    // Expone las funciones addTab, removeTab y redireccionar al ámbito global
    window.addTab = addTab;
    window.removeTab = removeTab;
    window.redireccionar = redireccionar;

    // Restaura las pestañas al cargar la página
    restoreTabs();
});
