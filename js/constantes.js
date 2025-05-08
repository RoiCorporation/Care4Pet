/*
 * En este fichero se guardarán las constantes y expresiones literales
 * que se utilizarán en los distintos archivos javascript.
*/


/* |-----------------   CONSTANTES NUMÉRICAS   -----------------| */

const LONGITUD_DNI = 9;
const LONGITUD_TELEFONO = 9;
const LONGITUD_MINIMA_CONTRASENA = 8;



/* |-----------------   IDS DE CAMPOS   -----------------| */

const ID_CAMPO_NOMBRE = "campoNombre";
const ID_CAMPO_APELLIDOS = "campoApellidos";
const ID_CAMPO_DNI = "campoDni";
const ID_CAMPO_EMAIL = "campoEmail";
const ID_CAMPO_EMAIL_REGISTRO = "campoEmailRegistro";
const ID_CAMPO_TELEFONO = "campoTelefono";
const ID_CAMPO_CONTRASENA = "campoContrasena";
const ID_CAMPO_CONTRASENA_REPETIDA = "campoContrasenaRepetida";



/* |-----------------   CÓDIGOS DE ERROR   -----------------| */

const CODIGO_NINGUN_ERROR = 0;

// Errores propios del campo email.
const CODIGO_ERROR_EMAIL_ARROBA = 111;
const CODIGO_ERROR_EMAIL_PUNTO = 112;
const CODIGO_ERROR_EMAIL_SUFIJO = 113;

// Errores propios del campo DNI.
const CODIGO_ERROR_DNI_LONGITUD = 211;
const CODIGO_ERROR_DNI_FORMATO = 212;

// Errores propios del campo teléfono.
const CODIGO_ERROR_TELEFONO_LONGITUD = 311;
const CODIGO_ERROR_TELEFONO_FORMATO = 312;



/* |-----------------   EXPRESIONES LITERALES   -----------------| */

// Mensajes de errores generales, aplicables a cualquier campo.
const MENSAJE_NINGUN_ERROR = "";
const CAMPO_VACIO = "";

// Mensajes de errores relacionados con el email.
const MENSAJE_ERROR_EMAIL_ARROBA = "Hay un error en la colocación del @ en ese email.";
const MENSAJE_ERROR_EMAIL_PUNTO = "Hay un error en la colocación del . después del arroba.";
const MENSAJE_ERROR_EMAIL_SUFIJO = "El email ha de terminar con un sufijo detrás del punto.";
const MENSAJE_ERROR_EMAIL_YA_EXISTE = "Ya existe una cuenta asociada a ese email.";
const MENSAJE_ERROR_EMAIL_NO_EXISTE = "No existe una cuenta con ese email.";

// Mensajes de errores relacionados con el DNI.
const MENSAJE_ERROR_DNI_LONGITUD = "El DNI ha de tener 9 caracteres.";
const MENSAJE_ERROR_DNI_FORMATO = "El formato del DNI ha de ser el siguiente: '00000000Z'.";

// Mensajes de errores relacionados con el teléfono.
const MENSAJE_ERROR_TELEFONO_LONGITUD = "El teléfono ha de constar de 9 dígitos.";
const MENSAJE_ERROR_TELEFONO_FORMATO = "Incluir solo los dígitos del número de teléfono, sin guiones ni puntos.";

// Mensajes de errores relacionados con la contraseña.
const MENSAJE_ERROR_CONTRASENA_LONGITUD = "La contraseña ha de tener como mínimo " + LONGITUD_MINIMA_CONTRASENA + " caracteres.";
const MENSAJE_ERROR_CONTRASENA_DESIGUALES = "Las contraseñas no coinciden.";