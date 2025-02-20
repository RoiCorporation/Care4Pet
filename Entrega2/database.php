<?php

    $db_servidor = "localhost";
    $db_usuario = "root";
    $db_contrasena = "";
    $db_nombre = "database_care4pet";
    $con = "";

    try {
        // El objeto "con" representa la conexión con la base de datos.
        $con = mysqli_connect($db_servidor, $db_usuario, $db_contrasena, $db_nombre);
    }

    // Informa al usuario si no se ha podido establecer la conexión con la 
    // base de datos.
    catch (mysqli_sql_exception) {
        echo "Lo sentimos, no se pudo conectar con la base de datos.<br>";
    }

?>