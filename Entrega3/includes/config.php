<?php

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'database_care4pet');
define('BD_USER', 'root');
define('BD_PASS', '');
define('BD_PORT', '3307');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/Care4Pet/Entrega3');
define('RUTA_IMGS', RUTA_APP.'/img/');
define('RUTA_CSS', RUTA_APP.'/CSS/');
define('RUTA_JS', RUTA_APP.'/js/');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');
