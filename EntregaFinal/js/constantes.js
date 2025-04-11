/*
 * En este fichero se guardarán las constantes y expresiones literales
 * que se utilizarán en los distintos archivos javascript.
*/

/* |-----------------   CONSTANTES NUMÉRICAS   -----------------| */
const LONGITUD_DNI = 9;
const LONGITUD_TELEFONO = 9;
const LONGITUD_MINIMA_CONTRASENA = 8;


/* |-----------------   CÓDIGOS DE ERROR   -----------------| */

const CODIGO_NINGUN_ERROR = 0;

// Errores generales, aplicables a cualquier campo.
const CODIGO_ERROR_CAMPO_VACIO = 111;

// Errores propios del campo email.
const CODIGO_ERROR_EMAIL_ARROBA = 211;
const CODIGO_ERROR_EMAIL_PUNTO = 212;
const CODIGO_ERROR_EMAIL_SUFIJO = 213;

// Errores propios del campo DNI.
const CODIGO_ERROR_DNI_LONGITUD = 311;
const CODIGO_ERROR_DNI_FORMATO = 312;

// Errores propios del campo teléfono.
const CODIGO_ERROR_TELEFONO_LONGITUD = 411;
const CODIGO_ERROR_TELEFONO_FORMATO = 412;


/* |-----------------   EXPRESIONES LITERALES   -----------------| */

// Mensajes de errores generales, aplicables a cualquier campo.
const MENSAJE_ERROR_CAMPO_VACIO = "Este campo no puede estar vacío.";

// Mensajes de errores relacionados con el email.
const MENSAJE_ERROR_EMAIL_ARROBA = "Hay un error en la colocación del @ en ese email.";
const MENSAJE_ERROR_EMAIL_PUNTO = "Hay un error en la colocación del . después del arroba.";
const MENSAJE_ERROR_EMAIL_SUFIJO = "El email ha de terminar con un sufijo detrás del punto.";

// Mensajes de errores relacionados con el DNI.
const MENSAJE_ERROR_DNI_LONGITUD = "El DNI ha de tener 9 caracteres.";
const MENSAJE_ERROR_DNI_FORMATO = "El formato del DNI ha de ser el siguiente: '00000000Z'.";

// Mensajes de errores relacionados con el teléfono.
const MENSAJE_ERROR_TELEFONO_LONGITUD = "El teléfono ha de constar de 9 dígitos.";
const MENSAJE_ERROR_TELEFONO_FORMATO = "Incluir solo los dígitos del número de teléfono, sin espacios ni guiones.";

// Mensajes de errores relacionados con la contraseña.
const MENSAJE_ERROR_CONTRASENA_LONGITUD = "La contraseña ha de tener como mínimo " + LONGITUD_MINIMA_CONTRASENA + " caracteres.";
const MENSAJE_ERROR_CONTRASENA_DESIGUALES = "Las contraseñas no coinciden.";