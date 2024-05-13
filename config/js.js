function visibleSubmenu(i) {
    var menu = document.querySelectorAll(".menu-vertical");
    if (i == 1) {
        menu[0].classList.add("activo");
    } else if (i == 2) {
        menu[1].classList.add("activo");
    } else if (i == 3) {
        menu[2].classList.add("activo");
    } else if (i == 4) {
        menu[3].classList.add("activo");
    } else if (i == 5) {
        menu[4].classList.add("activo");
    }
}

function invisibleSubmenu(i) {
    var menu = document.querySelectorAll(".menu-vertical");
    if (i == 1) {
        menu[0].classList.remove("activo");
    } else if (i == 2) {
        menu[1].classList.remove("activo");
    } else if (i == 3) {
        menu[2].classList.remove("activo");
    } else if (i == 4) {
        menu[3].classList.remove("activo");
    } else if (i == 5) {
        menu[4].classList.remove("activo");
    }
}

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
