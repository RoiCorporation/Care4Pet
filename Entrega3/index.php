<?php

	session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

	$tituloPagina = 'Landing page';

	$contenidoPagina = <<<EOS
		<div class="contenedor-general">

			<p>
				Care4Pet es una aplicación web diseñada para conectar a dueños de mascotas con cuidadores de confianza, 
				ofreciendo servicios personalizados para garantizar el bienestar de los animales. A través de esta plataforma, 
				los dueños pueden buscar cuidadores según su disponibilidad y experiencia, contratar servicios como alojamiento 
				temporal, paseos, cuidados a domicilio o visitas, y gestionar fácilmente las fechas, tarifas y requisitos 
				específicos. Los cuidadores, por su parte, pueden registrar su disponibilidad y especificar qué tipos de 
				mascotas pueden atender.
			</p>

			<p>
				La app web incluye un sistema de valoraciones y reseñas para asegurar la calidad de los servicios y la confianza 
				entre los usuarios.
			</p>

			<p>
				Care4Pet simplifica el proceso de cuidado animal con una experiencia accesible, segura y eficiente desde cualquier 
				dispositivo con conexión a internet.<br><br>
			</p>

			<img src="img/LogoCare4PetTransparente.png" alt="Logo de Care4Pet" style="display: block; margin: auto;"><br><br>

		</div>
	EOS;

	require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>
