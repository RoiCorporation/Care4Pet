/*
 * En este fichero de javascript está contenida la lógica de aparición de  
 * errores en "tiempo real" en los distintos formularios.
*/



/* |-----------------   VARIABLES GLOBALES   -----------------| */

/*
 * Variable necesaria para obtener el valor introducido en el primer campo
 * referente a la contraseña y evitar errores al compararlo con la introducida
 * en el segundo campo.
*/
let contrasenaIntroducida = null;



/* |-----------------   FUNCIONES DE VALIDACIÓN   -----------------| */

// Función de validación del campo nombre.
function validarNombre() {
    let nombreIntroducido = $("#campoNombre").val();

    if (nombreIntroducido.trim().length === 0)
        $('#mensajeErrorNombre').text(MENSAJE_ERROR_CAMPO_VACIO).addClass("activo").show();

    else
        $('#mensajeErrorNombre').removeClass("activo").hide();
}


// Función de validación del campo apellidos.
function validarApellidos() {
    let apellidosIntroducido = $("#campoApellidos").val();

    if (apellidosIntroducido.trim().length === 0)
        $('#mensajeErrorApellidos').text(MENSAJE_ERROR_CAMPO_VACIO).addClass("activo").show();

    else
        $('#mensajeErrorApellidos').removeClass("activo").hide();
}


// Función de validación del campo DNI.
function validarDni() {
    let dniIntroducido = $("#campoDni").val();
    let resultadoValidacionDni = comprobarDni(dniIntroducido);

    switch(resultadoValidacionDni) {
        case CODIGO_ERROR_DNI_LONGITUD:
            $('#mensajeErrorDni').text(MENSAJE_ERROR_DNI_LONGITUD).addClass("activo").show();
            break;

        case CODIGO_ERROR_DNI_FORMATO:
            $('#mensajeErrorDni').text(MENSAJE_ERROR_DNI_FORMATO).addClass("activo").show();
            break;

        case CODIGO_NINGUN_ERROR:
            $('#mensajeErrorDni').removeClass("activo").hide();
            break;
    }
}


// Función de validación del campo email.
function validarEmail() {
    let emailIntroducido = $("#campoEmail").val();
    let resultadoValidacionEmail = comprobarCorreo(emailIntroducido);

    switch(resultadoValidacionEmail) {
        case CODIGO_ERROR_CAMPO_VACIO:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_CAMPO_VACIO).addClass("activo").show();
            break;

        case CODIGO_ERROR_EMAIL_ARROBA:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_ARROBA).addClass("activo").show();
            break;

        case CODIGO_ERROR_EMAIL_PUNTO:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_PUNTO).addClass("activo").show();
            break;

        case CODIGO_ERROR_EMAIL_SUFIJO:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_SUFIJO).addClass("activo").show();
            break;
            
        case CODIGO_NINGUN_ERROR:
            $('#mensajeErrorEmail').removeClass("activo").hide();
            break;
    }
}


// Función de validación del campo email para los formularios de alta de usuario.
function validarEmailRegistro() {
    let emailIntroducido = $("#campoEmailRegistro").val();
    let resultadoValidacionEmailRegistro = comprobarCorreo(emailIntroducido);

    switch(resultadoValidacionEmailRegistro) {
        case CODIGO_ERROR_CAMPO_VACIO:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_CAMPO_VACIO).addClass("activo").show();
            break;

        case CODIGO_ERROR_EMAIL_ARROBA:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_ARROBA).addClass("activo").show();
            break;

        case CODIGO_ERROR_EMAIL_PUNTO:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_PUNTO).addClass("activo").show();
            break;

        case CODIGO_ERROR_EMAIL_SUFIJO:
            $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_SUFIJO).addClass("activo").show();
            break;
            
        case CODIGO_NINGUN_ERROR:
            $('#mensajeErrorEmail').removeClass("activo").hide();
            break;
    }

    // Sección de la llamada asíncrona al servidor con AJAX. Objetivo: comprobar
    // en tiempo real si el email que el usuario ha introducido ya pertenece 
    // a una cuenta, y hacérselo saber antes de que intente enviar el formulario.

    // Se utiliza encodeURIComponenent para escapar correctamente signos al 
    // generar la url.
    let url = "emailRegistroExisteEnBD.php?email=" + 
        encodeURIComponent(emailIntroducido);

    /*
     * Función AJAX que llama al archivo emailRegistroExisteEnBD.php. Se hace síncrona porque, 
     * en la segunda invocación que se hace a esta función -esto es, tras pulsar el botón de 
     * enviar formulario y no haber otro error en él- es necesario que el programa espere a
     * recibir la respuesta de esta función antes de continuar su ejecución, para que no se
     * omita un posible error en este campo.
    */ 
    $.ajax({
        url: url,
        async: false,  // Fuerza la petición síncrona.
        success: function (data, status) {

            // Si el email ya existe en la BD, muestra un mensaje de error.
            if (data === "Existe") {
                $("#mensajeErrorEmail").text(MENSAJE_ERROR_EMAIL_YA_EXISTE).addClass("activo").show();
                console.log("YA EXISTE");
            }

        }
    });

}


