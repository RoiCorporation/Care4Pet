<?php
	session_start();

	require_once __DIR__ . '/includes/config.php';
	require_once __DIR__ . '/includes/formularios/FormularioContacto.php';

	use Care4Pet\includes\formularios\FormularioContacto;

	$tituloPagina = 'Contacto';

	$formularioContacto = new FormularioContacto();
	$htmlFormulario = $formularioContacto->gestiona(); 

	$contenidoPagina = <<<EOS
		<div class="contenedor-general">
			<h2 class="titulo-pagina">Contacto</h2>

			<p>
				¡Buenas! Gracias por tu interés en contactar con nosotros. Rellena el siguiente formulario y te responderemos lo antes posible.
			</p>

			<!-- Mostrar el formulario aquí -->
			$htmlFormulario

			<p>
				Si prefieres, también puedes escribirnos directamente a: 
				<a href="mailto:care4pet@info.com">care4pet@info.com</a>
			</p>
		</div>
	EOS;

	require __DIR__ . '/includes/vistas/plantillas/plantilla.php';
?>
