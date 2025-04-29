/*
 * En este fichero de javascript está contenida la lógica de aparición de  
 * errores en "tiempo real" en los distintos formularios.
*/



/* |-----------------   VARIABLES GLOBALES   -----------------| */

/*
 * Variables necesarias para obtener los valores introducidos en los
 * campos de las contraseñas y evitar errores al compararlos entre ellos.
*/

let contrasenaPrimera = null;
let contrasenaSegunda = null;



/* |-----------------   FUNCIONES DE VALIDACIÓN   -----------------| */

// Función de validación del campo DNI.
function validarDni() {
    const campoDni = $("#" + ID_CAMPO_DNI);
    campoDni[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
    
    let resultadoValidacionDni = comprobarDni(campoDni.val());

    switch(resultadoValidacionDni) {
        case CODIGO_ERROR_DNI_LONGITUD:
            campoDni[0].setCustomValidity(MENSAJE_ERROR_DNI_LONGITUD);
            break;

        case CODIGO_ERROR_DNI_FORMATO:
            campoDni[0].setCustomValidity(MENSAJE_ERROR_DNI_FORMATO);
            break;

        case CODIGO_NINGUN_ERROR:
            campoDni[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
            break;
    }
}


// Función de validación del campo email.
function validarEmail() {
    const campoEmail = $("#" + ID_CAMPO_EMAIL);
    campoEmail[0].setCustomValidity(MENSAJE_NINGUN_ERROR);

    let resultadoValidacionEmail = comprobarCorreo(campoEmail.val());

    switch(resultadoValidacionEmail) {

        case CODIGO_ERROR_EMAIL_ARROBA:
            campoEmail[0].setCustomValidity(MENSAJE_ERROR_EMAIL_ARROBA);
            break;

        case CODIGO_ERROR_EMAIL_PUNTO:
            campoEmail[0].setCustomValidity(MENSAJE_ERROR_EMAIL_PUNTO);
            break;

        case CODIGO_ERROR_EMAIL_SUFIJO:
            campoEmail[0].setCustomValidity(MENSAJE_ERROR_EMAIL_SUFIJO);
            break;
            
        case CODIGO_NINGUN_ERROR:
            campoEmail[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
            break;
    }
}


// Función de validación del campo email para los formularios de alta de usuario.
function validarEmailRegistro() {
    const campoEmailRegistro = $("#" + ID_CAMPO_EMAIL_REGISTRO);
    campoEmailRegistro[0].setCustomValidity(MENSAJE_NINGUN_ERROR);

    let resultadoValidacionEmailRegistro = comprobarCorreo(campoEmailRegistro.val());

    switch(resultadoValidacionEmailRegistro) {

        case CODIGO_ERROR_EMAIL_ARROBA:
            campoEmailRegistro[0].setCustomValidity(MENSAJE_ERROR_EMAIL_ARROBA);
            break;

        case CODIGO_ERROR_EMAIL_PUNTO:
            campoEmailRegistro[0].setCustomValidity(MENSAJE_ERROR_EMAIL_PUNTO);
            break;

        case CODIGO_ERROR_EMAIL_SUFIJO:
            campoEmailRegistro[0].setCustomValidity(MENSAJE_ERROR_EMAIL_SUFIJO);
            break;
            
        case CODIGO_NINGUN_ERROR:
            campoEmailRegistro[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
            break;
    }

    // Sección de la llamada asíncrona al servidor con AJAX. Objetivo: comprobar
    // en tiempo real si el email que el usuario ha introducido ya pertenece 
    // a una cuenta, y hacérselo saber antes de que intente enviar el formulario.

    // Se utiliza encodeURIComponenent para escapar correctamente signos al 
    // generar la url.
    let url = "emailRegistroExisteEnBD.php?email=" + 
        encodeURIComponent(campoEmailRegistro.val());

    /*
     * Función AJAX que llama al archivo emailRegistroExisteEnBD.php. Con ella 
     * se comprueba de forma asíncrona si ya existe un usuario con ese mismo
     * email en la base de datos.
    */ 
    $.get(url, function(data) {

        // Si el email ya existe en la BD, muestra un mensaje de error.    
        if (data == "Existe")
            campoEmailRegistro[0].setCustomValidity(MENSAJE_ERROR_EMAIL_YA_EXISTE);
        else
            campoEmailRegistro[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
    });

}


// Función de validación del campo teléfono.
function validarTelefono() {
    const campoTelefono = $("#" + ID_CAMPO_TELEFONO);
    campoTelefono[0].setCustomValidity(MENSAJE_NINGUN_ERROR);

    let resultadoValidacionTelefono = comprobarTelefono(campoTelefono.val());

    switch(resultadoValidacionTelefono) {
        case CODIGO_ERROR_TELEFONO_LONGITUD:
            campoTelefono[0].setCustomValidity(MENSAJE_ERROR_TELEFONO_LONGITUD);
            break;

        case CODIGO_ERROR_TELEFONO_FORMATO:
            campoTelefono[0].setCustomValidity(MENSAJE_ERROR_TELEFONO_FORMATO);
            break;

        case CODIGO_NINGUN_ERROR:
            campoTelefono[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
            break;
    }
}


// Función de validación del campo contraseña.
function validarContrasena() {
    const campoContrasena = $("#" + ID_CAMPO_CONTRASENA);
    campoContrasena[0].setCustomValidity(MENSAJE_NINGUN_ERROR);

    if (campoContrasena.val().length < LONGITUD_MINIMA_CONTRASENA)
        campoContrasena[0].setCustomValidity(MENSAJE_ERROR_CONTRASENA_LONGITUD);

    else {
        contrasenaPrimera = campoContrasena.val();
        campoContrasena[0].setCustomValidity(MENSAJE_NINGUN_ERROR);
    }

}


// Función de validación del campo de repetición de la contraseña.
function validarContrasenaRepetida() {
    const campoContrasenaRepetida = $("#" + ID_CAMPO_CONTRASENA_REPETIDA);
    campoContrasenaRepetida[0].setCustomValidity(MENSAJE_NINGUN_ERROR);

    if (campoContrasenaRepetida.val().length < LONGITUD_MINIMA_CONTRASENA)
        campoContrasenaRepetida[0].setCustomValidity(MENSAJE_ERROR_CONTRASENA_LONGITUD);

    else {
        contrasenaSegunda = campoContrasenaRepetida.val();

        // Comprueba si las dos contraseñas introducidas coinciden.
        if (contrasenaPrimera != contrasenaSegunda)
            campoContrasenaRepetida[0].setCustomValidity(MENSAJE_ERROR_CONTRASENA_DESIGUALES);
        else
            campoContrasenaRepetida[0].setCustomValidity(MENSAJE_NINGUN_ERROR);

    }

}



/* |-----------------   FUNCIONES DE TRATAMIENTO DE LOS CAMPOS   -----------------| */

$(document).ready(function() {

    // Tratamiento del campo nombre.
    tratamientoCampo(ID_CAMPO_NOMBRE);

    // Tratamiento del campo apellidos.
    tratamientoCampo(ID_CAMPO_APELLIDOS);

    // Tratamiento del campo DNI.
    tratamientoCampo(ID_CAMPO_DNI);

    // Tratamiento del campo email.    
    tratamientoCampo(ID_CAMPO_EMAIL);

    // Caso particular del tratamiento del campo email: si es en alguno de los 
    // formularios de alta de usuario, se ha comprobar asíncronamente con AJAX 
    // si el email introducido por el usuario ya existe en la base de datos. 
    tratamientoCampo(ID_CAMPO_EMAIL_REGISTRO);

    // Tratamiento del campo teléfono.
    tratamientoCampo(ID_CAMPO_TELEFONO);

    // Tratamiento de ambos campos de contraseña.
    tratamientoCampo(ID_CAMPO_CONTRASENA);
    tratamientoCampo(ID_CAMPO_CONTRASENA_REPETIDA);

});


function tratamientoCampo(id) {
    idCampo = "#" + id;

    if (id == ID_CAMPO_DNI)
        $(idCampo).on('change', validarDni);
    
    else if (id == ID_CAMPO_EMAIL)
        $(idCampo).on('change', validarEmail);
    
    else if (id == ID_CAMPO_EMAIL_REGISTRO)
        $(idCampo).on('change', validarEmailRegistro);
    
    else if (id == ID_CAMPO_TELEFONO)
        $(idCampo).on('change', validarTelefono);
    
    else if (id == ID_CAMPO_CONTRASENA)
        $(idCampo).on('change', validarContrasena);
    
    else if (id == ID_CAMPO_CONTRASENA_REPETIDA)
        $(idCampo).on('change', validarContrasenaRepetida);
    
}



/* |-----------------   FUNCIONES DE COMPROBACIÓN DE LOS VALORES INTRODUCIDOS EN LOS CAMPOS   -----------------| */

// Función que comprueba si el DNI introducido tiene un formato válido.
function comprobarDni(dni) {

    // Elimina los espacios en blanco que pueda haber al
    // principio y al final del DNI.
    dni = dni.trim();

    // Comprueba si la longitud del DNI es correcta.
    if (dni.length != LONGITUD_DNI)
        return CODIGO_ERROR_DNI_LONGITUD;

    // Comprueba que el formato del DNI (es decir, ocho 
    // dígitos seguidos de una letra) es correcto.
    let seccionDigitos = dni.substring(0, LONGITUD_DNI - 1);   // Obtiene la subcadena con los ocho primeros caracteres.
    if (!esNumero(seccionDigitos) || !esLetra(dni[LONGITUD_DNI - 1]))
        return CODIGO_ERROR_DNI_FORMATO;

    // No hay ningún error, devuelve cero.
    else
        return CODIGO_NINGUN_ERROR;

}


// Función que comprueba si el correo introducido es válido.
function comprobarCorreo(correo) {

    // Elimina los espacios en blanco que pueda haber al
    // principio y al final del correo.
    correo = correo.trim();

    // Comprueba si falta el arroba o si no hay un nombre de
    // email antes de ella.
    let arroba = correo.indexOf("@");
    if (arroba <= 0)
        return CODIGO_ERROR_EMAIL_ARROBA;

    // Comprueba que hay un punto entre el arroba y el final
    // de la dirección de correo, y que hay algún caracter entre
    // la arroba y dicho punto.
    correo = correo.substring(arroba, correo.length);
    let punto = correo.indexOf(".");
    if (punto <= 1)
        return CODIGO_ERROR_EMAIL_PUNTO;

    // Comprueba que el punto no es el último caracter de la 
    // dirección de correo.
    correo = correo.substring(punto + 1, correo.length);
    if (correo.length == 0)
        return CODIGO_ERROR_EMAIL_SUFIJO;
    
    // No hay ningún error, devuelve cero.
    else
        return CODIGO_NINGUN_ERROR;

}


// Función que comprueba si el teléfono introducido es válido.
function comprobarTelefono(telefono) {

    // Elimina los espacios en blanco que pueda haber al
    // principio y al final del teléfono.
    telefono = telefono.trim();
    
    // Comprueba si la longitud del teléfono es correcta.
    if (telefono.length != LONGITUD_TELEFONO)
        return CODIGO_ERROR_TELEFONO_LONGITUD;

    // Comprueba si hay algún caracter que no es un dígito
    // en el número de teléfono introducido.
    if (!esNumero(telefono))
        return CODIGO_ERROR_TELEFONO_FORMATO;

    // No hay ningún error, devuelve cero.
    else
        return CODIGO_NINGUN_ERROR;

}



/* |-----------------   FUNCIONES AUXILIARES   -----------------| */

// Función auxiliar que comprueba si una determinada cadena
// de caracteres es un numero o no.
function esNumero(cadena) {
    for (let i = 0; i < cadena.length; i++) {
        if (cadena[i] < "0" || cadena[i] > "9")
            return false;
    }
    return true;
}


// Función auxiliar que comprueba si un determinado caracter
// es una letra o no.
function esLetra(caracter) {
    return (caracter >= 'A' && caracter <= 'Z') || 
        (caracter >= 'a' && caracter <= 'z')
}