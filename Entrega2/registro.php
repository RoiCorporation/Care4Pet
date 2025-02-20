<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Páginad de registro</title>
	</head>


	<body>

	<!-- Encabezado de la página dentro del cuerpo, en donde se inserta el menú. -->
    <header>
        <h1 style="text-align:center">Registro</h1>
        <?php
			require 'menu.php';
		?>
    </header><br><br><br><br>


	<!-- Sección de los campos de entrada de datos -->
	<div style="text-align:center">

		<h2>Crear una cuenta</h2>

		<!-- Formulario para introducir los datos para registrarse en la página web -->
		<form name="form_inicio_sesion" method="post" action="index.php">
			<input type="text" name="nombre" placeholder="Nombre" size="18"><br><br>
			<input type="text" name="email" placeholder="Email" size="18"><br><br>
			<input type="text" name="contrasena" placeholder="Contraseña" size="18"><br><br>
			<input style="text-align:center" type="submit" value="Iniciar sesión" size="20"><br><br>
		</form>

	</div><br><br><br><br>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>
	
	</body>

</html>