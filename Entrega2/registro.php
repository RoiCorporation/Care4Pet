<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Página de registro</title>
	</head>


	<body>

	<!-- Encabezado de la página dentro del cuerpo, en donde se inserta el menú -->
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

			<div style="display: table; margin: 0 auto;">

				<div style="display: table-row;">
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="nombre" placeholder="Nombre" size="18">
					</div>
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="apellidos" placeholder="Apellidos" size="18">
					</div>
				</div>

				<div style="display: table-row;">
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="dni" placeholder="DNI" size="18">
					</div>
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="direccion" placeholder="Dirección" size="18">
					</div>
				</div>

				<div style="display: table-row;">
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="email" placeholder="Email" size="18">
					</div>
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="telefono" placeholder="Teléfono" size="18">
					</div>
				</div>

				<div style="display: table-row;">
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="contraseña" placeholder="Contraseña" size="18">
					</div>
					<div style="display: table-cell; padding: 10px;">
						<input type="text" name="contraseña" placeholder="Repita la contraseña" size="18">
					</div>
				</div>

			</div>

			<br>
			<div style="text-align: center;">
				<input type="submit" value="Registrarse">
			</div>

		</form>


	</div><br><br><br><br>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>
	
	</body>

</html>