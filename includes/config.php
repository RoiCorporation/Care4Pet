<?php

namespace Care4Pet;

spl_autoload_register(function ($class) {

    // Prefijo del namespace
    $prefix = 'Care4Pet\\';

    // Directorio base donde están las clases
    $base_dir = __DIR__ . '/../';

    // Verifica si la clase pertenece al namespace definido
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Obtiene el nombre de la clase relativa al namespace
    $relative_class = substr($class, $len);

    echo "<h3>Base dir: " . $base_dir . "</h3>";

    echo "<h3>Class: " . $class . "</h3>";

    echo "<h3>Relative class: " . $relative_class . "</h3>";

    // Reemplaza los separadores de namespace con el sistema de archivos
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Si el archivo existe, lo incluye
    if (file_exists($file)) {
        echo "SISISISISISI " . $file;
        require $file;
    }
    else {
        echo "NONONONONO " . $file;
    }
});

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'database_care4pet');
define('BD_USER', 'root');
define('BD_PASS', '');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/Care4Pet/');
define('RUTA_IMGS', RUTA_APP.'img/');
define('RUTA_CSS', RUTA_APP.'css/');
define('RUTA_JS', RUTA_APP.'js/');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');