// Función de validación del campo teléfono.
function validarTelefono() {
    let telefonoIntroducido = $("#campoTelefono").val();
    let resultadoValidacionTelefono = comprobarTelefono(telefonoIntroducido);

    switch(resultadoValidacionTelefono) {
        case CODIGO_ERROR_TELEFONO_LONGITUD:
            $('#mensajeErrorTelefono').text(MENSAJE_ERROR_TELEFONO_LONGITUD).addClass("activo").show();
            break;

        case CODIGO_ERROR_TELEFONO_FORMATO:
            $('#mensajeErrorTelefono').text(MENSAJE_ERROR_TELEFONO_FORMATO).addClass("activo").show();
            break;

        case CODIGO_NINGUN_ERROR:
            $('#mensajeErrorTelefono').removeClass("activo").hide();
            break;
    }
}


// Función de validación del campo contraseña.
function validarContrasena() {
    contrasenaIntroducida = $("#campoContrasena").val();

    if (contrasenaIntroducida.length < LONGITUD_MINIMA_CONTRASENA)
        $('#mensajeErrorContrasena')
            .text(MENSAJE_ERROR_CONTRASENA_LONGITUD).addClass("activo").show();

    else
        $('#mensajeErrorContrasena').removeClass("activo").hide();
}


// Función de validación del campo de repetición de la contraseña.
function validarContrasenaRepetida() {
    let contrasenaRepetida = $("#campoContrasenaRepetida").val();

    if (contrasenaRepetida.length < LONGITUD_MINIMA_CONTRASENA)
        $('#mensajeErrorContrasenaRepetida')
            .text(MENSAJE_ERROR_CONTRASENA_LONGITUD).addClass("activo").show();

    // Si ya se ha introducido la contraseña en el anterior campo, 
    // comprueba si ambas coinciden. 
    if (contrasenaIntroducida != null) {
        if (contrasenaIntroducida != contrasenaRepetida)
            $('#mensajeErrorContrasenaRepetida')
                .text(MENSAJE_ERROR_CONTRASENA_DESIGUALES).addClass("activo").show();

        else
            $('#mensajeErrorContrasenaRepetida').removeClass("activo").hide();
    }
}


// Función que encapsula la lógica de validación de los formularios.
function validarFormulario(event) {

    // Obtiene el formulario que invocó esta función.
    let formulario = $(event.target);

    // Determina los campos a validar, en función de cuál sea el 
    // formulario que invocó la función.
    if (formulario.attr("id") === "formularioRegistro" || 
        formulario.attr("id") === "formularioAdminRegistro" || 
        formulario.attr("id") === "[id^=formularioEditarUsuario]" 
    ) {
        validarNombre();
        validarApellidos();
        validarDni();
        validarEmailRegistro();
        validarTelefono();
        validarContrasena();
        validarContrasenaRepetida();
    }

    else if (formulario.attr("id") === "formularioLogin") {
        validarEmail();
        validarContrasena();
    }

    // Si hay algún error en alguno de los campos o no se ha rellenado ningún 
    // campo, impide el envío del formulario.
    if (formulario.find(".error-campo-formulario.activo").length > 0) {
        event.preventDefault();
    }
    
}



/* |-----------------   FUNCIONES DE TRATAMIENTO DE LOS CAMPOS   -----------------| */

$(document).ready(function() {

    // Tratamiento de los campos nombre y appellidos, en los cuales solo 
    // se puede dar como error el dejarlos vacíos.
    $("#campoNombre").on('blur', validarNombre);
    $("#campoApellidos").on('blur', validarApellidos);
    
    // Tratamiento del campo DNI.
    $("#campoDni").on('blur', validarDni);

    // Tratamiento del campo email.    
    $("#campoEmail").on('blur', validarEmail);

    // Caso particular del tratamiento del campo email: si es en alguno de los 
    // formularios de alta de usuario, se ha comprobar asíncronamente con AJAX 
    // si el email introducido por el usuario ya existe en la base de datos. 
    $("#campoEmailRegistro").on('blur', validarEmailRegistro);

    // Tratamiento del campo teléfono.
    $("#campoTelefono").on('blur', validarTelefono);

    // Tratamiento de ambos campos de contraseña.
    $("#campoContrasena").on('blur', validarContrasena);
    $("#campoContrasenaRepetida").on('blur', validarContrasenaRepetida);
       
    // Todos los formularios comparten la misma lógica de validación antes de 
    // ser enviados. El objetivo es impedir el envío de formularios -con la 
    // consiguiente solicitud al servidor- en cuyos campos haya algún error.
    $("#formularioRegistro").on('submit', validarFormulario);
    $("#formularioLogin").on('submit', validarFormulario);
    $("[id^=formularioEditarUsuario]").on('submit', validarFormulario);
    $("#formularioAdminRegistro").on('submit', validarFormulario);

});


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

    // Comprueba si el correo es vacío.
    if (correo === "") {
        return CODIGO_ERROR_CAMPO_VACIO;
    }

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