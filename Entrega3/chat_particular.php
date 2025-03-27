<?php

    session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOMensaje.php';

    // Obtiene el ID del otro usuario.
    $idOtroUsuario = htmlspecialchars(trim(strip_tags($_REQUEST["idOtroUsuario"])));

    // Obtiene los mensajes de la conversación entre esos dos usuarios, dados sus 
    // respectivos IDs.
    $mensajesConversacion = (DAOMensaje::getInstance())->
        leerMensajesConversacion($_SESSION['id'], $idOtroUsuario);

    $contenidoPagina = <<<EOS
        <div class="scroller-mensajes">
    EOS;

    /*
    foreach($mensajesConversacion as $mensaje) {
        $contenidoPagina .= $mensaje->getMensaje() . '<br>';
    }
        */

    $contenidoPagina = '
    <div class="mi-caja">
        <p>
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
            Este contenido está dentro de una caja con estilo CSS.
        
        
        
        
        
        </p>
    </div>
    ';
    
/*
    $contenidoPagina .= <<<EOS
        </div>
    EOS;
*/
    $tituloPagina = 'Chat particular con otro usuario';


    $contenidoPagina = '<div class="mi-caja">HOLA</div>';


    require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>