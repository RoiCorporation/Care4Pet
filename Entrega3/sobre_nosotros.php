<?php

	session_start();

	$tituloPagina = 'Sobre nosotros';

	$contenidoPagina = <<<EOS
		<div class="contenedor-general">
			
			<h2 class="titulo-pagina"> Sobre nosotros </h2>

			<p> ¡Hola! </p>

			<p>
				Somos un grupo de 5 estudiantes de la Facultad de 
				Informática de la Universidad Complutense de Madrid.
				En este proyecto académico -sin ningún fin comercial-, 
				estamos desarrollando una aplicación web para la gestión 
				del cuidado de mascotas. Te invitamos a que continúes 
				navegando por esta plataforma y descubras por ti mism@ 
				algunas de las funcionalidades más innovadoras de la misma. 
			</p>

			<p>
				¡Gracias por utilizar Care4Pet!
			</p>

		</div>
	EOS;

	require __DIR__ . '/includes/vistas/plantillas/plantilla.php'

?>
