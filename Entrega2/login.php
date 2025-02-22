<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Página de inicio de sesión</title>
	</head>


	<body>

	<?php
		require 'cabecera.php';
	?>

	<!-- Sección de los campos de entrada de datos -->
	<div style="text-align:center">

		<h2>Iniciar sesión</h2>

		<!-- Formulario para introducir el email y la contraseña -->
		<form name="form_inicio_sesion" method="post" action="procesar_login.php">
			<input type="email" name="email" placeholder="Email" size="18"><br><br>
			<input type="password" name="contrasena" placeholder="Contraseña" size="18"><br><br>
			<input style="text-align:center" type="submit" value="Iniciar sesión" size="20">
		</form>

		<p>¿No tienes una cuenta todavía? <a href="registro.php">¡Regístrate!</a></p>

	</div>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>

	</body>

</html>