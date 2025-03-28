<?php

    session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOMensaje.php';
    require_once __DIR__ . '/includes/vistas/helpers/utils.php';

    
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

    $contenidoPagina .= cargarMensajes($idOtroUsuario);

    // Incluye el formulario para enviar un mensaje.
    $contenidoPagina .= <<<EOS
            <div class="formulario-envio-mensaje">

                <form name="form_inicio_sesion" method="post" action="procesar_envio_mensaje.php">

                    <input type="text" name="textoMensaje" placeholder="Escribe un mensaje" size="47">
                    <button type="submit">📨</button>
                    <input type="hidden" name="idOtroUsuario" value="$idOtroUsuario">
                    <input type="hidden" name="nombreOtroUsuario" value="$nombreOtroUsuario">

                </form>

            </div>

        </div>
    EOS;

    require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>