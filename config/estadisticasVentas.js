// const host = '192.168.100.23';
// var host = 'localhost';

// si la URL contiene 'controlVentas' llamo a las funciones
if (window.location.href.indexOf('panelControl') !== -1) {
    ProductosMasVendidos();
    CategoriasConMasVentas();
    TotalVentasCadaMesDelAnio();
    IngresosUltimosSieteDias();
    IngresosUltimasCuatroSemanas();
    TotalComprasCadaMesDelAño();
    CategoriasConMasCompras();
    ProductosMasComprados();
    TotalGastosCadaMesDelAnio();
    CategoriasConMasGastos();
    CategoriasMasRepetidasGastos();
    IngresosDiariosPorMes();
    ObtenerTotalesDelMes();
    ObtenerDatosMensuales();
    ObtenerRentabilidadProductos();

}

function shuffleColors(count) {
    const allColors = [
        'orange', 'red', 'purple', 'blue', 'green', 'cyan', 'brown', 'navy',
        'olive', 'teal', 'maroon', 'gold', 'coral', 'plum', 'crimson',
        'aquamarine', 'blueviolet', 'cadetblue', 'chocolate', 'cornflowerblue',
        'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki',
        'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon',
        'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet',
        'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'forestgreen',
        'goldenrod', 'gray', 'greenyellow', 'hotpink', 'indianred', 'indigo', 'limegreen',
        'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen',
        'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred',
        'midnightblue', 'navy', 'orangered', 'peru', 'royalblue', 'saddlebrown', 'seagreen',
        'sienna', 'skyblue', 'slateblue', 'slategray', 'steelblue', 'tan', 'tomato',
        'turquoise', 'violet', 'yellowgreen'
    ];

    // Mezclar los colores
    let shuffled = allColors.slice(); // Crear una copia del array de colores
    let currentIndex = shuffled.length, randomIndex;

    // Mientras queden elementos a mezclar
    while (currentIndex != 0) {
        // Seleccionar un elemento restante
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // E intercambiarlo con el elemento actual
        [shuffled[currentIndex], shuffled[randomIndex]] = [shuffled[randomIndex], shuffled[currentIndex]];
    }

    // Devolver los primeros 'count' elementos del array mezclado
    return shuffled.slice(0, count);
}


