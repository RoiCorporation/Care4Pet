<?php

    require_once __DIR__ . '/../../FormularioBorrarMensaje.php';

    // Función auxiliar que carga los mensajes de un determinado chat desde la base 
    // de datos y puebla con ellos la ventana de mensajes de esa conversación concreta.
    function cargarMensajes($idOtroUsuario, $nombreOtroUsuario) {

        // Variable en la que se guarden los mensajes y su formato.
        $contenidoSeccionMensajes = '<div style="text-align:center">
            <div class="scroller-mensajes" id="scroller-mensajes">';

        // Obtiene los mensajes de la conversación entre esos dos usuarios, dados 
        // sus respectivos IDs.
        $mensajesConversacion = (DAOMensaje::getInstance())->
        leerMensajesConversacion($_SESSION['id'], $idOtroUsuario);
            
        // Inserta cada mensaje en la variable de contenido.
        foreach($mensajesConversacion as $mensaje) {

            // Si el emisor del mensaje es el propio usuario, asocia a ese 
            // mensaje la clase de estilos "mensaje-propio".
            if ($mensaje->getIdUsuarioEmisor() == $_SESSION['id']) {
                $contenidoSeccionMensajes .=
                    '<div class="mensaje-propio">';

                // Crea el enlace que lleve al usuario a la página de edición del mensaje.
                $contenidoSeccionMensajes .= '<a href="editar_mensaje.php?idOtroUsuario=' . $idOtroUsuario .
                '&nombreOtroUsuario=' . $nombreOtroUsuario .
                '&idMensaje=' . $mensaje->getId() .
                '&textoMensajeOriginal=' . $mensaje->getMensaje() .
                '" title="Editar Mensaje">✏️</a>';
                
                // Crea el formulario de borrado de mensaje (es decir, el "botón" de 
                // borrado).
                $formularioBorrarMensaje = new FormularioBorrarMensaje(
                    $idOtroUsuario, 
                    $nombreOtroUsuario,
                    $mensaje->getId()
                );

                // Añade el formulario de borrado al mensaje.
                $contenidoSeccionMensajes .= $htmlFormularioMensaje = $formularioBorrarMensaje->gestiona();

                // Añade al div del mensaje el texto del mismo.
                $contenidoSeccionMensajes .= 
                        '<p>' . $mensaje->getMensaje() . '</p>
                    </div><br>';               
            }

            // Si el emisor del mensaje es el otro usuario, asocia a ese 
            // mensaje la clase de estilos "mensaje-otro-usuario".
            else {
                $contenidoSeccionMensajes .=
                    '<div class="mensaje-otro-usuario">
                        <p>' . $mensaje->getMensaje() . '</p>
                    </div><br>';               
            }
        }

        $contenidoSeccionMensajes .= '</div></div>';

        // Añade el script de JavaScript necesario para que, cada vez que se cargue la
        // ventana de los mensajes, el scroller vaya automáticamente abajo del todo.
        $contenidoSeccionMensajes .= '
            <script>
                window.onload = function() {
                    var scroller = document.getElementById(\'scroller-mensajes\');
                    scroller.scrollTop = scroller.scrollHeight;
                };
            </script>';

        return $contenidoSeccionMensajes;

    }




?>