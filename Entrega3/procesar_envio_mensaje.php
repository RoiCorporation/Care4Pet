<?php

    session_start();

    require_once __DIR__ . '/includes/mysql/DAOs/DAOMensaje.php';

    // Obtiene el ID y nombre del otro usuario, así como el texto del mensaje enviado.
    $idUsuarioReceptor = htmlspecialchars(trim(strip_tags($_REQUEST["idOtroUsuario"])));
    $nombreOtroUsuario = htmlspecialchars(trim(strip_tags($_REQUEST["nombreOtroUsuario"])));
    $mensaje = htmlspecialchars(trim(strip_tags($_REQUEST["textoMensaje"])));
    
    // Obtiene el ID del usuario actual -es decir, el emisor del mensaje- y la fecha y hora
    // actuales.
    $idUsuarioEmisor = $_SESSION['id'];
    $fecha = date("Y-m-d H:i:s");

    // Crea el objeto de tipo tMensaje a insertar en la base de datos.
    $mensajeAInsertar = new tMensaje(
        $idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje
    );
    
    // Invoca a la función de inserción del DAOMensaje para que introduzca dicho mensaje
    // en la base de datos.
    $resultadoInsercionMensaje = (DAOMensaje::getInstance())->crearMensaje($mensajeAInsertar);

    // Si se ha enviado el mensaje exitosamente, carga de nuevo la página de la conversación.
    if ($resultadoInsercionMensaje) {
        header("Location: chat_particular.php?idOtroUsuario=$idUsuarioReceptor&nombreOtroUsuario=$nombreOtroUsuario");
    }

    // Si no se consigue guardar el mensaje en la base de datos, muestra un error por pantalla.
    else {
        echo "<h3>No se ha podido enviar su mensaje. Por favor, inténtelo de nuevo más tarde.</hs><br>";
    }

    require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>