function ProductosMasVendidos() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/productosMasVendidos`,
        type: 'POST',
        success: function (data) {
            const productosData = JSON.parse(data);

            const ctx = document.getElementById('productos-mas-vendidos-chart').getContext('2d');
            const colorCount = productosData.productos.length;
            const colors = shuffleColors(colorCount);
            const barChart = new Chart(ctx, {
                type: 'bar', // tipo de grafico 'bar'
                data: {
                    labels: productosData.productos,
                    datasets: [
                        {
                            label: 'Ingresos totales por producto',
                            data: productosData.ingresos,
                            backgroundColor: colors,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0, // limite minimo en 0
                            suggestedMax: Math.max(...productosData.ingresos) + 50, // limite máximo
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16, // tamaño del texto del eje Y
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos', // titulo del eje Y
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Productos', // titulo del eje X
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                                // margin: {
                                //     top: 500,
                                // },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                maxHeight: 100,
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,

                        },
                    },
                },
            });
        },
    });
}


function CategoriasConMasVentas() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/categoriasConMasVentas`,
        type: 'POST',
        success: function (data) {
            const categoriasData = JSON.parse(data);

            const colorCount = categoriasData.categorias.length;
            const colors = shuffleColors(colorCount);
            const ctx = document.getElementById('categorias-con-mas-ventas-chart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'doughnut', // tipo de grafico 'pie'
                data: {
                    labels: categoriasData.categorias,
                    datasets: [
                        {
                            label: 'Ingresos totales por categoria',
                            data: categoriasData.ingresos,
                            backgroundColor: colors,
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 16, // tamaño del texto del titulo
                                },
                            },
                            title: {
                                display: true,
                                text: 'Categorias con más ventas', // titulo del gráfico
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
    });
}

function TotalVentasCadaMesDelAnio() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/totalVentasCadaMesDelAnio`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('total-ventas-cada-mes-del-año-chart').getContext('2d');
            const colorCount = data.meses.length;
            const colors = shuffleColors(colorCount);
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.meses,
                    datasets: [
                        {
                            label: 'Ventas cada mes del año',
                            data: data.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ventas',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Meses',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}

function IngresosUltimosSieteDias() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/ingresosUltimosSieteDias`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('ingresos-ultimos-siete-dias-chart').getContext('2d');
            const colorCount = data.fechas.length;
            const colors = shuffleColors(colorCount);
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.fechas,
                    datasets: [
                        {
                            label: 'Ingresos ultimos 7 dias',
                            data: data.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fechas',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}

function IngresosUltimasCuatroSemanas() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/ingresosUltimasCuatroSemanas`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const colorCount = data.semanas.length;
            const colors = shuffleColors(colorCount);
            const ctx = document.getElementById('ingresos-ultimas-cuatro-semanas-chart').getContext('2d');
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.semanas,
                    datasets: [
                        {
                            label: 'Ingresos ultimas 4 semanas',
                            data: data.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fechas',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}

function IngresosDiariosPorMes() {

    $.ajax({
        url: `http://${host}/proyectoTienda/page/ingresosDiariosPorMes`,
        type: 'POST',
        // data: { mes: mesSeleccionado },
        success: function (data) {
            const ingresosData = JSON.parse(data);
            const ctx = document.getElementById('ingresos-ultimo-mes-chart').getContext('2d');
            if (window.myLineChart) {
                window.myLineChart.destroy();
            }

            const datasets = [
                {
                    label: 'Ventas diarias del mes',
                    data: ingresosData.ingresos, // Utiliza los datos directamente
                    borderColor: 'blue',
                    fill: false,
                },
            ];

            window.myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ingresosData.dias, // Utiliza los días proporcionados por el servidor
                    datasets: datasets,
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true, // Iniciar el eje Y en 0
                            suggestedMin: 0,
                            suggestedMax: Math.max(...datasets[0].data) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ventas',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Días del Mes',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        // Resto de las opciones de los plugins
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var formattedValue = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: context.raw % 1 === 0 ? 0 : 2
                                    }).format(context.raw);
                                    return 'Dia ' + label + ': ' + formattedValue;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    },
                },
            });
        }, error: function () {
            console.log('Hubo un error al obtener ');
        },
    });
}


