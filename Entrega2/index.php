<?php
	session_start();

	require_once 'database.php';

?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Landing page</title>
	</head>


	<body>

	<?php
		require 'cabecera.php';
		require 'DAOUsuario.php';


		
		require 'DAOMascota.php';
		require 'Mascota_t.php';
		require_once 'database.php';
		
		$idTipo = 345234;
		$descripcion = "es muy muy mono";
		$nuevaMascota = new tMascota(1010, $idTipo, "hola", $descripcion);

		echo "Servidor: {$db_servidor}, Usuario: {$db_usuario}";

		(DAOMascota::getInstance())->crearMascota($nuevaMascota);
		


		/*
		(DAOUsuario::getInstance())->leerUnUsuario("vv@vv.com");
		$arrayUsuario = (DAOUsuario::getInstance())->leerTodosLosUsuarios();

		
		if (!empty($arrayUsuario) && isset($arrayUsuario[0]->idUsuario)) {
			echo "{$arrayUsuario[0]->idUsuario}";
		} 
		
		else {
			echo "No users found.";
		}
		*/


	?>
	
	<!-- Contenido principal de la página de inicio -->
	<div style="padding-left: 200px; padding-right: 200px">
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


	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>


	</body>

</html>