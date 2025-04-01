<?php

    session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOMensaje.php';
    require_once __DIR__ . '/includes/vistas/helpers/utils.php';
    require_once __DIR__ . '/includes/FormularioMensaje.php';

    
    // Obtiene el ID y el nombre del otro usuario.
    $idOtroUsuario = htmlspecialchars(trim(strip_tags($_REQUEST["idOtroUsuario"])));
    $nombreOtroUsuario = htmlspecialchars(trim(strip_tags($_REQUEST["nombreOtroUsuario"])));
    
    $tituloPagina = 'Chat particular con otro usuario';

    // Da nombre al chat y asocia la clase de scroller para crear una 
    // ventana de mensajes.
    $contenidoPagina = <<<EOS
        <div class="contenedor-general">
        
            <h2 class="titulo-pagina">
                Chat con $nombreOtroUsuario 
            </h2>

    EOS;

    // Procede a generar la ventana de mensajes y popularla con aquellos
    // propios de la conversación.
    $contenidoPagina .= cargarMensajes($idOtroUsuario, $nombreOtroUsuario);

    // Crea e incluye el formulario de envío de mensaje (es decir, el 
    // "botón" de enviar).
    $form = new FormularioMensaje($idOtroUsuario, $nombreOtroUsuario);
	$contenidoPagina .= $htmlFormularioMensaje = $form->gestiona();

    require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>