function TotalComprasCadaMesDelAño() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/totalComprasCadaMesDelAnio`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('total-compras-cada-mes-del-año-chart').getContext('2d');
            const colorCount = data.meses.length;
            const colors = shuffleColors(colorCount);
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.meses,
                    datasets: [
                        {
                            label: 'Compras cada mes del año',
                            data: data.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Compras',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Meses',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}

function CategoriasConMasCompras() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/categoriasConMasCompras`,
        type: 'POST',
        success: function (data) {
            const categoriasData = JSON.parse(data);
            const colorCount = categoriasData.categorias.length;
            const colors = shuffleColors(colorCount);
            const ctx = document.getElementById('categorias-con-mas-compras-chart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'doughnut', // tipo de grafico 'pie'
                data: {
                    labels: categoriasData.categorias,
                    datasets: [
                        {
                            label: 'Compras totales por categoria',
                            data: categoriasData.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 16, // tamaño del texto del titulo
                                },
                            },
                            title: {
                                display: true,
                                text: 'Categorias con más compras', // titulo del gráfico
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
    });
}


function ProductosMasComprados() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/productosMasComprados`,
        type: 'POST',
        success: function (data) {
            const productosData = JSON.parse(data);
            const colorCount = productosData.productos.length;
            const colors = shuffleColors(colorCount);
            const ctx = document.getElementById('productos-mas-comprados-chart').getContext('2d');
            const barChart = new Chart(ctx, {
                type: 'bar', // tipo de grafico 'bar'
                data: {
                    labels: productosData.productos,
                    datasets: [
                        {
                            label: 'Compras totales por producto',
                            data: productosData.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0, // limite minimo en 0
                            suggestedMax: Math.max(...productosData.ingresos) + 50, // limite máximo
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16, // tamaño del texto del eje Y
                                },
                            },
                            title: {
                                display: true,
                                text: 'Compras', // titulo del eje Y
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Productos', // titulo del eje X
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                                // margin: {
                                //     top: 500,
                                // },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                maxHeight: 100,
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,

                        },
                    },
                },
            });
        },
    });
}


function TotalGastosCadaMesDelAnio() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/totalGastosCadaMesDelAnio`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('total-gastos-cada-mes-del-año-chart').getContext('2d');
            const colorCount = data.meses.length;
            const colors = shuffleColors(colorCount);
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.meses,
                    datasets: [
                        {
                            label: 'Gastos cada mes del año',
                            data: data.ingresos,
                            backgroundColor: colors
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Gastos',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Meses',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}


function CategoriasConMasGastos() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/categoriasConMasGastos`,
        type: 'POST',
        success: function (data) {
            const categoriasData = JSON.parse(data);
            const colorCount = categoriasData.categorias.length;
            const colors = shuffleColors(colorCount);
            const ctx = document.getElementById('categorias-con-mas-gastos-chart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'doughnut', // tipo de grafico 'pie'
                data: {
                    labels: categoriasData.categorias,
                    datasets: [
                        {
                            label: 'Ingresos totales por categoria',
                            data: categoriasData.ingresos,
                            backgroundColor: colors,
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 16, // tamaño del texto del titulo
                                },
                            },
                            title: {
                                display: true,
                                text: 'Categorias con más gastos', // titulo del gráfico
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
    });
}


function CategoriasMasRepetidasGastos() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/categoriasMasRepetidasGastos`,
        type: 'POST',
        success: function (data) {
            const categoriasData = JSON.parse(data);

            const colorCount = categoriasData.categorias.length;
            const colors = shuffleColors(colorCount);
            const ctx = document.getElementById('categorias-mas-repetidas-gastos-chart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'doughnut', // tipo de grafico 'pie'
                data: {
                    labels: categoriasData.categorias,
                    datasets: [
                        {
                            label: 'Cantidad de veces',
                            data: categoriasData.ingresos,
                            backgroundColor: colors,
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            // callbacks: {
                            //     label: function (context) {
                            //         var label = context.label;
                            //         var value = '$ ' + new Intl.NumberFormat('es-ES', {
                            //             style: 'currency',
                            //             currency: 'ARS',
                            //             minimumFractionDigits: 0,
                            //         }).format(context.raw);
                            //         return label + ': ' + value;
                            //     },
                            // },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 16, // tamaño del texto del titulo
                                },
                            },
                            title: {
                                display: true,
                                text: 'Categorias de gasto más repetidas', // titulo del gráfico
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
    });
}

function IngresosDiariosPorMes() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/datosDiariosPorMes`,
        type: 'POST',
        success: function (data) {
            // console.log(data);
            const datos = JSON.parse(data);
            const ctx = document.getElementById('ingresos-diarios-por-mes-chart').getContext('2d');
            if (window.myLineChart) {
                window.myLineChart.destroy();
            }

            const datasets = [
                {
                    label: 'Ganancia real diaria del mes',
                    data: datos.gananciaReal,
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 255, 0, 0.2)',
                    fill: false,
                    pointBackgroundColor: 'green',
                    pointBorderColor: 'green',
                    pointBorderWidth: 2,
                },
                {
                    label: 'Ventas diarias del mes',
                    data: datos.ventas,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.2)', // Color de fondo de la línea
                    fill: false,
                    pointBackgroundColor: 'blue', // Color de los puntos
                    pointBorderColor: 'blue',
                    pointBorderWidth: 2,
                },
                {
                    label: 'Compras diarias del mes',
                    data: datos.compras,
                    borderColor: 'purple',
                    backgroundColor: 'rgba(128, 0, 128, 0.2)',
                    fill: false,
                    pointBackgroundColor: 'purple',
                    pointBorderColor: 'purple',
                    pointBorderWidth: 2,
                },
                {
                    label: 'Gastos diarios del mes',
                    data: datos.gastos,
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    fill: false,
                    pointBackgroundColor: 'red',
                    pointBorderColor: 'red',
                    pointBorderWidth: 2,
                },
               
            ];


            window.myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: datos.dias,
                    datasets: datasets,
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Monto',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Días del Mes',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var formattedValue = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: context.raw % 1 === 0 ? 0 : 2
                                    }).format(context.raw);
                                    return 'Día ' + label + ': ' + formattedValue;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                // boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            // onClick: false,
                        },
                    },
                    animations: {
                        // tension: {
                        //     duration: 1000,
                        //     easing: 'linear',
                        //     from: 1,
                        //     to: 0,
                        //     loop: true
                        // }
                    },
                },
            });
        }, error: function () {
            console.log('Hubo un error al obtener los datos.');
        },
    });
}

function ObtenerTotalesDelMes() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/obtenerTotalesDelMes`,
        type: 'POST',
        success: function (data) {
            const datos = JSON.parse(data);
            const ctx = document.getElementById('ingresos-totales-del-mes-chart').getContext('2d');
            if (window.myPolarAreaChart) {
                window.myPolarAreaChart.destroy();
            }

            window.myPolarAreaChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: ['Ventas del mes', 'Compras del mes', 'Gastos del mes', 'Ganancia Real del mes'],
                    datasets: [{
                        label: 'Totales del Mes',
                        data: [datos.totalVentas, datos.totalCompras, datos.totalGastos, datos.totalGananciaReal],
                        backgroundColor: [
                            'rgba(0, 0, 255, 0.2)',    // Color de fondo para Ventas
                            'rgba(128, 0, 128, 0.2)',  // Color de fondo para Compras
                            'rgba(255, 0, 0, 0.2)',    // Color de fondo para Gastos
                            'rgba(0, 255, 0, 0.2)'     // Color de fondo para Ganancia Real
                        ],
                        borderColor: [
                            'blue',
                            'purple',
                            'red',
                            'green'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var formattedValue = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: context.raw % 1 === 0 ? 0 : 2
                                    }).format(context.raw);
                                    return label + ': ' + formattedValue;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                },
            });
        },
        error: function () {
            console.log('Hubo un error al obtener los datos.');
        },
    });
}

