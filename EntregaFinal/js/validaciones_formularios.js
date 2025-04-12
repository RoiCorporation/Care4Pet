/*
 * En este fichero de javascript está contenida la lógica de aparición de  
 * errores en "tiempo real" en los distintos formularios.
*/

/* |-----------------   FUNCIONES DE TRATAMIENTO DE LOS CAMPOS   -----------------| */

$(document).ready(function() {

    // Tratamiento de los campos nombre y appellidos, en los cuales solo 
    // se puede dar como error el dejarlos vacíos.
    $("#campoNombre").on('blur', function() {
        let nombreIntroducido = $(this).val();

        if (nombreIntroducido.trim().length === 0)
            $('#mensajeErrorNombre').text(MENSAJE_ERROR_CAMPO_VACIO).show();


        else
            $('#mensajeErrorNombre').hide();
    });

    $("#campoApellidos").on('blur', function() {
        let nombreIntroducido = $(this).val();

        if (nombreIntroducido.trim().length === 0)
            $('#mensajeErrorApellidos').text(MENSAJE_ERROR_CAMPO_VACIO).show();

        else
            $('#mensajeErrorApellidos').hide();
    });
    

    // Tratamiento del campo DNI.
    $("#campoDni").on('blur', function() {
        let dniIntroducido = $(this).val();
        let resultadoValidacion = dniValido(dniIntroducido);

        switch(resultadoValidacion) {
            case CODIGO_ERROR_DNI_LONGITUD:
                $('#mensajeErrorDni').text(MENSAJE_ERROR_DNI_LONGITUD).show();
                break;

            case CODIGO_ERROR_DNI_FORMATO:
                $('#mensajeErrorDni').text(MENSAJE_ERROR_DNI_FORMATO).show();
                break;

            case CODIGO_NINGUN_ERROR:
                $('#mensajeErrorDni').hide();
                break;
        }
    });


    // Tratamiento del campo email.    
    $("#campoEmail").on('blur', function() {
        let emailIntroducido = $(this).val();
        let resultadoValidacion = correoValido(emailIntroducido);

        switch(resultadoValidacion) {
            case CODIGO_ERROR_CAMPO_VACIO:
                $('#mensajeErrorEmail').text(MENSAJE_ERROR_CAMPO_VACIO).show();
                break;

            case CODIGO_ERROR_EMAIL_ARROBA:
                $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_ARROBA).show();
                break;

            case CODIGO_ERROR_EMAIL_PUNTO:
                $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_PUNTO).show();
                break;

            case CODIGO_ERROR_EMAIL_SUFIJO:
                $('#mensajeErrorEmail').text(MENSAJE_ERROR_EMAIL_SUFIJO).show();
                break;
                
            case CODIGO_NINGUN_ERROR:
            $('#mensajeErrorEmail').hide();
            break;
                
        }
    });
    

    // Tratamiento del campo teléfono.
    $("#campoTelefono").on('blur', function() {
        let telefonoIntroducido = $(this).val();
        let resultadoValidacion = telefonoValido(telefonoIntroducido);

        switch(resultadoValidacion) {
            case CODIGO_ERROR_TELEFONO_LONGITUD:
                $('#mensajeErrorTelefono').text(MENSAJE_ERROR_TELEFONO_LONGITUD).show();
                break;

            case CODIGO_ERROR_TELEFONO_FORMATO:
                $('#mensajeErrorTelefono').text(MENSAJE_ERROR_TELEFONO_FORMATO).show();
                break;

            case CODIGO_NINGUN_ERROR:
                $('#mensajeErrorTelefono').hide();
                break;

        }
    });


    // Variable global necesaria para obtener el valor introducido en el primer
    // campo referente a la contraseña y evitar errores al compararlo con la 
    // introducida en el segundo campo.
    let contrasenaIntroducida = null;

    // Tratamiento de ambos campos de contraseña.
    $("#campoContrasena").on('blur', function() {
        contrasenaIntroducida = $(this).val();

        if (contrasenaIntroducida.length < LONGITUD_MINIMA_CONTRASENA)
            $('#mensajeErrorContrasena')
                .text(MENSAJE_ERROR_CONTRASENA_LONGITUD).show();

        else
            $('#mensajeErrorContrasena').hide();
        
    });

    $("#campoContrasenaRepetida").on('blur', function() {
        let contrasenaRepetida = $(this).val();

        console.log("Contraseña primera: " + contrasenaIntroducida);

        if (contrasenaRepetida.length < LONGITUD_MINIMA_CONTRASENA)
            $('#mensajeErrorContrasenaRepetida')
                .text(MENSAJE_ERROR_CONTRASENA_LONGITUD).show();

        // Si ya se ha introducido la contraseña en el anterior campo, 
        // comprueba si ambas coinciden. 
        if (contrasenaIntroducida != null) {
            if (contrasenaIntroducida != contrasenaRepetida)
                $('#mensajeErrorContrasenaRepetida')
                    .text(MENSAJE_ERROR_CONTRASENA_DESIGUALES).show();
    
            else
                $('#mensajeErrorContrasenaRepetida').hide();
        }
        
    });


    // Lógica de envío del formulario. Se quiere impedir que al pulsar el botón 
    // de enviar se envíe el formulario al servidor, de haber en algún campo 
    // errores por subsanar.
    $("#formularioRegistro").on('submit', function (event) {

        // Si hay algún error en alguno de los campos, impide el envío del formulario.
        if ($('#mensajeErrorNombre').is(':visible') || 
            $('#mensajeErrorApellidos').is(':visible') || 
            $('#mensajeErrorDni').is(':visible') || 
            $('#mensajeErrorEmail').is(':visible') || 
            $('#mensajeErrorTelefono').is(':visible') || 
            $('#mensajeErrorContrasena').is(':visible') || 
            $('#mensajeErrorContrasenaRepetida').is(':visible')            
        ) {
            event.preventDefault();
        }
    
    });


    // Misma lógica de envío del formulario, pero aplicada al formulario de login.
    $("#formularioLogin").on('submit', function (event) {

        // Si hay algún error en las credenciales, impide el envío del formulario.
        if ($('#mensajeErrorEmail').is(':visible') || 
            $('#mensajeErrorContrasena').is(':visible')
        )
            event.preventDefault();

        // Si no hay ningún error, permite el envío.
        else
            this.submit();

    });

});


/* |-----------------   FUNCIONES AUXILIARES DE VALIDACIÓN DE DATOS   -----------------| */

function dniValido(dni) {

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
function correoValido(correo) {

    // Elimina los espacios en blanco que pueda haber al
    // principio y al final del correo.
    correo = correo.trim();

    // Comprueba si el correo es vacío.
    if (correo.length === 0)
        return CODIGO_ERROR_CAMPO_VACIO;

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
function telefonoValido(telefono) {

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