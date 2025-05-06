<?php

    use Care4Pet\includes\formularios\FormularioBorrarMensaje;
    use Care4Pet\includes\mysql\DAOs\DAOMensaje;

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

            // Invoca a la función que obtiene el párrafo con la hora y la
            // fecha formateado y listo para incluir en el HTML.
            $parrafoHoraYFecha = obtenerFechaMensajeFormateada($mensaje);

            // Si el emisor del mensaje es el propio usuario, asocia a ese 
            // mensaje la clase de estilos "mensaje-propio".
            if ($mensaje->getIdUsuarioEmisor() == $_SESSION['id']) {

                // Añade al mensaje la hora y fecha del mismo.
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
                $contenidoSeccionMensajes .= $formularioBorrarMensaje->gestiona();

                // Añade al mensaje el texto del mismo, así como el párrafo
                // de hora y fecha en la que fue enviado.
                $contenidoSeccionMensajes .=
                        '<p>' . $mensaje->getMensaje() . '</p>
                    </div>' . $parrafoHoraYFecha . 
                    '<br>';
            }

            // Si el emisor del mensaje es el otro usuario, asocia a ese 
            // mensaje la clase de estilos "mensaje-otro-usuario".
            else {

                // Añade al mensaje el texto del mismo, así como el párrafo
                // de hora y fecha en la que fue enviado.
                $contenidoSeccionMensajes .=
                    '<div class="mensaje-otro-usuario">
                        <p>' . $mensaje->getMensaje() . '</p>
                    </div>' . $parrafoHoraYFecha . 
                    '<br>';
            }
        }

        $contenidoSeccionMensajes .= '</div></div>';

        // Añade el script de JavaScript necesario para que, cada vez que se cargue la
        // ventana de los mensajes, el scroller vaya automáticamente abajo del todo.
        // Este script ha sido creado utilizando la herramienta ChatGPT de OpenAI.
        $contenidoSeccionMensajes .= '
            <script>
                window.onload = function() {
                    var scroller = document.getElementById(\'scroller-mensajes\');
                    scroller.scrollTop = scroller.scrollHeight;
                };
            </script>';

        return $contenidoSeccionMensajes;

    }



    // Función auxiliar que, dado un mensaje, devuelve un párrafo HTML (<p>)
    // formateado con la información relevante de su fecha. Se utiliza al
    // incluir dichos datos temporales en los mensajes que se muestran en
    // cada chat.
    function obtenerFechaMensajeFormateada($mensaje) {

        // Variable en la que se guardará la clase de estilo del párrafo
        // de hora y fecha.
        $claseParrafoHoraYFecha = "";

        // Determina el valor de la variable anterior, en función de si se
        // trata de un mensaje del propio usuario o uno que ha recibido de
        // otro usuario.
        if ($mensaje->getIdUsuarioEmisor() == $_SESSION['id']) {
            $claseParrafoHoraYFecha = "hora-fecha-mensaje-propio";
        }

        else {
            $claseParrafoHoraYFecha = "hora-fecha-mensaje-otro";
        }

        // Obtiene la fecha completa del mensaje y lo guarda en una
        // variable que se parseará para obtener los datos horarios
        // por separado.
        $datetimeAParsear = date_parse($mensaje->getFecha());

        // Crea un párrafo con la información temporal del mensaje
        // formateada. En la hora y fecha, se utiliza la función
        // sprintf, para añadir ceros a la izquierda en aquellos casos
        // en que el valor en sí no tenga dos cifras.
        $parrafoHoraYFecha = 
            '<p class=' . $claseParrafoHoraYFecha . '>' . 
                sprintf('%02d', $datetimeAParsear['hour']) . ':' . 
                sprintf('%02d', $datetimeAParsear['minute']) . '   ' . 
                sprintf('%02d', $datetimeAParsear['day']) . '/' . 
                sprintf('%02d', $datetimeAParsear['month']) . 
            '</p>';

        return $parrafoHoraYFecha;

    }



?>