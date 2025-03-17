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

	<?php
		require_once __DIR__ . '/includes/vistas/comun/cabecera.php';
	?>

	<!-- Sección de los campos de entrada de datos -->
	<div style="text-align:center">

		<h2>Crear una cuenta</h2>

		<!-- Formulario para introducir los datos para registrarse en la página web -->
		<form name="form_inicio_sesion" method="post" action="procesar_registro.php">

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
						<input type="email" name="email" placeholder="Email" size="18">
					</div>
					<div style="display: table-cell; padding: 10px;">
						<input type="tel" name="telefono" placeholder="Teléfono" size="18">
					</div>
				</div>

				<div style="display: table-row;">
					<div style="display: table-cell; padding: 10px;">
						<input type="password" name="contrasena" placeholder="Contraseña" size="18">
					</div>
					<div style="display: table-cell; padding: 10px;">
						<input type="password" name="contrasena repetida" placeholder="Repita la contraseña" size="18">
					</div>
				</div>
				
			</div><br>
			
			<fieldset>
				<legend>Darse de alta como cuidador</legend>
				<div style="display: inline-block; text-align: center;">
					<input type="radio" id="CuidadorSi" name="esCuidador" value="Si">
					<label for="CuidadorSi">Sí</label>&nbsp;&nbsp;&nbsp;
					<input type="radio" id="CuidadorNo" name="esCuidador" value="No" checked>
					<label for="CuidadorNo">No</label>
				</div><br>
			</fieldset>

			<br>
			<div style="text-align: center;">
				<input type="submit" value="Registrarse">
			</div>

		</form>


	</div>

	<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
	<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>
	
	</body>

</html>
