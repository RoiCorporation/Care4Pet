<?php

    /*
     * Archivo auxiliar de la llamada AJAX realizada en el formulario de registro.
     * Su función es utilizar el DAOUsuario para determinar si ya existe una 
     * cuenta con el email que recibe y devolver como resultado un cadena de 
     * caracteres en función de dicha consulta.
    */

    require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';

    // Obtiene el email.
    $emailUsuario = $_REQUEST["email"];

    // Obtiene el usuario de la base de datos, utilizando para ello la función
    // apropiada de DAOUsuario.
    $usuarioObtenido = (DAOUsuario::getInstance())->leerUnUsuario($emailUsuario);

    // Si el usuario existe -esto es, la función de búsqueda de usuario de DAOUsuario
    // no devuelve NULL-, devuelve "Existe"; en caso contrario, devuelve "No existe".
    if ($usuarioObtenido == NULL)
        echo "No existe";

    else
        echo "Existe";

?>