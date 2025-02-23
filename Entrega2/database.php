<?php

    // Obtenemos parametros de conexión DB del fichero env
    $env = parse_ini_file(__DIR__ . '/.env');

    $db_servidor = $env['DB_SERVIDOR'];
    $db_usuario = $env['DB_USUARIO'];
    $db_contrasena = $env['DB_CONTRASENA'];
    $db_nombre = $env['DB_NOMBRE'];

    try {
        // El objeto "con" representa la conexión con la base de datos.
        $con = new mysqli($db_servidor, $db_usuario, $db_contrasena, $db_nombre);
    }

    // Informa al usuario si no se ha podido establecer la conexión con la 
    // base de datos.
    catch (mysqli_sql_exception) {
        echo "Lo sentimos, no se pudo conectar con la base de datos.<br>";
    }

?>