function ObtenerDatosMensuales() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/obtenerDatosMensuales`,
        type: 'POST',
        success: function (data) {
            const datos = JSON.parse(data);
            const ctx = document.getElementById('datos-mensuales-chart').getContext('2d');
            // if (window.myBarChart) {
            //     window.myBarChart.destroy();
            // }

            window.myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datos.meses, // Etiquetas de los meses
                    datasets: [
                        {
                            label: 'Ganancia Real',
                            data: datos.gananciaReal,
                            backgroundColor: 'rgba(0, 255, 0, 0.6)', // Color de fondo para Ganancia Real
                            borderColor: 'green',
                            borderWidth: 1,
                        },
                        {
                            label: 'Dinero Perdido (Compras + Gastos)',
                            data: datos.dineroPerdido,
                            backgroundColor: 'rgba(255, 0, 0, 0.6)', // Color de fondo para Dinero Perdido
                            borderColor: 'red',
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Meses',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Monto',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.dataset.label || '';
                                    var formattedValue = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: context.raw % 1 === 0 ? 0 : 2
                                    }).format(context.raw);
                                    return label + ': ' + formattedValue;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                },
            });
        },
        error: function () {
            console.log('Hubo un error al obtener los datos.');
        },
    });
}

function ObtenerRentabilidadProductos() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/obtenerRentabilidadProductos`,
        type: 'POST',
        success: function (data) {
            const datos = JSON.parse(data);

            const ctx = document.getElementById('rentabilidad-productos-chart').getContext('2d');
            // if (window.myBarChart) {
            //     window.myBarChart.destroy();
            // }

            window.myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datos.productos, // Nombres de los productos
                    datasets: [
                        {
                            label: 'Rentabilidad',
                            data: datos.rentabilidad,
                            backgroundColor: 'rgba(0, 0, 255, 0.6)', // Color de fondo para Ventas
                            borderColor: 'blue',
                            borderWidth: 1,
                        },
                        {
                            label: 'Costos de compra',
                            data: datos.costos,
                            backgroundColor: 'rgba(255, 0, 0, 0.6)', // Color de fondo para Costos
                            borderColor: 'red',
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Productos',
                                font: {
                                    size: 20,
                                },
                            },
                            stacked: false, // Para barras agrupadas
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Monto',
                                font: {
                                    size: 20,
                                },
                            },
                            stacked: false, // Para barras agrupadas
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.dataset.label || '';
                                    var formattedValue = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: context.raw % 1 === 0 ? 0 : 2
                                    }).format(context.raw);
                                    return label + ': ' + formattedValue;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                },
            });
        },
        error: function () {
            console.log('Hubo un error al obtener los datos.');
        },
    });
}
