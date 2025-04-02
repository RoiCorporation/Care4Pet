<?php

	session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOMensaje.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';

	$tituloPagina = 'Landing page';

	// Obtener todos los mensajes en los que participe ese usuario.
	$mensajesUsuario = (DAOMensaje::getInstance())->leerMensajesUsuario($_SESSION['id']);

	// Obtener los mensajes de cada conversación.
	$conversaciones = [];

	foreach($mensajesUsuario as $mensajeActual) {
		// A continuación se agrupan los mensajes en torno a las personas a las que 
		// el usuario en cuestión envía/recibe mensajes. Es decir, las conversaciones
		// con los diferentes usuarios.

		// Si el usuario actual es el emisor, considera el id del receptor como la clave
		// a introducir en el array.
		if ($mensajeActual->getIdUsuarioEmisor() == $_SESSION['id']) {
			$claveArrayMensajes = $mensajeActual->getIdUsuarioReceptor();

			$conversaciones[$claveArrayMensajes][] = $mensajeActual;
		}

		// Si el usuario actual es el receptor, considera el id del emisor como la clave
		// a introducir en el array.
		if ($mensajeActual->getIdUsuarioReceptor() == $_SESSION['id']) {
			$claveArrayMensajes = $mensajeActual->getIdUsuarioEmisor();

			$conversaciones[$claveArrayMensajes][] = $mensajeActual;
		}
	}

	$contenidoPagina = '<div class="contenedor-general">';

	$renderConversacionActual = '';

	foreach($conversaciones as $idOtroUsuario => $conversacion) {

		// Obtiene los atributos del otro usuario con el que se comunica en ese chat.
		$otroUsuario = (DAOUsuario::getInstance())->leerUnUsuarioPorID($idOtroUsuario);

		// Construye el "recuadro" gráfico con información del otro usuario -su foto y nombre-, 
		// así como con el último mensaje que se ha enviado.
		$renderConversacionActual .= '
			<form method="post" action="chat_particular.php" style="margin: 0;">
				<div onclick="this.closest(\'form\').submit();" style="display: flex; align-items: center; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; cursor: pointer;">
					<img src="/img/cuidador1.png" alt="Foto cuidador" style="width:100px; height:100px; margin-right: 20px;">
					<div>
						<h3><strong>' . $otroUsuario->getNombre() . '</strong></h3>
						<p>' . $conversacion[0]->getMensaje() . '</p>
					</div>
					<input type="hidden" name="idOtroUsuario" value="' . $otroUsuario->getId() . '">
					<input type="hidden" name="nombreOtroUsuario" value="' . $otroUsuario->getNombre() . '">
				</div>
			</form>';
			
	}
	
	$contenidoPagina .= $renderConversacionActual . '</div>';
		
	require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>
