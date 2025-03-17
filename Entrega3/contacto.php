<?php

	session_start();

	$tituloPagina = 'Contacto';

	$contenidoPagina = <<<EOS
		<div style="padding-left: 200px; padding-right: 200px">
				
			<h2 style="text-align:center">Contacto</h2>

			<p>
				¡Buenas! Gracias por tu interés en contactar con nosotros.
				En breves tendremos configurada esta página de contacto.
				Mientras tanto, puedes mandar tus preguntas al correo 
				care4pet@info.com. 
			</p>

			<p>
				¡Nos vemos pronto! 
			</p>

		</div>
	EOS;

	require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>
